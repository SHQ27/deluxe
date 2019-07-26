var productoDetalle = function()
{
    var self = this;    

    this.init = function()
    {   
        // Inicializo el Helper
        self.productoDetalleHelper = new productoDetalleHelper(true);

        // Inicializo las configuraciones propias para desktop
        if (!isMobile) { this.initDesktop(); }

        // Inicializo las configuraciones propias para mobile
        if (isMobile)  { this.initMobile(); }
    };

    this.initMobile = function()
    {
        self.initSlider('productoImagenSlider');
    };

    this.initDesktop = function()
    {
        // Selecciono y cargo la primer imagen
        var firstPicture = $(".thumb").first();
        firstPicture.addClass("selected");
        self.changePicture( firstPicture );
        
        // Manejo de imagenes y zoom
        $(".thumb").hover(function(){ self.changePicture( $(this) ); });  



        // Configuracion solo para Naima
        if ( idEshop == 10 ) {
            $(window).scrollTop(135);
        }

    };
    
    
    this.changePicture = function( thumb ){
                
        $(".thumb").removeClass("selected");
        thumb.addClass("selected");
        $("#foto_grande img").attr("src", thumb.data().imagenGrande);
        $("#foto_grande img").elevateZoom({ zoomType    : "inner", cursor: "crosshair" });
    };

    this.initSlider = function(tipo)
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
    
    
    this.init();   
};

$(document).ready( function() { new productoDetalle(); } );