var restaurarStockCampana = function()
{
	this.init = function()
	{				
	    $(".restaurarStockCampana table a").click( function(ev){
	        
	        ev.preventDefault();
	        
	        var url = $(this).attr("href");
	        
	        tr = $(this).parents('tr').first();
	        
	        var idCampana = tr.find('.idCampana').val();
	        var idMarca = tr.find('.idMarca').val();
	        var idProductoCategoria = tr.find('.idProductoCategoria').val();
	        window.location.href = url + '?idCampana=' + idCampana + '&idMarca=' + idMarca + '&idProductoCategoria=' + idProductoCategoria;
	    });
	};

	this.init();
}

$(document).ready( function() { new restaurarStockCampana(); } );