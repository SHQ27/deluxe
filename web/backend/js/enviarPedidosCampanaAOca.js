var enviarPedidosCampanaAOca = function()
{
    var thisClass = this;
    
	this.init = function()
	{   	    
		$('#enviarPedidosCampanaAOcaForm_campana').change( function(){ thisClass.updatePedidos(); } )		
		thisClass.updatePedidos();
		thisClass.togglesChecks();
		
		$("[name*='enviarPedidosCampanaAOcaForm[pedidos]']").live('change' ,function(){ thisClass.updateContadorPedidos(); } )
		
		$('.enviarPedidosCampanaAOca #verificarEnvio').click( function(){ thisClass.verificarEnvio()  } )
	};
	
	this.updateContadorPedidos = function()
	{
	    $("#cant_pedidos_seleccionados").html( $("[name*='enviarPedidosCampanaAOcaForm[pedidos]']:checked").length );    
	};
	
	this.updatePedidos = function()
	{
		var idCampana = $('#enviarPedidosCampanaAOcaForm_campana').val()
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/ajax/getEnviarPedidosCampanaAOca",
			  dataType: "json",
			  data: "idCampana=" + idCampana,
			  cache : false,
			  success: function(results)
			  {
			      
				  	var table = $('table.pedidos tbody');
				  	
				  	if (results.length)
				  	{
				  	    var htmlPedidos = '';
					    for(i in results)
					    {
					    	var row = results[i];
					    
					    	htmlPedidos += '<tr>';
					    	
					    	
					    	htmlPedidos += '  <td id="pedido-' + row.idPedido + '"><input type="checkbox" name="enviarPedidosCampanaAOcaForm[pedidos][' + row.idPedido +']" value="' + row.idPedido + '" /></td>';
					    	htmlPedidos += '  <td><a href="/backend/pedidos/' + row.idPedido +'/ListView">' + row.idPedido + '</a></td>';
					    	htmlPedidos += '  <td>' + row.fechaAlta + '</td>';
					    	htmlPedidos += '  <td>' + row.datosCliente + '</td>';
					    	
					    	htmlPedidos += '  <td>';
					    	htmlPedidos += '      <table class="productos">';
					    	
                            htmlPedidos += '      <tr>';
                            htmlPedidos += '          <th width="80">Codigo</th>';
                            htmlPedidos += '          <th width="200">Producto</th>';
                            htmlPedidos += '          <th width="120">Marca</th>';
                            htmlPedidos += '          <th width="80">Talle</th>';
                            htmlPedidos += '          <th width="80">Color</th>';
                            htmlPedidos += '          <th width="40">Cantidad</th>';
                            htmlPedidos += '      </tr>';
					    	
					    	for ( j in row.productos )
					    	{
					    	    var rowPedido = row.productos[j];
					    	    
					    	    htmlPedidos += '      <tr>';
					    	    htmlPedidos += '          <td>' + rowPedido.codigo + '</td>';
					    	    htmlPedidos += '          <td><a href="' + rowPedido.url +'">' + rowPedido.denominacion + '</a></td>';
					    	    htmlPedidos += '          <td>' + rowPedido.marca + '</td>';
					    	    htmlPedidos += '          <td>' + rowPedido.talle + '</td>';
					    	    htmlPedidos += '          <td>' + rowPedido.color + '</td>';
					    	    htmlPedidos += '          <td>' + rowPedido.cantidad + '</td>';
					    	    htmlPedidos += '      </tr>';
					    	}
					    	    htmlPedidos += '  </table>';
					    	htmlPedidos += '  </td>';
					    	
                            htmlPedidos += '</tr>';
					    	
						}
					    
					    table.html( htmlPedidos );
					    
				  	}
				  	else
				  	{
				  		table.html( $('<tr><td colspan="5" style="text-align: center;">No hay pedidos pendientes de envios para esta campaña</td></tr>') );	
				  	}
			    	  
			  }
			}
		);
	};
	
    this.verificarEnvio = function()
    {
        var idPedidos = [];
        
        $("[name^='enviarPedidosCampanaAOcaForm[pedidos]']:checked").each( function(i,e){
            idPedidos.push( $(e).val() ); 
        });
        
        var idCampana = $('#enviarPedidosCampanaAOcaForm_campana').val()
        
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/verificarEnvioCampanaAOca",
              dataType: "json",
              data: "idPedidos=" + idPedidos.join(',') + '&idCampana=' + idCampana,
              cache : false,
              success: function(results)
              {
                  $(".verificacion").show();
                  
                  if ( results.length )
                  {
                      var htmlFaltantes = '';
                      for(i in results)
                      {
                          var row = results[i];
                      
                          var htmlPedidos = '';
                          
                          for(i in row.idPedidos)
                          {
                              htmlPedidos += "<a href=#pedido-" + row.idPedidos[i] + ">" + row.idPedidos[i] + "</a> ";
                          }
                          
                          
                          htmlFaltantes += '<tr>';
                          htmlFaltantes += '    <td>' + row.codigo + '</td>';
                          htmlFaltantes += '    <td>' + row.producto + '</td>';
                          htmlFaltantes += '    <td>' + row.marca + '</td>';
                          htmlFaltantes += '    <td>' + row.talle + '</td>';
                          htmlFaltantes += '    <td>' + row.color + '</td>';
                          htmlFaltantes += '    <td>' + row.cantidad + '</td>';
                          htmlFaltantes += '    <td>' + htmlPedidos + '</td>';
                          htmlFaltantes += '</tr>';
                          
                      }
                      
                      $('table.faltantes tbody').html( htmlFaltantes );
                      
                      $(".faltantes").show();
                      $(".faltantesOk").hide();
                      $(".faltantesError").show();
                      $("#enviarPedidos").hide();
                  }
                  else  
                  {
                      $(".faltantes").hide();
                      $(".faltantesError").hide();
                      $(".faltantesOk").show();
                      $("#enviarPedidos").show();
                  }
              }
            }
        );
        
        
    };
	
    this.togglesChecks = function()
    {
        $('#selectAll').live('change', function() {
            
            if ( $(this).attr('checked') )
            {
                $('.pedidos input[type="checkbox"]').attr('checked','checked');
            }
            else
            {
                $('.pedidos input[type="checkbox"]').removeAttr('checked');
            }
            
            thisClass.updateContadorPedidos();
            
        } );
    };
	this.init();   
}

$(document).ready( function() { new enviarPedidosCampanaAOca(); } );