var carritoPaso2 = function()
{
    var self = this;

    this.init = function()
    {
        // Inicializo el Helper
        self.carritoPaso2Helper = new carritoPaso2Helper(false);

        $("[name='SUC[idLocalidad]']").change( function(){ self.carritoPaso2Helper.makeSucursalOptions( $("[name='SUC[idLocalidad]']").val() ); } );
        $("[name='DOM[codigoPostal]']").change( function(){ self.carritoPaso2Helper.cotizarDOM( $("[name='DOM[codigoPostal]']").val(), $("[name='DOM[idProvincia]']").val() ); } );
        $(document).on('click', ".opciones .opcion", function(){ self.choiceOption(); } );

        self.choiceOption();

        self.openPromoModal();
    };

    this.choiceOption = function()
    {   
      var opcionSelected = $("[name=tipoEnvio]:checked").val();
      $(".envio").hide();
      $(".envio." + opcionSelected).show();
    };

    this.openPromoModal = function(modalName)
    {
        $("#promo-envio").dialog( {
            width: 616,
            height: 500,
            modal: true,
            zindex: 99999,
            closeOnEscape: true,
            resizable: false,
            dialogClass: "dialog-promo-modal"
        });

        $(".ui-widget-overlay").click(function(){ $("#promo-envio").dialog('close') });
    };
    

    this.init();
};

$(document).ready( function() { new carritoPaso2(); } );