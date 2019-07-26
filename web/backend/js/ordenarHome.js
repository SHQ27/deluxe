var ordenarHome = function()
{
	var self = this;

	this.init = function()
	{	
		self.updateSort();
		
		self.windowResize();
		$( window ).resize(function(ev) { self.windowResize();  });   

		$( ".resultados" ).sortable({
			update: function( event, ui ) { self.updateSort() }
		});

		$(".resultado img").error(function () { 
		    $(this).hide(); 
		});

	};

	this.updateSort = function()
	{
		var data = {};

		$(".resultado").each( function(i,e) {
		  var id = $(e).data().id;
		  data[ id ] = i;
		});

		$("#ordenarHome_data").val( JSON.stringify( data ) );
	};

	this.windowResize = function()
	{	
		var ppr = Math.floor( $(".resultados").width() / 316 );
		var lines = Math.ceil( $(".resultados .resultado").length / ppr );
		$(".resultados").height( lines * 304 + 100 );
	};
	
	this.init();   
}

$(document).ready( function() { new ordenarHome(); } );