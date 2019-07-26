var pmWidgetProductAssign = function(formName, identifier)
{
	var thisClass = this;
	this.formName = formName;
	this.selectMarca = $( '#' + identifier + '_marca' );
	this.selectCampana = $( '#' + identifier + '_campana' );
	this.selectActivo = $( '#' + identifier + '_activo' );
	this.selectCategoria = $( '#' + identifier + '_categoria' );
	this.selectEshop = $( '#' + identifier + '_eshop' );
	this.divResults = $( '#' + identifier + '_results' );
	this.divSelectedItems = $( '#' + identifier + '_selectedItems' );
	
	this.init = function()
	{
	    $(".pmWidgetProductAssign .button").click( function(){ thisClass.updateResults();  } )
	    $(".pmWidgetProductAssign .restablecer").click( function(){
	        
	        thisClass.selectMarca.val('');
	        thisClass.selectCampana.val('');
	        thisClass.selectActivo.val('');
	        thisClass.selectCategoria.val('');
	        thisClass.selectEshop.val('');
	        
	        var tableData = $('tbody', thisClass.divResults);
	        tableData.find('tr').remove();
	        tableData.append( $('<tr><td colspan="15" style="text-align: center;">Debe aplicar filtros para mostrar los productos</td></tr>') );
	    } )
		
		$('a.remove', thisClass.divSelectedItems).click( function (e){ thisClass.removeItem(e, this); } );
		
		$('a.deallocateAll').click( function (e){ thisClass.deallocateAll() } );
		$('a.allocateAll').click( function (e){ thisClass.allocateAll() } );
	}
	
	this.addItem = function(e, elem)
	{
		e.preventDefault();
		var a = $(elem);
		var idProducto = a.attr("rel");
		
		var existe = $('tr[rel=' + idProducto + ']', thisClass.divSelectedItems).length;
		
		if (existe) return;
		
		var tr = a.parents('tr').first().clone();
		tr.attr('rel', idProducto);
				
		var tdAction = $('a.add', tr).parent();
		$('a.add', tr).remove();
		tdAction.append('<a class="remove">Eliminar</a>');
		
		$('table', thisClass.divSelectedItems).append( tr );
		
		$('a.remove', tr).click( function (e){ thisClass.removeItem(e, this); } );
		
		$('tr[rel=0]', thisClass.divSelectedItems).remove();
		
		this.updateHidden();
	}
	
	this.removeItem = function(e, elem)
	{
		e.preventDefault();
		var a = $(elem);
		a.parents('tr').first().remove();
		
		var cantidadRows = $('tr', thisClass.divSelectedItems).length;
				
		if (cantidadRows <= 1)
		{
			$('table', thisClass.divSelectedItems).append( '<tr rel="0"><td colspan="15">No hay productos asignados</td></tr>' );
		}
		
		this.updateHidden();		
	}
	
	this.deallocateAll = function()
	{
		var tr = $('table tr', thisClass.divSelectedItems);
		tr.splice(0,1);
		tr.remove();
		
		$('table', thisClass.divSelectedItems).append( '<tr rel="0"><td colspan="15">No hay productos asignados</td></tr>' );
		
		this.updateHidden();
	}
	
    this.allocateAll = function()
    {
        $('table', thisClass.divResults).find('a.add').each( function(e,el){ $(el).click(); }  );
    }
    
    this.updateHidden = function()
    {
        var asignados = [];
        $( 'tr', thisClass.divSelectedItems ).each( function(i,e) {
            
            var idProducto = $(e).attr("rel");
            
            if (i > 0 && idProducto != "0")
            {
                asignados.push( idProducto );
            }
        } );
        
        $('[name="' + this.formName +'[asignacion]"]').val( asignados.join(",") );
    }
	
	this.updateResults = function()
	{
	    var idMarca = this.selectMarca.val()
	    var idCampana = this.selectCampana.val()
	    var activo = this.selectActivo.val()
	    var idProductoCategoria = this.selectCategoria.val()
	    var idEshop = this.selectEshop.val()
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/ajax/getProductosByFilters",
			  dataType: "json",
			  data: "idMarca=" + idMarca + "&idCampana=" + idCampana + "&activo=" + activo + "&idProductoCategoria=" + idProductoCategoria + "&idEshop=" + idEshop,
			  success: function(productos)
			  {
			        var tableData = $('tbody', thisClass.divResults);
			        tableData.html('');
				  						
				  	if (productos.length)
				  	{
					    for(i in productos)
					    {
					    	var producto = productos[i];
					    								    	
					        var esOferta = ( producto.es_oferta == 1 ) ? 'oferta' : 'stockPermanente';
					    	var tr = $('<tr class="' + esOferta + '"></tr>');
					    	
							tr.append('<td>' + producto.codigos + '</td>');
							tr.append('<td>' + producto.denominacion + '</td>');
							tr.append('<td>' + producto.marca + '</td>');
							tr.append('<td>' + producto.eshop + '</td>');
							tr.append('<td>' + producto.categoria + '</td>');
							tr.append('<td>' + producto.diversidad + '</td>');
							tr.append('<td>' + producto.activo + '</td>');
							tr.append('<td>' + producto.stockPermanente + '</td>');
							tr.append('<td>' + producto.stockCampana + '</td>');
							tr.append('<td>' + producto.stockOutlet + '</td>');
							
							if ( producto.sticker )
						    {
							    tr.append('<td><div class="relative">' + producto.sticker + '</div>' + producto.imagen + '</td>');
						    }
							else
						    {
							    tr.append('<td>' + producto.imagen + '</td>');
						    }
							
							tr.append('<td>' + producto.precio_lista + '</td>');
							tr.append('<td class="precioDeluxe">' + producto.precio_deluxe + '</td>');
							tr.append('<td>' + producto.costo + '</td>');
							tr.append('<td class="center"><a class="add" rel="' + producto.idProducto + '">Agregar</a></td>');
							
							$('a.add', tr).click( function (e){ thisClass.addItem(e, this); } );
					    	
							tableData.append(tr);
						}
				  	}
				  	else
				  	{
				  	  tableData.append( $('<tr><td colspan="15" style="text-align: center;">No hay productos para los filtros aplicados</td></tr>') );	
				  	}
			  }
			}
		);
	}
	

	
	this.init();   
}
