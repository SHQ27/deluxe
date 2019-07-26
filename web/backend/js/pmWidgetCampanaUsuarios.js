var pmWidgetCampanaUsuarios = function()
{
	var thisClass = this;
	var inputEmail = null
	
	this.init = function()
	{
		this.addRow();
		this.removeRow();
		
		$("#campana_usuarios_table .resend a").live( 'click', function(){ thisClass.renviarDatosAcceso(this) } );
				
		this.inputEmail = $("#campana_usuarios_email").first().clone();
		$("#campana_usuarios_email").remove();		
	}

	this.renviarDatosAcceso = function( elem )
	{
		var email = $(elem).parent().parent().attr("rel");
		var idCampana = $("#campana_id_campana").val();

		$(elem).hide();
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/campanas/reenviarDatosAcceso",
			  dataType: "json",
			  data: "idCampana=" + idCampana + "&email=" + email,
			  success: function(response)
			  {
				  $(elem).parent().html('Enviado');  
				  
			  }
			}
		);		
	}
	
	this.addRow = function()
	{
		$( "#campana_usuarios_addItem" ).click
		(
				function()
				{	
					$("body").append('<div id="temp"></div>');
					
					var newTr = '<tr>';
				
					newTr += '<td>';
					$("#temp").append ( thisClass.inputEmail );
					newTr += $("#temp").html();
					newTr += '</td>';
					
					newTr += '<td></td>';
					
					newTr += '<td class="remove"><a></a></td>';
					newTr += '<td class="resend"></td>';
					
					newTr += '</tr>';
					
					$("#temp").remove();
					
					$("input", newTr).each( function(i,e){ e.value = '' } );
					$("#campana_usuarios_table").append( newTr );
					thisClass.removeRow();					
				}
		);
	}
	
	this.removeRow = function()
	{
		$( "#campana_usuarios_table tr td.remove a" ).click
		(
				function(e)
				{
					$(e.currentTarget).parent().parent().remove();
				}
		);
	}
	

	
	this.init();   
}

var pmWidgetCampanaUsuarios;
$(document).ready( function() { pmWidgetCampanaUsuarios = new pmWidgetCampanaUsuarios(); } );