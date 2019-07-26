var formDescuento = function()
{
	var thisClass = this;
	
    this.init = function()
    {
        thisClass.updateTipoDescuento();
        $("#descuento_id_tipo_descuento").change( function(){ thisClass.updateTipoDescuento(); } );
    };
    
    this.updateTipoDescuento = function()
    {
        if ( $("#descuento_id_tipo_descuento").val() == 'COMIN' )
        {
            $(".compra_minima").show();
            $(".sf_admin_form_field_valor").show();
            $(".sf_admin_form_field_valor label").html("Porcentaje");            
        }
        else if ( $("#descuento_id_tipo_descuento").val() == 'FSHIP' )
        {
            $(".compra_minima").hide();
            $(".sf_admin_form_field_valor").hide();
        }
        else
        {
            $(".sf_admin_form_field_valor").show();
            $(".compra_minima").hide();
            $(".sf_admin_form_field_valor label").html("Valor");
        }
    };
	
	this.init();   
}

$(document).ready( function() { new formDescuento(); } );