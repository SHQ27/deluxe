var formBonificacion = function()
{
	var thisClass = this;
	
	this.init = function()
	{
		this.widgetIdUsuario('#bonificacion_email_usuario');
		this.widgetIdUsuario('#bonificacion_filters_email_usuario');		
	}

	
	this.widgetIdUsuario = function(idWidget)
	{
				
             	function split( val )
             	{
             		return val.split( /,\s*/ );
             	}
             	
             	function extractLast( term )
             	{
             		return split( term ).pop();
             	}

             	$( idWidget )
             		// 
             		.bind( "keydown", function( event )
             		{
             			if ( event.keyCode === $.ui.keyCode.TAB &&
             					$( this ).data( "autocomplete" ).menu.active ) {
             				event.preventDefault();
             			}
             		})
             		.autocomplete({
             			minLength: 0,
             			source: function( request, response )
             			{
        					$.getJSON( "/backend/ajax/autocompleteUsuarios", { term: extractLast( request.term ) }, response );
        				},
             			focus: function()
             			{
             				// prevent value inserted on focus
             				return false;
             			},
             			select: function( event, ui ) {
             				this.value = ui.item.value
             				return false;
             			}
             		});

	};

	
	this.init();   
}

var formBonificacion;
$(document).ready( function() { formBonificacion = new formBonificacion(); } );