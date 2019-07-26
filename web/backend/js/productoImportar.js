var productoImportar = function()
{
	var self = this;
	
	
	this.init = function()
	{
		self.updateEshop();
		$("#id_eshop").change( self.updateEshop );
	};

	this.updateEshop = function()
	{
		var idEshop = $("#id_eshop").val();
		if ( idEshop ) {
			$(".divMarca").hide();
			$(".divOrigen").hide();
		} else {
			$(".divMarca").show();
			$(".divOrigen").show();
		}
	};
		
	
	this.init();   
}

$(document).ready( function() { new productoImportar(); } );