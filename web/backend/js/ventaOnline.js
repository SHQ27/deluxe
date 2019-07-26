var ventaOnline = function()
{
	var thisClass = this;

	this.init = function()
	{		
		
		$(".reporteVentaOnline .helpButton").easyTooltip();
	}
	
	this.init();   
}

$(document).ready( function() { new ventaOnline(); } );