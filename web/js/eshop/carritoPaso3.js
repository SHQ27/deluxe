var carritoPaso3 = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.carritoPaso3Helper = new carritoPaso3Helper();   

        self.formaPago();  
    };

    this.formaPago = function()
    {        
        $("form .opcion").click( function(ev){      
            
            $(".selectorCuotas").addClass("hide");
            
            if ( $(this).find('input').val() != 'MP'  ) {
                $('#checkout_carrito .eliminar-descuento').click();
                $(".renglon.descuento").hide();
                $(this).parent().find('.selectorCuotas').removeClass("hide");
            } else {
                $(".renglon.descuento").show();
            }
            
            self.carritoPaso3Helper.calculateCuota( $(this).parent().find('select') );
            
        });
                
        $(".selectorCuotas select").change( function(){
            self.carritoPaso3Helper.calculateCuota($(this));
        });
    };
    

    this.init();
};

$(document).ready( function() { new carritoPaso3(); } );