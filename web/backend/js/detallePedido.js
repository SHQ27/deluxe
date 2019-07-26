var detallePedido = function()
{
	var thisClass = this;
	
	
	this.init = function()
	{
		thisClass.initPrepararEnvio();
		
		$(".detalleEstados a.confirm").click( function (ev) { thisClass.confirm(ev, this) });
		$(".detalleEstados a.ENVIADO").click( function (ev) { thisClass.changeEstadoEnvio(ev, this) });
		$(".detalleEstados a.NO_ENVIADO").click( function (ev) { thisClass.changeEstadoEnvio(ev, this) });
		
		
		$("a.addTooltip").easyTooltip ( {tooltipId: "divTooltip"} );
	}
	
	this.removeRow = function(elem)
	{
		$(elem).parents('tr').first().remove();
	}
	
	this.initPrepararEnvio = function()
	{
		$('#reciboDevolucion .button').click
		(
				function()
				{
					var monto = $("[name='devolucion[monto]']").val();
					var devolucion = $("[name='devolucion[devolucion]']:checked").val();
					var idPedido = $("[name='devolucion[idPedido]']").val();
					
					var productos = [];
					
					$("#reciboDevolucion .cantidad").each
					(
					    function(i,elem)
					    {
					    	productos.push( $(elem).attr('rel') + '|' + $(elem).val() )
					    }
					);
										
			      	window.open('/backend/pedidos/reciboDevolucion?monto=' + monto + '&devolucion=' + devolucion + '&idPedido=' + idPedido + '&detalle=' + productos.join(','), 'ReciboDevolucion', "width=700,height=800,scrollTo,resizable=1,scrollbars=1,location=0");
				}
		);
		
		$('#reciboDevolucion .eliminar').live('click', function(){ thisClass.removeRow(this) } );
	}
		
	this.confirm = function(ev, elem)
	{
		var elem = $(elem);
		
		var message = 'Elijió: "' + elem.html() + '". Está seguro?'
		
	    if (!window.confirm( message ))
	    {
	        ev.preventDefault();
	    }
	}
	
	
	this.confirm = function(ev, elem)
	{
		var elem = $(elem);
		
		var message = 'Elijió: "' + elem.html() + '". Está seguro?'
		
	    if (!window.confirm( message ))
	    {
	        ev.preventDefault();
	    }
	}
	
	this.changeEstadoEnvio = function(ev, elem)
	{	
		var elem = $(elem);
		
		if(elem.attr("class") == "ENVIADO")
		{
			var codigo = prompt("Ingrese el código de seguimiento");
			
			if (codigo)
			{
				window.location.href = elem.attr("href") + '?codigo=' + codigo;
			}
			ev.preventDefault();
		}
		else
		{
			var message = 'Elijió: "' + elem.html() + '". Está seguro?'
		    if (!window.confirm( message ))
		    {
		        ev.preventDefault();
		    }
		}
	}
		
	this.init();   
}

$(document).ready( function() { new detallePedido(); } );