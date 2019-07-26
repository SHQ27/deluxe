var waitList = function()
{
	var thisClass = this;
	
	this.init = function()
	{
		$(".verDetalle").click( function(){ thisClass.showInfo( $(this).attr("rel") ); } );
	}

	
	this.showInfo = function(idProducto)
	{
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/waitList/getDetails",
			  dataType: "html",
			  data: "idProducto=" + idProducto,
			  success: function(html)
			  {
				  	$( "#waitListDetail" ).html( html );				  
				  
					$( "#waitListDetail" ).dialog({
						autoOpen: true,
			            show: {effect: "drop", duration: 250},
			            hide: {effect: "drop", duration: 250},
			            width: 780,
			            height: 400,
			            title: 'WaitList para el producto #' + idProducto,
			            zIndex: 200
					});
					
			  }
			}
		);
	}	
	this.init();   
}

var waitList;
$(document).ready( function() { waitList = new waitList(); } );