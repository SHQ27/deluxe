var productoImportarPreview = function()
{
	var thisClass = this;
	
	
	this.init = function()
	{
		$("a.addTooltip").easyTooltip
		(
			{
				tooltipId: "divTooltip"
			}
		);	
	}
		
	
	this.init();   
}

$(document).ready( function() { new productoImportarPreview(); } );