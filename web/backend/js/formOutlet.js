var formOutlet = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        $(".administrar_imagenes .delete").click( function(){
            thisClass.deleteImage( $(this) );
        } );
        
        $(".campana_estimacion input").change( function(){
            thisClass.changeEstimacion();
        } );
        
        if ( $("#outlet_estimacion_envio_horas").val() ) {
            $("#estimacion_horas").click();
        } else {
            $("#estimacion_fechas").click();
        }
        
        this.changeEstimacion();        
    };
    
    this.deleteImage = function(a)
    {
        var img = a.parent().find('img');
        var idImagenBannerPrincipal = img.attr('rel');
        
        $.ajax
        (
            {
              type: "POST",
              dataType: "html",
              url: '/backend/ajax/deleteImagenBannerPrincipal',
              data: 'idImagenBannerPrincipal=' + idImagenBannerPrincipal,
              success: function(response)
              {
                  a.parent().remove();
              }
            }
        );
    };
    
    this.changeEstimacion = function()
    {
        var tipo = $('[name=estimacion_tipo]:checked').val();
        
        if ( tipo == 'FECHAS' ) {
            $(".estimacion_envio_fecha").show();
            $(".estimacion_envio_horas").hide();
        } else {
            $(".estimacion_envio_fecha").hide();
            $(".estimacion_envio_horas").show();
        }
    }
 
    this.init();
}

$(document).ready( function() { new formOutlet(); } );