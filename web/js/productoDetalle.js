var productoDetalle = function()
{
    var thisClass = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.productoDetalleHelper = new productoDetalleHelper(false);
        
        // Manejo de imagenes y zoom
        $('.product-picture').cycle({
            fx:     'scrollHorz',
            speed:  'slow',
            timeout: 0,
            pager:  '.slider',
            pagerTemplate: ''
        }); 
        
        $('#ficha .blockContentTwo.imagesBlock img.bigImage:visible').addimagezoom({
            magnifierpos: 'right',
            cursorshade: true,
            magnifiersize: [528,649],
            width: 390,
            height: 588,
            largeimage: $('.productRecordSlider .slider li img').attr("src").replace('chica', 'grande'),
            disablewheel: true
        });
        
        $('.productRecordSlider .slider li img').click(function(){
            $('.magnifyarea img').attr("src", $(this).attr("src").replace('chica', 'grande'));
        });
        
        
        if ($('.productRecordSlider .slider li').length > 4 ){
            $(".productRecordSlider").jcarousel({
                wrap: 'circular',
                scroll: 1
            });
        }
        
        // Share Buttons
        setTimeout( function(){
            $("#pinterest_button a").attr("class", "sprite blackIcons pinterest");
            $(".shareProduct").removeClass("hide");
            $(".shareProduct").addClass("show");
        }, 5000 );
        
        $(".shareProduct .mail").click( function() { thisClass.mostrarRecomendarProducto(); });
        
       
        
        // Recomendar        
        $("#recomendarProducto form").submit( function (ev) { thisClass.recomendarProducto(ev, this); });
    };
    
    this.mostrarRecomendarProducto = function(ev)
    {
        $("#recomendarProducto").dialog({
            width: 400,
            height: 200,
            modal: true,
            resizable: false,
            zindex: 99999,
            dialogClass: "alert"
        });
        
        $(".ui-widget-overlay").click(function(){ $("#recomendarProducto").dialog('close'); });
        $("#recomendarProducto .cerrar").click(function(){ $("#recomendarProducto").dialog('close'); });
        
    };
    
    
    this.recomendarProducto = function(ev, form)
    {
        ev.preventDefault();    

        $.ajax
        (
            {
              type: "POST",
              url: "/producto/recomendar",
              dataType: "json",
              data: $(form).serialize(),
              success: function(result)
                        {
                            if (result.status == 'OK')
                            {
                                $("#recomendarProducto").dialog('close');
                            }
                            else
                            {
                                $('#recomendarProducto .alert').html(result.message);
                            }
                        }
            }
        );
        
   };
        
   this.init();   
};

$(document).ready( function() { new productoDetalle(); } );