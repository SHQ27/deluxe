var pmWidgetMovStock = function(formName, identifier, stockLimitado, asignados)
{    
    var thisClass = this;
    this.formName = formName;
    this.stockLimitado = stockLimitado;
    this.asignados = asignados;    
    this.selectMarca = $( '#' + identifier + '_marca' );
    this.selectCampana = $( '#' + identifier + '_campana' );
	this.divResults = $( '#' + identifier + '_results' );
	this.divSelectedItems = $( '#' + identifier + '_selectedItems' );
	this.total = $( '#' + identifier + '_total' );
	
	this.init = function()
	{   	    
        this.selectMarca.change( function(){
            thisClass.updateCampanas();
            thisClass.updateResults();
        } );
        
        this.selectCampana.change( function(){
            thisClass.updateResults();
        } );
		    
		thisClass.updateResults();
		thisClass.updateCampanas();
		
		this.togglesChecks();
		
		$('#' + thisClass.formName + '_add').live('click', function() { thisClass.add() } )
		$('.' + thisClass.formName + '_remove').live('click', function() { thisClass.remove(this) } )
		
		$('form').submit(function(e) {
		    
		    var tipo = $('[name="movimiento_stock_oca[tipo]"]]:checked').val();
		    
		    if ( tipo == 'MANUAL' )
	        {
		        thisClass.validation(e, this);
	        }
		    else
	        {
		        $(form).submit();   
	        }
	    } )
				
        $('.' + thisClass.formName + '_asignacion').live('keyup' , function() {
            thisClass.updateCantidadTotal();
        });
		
        $('.' + thisClass.formName + '_asignacion').live('change' , function() {
            thisClass.updateCantidadTotal();
        });
		
		var c = this.asignados.length;
		for ( i = 0 ; i < c ; i++ )
		{
		    $('[name="' + thisClass.formName + '[asignacion][' + this.asignados[i].idProductoItem + '][cantidad]"]').val( this.asignados[i].stock );   
		}
				
	}


    this.updateCantidadTotal = function(e, form)
    {
        var total = 0;
        
        $('.' + thisClass.formName + '_asignacion').each(function(i, elem) {
            var val = $(elem).val();
            if (parseInt(val, 10) > 0 )
            {
                total += parseInt( val );
                
            }                
        });
        
        thisClass.total.text('Cantidad Total: ' + total);
    };
	
    this.validation = function(e, form)
    {
        e.preventDefault();
                        
        var asignados = $('.' + thisClass.formName + '_asignacion')
        var c = asignados.length;
        
        var error = false;
        
        if (c == 0) {
            $('.no-results', thisClass.divSelectedItems).addClass("error")
            error = true;
        }
        
        for ( i = 0 ; i < c ; i++ )
        {
            var val = $(asignados[i]).val();
            if ( jQuery.trim(val) == '' || isNaN(val) )
            {
                $(asignados[i]).parents('tr').first().addClass("error");
                error = true;
            }
            else
            {
                $(asignados[i]).parents('tr').first().removeClass("error");
            }
        }
        
        if ( !error )
        {
            $('form').unbind('submit');
            $('[name="' + formName + '[asignacion][html]"]').val ( $('.selectedItems').html() );
            $(form).submit();   
        }
    }
	
	this.add = function()
	{  	    
	    var porAgregar = $('.' + thisClass.formName + '_asignacion_check:checked')
	    var c = porAgregar.length;
	    	    
	    for ( i = 0 ; i < c ; i++ )
	    {
	        var idProductoItem = $(porAgregar[i]).val();
	        var stock = $(porAgregar[i]).attr('rel');
	        	        
	        if ( $('tr[rel="' + idProductoItem + '"]', thisClass.divSelectedItems).length ) continue;
	        
	        var tr = $(porAgregar[i]).parents('tr').first();
	        
	        tr.attr('rel', idProductoItem);
	        $('td', tr).first().remove();
	        
	        
	        var idCampana = this.selectCampana.val();
	        var inputCampana = '<input type="hidden" name="' + thisClass.formName + '[asignacion][' + idProductoItem + '][idCampana]" value="' +  idCampana+ '"/>';
	        
	        if ( this.stockLimitado )
	        {
	            tr.append('<td><select class="' + thisClass.formName + '_asignacion" name="' + thisClass.formName + '[asignacion][' + idProductoItem + '][cantidad]"></select>' + inputCampana + '</td>');
	            
	            for ( j = 0 ; j <= stock ; j++ )
	            {
	                $('[name="' + thisClass.formName + '[asignacion][' + idProductoItem + '][cantidad]"]').append('<option val="' + j + '">' + j + '</option>');
	            }
	        }
	        else
	        {
	            tr.append('<td><input type="input" class="' + thisClass.formName + '_asignacion" name="' + thisClass.formName + '[asignacion][' + idProductoItem + '][cantidad]" value="" />' + inputCampana + '</td>');   
	        }
	        
	        tr.append('<td><a class="' + thisClass.formName + '_remove' + '">Eliminar</a></td>');
	        tr.removeClass("selected");
	        
	        $('.no-results', thisClass.divSelectedItems).remove();
	        
	        $('table', thisClass.divSelectedItems).append( tr );
	        
	        thisClass.updateCantidadTotal();
	    }	    
	    
	}
	
    this.remove = function(elem)
    {
        $(elem).parents('tr').first().remove();
        
        var noResult = $('.' + identifier, thisClass.divSelectedItems);
        
        if ( noResult.length == 0 && $('.no-results', thisClass.divSelectedItems).length == 0)
        {
            $('table', thisClass.divSelectedItems).append( '<tr class="no-results"><td colspan="9">No hay productos asignados</td></tr>' );
        }
        
        thisClass.updateResults();
        thisClass.updateCantidadTotal();
    }
	
    this.togglesChecks = function()
    {
        $('#' + this.formName + '_asignacion_check_all').live('change', function() {
            
            if ( $(this).attr('checked') )
            {
                $('.' + thisClass.formName + '_asignacion_check').attr('checked','checked');
                $('.' + thisClass.formName + '_asignacion_check').parent().parent().addClass("selected");
            }
            else
            {
                $('.' + thisClass.formName + '_asignacion_check').removeAttr('checked');
                $('.' + thisClass.formName + '_asignacion_check').parent().parent().removeClass("selected");
            }
        } );
        
        $('.' + this.formName + '_asignacion_check').live('change', function() {
            
            if ( $(this).attr('checked') )
            {
                $(this).parents('tr').first().addClass("selected");
            }
            else
            {
                $(this).parents('tr').first().removeClass("selected");              
            }
            
        } );
        
    }
	
    this.updateResults = function()
    {
        var idMarca = this.selectMarca.val()
        var idCampana = this.selectCampana.val()    
                
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/getProductoItemsMovStock",
              dataType: "json",
              data: "idMarca=" + idMarca + "&idCampana=" + idCampana,
              success: function(results)
              {
                  
                    var table = $('<table></table>');
                    
                    var head =  $(
                            '<tr>' +
                                '<td><input type="checkbox" id="' + thisClass.formName + '_asignacion_check_all"></td>' +
                                '<td><strong>Id Producto Item</strong></td>' +
                                '<td><strong>Imagen Poducto</strong></td>' +
                                '<td><strong>Código</strong></td>' +
                                '<td><strong>Producto</strong></td>' +
                                '<td><strong>Marca</strong></td>' +
                                '<td><strong>Talle</strong></td>' +
                                '<td><strong>Color</strong></td>' +
                            '</tr>'
                        );
                    
                    table.append(head);
                    
                    if (results.length)
                    {
                        for(i in results)
                        {
                            var row = results[i];
                            
                            if ( $('tr[rel="' + row.id_producto_item + '"]', thisClass.divSelectedItems).length ) continue;     
                            
                            var tr = $('<tr></tr>');
                                                        
                            var stockLimitado = ( idCampana ) ? row.stock : row.stockPermanente;
                                
                                                        
                            tr.append('<td><input type="checkbox" class="' + thisClass.formName + '_asignacion_check" value="' + row.id_producto_item + '" rel="' + stockLimitado + '"></td>');       
                            tr.append('<td>' + row.id_producto_item + '</td>');
                            tr.append('<td><img src="' + row.imagen_url + '" width="100px"></td>');
                            tr.append('<td>' + row.codigo + '</td>');
                            tr.append('<td>' + row.producto + '</td>');
                            tr.append('<td>' + row.marca + '</td>');
                            tr.append('<td>' + row.talle + '</td>');
                            tr.append('<td>' + row.color + '</td>');                            
                            table.append(tr);
                        }
                    }
                    else
                    {
                        table.append( $('<tr><td colspan="9" style="text-align: center;">No hay items de productos para la marca seleccionada</td></tr>') );    
                    }
                    
                    thisClass.divResults.html( table );
                    
                    var button =  '<input class="add" type="button" value="Agregar al Envío" id="' + thisClass.formName  + '_add" />';
                    
                    thisClass.divResults.html( thisClass.divResults.html() + button );
                      
              }
            }
        );
    };
    
    this.updateCampanas = function()
    {
        var idMarca = this.selectMarca.val()
        
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/getCampanasByIdMarca",
              dataType: "json",
              data: "idMarca=" + idMarca,
              success: function(campanas)
              {                
                  thisClass.selectCampana.find('option').remove().end();
                  thisClass.selectCampana.append('<option value="">No filtrar por campaña</option>').val('');
                  
                  if (!campanas) return;
                  
                  for(i in campanas)
                  {
                      var campana = campanas[i];
                      thisClass.selectCampana.append($('<option value="' + campana.value + '">').text(campana.denominacion)); 
                  }                  
              }
            }
        );
    };
	

	
	this.init();   
}
