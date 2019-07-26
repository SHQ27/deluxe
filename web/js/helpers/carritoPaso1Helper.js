var carritoPaso1Helper = function()
{
	var thisClass = this;

	this.init = function()
	{
		$("#checkout_carrito .item .eliminar").click( function(e){ thisClass.removeProducto(e.currentTarget ) } );
		$("#checkout_carrito .item .cantidad select").change( function(e){ thisClass.updateItem(e.currentTarget ) } );
		
		if ( $('#checkout_carrito .item').length == 0 ) {
            thisClass.showNoProducts();
        }
	}
	

	this.updateItem = function(elem)
	{
	    var item = $(elem).parents(".item").first(); 
        
        var idCarritoProductoItem = item.attr("id").replace('carritoProductoItem_','');
        var cantidad = $(elem).val();
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/carrito/update",
			  dataType: "json",
			  data: "idCarritoProductoItem=" + idCarritoProductoItem + '&cantidad=' + cantidad,
			  success: function(response)
			  {
				  if (response.status == 'KO')
				  {
					  $('#carritoProductoItem_' + idCarritoProductoItem + ' .alert').html( response.message );
                      $('#carritoProductoItem_' + idCarritoProductoItem + ' .alert').removeClass('hide').addClass('show');
					  
					  thisClass.removeOptions('#carritoProductoItem_' + idCarritoProductoItem + ' select');
					  
					  for (i = 1 ; i <= response.stockDisponible ; i++)
					  {
						  $('#carritoProductoItem_' + idCarritoProductoItem + ' select').append($('<option value="' + i  + '">').text( ('0' + i).slice(-2) ) );
					  }
					  
					  $('#carritoProductoItem_' + idCarritoProductoItem + ' select').val( response.stockDisponible );
				  }
				  else
				  {
				      $('#carritoProductoItem_' + idCarritoProductoItem + ' .alert').html('');
                      $('#carritoProductoItem_' + idCarritoProductoItem + ' .alert').removeClass('show').addClass('hide');
				  }
				  
				  $('#carritoProductoItem_' + idCarritoProductoItem + ' .total').html( '$' + response.subTotal + '.-' );
				  thisClass.updateTotal();
			  }
			}
		);
		
	}
		
	this.removeProducto = function(elem)
	{
	    var item = $(elem).parents(".item").first(); 
	    
		var idCarritoProductoItem = item.attr("id").replace('carritoProductoItem_','');
		item.remove();
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/carrito/removeProducto",
			  dataType: "json",
			  data: "idCarritoProductoItem=" + idCarritoProductoItem,
			  success: function(){}
			}
		);
		
		thisClass.updateTotal();
		
		if ( $('#checkout_carrito .item').length == 0 ) {
		    thisClass.showNoProducts();
		}
		
	}
	
	this.updateTotal = function()
	{

		var total = 0;
		$('#checkout_carrito .item .total').each
		(
				function(i,elem)
				{
					total += parseFloat( $(elem).html().replace('$','').replace('.-','').replace('.','').replace(',','.') );
				}
		);
										
		var totalDiv = $('#checkout_carrito .checkoutSubTotal .total');
		$('#checkout_carrito .checkoutSubTotal .total').html( total );
		totalDiv.formatCurrency( { digitGroupSymbol: '.', decimalSymbol: ',' } );
		totalDiv.html( totalDiv.html() + '.-' );
		
		return total;
	}
	
	
	this.removeOptions = function(selector)
	{
		$(selector)
	    .find('option')
	    .remove()
	    .end()
	}
	
    this.showNoProducts = function()
    {
        $("#generalError").html( "No hay productos cargados en el carrito." );
        $("#generalError").removeClass('hide').addClass('show');
        $("#goToPaso2").remove();
    }
	
	this.init();
}