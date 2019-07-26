var productosList = function()
{
	var self = this;
	
	
	this.init = function()
	{
	    this.updateCategorias(true);
	    
	    $("#sf_admin_list_batch_checkbox").attr('name','all');
	    $("#sf_admin_list_batch_checkbox").attr('value','false');
	    $("#sf_admin_list_batch_checkbox").removeAttr('onclick');
	    
	    $("#sf_admin_list_batch_checkbox").click( function(){ self.checkAll() });
	    
	    $(".selectAllElements").live( 'click', function(){ self.selectAllElements(); });
	    $(".removeAllElements").live( 'click', function(){ self.removeAllElements(); });
	    $("#producto_filters_campana").change( function(){ self.updateCategorias(false); });
	    
	    
	};
	
    this.checkAll = function()
    {
        var checked = $("#sf_admin_list_batch_checkbox").attr('checked');
        $('.sf_admin_batch_checkbox[type=checkbox]').attr('checked',  checked);
        
        var colspan =  $('.sf_admin_list table tbody tr').first().find('td').length;
        var rpp = $('.sf_admin_batch_checkbox[type=checkbox]').length;
        var pagination = $( $('.sf_admin_pagination').get(0).nextSibling ).text().trim();
        var total = pagination.substr(0, pagination.indexOf(' '));
        
        if ( checked ) {
            $('.sf_admin_list table tbody').prepend('<tr><td class="center" colspan="' +  colspan + '">Los ' + rpp + ' elementos de esta página están seleccionadas. <strong><a class="selectAllElements">Seleccionar los ' + total + ' elementos</a></strong></td></tr>');
        } else {
            $("#sf_admin_list_batch_checkbox").attr('value','false');
            $('.sf_admin_list table tbody tr').first().remove();
        }        
    };
    
    this.selectAllElements = function()
    {
        $("#sf_admin_list_batch_checkbox").attr('value','true');
        
        $('.sf_admin_list table tbody tr').first().remove();
        var colspan =  $('.sf_admin_list table tbody tr').first().find('td').length;
        var pagination = $( $('.sf_admin_pagination').get(0).nextSibling ).text().trim();
        var total = pagination.substr(0, pagination.indexOf(' '));
        $('.sf_admin_list table tbody').prepend('<tr><td class="center" colspan="' +  colspan + '">Los ' + total + ' elementos están seleccionadas. <strong><a class="removeAllElements">Anular la selección</a></strong></td></tr>');
    };
    
    this.removeAllElements = function()
    {
        $("#sf_admin_list_batch_checkbox").attr('value','false');
        
        $('.sf_admin_list table tbody tr').first().remove();
        $("#sf_admin_list_batch_checkbox").click();
        self.checkAll();
    };
    
    this.updateCategorias = function(firstTime)
    {
        var idsCampana = $("#producto_filters_campana").val();
        idsCampana = idsCampana.join(',')
        
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/listCategoriasByIdCampana",
              dataType: "json",
              data: "idsCampana=" + idsCampana,
              success: function(choices)
              {                  
                  $("#producto_filters_id_producto_categoria").find('option').remove();
                  var c = choices.length;
                  for ( i = 0 ; i < c ; i ++ )
                  {
                      $("#producto_filters_id_producto_categoria").append('<option value="' + choices[i].value + '">' + choices[i].name + '</option>');
                  }
                  
                  if ( firstTime ) {
                      $("#producto_filters_id_producto_categoria").val( idCategoriaSelected );
                  }
                  
              }
            }
        );
    };

	
	this.init();   
}

$(document).ready( function() { new productosList(); } );


