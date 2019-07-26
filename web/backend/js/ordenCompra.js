var ordenCompra = function()
{
	var self = this;

  this.init = function()
  {
    self.changeEshop();
    $("#ordenCompra_id_eshop").change( self.changeEshop );

    self.updateOrigen();
    $("#ordenCompra_stock_campana").change( self.updateOrigen );
  }
  
  this.changeEshop = function()
  { 
     var idEshop = $("#ordenCompra_id_eshop").val();
     if ( idEshop ) {
      $(".deluxeRow").hide();
     } else {
      $(".deluxeRow").show();
     }

     self.updateOrigen();
  }

  this.updateOrigen = function()
  { 
     var stockCampana = $("#ordenCompra_stock_campana").val();
     if ( stockCampana == 'STKPER' ) {
      $("#ordenCompra_origen_stock option[value='STKPER']").show();
      $("#ordenCompra_origen_stock option[value='OFERTA']").hide();

      var idEshop = $("#ordenCompra_id_eshop").val();
      if( idEshop ) {
        $("#ordenCompra_origen_stock option[value='OUTLET']").hide();
      } else {
        $("#ordenCompra_origen_stock option[value='OUTLET']").show();
      }

     } else {
      $("#ordenCompra_origen_stock option[value='STKPER']").hide();
      $("#ordenCompra_origen_stock option[value='OUTLET']").hide();
      $("#ordenCompra_origen_stock option[value='OFERTA']").show();
     }
  }

	this.init();   
}

$(document).ready( function() { new ordenCompra(); } );