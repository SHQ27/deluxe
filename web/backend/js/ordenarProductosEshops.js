var ordenarProductosEshops = function()
{
	var self = this;

	this.init = function()
	{	
		self.updateSort();	

		$( ".resultados" ).sortable({
			update: function( event, ui ) { self.updateSort() }
		});

		$(".preordenarPorCategorias").click( function() { self.preordenarPorCategorias() }  );
	};

	this.preordenarPorCategorias = function() {
		$(".resultados .resultado").sort(
			function (a, b){
				if ( $(b).data('orden-categoria') != $(a).data('orden-categoria') ) {
					return ($(b).data('orden-categoria')) < ($(a).data('orden-categoria')) ? 1 : -1;
				} else {
					return ($(b).data('denominacion-producto')) < ($(a).data('denominacion-producto')) ? 1 : -1;
				}
			    
			}	
		).appendTo('.resultados');

		self.updateSort();
	}

	this.updateSort = function()
	{
		var data = {};

		$(".producto").each( function(i,e) {
		  var idProducto = $(e).data().id;
		  data[ idProducto ] = i;
		});

		$("#ordenarProductosEshops_data").val( JSON.stringify( data ) );
	};
	
	this.init();   
}

$(document).ready( function() { new ordenarProductosEshops(); } );