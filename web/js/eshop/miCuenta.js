var miCuenta = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.miCuentaHelper = new miCuentaHelper();
        
        $("#mi_cuenta #paso-1 .item").click( function(ev){
                                
            if ( $(ev.target).hasClass("avoid-click") || $(ev.target).hasClass("select" ) ) {
                return;
            }
            
            var checkbox = $(this).find(".checkbox");
            
            if ( checkbox.hasClass('selected') ) { 
                checkbox.removeClass('selected');
            } else {
                checkbox.addClass('selected');
            }
            
            checkbox.val('');
        });
        
        // Fuerzo la eleccion de la devolucion por MP en el segundo paso de la devolucion
        $('[name="devoluciones[credito]"]').click()

        // Inicializo las configuraciones propias para mobile
        if (isMobile)  { this.initMobile(); }
    };

    this.initMobile = function()
    {
        $(function(){

             $('#mi_cuenta .panel .miCuentaMenu a[href*=#]').click(function() {

             if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')
                 && location.hostname == this.hostname) {

                     var $target = $(this.hash);

                     $target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');

                     if ($target.length) {

                         var targetOffset = $target.offset().top;

                         $('html,body').animate({scrollTop: targetOffset}, 1000);

                         return false;

                    }

               }

           });

        });
    };

    this.init();
};

$(document).ready( function() { new miCuenta(); } );