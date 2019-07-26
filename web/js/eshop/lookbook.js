var lookbook = function()
{    
    var self = this;


    this.init = function()
    {
        // Inicializo las configuraciones propias para desktop
        if (!isMobile) { this.initDesktop(); }

        // Inicializo las configuraciones propias para mobile
        if (isMobile)  { this.initMobile(); }
    };

    this.initMobile = function()
    {   
        $(".lookbook .item img").each( function(i,item){
            var originalWidth  = $(item).width();
            var originalHeight = $(item).height();

            $(item).css("width","100%");

            var newWidth  = $(item).width();
            var newHeight = $(item).height();

            var coeficienteWidth = newWidth / originalWidth;
            var coeficienteHeight = newHeight / originalHeight;

            $(item).parents('.item').first().find('.lookbookPointer').each( function(j,pointer){
                var top = $(pointer).css('top').replace('px', '');
                $(pointer).css('top', top * coeficienteHeight );

                var left = $(pointer).css('left').replace('px', '');
                $(pointer).css('left', left * coeficienteWidth);
            });
        });
        $(".lookbook .container").css('visibility', 'visible');

        $(".lookbookPointer").click( function(){
            $("#infoProducto").append($(this).find(".infoProducto .contenedor").clone());
            $("#infoProducto").show();
            $("#infoProductoOverlay").show();
        });

        $("#infoProductoOverlay").click( function(){
            $("#infoProducto").html('');
            $("#infoProducto").hide();
            $("#infoProductoOverlay").hide();
        });

        

    };

    this.initDesktop = function()
    {
        this.modalZoom();

        // Window Resize
        setTimeout( function(){ self.windowResize(); }, 500 );
        setTimeout( function(){ self.windowResize(); }, 10000 );
        $( window ).resize(function(ev) { self.windowResize(); });           
    };

    this.windowResize = function()
    {
        var imageWidth = $(".lookbook .item").first().width();
        var imagePerRow = Math.floor( (998) / (imageWidth + 18));

        var margin = Math.floor( ( 998 - (imagePerRow * (imageWidth + 18)) ) / 2);

        $(".lookbook .container").css('width', 998 - (margin * 2) );
        $(".lookbook .container").css('padding-left', margin);
        $(".lookbook .container").css('padding-right', margin);
        $(".lookbook .container").css('visibility', 'visible');
    };

    this.modalZoom = function()
    {

        $(".lookbook .item").click( function() {

            var idEshopLookbook = $(this).attr('rel');
            var points = dataModal[ idEshopLookbook ].points;

            $('#modalZoom h3').html( dataModal[ idEshopLookbook ].denominacion );
            $('#modalZoom p').html( dataModal[ idEshopLookbook ].texto );
            $('#modalZoom img').attr('src', dataModal[ idEshopLookbook ].imagen);

            $('#modalZoom .lookbookPointer').remove();
            for ( i in points) {

                var top          = points[i].top;
                var left         = points[i].left;
                var denominacion = points[i].denominacion;
                var precio       = points[i].precio;
                var url          = points[i].url;

                $('#modalZoom .imagen').append('<div class="lookbookPointer" style="top: ' + top + 'px ;left: ' + left + 'px;"><div class="indicador"></div><div class="infoProducto"><div class="contenedor"><div class="titulo">' + denominacion + '</div><div class="precio">$' + precio + '</div><a class="link" href="' + url + '">Comprar</a></div></div></div>');
            }

            setTimeout( function(){
                $("#modalZoom").dialog({
                    width: 600,
                    height: 720,
                    modal: true,
                    dialogClass: "lookbookDialog",
                    open: function() { $('.ui-widget-overlay').addClass('lookbookOverlay'); },
                    close: function() { $('.ui-widget-overlay').removeClass('lookbookOverlay'); }
                });    

                $(".ui-widget-overlay").click(function(){ $("#modalZoom").dialog('close') });

             }, 200 );
        });
    }
        
    this.init();
}

$(window).load( function() { new lookbook(); } );