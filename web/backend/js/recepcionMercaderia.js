var recepcionMercaderia = function()
{
    var self = this;
    
    this.init = function()
    {
        $(".resetear").click( function(){
            $("[name*=cantidad_recibida]").val(0);
            $("[name*=cantidad_faltante]").val(0);
        } )

        $("[name*=cantidad_recibida]").each( function(i, e){
            var idProductoItem = $(e).attr('id').replace('recepcionMercaderia_cantidad_recibida_','');
            self.doValidacion( idProductoItem );
        });


        $("[name*=cantidad_recibida]").change( function() {
            var idProductoItem = $(this).attr('id').replace('recepcionMercaderia_cantidad_recibida_','');
            self.doObservacionAutomatica( idProductoItem );
            self.doValidacion( idProductoItem );
        } );

        $("[name*=cantidad_faltante]").change( function() {
            var idProductoItem = $(this).attr('id').replace('recepcionMercaderia_cantidad_faltante_','');
            self.doValidacion( idProductoItem );
        } );

        $("[name*=observacion]").change( function() {
            var idProductoItem = $(this).attr('id').replace('recepcionMercaderia_observacion_','');

            if ( $("#recepcionMercaderia_observacion_" + idProductoItem).val().trim() == '' ) {
                self.doObservacionAutomatica( idProductoItem );    
            }
        });

        setTimeout( self.initCabeceraFlotante, 500 );



    };

    this.doValidacion = function(idProductoItem)
    {
        var cantidadMaxima = parseInt( $("#recepcionMercaderia_cantidad_recibida_" + idProductoItem).find('option').last().val() );
        var cantidadRecibida = parseInt( $("#recepcionMercaderia_cantidad_recibida_" + idProductoItem).val() );
        var cantidadFaltante = parseInt( $("#recepcionMercaderia_cantidad_faltante_" + idProductoItem).val() );

        if ( (cantidadRecibida + cantidadFaltante) > cantidadMaxima ) {
            $("#recepcionMercaderia_cantidad_recibida_" + idProductoItem).parent().addClass('alert');
            $("#recepcionMercaderia_cantidad_faltante_" + idProductoItem).parent().addClass('alert');
        } else {
            $("#recepcionMercaderia_cantidad_recibida_" + idProductoItem).parent().removeClass('alert');
            $("#recepcionMercaderia_cantidad_faltante_" + idProductoItem).parent().removeClass('alert');
        }
    }

    this.doObservacionAutomatica = function(idProductoItem)
    {
        var cantidadMaxima = parseInt( $("#recepcionMercaderia_cantidad_recibida_" + idProductoItem).find('option').last().val() );
        var cantidadRecibida = parseInt( $("#recepcionMercaderia_cantidad_recibida_" + idProductoItem).val() );
        var diferencia = cantidadMaxima - cantidadRecibida;

        if ( diferencia == 0 ) {
          $("#recepcionMercaderia_observacion_" + idProductoItem).val('');
        } else if ( diferencia == 1  ) {
          $("#recepcionMercaderia_observacion_" + idProductoItem).val('Falta una unidad');
        } else {
          $("#recepcionMercaderia_observacion_" + idProductoItem).val('Faltan ' + diferencia + ' unidades.');
        }

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

$(document).ready( function() { new recepcionMercaderia(); } );