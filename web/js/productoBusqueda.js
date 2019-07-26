var productoBusqueda = function()
{
	var thisClass = this;
	
	this.init = function()
	{
		$("#selectOrder").change( function() { window.location.href = $("#selectOrder").val(); } )
		$("#selectRPP").change( function() { window.location.href = $("#selectRPP").val(); } )
	};
	
	this.init();   
}

$(document).ready( function() { new productoBusqueda(); } );