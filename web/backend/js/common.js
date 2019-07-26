var common = function()
{
    var thisClass = this;

    this.init = function()
    {       
        $('.sf_admin_filter table tbody tr td').each
        (
            function (i, elem)
            {
                if (i%2 == 0)
                {
                    $(elem).attr("class",'label');
                }
            }
        );
        
        $("#pedido_filters_intervencionManual").attr("checked", false);
        $("#producto_item_filters_atencion").attr("checked", false);
        
        $("img").error(function(){
                $(this).hide();
        });
        
        $(".enlargeImage").fancybox();
                
        $("#sf_admin_list_batch_checkbox").live('click', function(e){

            var allChecked = $(e.currentTarget).attr('checked');
            $("#sf_admin_content .sf_admin_list table tbody .sf_admin_batch_checkbox").attr('checked', allChecked);
        });
        
        thisClass.checkNotifications()
        setInterval(function(){ thisClass.checkNotifications() }, 120 * 1000);
    }
    
    this.checkNotifications = function()
    {
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/notificaciones/check",
              success: function(cantidad)
              {                  
                  $("#notificaciones").hide();
                       
                  var cantidad = parseInt( cantidad );
                                    
                  if ( cantidad ) {
                      $("#notificaciones").show();
                      
                      $("#notificaciones span").countTo({
                          from: 0,
                          to: cantidad,
                          speed: 1000,
                          refreshInterval: 50
                      });                      
                      
                  } else {
                      $("#notificaciones").hide();
                  }
              }
            }
        );
    }
    
    this.init();   
}

$(document).ready( function() { new common(); } );