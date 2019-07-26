var contactoHelper = function()
{
	var self = this;

	this.init = function()
	{		
        $(".respuesta img").each(function(){ 
            var image = $(this); 
            if(image.context.naturalWidth == 0 || image.readyState == 'uninitialized'){  
               $(image).unbind("error").hide();
            } 
         }); 
	    
        $('#consultas .titleFaqCategoria').click( function(){
            var id = $(this).attr("rel");
            $("#faqCategoria_" + id).slideToggle();
        });
	    
        $('#consultas .pregunta').click( function(){
            var id = $(this).attr("rel");
            $("#respuesta_" + id).slideToggle();
        });
        		
		$('#consultas .respuesta a').click( function(){
			var href = $(this).attr("href");
			
			if ( href.substr(0,10) == '#pregunta_' )
			{
			    $("#respuesta_" + href.substr(10) ).slideDown();    
			}
			
		});

		$('.buttonContacto').click( function(){
			$("#contactoForm").slideToggle();
		});
				
	}
	
	this.init();
}