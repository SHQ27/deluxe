var pedidosList = function()
{
	var self = this;
	
	
	this.init = function()
	{
	    this.updateMarcas(true);
      this.showHideDespachables();

	    $("#pedido_filters_campana").change(
        function(){
           self.updateMarcas(false);
           self.showHideDespachables();
      });
	};

  this.showHideDespachables = function()
  {
    var idCampana = $("#pedido_filters_campana").val();

    if ( idCampana ) {
      $(".sf_admin_filter_field_solo_despachables").show();
    } else {
      $(".sf_admin_filter_field_solo_despachables").hide();
    }
  };
    
  this.updateMarcas = function(firstTime)
  {
      var idCampana = $("#pedido_filters_campana").val();
      
      $.ajax
      (
          {
            type: "POST",
            url: "/backend/ajax/getMarcasByIdCampana",
            dataType: "json",
            data: "idCampana=" + idCampana,
            success: function(choices)
            {                  
                $("#pedido_filters_marca").find('option').remove();

                var c = choices.length;

                if ( c > 1 ) {
                  $("#pedido_filters_marca").append('<option value="">Todas</option>');  
                }                

                for ( i = 0 ; i < c ; i ++ )
                {
                    var selected = '';
                    if ( firstTime &&  idsMarcaSelected.indexOf( parseInt(choices[i].id) ) != -1 ) {
                        selected = 'selected="selected"';
                    }

                    $("#pedido_filters_marca").append('<option ' + selected + ' value="' + choices[i].id + '">' + choices[i].nombre + '</option>');
                }                
            }
          }
      );
  };

	
	this.init();   
}

$(document).ready( function() { new pedidosList(); } );


