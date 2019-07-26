var productoListaSticker = function()
{
	var thisClass = this;
	
	this.init = function()
	{				
		$("#selectOrder").change( function() { window.location.href = $("#selectOrder").val(); } );
        $("#selectRPP").change( function() { window.location.href = $("#selectRPP").val(); } );
                
        $.ias({
            container  : ".listado",   
            item       : ".item",
            pagination : "#contentPaginator",
            next       : "#contentPaginator .next",
            loader     : "/images/paginator-loader.gif",
            onPageChange: function(pageNum, pageUrl, scrollOffset) {                
              var posSigno = window.location.href.indexOf('?');
              if ( posSigno == -1 ) posSigno = window.location.href.length;
              var posNumeral = window.location.href.indexOf('#');
              if ( posNumeral == -1 ) posNumeral = window.location.href.length;
              
              var pos = ( posNumeral < posSigno ) ? posNumeral : posSigno;
                
              var baseUrl = ( pos == -1 ) ? window.location.href : window.location.href.substr(0, pos );
              ga('send', 'pageview', baseUrl + pageUrl);
            }
          });
        
        $(window).scroll( function(){
            
            $(".subir").css('bottom', 15);
            $(".subir").css('left', $(window).width() / 2 + $(".listadoProductos").width()/2 + 15 );
            
           var minPosition = $(window).height();
           var maxPosition = $(".listadoProductos .boxContainer").last().offset().top;
               maxPosition += $(".listadoProductos .boxContainer").height() - $(window).height();
               maxPosition += parseInt( $(".listadoProductos .boxContainer").css('margin-top').replace('px','') );
               maxPosition += parseInt( $(".listadoProductos .boxContainer").css('margin-left').replace('px','') );
               
               
           if ( $(window).scrollTop() < minPosition ) {
               $(".subir").hide();
           } else if ( $(window).scrollTop() > maxPosition && $('.ias_loader').length == 0 ) {
               $(".subir").css("position","absolute");
               $(".subir").css("left", 955);
           } else { 
               $(".subir").show();
               $(".subir").css("position","fixed");
           }
        });
        
        $(".subir").click( function(){ 
            $("html, body").animate({ scrollTop: 0 }, 600);
        } );
        
        
	};
	
	this.init();   
}

$(document).ready( function() { new productoListaSticker(); } );