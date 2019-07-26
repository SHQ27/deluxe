var formBannerPrincipal = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        $('#banner_principal_color').colorpicker({
            showOn:       'both',
            buttonImageOnly:  true,
            buttonColorize:  true,
            buttonText: '', 
            buttonImage: '/backend/js/colorpicker/images/ui-colorpicker.png',
            select: function(event, color) { $(this).val('#' + color.formatted); }          
        });


        $(".administrar_imagenes .delete").click( function(){
            thisClass.deleteImage( $(this) );
        } );
        
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
 
    this.init();
}

$(document).ready( function() { new formBannerPrincipal(); } );