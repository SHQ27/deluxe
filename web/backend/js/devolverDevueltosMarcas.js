var devolverDevueltosMarcas = function()
{	
	this.init = function()
	{
        $(".select-all").click( function(){
            $(".devueltosMarcasDevolver table input").attr( "checked", true );
        } );
        
        $(".remove-all").click( function(){
            $(".devueltosMarcasDevolver table input").attr( "checked", false );
        } );

	}
	
	this.init();   
}

$(document).ready( function() { new devolverDevueltosMarcas(); } );