var formEditStock = function()
{
	var thisClass = this;
	
	this.init = function()
	{
		this.verWidgetProductoItem();

		preventDoubleSubmit.init('editStock');

		$(".vaciarPermanente").click( function(){ thisClass.vaciarCantidades('permanente') });
		$(".restaurarPermanente").click( function(){ thisClass.restaurarCantidades('permanente') });
		$(".vaciarCampana").click( function(){ thisClass.vaciarCantidades('campana') });
		$(".restaurarCampana").click( function(){ thisClass.restaurarCantidades('campana') });
		$(".vaciarRefuerzo").click( function(){ thisClass.vaciarCantidades('refuerzo') });
		$(".restaurarRefuerzo").click( function(){ thisClass.restaurarCantidades('refuerzo') });
	};


	this.vaciarCantidades = function(tipoStock)
	{
		$("[name*=cantidad_" + tipoStock + "]").val(0);
	}

	this.restaurarCantidades = function(tipoStock)
	{
		var className = '.stock' + tipoStock.charAt(0).toUpperCase() + tipoStock.slice(1);

		$("[name*=cantidad_" + tipoStock + "]").each(function(i,e) {
			var tr = $(e).parents('tr').first();
			var value =  parseInt(tr.find(className).html());
			$(e).val(value);
		});
	}
	
	this.verWidgetProductoItem = function()
	{
		$( ".sf_admin_form_field_stock tr td.ver a" ).click
		(
				function(e)
				{
					var idProductoItem = $(e.currentTarget).parent().parent().attr("rel")
					thisClass.showInfo(idProductoItem);
				}
		);
	}
	
	this.showInfo = function(idProductoItem)
	{
		var talle = $('[rel=' + idProductoItem + ']').find('[name*="[talle][]"]').attr("rel");
		var color = $('[rel=' + idProductoItem + ']').find('[name*="[color][]"]').attr("rel");

		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/productos/productoItemHistory",
			  dataType: "html",
			  data: "idProductoItem=" + idProductoItem,
			  success: function(html)
			  {
				  	$( "#batchEdit_info" ).html( html );				  
				  
					$( "#batchEdit_info" ).dialog({
						autoOpen: true,
			            show: {effect: "drop", duration: 250},
			            hide: {effect: "drop", duration: 250},
			            width: 780,
			            height: 400,
			            title: 'Informacion histórica del item :: Talle = ' + talle + ' / Color ' + color,
			            zIndex: 200
					});
					
			  }
			}
		);
	}
			
	this.init();
}

var formProducto;
$(document).ready( function() { formEditStock = new formEditStock(); } );