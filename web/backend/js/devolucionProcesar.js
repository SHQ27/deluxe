var devolucionProcesar = function()
{
	var thisClass = this;
    thisClass.dataProducto = {}
	thisClass.textos =	{
							'COMPLETO-TC': 'Se estará gestionando la devolución directamente con la entidad emisora de tu tarjeta de crédito para que puedas verificar la anulación en el próximo resumen.',
							'PARCIAL': 'Se estará gestionando la devolución directamente con la entidad emisora de tu tarjeta de crédito para que puedas verificarla en el próximo resumen.',
							'COMPLETO-EF': 'Para acceder al dinero tenés que ingresar a www.mercadopago.com con tu dirección de mail y podés transferirlo a tu cuenta bancaria desde Mi Cuenta > Retirar Dinero de MercadoPago.'
						};			

	this.init = function()
	{		

		$("[name='procesarDevolucion[opcion]']").change( function(){ thisClass.changeOption( $(this).val() ); } );
		
        $("tr.row").each( function(i, e){
            var idDevolucionProductoItem = $(this).attr('rel');
            var idProducto = defaults[ idDevolucionProductoItem ].idProducto;

            var selectProducto = $(this).find('.producto select');
            selectProducto.val(idProducto);
            selectProducto.change( function(){ thisClass.changeProducto( $(e), false ); } );
            thisClass.changeProducto( $(e), defaults[ idDevolucionProductoItem ]  );

            var selectTalle = $(this).find('.talle select');
            selectTalle.change( function(){ thisClass.makeColorOptions( $(e) ); } );

        });
		
		
		$("[name*='procesarDevolucion[devolucion][cantidad_fallados]']").change( function(){ thisClass.changeCantidadFallados( $(this) ); } );
		
	}

    this.changeProducto = function( tr, defaultValues )
    {
        var selectProducto = tr.find('.producto select');
        var idProducto = selectProducto.val();

        $.ajax
        (
            {
              type: "POST",
              url: '/backend/ajax/getDataProductoItem',
              data: 'idProducto=' + idProducto,
              dataType: "json",
              success: function(dataProductoItems)
              {
                thisClass.dataProducto[ idProducto ] = dataProductoItems;
                thisClass.makeTalleOptions( tr, defaultValues );
              }
            }
        );
    }

    this.makeTalleOptions = function(tr, defaultValues)
    {       
        var selectProducto = tr.find('.producto select');
        var idProducto = selectProducto.val();

        var selectTalle = tr.find('.talle select');
        thisClass.removeOptions(selectTalle);

        var dataProductoItems = thisClass.dataProducto[ idProducto ];

        for(idProductoTalle in dataProductoItems)
        {
            var rowTalle = dataProductoItems[idProductoTalle];
            selectTalle.append($('<option value="' + rowTalle.idProductoTalle  + '">').text(rowTalle.denominacion)); 
        }

        if ( defaultValues ) {
            selectTalle.val( defaultValues.idProductoTalle );    
        }

        this.makeColorOptions(tr, defaultValues);
    };

    this.makeColorOptions = function(tr, defaultValues)
    {               
        var selectProducto = tr.find('.producto select');
        var idProducto = selectProducto.val();

        var selectTalle = tr.find('.talle select');
        var idProductoTalle = selectTalle.val();

        var selectColor = tr.find('.color select');
        thisClass.removeOptions(selectColor);

        var dataProductoItems = thisClass.dataProducto[ idProducto ];
        
        for(idProductoColor in dataProductoItems[idProductoTalle].childs)
        {
            var rowColor = dataProductoItems[idProductoTalle].childs[idProductoColor];
            selectColor.append($('<option value="' + rowColor.idProductoColor  + '">').text(rowColor.denominacion)); 
        }
        
        if ( defaultValues ) {
            selectColor.val( defaultValues.idProductoColor );    
        }
        
    };

    this.removeOptions = function(select)
    {
        select.find('option').remove().end().val('');
    };

    this.changeOption = function( value )
    {   
        $("[name='procesarDevolucion[mensaje]']").val( thisClass.textos[value] );
    }
    
    this.actualizarHiddens = function( tr )
    {
        var idProducto = tr.find('.producto select').val();
        tr.find('.producto input').val(idProducto);

        var idProductoTalle = tr.find('.productoTalle select').val();
        tr.find('.productoTalle input').val(idProductoTalle);

        var idProductoColor = tr.find('.productoColor select').val();
        tr.find('.productoColor input').val(idProductoColor);
    }

    this.changeCantidadFallados = function( CantidadFalladosSelect )
    {           
        var cantidadFallados = CantidadFalladosSelect.val();
                
        var container = CantidadFalladosSelect.parents('tr').first().find('.detalleFallados');
                
        container.html("");
        
        var nameNewInput = CantidadFalladosSelect.attr('name').replace('cantidad_fallados', 'detalle_fallados') + '[]';
        
        if ( cantidadFallados > 0  )
        {
            container.append( '<ul>');
            
            for ( var i = 1 ; i <= cantidadFallados ; i++ )
            {
                container.find('ul').append( '<li>' + i + ' - <input type="text" name="' + nameNewInput + '" placeholder="Describa aquí la falla" /></li>');
            }
        }
        else
        {
            container.append('No hay fallados');   
        }        
    }
    
    
	this.init();   
}

$(document).ready( function() { new devolucionProcesar(); } );