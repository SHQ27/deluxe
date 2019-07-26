var carritoPaso2 = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.carritoPaso2Helper = new carritoPaso2Helper(true);

        $("[name='SUC[idLocalidad]']").change( function(){ self.carritoPaso2Helper.makeSucursalOptions( $("[name='SUC[idLocalidad]']").val() ); } );
        $("[name='DOM[codigoPostal]']").change( function(){ self.carritoPaso2Helper.cotizarDOM( $("[name='DOM[codigoPostal]']").val(), $("[name='DOM[idProvincia]']").val() ); } );


        // Inicializo las configuraciones propias para Mobile o Desktop
        if (isMobile) {
            this.initMobile();
        } else {
            this.initDesktop();
        }
    };

    this.initDesktop = function()
    {

        $("#checkout_carrito .envio .mask").click( function(){

            $(this).parent().find('.radioLabel').first().click();

            var tipoSeleccionado = $(this).parent().find("[name='tipoEnvio']:checked").val();

            if ( tipoSeleccionado == "SUC" ) {
                $('.radioLabel')
                $("#checkout_carrito .form.DOM").removeClass("selected");
                $("#checkout_carrito .form.SUC").addClass("selected");
            } else {
                $("#checkout_carrito .form.SUC").removeClass("selected");
                $("#checkout_carrito .form.DOM").addClass("selected");
            }


        });
    };

    
    this.initMobile = function()
    {
    	$('#checkout_carrito .form .opcion #radioSUC').click( function() {
    		$("#checkout_carrito .formDOM").slideUp("slow");
    		$("#checkout_carrito .formSUC").slideDown("slow");
    	});

    	$('#checkout_carrito .form .opcion #radioDOM').click( function() {
    		$("#checkout_carrito .formSUC").slideUp("slow");
    		$("#checkout_carrito .formDOM").slideDown("slow");
    	});
    };

    this.init();
};

$(document).ready( function() { new carritoPaso2(); } );