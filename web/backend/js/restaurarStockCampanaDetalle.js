var restaurarStockCampanaDetalle = function()
{
	var self = this;

	this.init = function()
	{	
		self.updateChecks();
		
		// Seleccionar todos	
		$(".checkAll").click( function(ev){

			var checked = $(this).attr('checked');

			$(".check").each( function(i, el) {
				$(el).attr('checked', checked );
			});

			self.updateChecks();
		});

		// Elimino el Check individual
		$("input[type='checkbox']").click( function(ev){ ev.stopPropagation(); });

		// Actualizacion del input hidden al hacer submit
		$("form").submit( function(ev){

			ev.preventDefault();

			if ( $(this).data('submitted') !== true ) {
				$(this).data('submitted', true);
				self.updateChecks();
				$('.restaurarStockCampana input[type=submit]').last().after('<span class="procesando">Procesando...</span>');
				this.submit();
			}

		});

		// Click en TR
		$("table tr").click( function(ev){ 
			var idProducto = $(this).find(".idProductoItem").data().idproducto;
      var check = $(".check[value=" + idProducto + "]");
      check.attr('checked', !check.attr('checked') );
		});

	};

	this.updateChecks = function()
	{
			var ids = [];
			$(".check:checked").each( function(i, el) {
				var idProducto = $(el).val();
				$('.idProductoItem-' + idProducto).each( function(i, pi){
				  ids.push( $(pi).data().id );
				});				
			});

			$(".idsProductoItems").val( ids.join(',') );
	};
	
	this.init();   
}

$(document).ready( function() { new restaurarStockCampanaDetalle(); } );