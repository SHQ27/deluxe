var devueltosOca = function()
{
	var thisClass = this;

	this.init = function()
	{		
	
		$('#procesarDevueltosOca_selectAll').change( function(){
			$('[name*="procesarDevueltosOca[id_pedido]"]').attr('checked', $('#procesarDevueltosOca_selectAll').attr('checked'));
		} );
	}
	
	this.init();   
}

$(document).ready( function() { new devueltosOca(); } );