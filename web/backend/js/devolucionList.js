var devolucionList = function()
{
	var thisClass = this;

	this.init = function()
	{		
	    $(".sf_admin_action_view a").click( function(ev){ thisClass.showInfo( ev, $(this).attr("rel") ) } );
	}
	
    this.showInfo = function(ev, idDevolucion)
    {
        ev.preventDefault();
        
        $.ajax
        (
            {
              type: "POST",
              url: '/backend/devolucion/ver',
              data: 'idDevolucion=' + idDevolucion,
              dataType: "html",
              success: function(html)
              {
                    $( "#devoluciones_info" ).html( html );     
                  
                    $( "#devoluciones_info" ).dialog({
                        autoOpen: true,
                        show: {effect: "drop", duration: 250},
                        hide: {effect: "drop", duration: 250},
                        width: 780,
                        height: 400,
                        title: 'Información sobre la devolución  #' + idDevolucion,
                        zIndex: 200
                    });
                    
              }
            }
        );
    }
	
	this.init();   
}

$(document).ready( function() { new devolucionList(); } );