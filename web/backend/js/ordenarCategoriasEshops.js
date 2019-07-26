var ordenarCategoriasEshops = function()
{
	var self = this;

	this.init = function()
	{	
		self.updateSort();

		$( ".prendas, .accesorios" ).sortable({
			connectWith: ".sortable",
			update: function( event, ui ) { self.updateSort() }
		});
	};

	this.updateSort = function()
	{
		var data = { 'prendas': {}, 'accesorios': {} };

		$(".prendas .categoria").each( function(i,e) {
		  var idProducto = $(e).data().id;
		  data['prendas'][ idProducto ] = i;
		});

		$(".accesorios .categoria").each( function(i,e) {
		  var idProducto = $(e).data().id;
		  data['accesorios'][ idProducto ] = i;
		});

		$("#ordenarCategoriasEshops_data").val( JSON.stringify( data ) );
	};
	
	this.init();   
}

$(document).ready( function() { new ordenarCategoriasEshops(); } );