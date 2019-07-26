var formEshopHome = function()
{
    var self = this;
    
    this.init = function()
    {
        self.changeTipo();

        $("#eshop_home_tipo").change( function() {
            self.changeTipo();
        } );

        $(".imagen .delete").click( function(){
            self.deleteImage( $(this) );
        } );

    };

    this.changeTipo = function()
    {
        var tipo = $("#eshop_home_tipo").val();
        $(".rowElemento").hide();
        $(".rowElemento." + tipo).show()

        $(".h3").hide();
        $(".h3." + tipo).show()
    };

    this.deleteImage = function(a)
    {
        var div = a.parent();
        var idEshopHomeMultimedia = div.attr('rel');
        
        $.ajax
        (
            {
              type: "POST",
              dataType: "html",
              url: '/backend/ajax/deleteEshopHomeMultimedia',
              data: 'idEshopHomeMultimedia=' + idEshopHomeMultimedia,
              success: function(response)
              {
                  a.parent().remove();
              }
            }
        );
    };

 
    this.init();
}

$(document).ready( function() { new formEshopHome(); } );