var formCampana = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        $('#campana_color').colorpicker({
            showOn:       'both',
            buttonImageOnly:  true,
            buttonColorize:  true,
            buttonText: '', 
            buttonImage: '/backend/js/colorpicker/images/ui-colorpicker.png',
            select: function(event, color) { $(this).val('#' + color.formatted); }          
        });

        this.fieldsetContent = $("#sf_fieldset_informacion_sobre_el_comercial_de_la_marca").html();
        $("#sf_fieldset_informacion_sobre_el_comercial_de_la_marca").remove();
        
        this.createComercialBox();
        
        $(".sf_admin_form_field_marcas a").click( function(){
            thisClass.updateComercialBox();
        } )
        
        $(".sf_admin_form_field_email_orden_compra .add").live('click', function(){
            thisClass.addInputEmail( $(this) );
        } );
        
        $(".administrar_imagenes .delete").click( function(){
            thisClass.deleteImage( $(this) );
        } );
        
        $(".campana_estimacion input").change( function(){
            thisClass.changeEstimacion();
        } );
        
        if ( $("#campana_estimacion_envio_horas").val() ) {
            $("#estimacion_horas").click();
        } else {
            $("#estimacion_fechas").click();
        }
        
        this.changeEstimacion();
        
    };

    this.changeEstimacion = function()
    {
        var tipo = $('[name=estimacion_tipo]:checked').val();
        
        if ( tipo == 'FECHAS' ) {
            $(".sf_admin_form_field_estimacion_envio_fecha").show();
            $(".sf_admin_form_field_estimacion_envio_horas").hide();
        } else {
            $(".sf_admin_form_field_estimacion_envio_fecha").hide();
            $(".sf_admin_form_field_estimacion_envio_horas").show();
        }
    }
    
    this.deleteImage = function(a)
    {
        var img = a.parent().find('img');
        var idImagenBannerPrincipal = img.attr('rel');
        
        $.ajax
        (
            {
              type: "POST",
              dataType: "html",
              url: '/backend/ajax/deleteImagenBannerPrincipal',
              data: 'idImagenBannerPrincipal=' + idImagenBannerPrincipal,
              success: function(response)
              {
                  a.parent().remove();
              }
            }
        );
    };
    
    this.updateComercialBox = function()
    {   
        $("#campana_marcas option").each( function(i, elem)
            {            
                var id = $(elem).val();
                var denominacion = $(elem).html();
                var marcaId = $(elem).val();
                                
                if ( $("fieldset[class=comercialFieldset][rel=" + marcaId + "]").length == 0)
                {
                    var htmlBox = thisClass.fieldsetContent;
                    
                    htmlBox = htmlBox.replace( /name=.campana/g, 'name="campana[' + id + ']' );
                    htmlBox = htmlBox.replace( /\[email_orden_compra\]/g, '[email_orden_compra][]' );
                    htmlBox = htmlBox.replace( /id="campana_email_orden_compra"/g, '' );
                    htmlBox = htmlBox.replace( 'Informacion sobre el comercial de la marca', 'Informacion sobre el comercial de la marca ' + denominacion);                    
                                    
                    $("#sf_fieldset_informacion_para_reportes").after( '<fieldset class="comercialFieldset" rel="' + marcaId + '">' + htmlBox + '</fieldset>' );
                    
                    var idCampana = $("#campana_id_campana").val();
                    
                    $.ajax
                    (
                        {
                          type: "POST",
                          url: "/backend/ajax/getDataOCByIdMarca",
                          dataType: "json",
                          data: "idMarca=" + marcaId + "&idCampana=" + idCampana,
                          cache : false,
                          success: function(results)
                          {                              
                              var emails = results.emails.split(',');
                              thisClass.fillInputEmails(marcaId, emails);
                                                            
                              $('[name="campana[' + marcaId + '][telefono_orden_compra]"]').val( results.telefono );
                              
                          }
                        }
                    );                    
                }
            }
        )
        
        $("fieldset[class=comercialFieldset]").each( function(i, elem)
            {
                var marcaId = $(elem).attr("rel");
                
                if ( $("#campana_marcas option[value=" + marcaId + "]").length == 0)
                {
                    $("fieldset[class=comercialFieldset][rel=" + marcaId + "]").remove();
                }                
            }        
        );
        
        this.ordenar( $("#campana_marcas") );
        
        $(".sf_admin_form_field_email_orden_compra .content").append('<a class="add">Agregar Otro</a>');
    };
    
    this.createComercialBox = function()
    {        
        thisClass.updateComercialBox();
        
        var len = campanaMarcaData.length
        for (i = 0 ; i < len ; i++ )
        {            
            var marcaId = campanaMarcaData[i].id_marca;
            
            $('[name="campana[' + marcaId + '][id_comercial]"]').val( campanaMarcaData[i].id_comercial );
            $('[name="campana[' + marcaId + '][comision_comercial]"]').val( campanaMarcaData[i].comision_comercial );
            $('[name="campana[' + marcaId + '][apertura_marca]"]').val( campanaMarcaData[i].apertura_marca );            
            $('[name="campana[' + marcaId + '][enviar_aviso_orden_compra]"]').attr('checked', campanaMarcaData[i].enviar_aviso_orden_compra );
        }
        
    };
    
    this.ordenar = function (select)
    {
        var ops = $("option", select);
        
         ops.sort(function (a,b) { return ( $(a).html().toUpperCase() < $(b).html().toUpperCase() ) ? -1 : ( $(a).html().toUpperCase() > $(b).html().toUpperCase() ) ? 1 : 0; });
         
         html="";
         for(i=0;i<ops.length;i++) html += "<option value='" + $(ops[i]).val() + "'>" + $(ops[i]).html() + "</option>";
         select.html(html);        
    };
    
    this.addInputEmail = function(aButton)
    {
        var content = aButton.parent().clone();
        content.find('input').val('');
        content.find('a').remove();
        
        $(aButton).parent().parent().append( content );
        
        return content.find('input');
    };
    
    
    this.fillInputEmails = function(marcaId, emails)
    {
        
        for ( j in emails )
        {
                        
            if ( j > 0)
            {
                var input = thisClass.addInputEmail( $('.comercialFieldset[rel=' + marcaId + '] .add') );
                input.val( emails[j] );
            }
            else
            {
                $('[name="campana[' + marcaId + '][email_orden_compra][]"]').val( emails[j] );
            }
        }
    };    

    this.init();
}

sfDoubleList.move = function(srcId, destId)
{    
    var src = document.getElementById(srcId);
    var dest = document.getElementById(destId);
    var idCampana = $("#campana_id_campana").val();
    
    for (var i = 0; i < src.options.length; i++)
    {
      if (src.options[i].selected)
      {
        var nombre = src.options[i].text;
        var id =  src.options[i].value  + '';
             
        if ( srcId == 'campana_marcas' && idCampana)
        {
            $.ajax
            (
                {
                  type: "POST",
                  async: false,
                  url: "/backend/ajax/hasProducsAsignedWith",
                  dataType: "json",
                  data: "idMarca=" + id + "&idCampana=" + idCampana,
                  cache : false,
                  success: function(results)
                  {
                      if ( results.exists )
                      {
                          alert("Desasigne los productos de esta marca antes de quitarla de esta lista");    
                      }
                      else
                      {
                          dest.options[dest.length] = new Option(src.options[i].text, src.options[i].value);
                          src.options[i] = null;
                          --i;
                      }
                  }
                }
            );  
        }
        else
        {
            dest.options[dest.length] = new Option(src.options[i].text, src.options[i].value);
            src.options[i] = null;
            --i;
        }
      }
    }
};


$(document).ready( function() { new formCampana(); } );