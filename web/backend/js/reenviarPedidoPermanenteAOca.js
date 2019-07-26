var reenviarPedidoPermanenteAOca = function()
{   
	var thisClass = this;

	this.init = function()
	{		
	    
	    $("#mostrarPedido").click( function(e){
	        
	        e.preventDefault();
	        
	        var idPedido = $("#idPedido").val(); 
	        
	        $.ajax
	        (
	            {
	              type: "POST",
	              url: "/backend/pedido/getJsonInfo",
	              dataType: "json",
	              data: "idPedido=" + idPedido,
	              success: function(response)
	              {
	                  var data = response.data;
	                  
	                  if ( !response.status )
	                  {
	                      $('#infoPedido').html( '<p><strong>El pedido solicitado no existe.</strong></p>' );
	                      return;
	                  }
	                  
                      var pedido = data.pedido;
                      var pedidoProductoItems = data.pedidoProductoItem;
	                  
                      var  html = '<form method="post">';
                      
	                  html += '<h2>Pedido #' + pedido.id_pedido  + '</h2>';
	                  
	                  html += '<input type="hidden" name="reenviarPedidoPermanenteOCA[id_pedido]" value="' + pedido.id_pedido + '" />';
	                  
	                  html += '<table>';
	                  html += '    <tr>';
                      html += '     <th><strong>Producto</strong></th>';
                      html += '     <th><strong>Marca</strong></th>';
                      html += '     <th><strong>Talle</strong></th>';
                      html += '     <th><strong>Color</strong></th>';
                      html += '     <th><strong>Cantidad</strong></th>';
                      html += '     <th><strong>Acción</strong></th>';
                      html += ' </tr>';	                  
	                  
	                  for ( i in pedidoProductoItems )
	                  {
	                      var row = pedidoProductoItems[i];
	                      
	                      html += ' <tr>';
	                      html += '     <td>' + row.denominacion + '</td>';
	                      html += '     <td>' + row.marca + '</td>';
	                      html += '     <td>' + row.talle + '</td>';
	                      html += '     <td>' + row.color + '</td>';
	                      html += '     <td><input name="reenviarPedidoPermanenteOCA[cantidades][' + row.idPedidoProductoItem + ']" value="' + row.cantidad + '" /></td>';
	                      html += '     <td><a class="eliminar">Eliminar</a></td>';
	                      html += ' </tr>';
	                  }
	                  
	                  html += '</table>';
	                  
	                  html += '<input type="submit" value="Reenviar a OCA">';
	                  
	                  html += '</form>';
	                  	                  
	                  $('#infoPedido').html( html );
	              }
	            }
	        );
	    } );
	    
	    $('.reenviarPedidoPermanenteAOca table .eliminar').live('click', function(){ $(this).parents('tr').first().remove(); } );
	    	    
	}
	
	this.init();   
}

$(document).ready( function() { new reenviarPedidoPermanenteAOca(); } );