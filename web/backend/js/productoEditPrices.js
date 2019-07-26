var productoEditPrices = function()
{
	var thisClass = this;
	
	
	this.init = function()
	{
		$(".actualizar a").click( function (ev) { thisClass.aplicarPorcentaje(ev, this) });
		$(".pasarPrecioListaANormal").click( function (ev) { thisClass.pasarPrecioListaANormal() });
		$(".redondear").click( function (ev) { thisClass.redondear(ev, this) });
	}

	this.pasarPrecioListaANormal = function()
	{

		$('[name*="productosEditarPrecios[precio_lista"]').each
		(
			function(i,e)
			{				
				var precioLista = $(e).val();
				var id = $(e).attr('id').replace('productosEditarPrecios_precio_lista_', '');
				$("#productosEditarPrecios_precio_normal_" + id).val(precioLista);
			}
		);		
	}

	this.redondear = function(ev, elem)
	{
		var button = $(elem);
		var type = button.attr("rel").replace('button_', '');

		console.log(type);

		$('[name*="productosEditarPrecios[' + type + '"]').each
		(
			function(i,e)
			{				
				$(e).val( Math.ceil( $(e).val() ) );
			}
		);		
	}
		
	this.aplicarPorcentaje = function(ev, elem)
	{
		var button = $(elem);
		var type = button.attr("class").replace('button_', '');
		var porc = parseFloat( $( '#porc_' + type).val() ); 
		porc = porc/100; 
					
		$('[name*="productosEditarPrecios[' + type + '"]').each
		(
			function(i,e)
			{				
				var input = $(e);
				var valorOriginal = parseFloat(input.val()) + parseFloat(input.val() * porc);

				if ( type == 'costo' || type == 'precio_lista' ) {
					input.val( valorOriginal );
				} else {
					valorOriginal = parseFloat(valorOriginal / 10);

					var valorRedondeado = parseFloat(Math.round(valorOriginal));
					var valor = ( parseFloat(valorRedondeado - 0.1) ) * 10 ;
					input.val( valor + '.00' );
				}

				
			}
		);		
		
	}
	

	
	this.init();   
}

$(document).ready( function() { new productoEditPrices(); } );