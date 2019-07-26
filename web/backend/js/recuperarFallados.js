var recuperarFallados = function()
{	
	this.init = function()
	{
        $(".select-all").click( function(){
            $(".falladosRecuperar table input").attr( "checked", true );
        } );
        
        $(".remove-all").click( function(){
            $(".falladosRecuperar table input").attr( "checked", false );
        } );

	    
	}
	
	this.init();   
}

$(document).ready( function() { new recuperarFallados(); } );