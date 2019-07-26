var formPromoPago = function()
{
	var self = this;
   self.formasHabilitadas = {
      ''  : ['PANPS'],
      '1' : ['DECID'],
      '3' : [],
      '4' : [],
      '5' : [],
      '6' : [],
      '7' : [],
      '8' : [],
      '9' : ['DECID'],
      '10' : ['DECID']
   };

   self.tarjetasHabilitadas = {
      ''  : ['PANPS-14','PANPS-1','PANPS-5'],
      '1' : ['DECID-1','DECID-6'],
      '3' : [],
      '4' : [],
      '5' : [],
      '6' : [],
      '7' : [],
      '8' : [],
      '9' : ['DECID-1','DECID-6','DECID-15'],
      '10' : ['DECID-1','DECID-6']
   };

	
   this.init = function()
   {
         $("#promo_pago_tarjeta option").each( function(i, e){
               var data = $(e).html().split('|');
               $(e).attr('data-id_forma_pago', data[0]);
               $(e).html(data[1]);
         } );

         this.updateEshop(true);
         $("#promo_pago_id_eshop").change( function(){ self.updateEshop(); } );


         this.updateFormaPago(true);
         $("#promo_pago_id_forma_pago").change( function(){ self.updateFormaPago(); } );

         this.updateDescuentoTipo();
         $("#promo_pago_descuento_tipo").change( function(){ self.updateDescuentoTipo(); } );
   };

   this.updateFormaPago = function(firstTime)
   {
         var idEshop = $("#promo_pago_id_eshop").val();
         var idFormaPago = $("#promo_pago_id_forma_pago").val();

         if ( idFormaPago == 'PANPS' ) {
            $(".sf_admin_form_field_identificador label").html('Promotion Code brindado por NPS');
         } else {
            $(".sf_admin_form_field_identificador label").html('Id Site brindado por DECIDIR');
         }            

         $("#promo_pago_tarjeta option").each( function(i, e){

               if ( (self.tarjetasHabilitadas[ idEshop ].indexOf( $(e).val() ) != -1 && idFormaPago) || $(e).attr('value') == '' ) {
                     $(e).show();
               } else { 
                     $(e).hide();
               }
         } );

         if ( !firstTime ) {
            $("#promo_pago_tarjeta").val('');   
         }
         
   };

   this.updateEshop = function(firstTime)
   {
         var idEshop = $("#promo_pago_id_eshop").val();

         $("#promo_pago_id_forma_pago option").each( function(i, e){

            if ( self.formasHabilitadas[ idEshop ].indexOf( $(e).val() ) != -1 || $(e).attr('value') == '' ) {
                  $(e).show();
            } else { 
                  $(e).hide();
            }

            if ( !firstTime ) {
               $("#promo_pago_id_forma_pago").val('')   
            }
            

         } );

         this.updateFormaPago(firstTime);
   };

   this.updateDescuentoTipo = function()
   {
         var descuentoTipo = $("#promo_pago_descuento_tipo").val();
         if ( descuentoTipo == 'DELUXE' ) {
            $(".sf_admin_form_field_descuento_porcentaje").show();
         } else {
            $(".sf_admin_form_field_descuento_porcentaje").hide();
         }
   };
	
	this.init();   
}

$(document).ready( function() { new formPromoPago(); } );