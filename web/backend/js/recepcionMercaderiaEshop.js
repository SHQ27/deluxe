var recepcionMercaderiaEshop = function()
{
    var self = this;
    
    this.init = function()
    {
        $("[name*=cantidad_recibida]").change( function() {
            var tr = $(this).parents('tr').first();
            var cantidadRequerida = parseInt( tr.find('.cantidadRequerida').html() );
            var faltantesInformado = parseInt( tr.find('.faltantesInformado').html() );
            var cantidadRecibida = parseInt( $(this).val() );
            
            var nuevosFaltante = cantidadRequerida - ( faltantesInformado + cantidadRecibida );
            tr.find('.nuevosFaltante').html( nuevosFaltante );
        } );


        setTimeout( self.initCabeceraFlotante, 500 );



    };

    this.initCabeceraFlotante = function()
    {
        $(".recepcionMercaderia").append('<table class="flotante"></table>')
        $(".flotante").append($(".tabla thead").clone());

        $(".tabla thead  th").each( function(i,e){
          $(".flotante thead  th:eq(" + i + ")").width( $(e).width() );
        });

        var limit = parseInt($(".recepcionMercaderia").position().top) + 150;
        $(window).scroll(function () {
            var positionY = $(window).scrollTop();
            if ( positionY >= limit ) {
                $(".flotante").show();
            } else {
                $(".flotante").hide();
            }
        });
    }

    this.init();
    
}

$(document).ready( function() { new recepcionMercaderiaEshop(); } );