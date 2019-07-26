var home = function()
{    
    var self = this;

    this.init = function()
    {
        self.initVideoControl();

        // Inicializo las configuraciones propias para desktop
        if (!isMobile) { this.initDesktop(); }

        // Inicializo las configuraciones propias para mobile
        if (isMobile)  { this.initMobile(); }
    };

    this.initMobile = function()
    {
        self.initBannerMobile('BPRFS');
        self.initBannerMobile('BPRNO .container');
    };

    this.initDesktop = function()
    {
        self.initDestacados();
        self.initBannerDesktop('BPRFS');
        self.initBannerDesktop('BPRNO .container');

        // Window Resize
        $(".BPRFS .flex-direction-nav").hide();
        $(".BPRNO .flex-direction-nav").hide();

        setTimeout( function(){
            $(window).resize();
         }, 500 );
        
        $( window ).resize(function(ev) {
            self.windowResize('BPRFS'); 
            self.windowResize('BPRNO'); 
        });
    };
    

    this.initVideoControl = function()
    {
        $(".seccion.bannerHome video").click( function(e){
            var idEshopHomeMultimedia =  $(this).attr('rel');
            var control = $(".seccion.bannerHome .control[rel=" + idEshopHomeMultimedia + "]");
            control.click();
        } );

        $(".seccion.bannerHome .control").click( function(e){

            var idEshopHomeMultimedia =  $(this).attr('rel');
            var video = $(".seccion.bannerHome video[rel=" + idEshopHomeMultimedia + "]").get(0);

            video.addEventListener('ended', function endVideo(e) {
                var control = $(".seccion.bannerHome .control[rel=" + idEshopHomeMultimedia + "]");
                control.removeClass('pause');
                control.addClass('play');
            },false);

            if ( $(this).hasClass('play') ) {
                video.play();
                $(this).removeClass('play');
                $(this).addClass('pause');
            } else {
                video.pause();
                $(this).removeClass('pause');
                $(this).addClass('play');
            }            
        } );

    };

    this.initDestacados = function() {
        $('.flexslider').flexslider({
            animation: "slide",
            animationLoop: false,
            itemWidth: 210,
            itemMargin: 5,
            minItems: 4,
            maxItems: 4,
            prevText: "",
            nextText: ""
        });
        
        if ( $(".flexslider .slides li").length < 4 ) {
            $(".flexslider .flex-direction-nav").hide();  
        };
    }

    this.initBannerDesktop = function(tipo)
    {
        if ( $("." + tipo +  " .slides li").length > 1 ) {
            
            $("." + tipo ).flexslider({
                animation: "slide",
                controlNav: true,
                slideshowSpeed: 10000,
                prevText: "",
                nextText: ""
            });
    
        }
    }

    this.initBannerMobile = function(tipo)
    {
        if ( $("." + tipo +  " .slides li").length > 1 ) {
            
            $("." + tipo ).flexslider({
                animation: "slide",
                directionNav: false,
                controlNav: true,
                slideshowSpeed: 10000,
                prevText: "",
                nextText: ""
            });
    
        }
    }

    this.windowResize = function(tipo)
    {

        var top = $("." + tipo + " .flex-viewport").height()*(3/7);
        $("." + tipo + " .flex-prev").css('top', top );
        $("." + tipo + " .flex-next").css('top', top );
                                    
        var left = $("." + tipo + " .flex-viewport").width() - 180;
        $("." + tipo + " .flex-next").css('left', left );
        
        setTimeout( function(){ self.windowResize(); }, 1000 );
        $("." + tipo + " .flex-direction-nav").show();
    };
    
        
    this.init();
}

$(document).ready( function() { new home(); } );