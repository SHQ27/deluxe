var carritoPaso3Helper = function()
{
    var thisClass = this;
    thisClass.descuento = 0;
    thisClass.bonificacion = 0;
    thisClass.totalFinal = 0;

    this.init = function()
    {

        
        $('.promo-datos-adicionales').hide();
        
        $('#checkout_carrito #descuento_codigo').keyup(
                function() {
                    if ( $(this).val() == '365' ) {
                        $('.promo-datos-adicionales').show();
                    } else {
                        $('.promo-datos-adicionales').hide();
                    }
                }
        );
        
        $('#checkout_carrito .verificar-descuento').click( function(e){ thisClass.addDescuento(); } );
        $('#checkout_carrito .eliminar-descuento').click( function(e){ $('#checkout_carrito .descuento input').val(''); thisClass.addDescuento(); } );
        $('#checkout_carrito .bonificacion select').change( function(e){ thisClass.addBonificacion(); } );
                
        thisClass.addDescuento();
        thisClass.addBonificacion();
        
        thisClass.updateTotal();
};
    
    this.calculateCuota = function(select)
    {
        var cuotas = select.val();
        
        var porCuotas = thisClass.totalFinal / cuotas; 
        porCuotas =  new String(porCuotas.toFixed(2)).replace(".", ",");
        var total =  new String(thisClass.totalFinal.toFixed(2)).replace(".", ",");            
                    
        select.parents('.selectorCuotas').first().find('.porCuota .input').html( "$" + porCuotas );
        select.parents('.selectorCuotas').first().find('.total .input').html("$" + total);   
    };
    
    this.addDescuento = function()
    {       
        var codigo = $('#checkout_carrito #descuento_codigo').val();
                
        $('#checkout_carrito .descuento .response').html('');
        
        var promoError = false;
        var infoAdicional = '';
        if ( codigo == '365' )
        {
            var promoNumero = $('#descuento_promo_numero').val();
            var promoSocio = $('#descuento_promo_socio').val();
            
            if ( promoNumero == '')
            {
                var parent = $('#descuento_promo_numero').parent();
                $('.response', parent).html('<span class="KO">Obligatorio</span>');
                promoError = true;
            }
            else if (promoNumero.length != 19)
            {
                  var parent = $('#descuento_promo_numero').parent();
                  $('.response', parent).html('<span class="KO">19 Dígitos (Sin espacios)</span>');
                  promoError = true;
            }
            
            if ( promoSocio == '' )
            {
                var parent = $('#descuento_promo_socio').parent();
                $('.response', parent).html('<span class="KO">Obligatorio</span>');
                promoError = true;
            }
            
            if (promoError)
            {
                return;
            }
            else
            {
                $('#descuento_promo_numero').val();
                infoAdicional = '{ "socio": "' + promoSocio + '" , "numero": "' + promoNumero + '"}';
            }
        }
        else
        {
            $('#descuento_promo_numero').val('');
            $('#descuento_promo_socio').val('');
        }
        
        $.ajax
        (
            {
              type: "POST",
              url: "/carrito/addDescuento",
              dataType: "json",
              data: "codigo=" + codigo + '&infoAdicional=' + infoAdicional,
              success: function(response)
              {               
                  if (response.status == 'OK')
                  {                                             
                      thisClass.descuento = parseFloat(response.monto);
                      $('#checkout_carrito .descuento .response').eq(0).html('<span class="' + response.status + '">C&oacute;digo v&aacute;lido!</span>');
                      $('#checkout_carrito .verificar-descuento').hide();
                      $('#checkout_carrito .eliminar-descuento').show();
                      $('.promo-datos-adicionales').hide();
                      
                      // Oculto la bonificacion
                      $('#checkout_carrito .bonificacion select').val('');
                      $('#checkout_carrito .bonificacion').hide();
                      
                      
                  }
                  else
                  {
                      thisClass.descuento = 0;
                      
                      if (codigo)
                      {
                          $('#checkout_carrito .descuento .response').eq(0).html('<span class="' + response.status + '">C&oacute;digo inv&aacute;lido</span>');  
                      }
                      else
                      {
                          $('#checkout_carrito .descuento .response').eq(0).html('<span class="' + response.status + '"></span>');                        
                      }
                      
                      $('#checkout_carrito .bonificacion').show();
                      $('#checkout_carrito .descuento .verificar-descuento').show();
                      $('#checkout_carrito .descuento .eliminar-descuento').hide();
                  }
                  
                  thisClass.updateTotal();
              }
            }
        );
    };
    
    this.addBonificacion = function()
    {
        var idBonificacion = $('#checkout_carrito .bonificacion select').val();
        
        $.ajax
        (
            {
              type: "POST",
              url: "/carrito/addBonificacion",
              dataType: "json",
              data: "idBonificacion=" + idBonificacion,
              success: function(response)
              {
                  
                  if (response.status == 'OK')
                  {                                             
                      thisClass.bonificacion = parseFloat(response.monto);
                      
                      // Oculto la bonificacion
                      $('#checkout_carrito .descuento input').val('');
                      $('#checkout_carrito .descuento').hide();                   
                  }
                  else
                  {
                      thisClass.bonificacion = 0;
                      
                      if ( $("[name='paso3[tipoPago]']:checked").val() == 'MP' )
                      {
                          $('#checkout_carrito .descuento').show();
                      }
                  }
                  
                  thisClass.updateTotal();
              }
            }
        );
    };
    
    this.updateTotal = function()
    {

        var totalProductos = 0;
        $('#checkout_carrito .item .total').each
        (
                function(i,elem)
                {
                    totalProductos += parseFloat( $(elem).html().replace('$','').replace('.-','').replace('.','').replace(',','.') );
                    
                }
        );
                
        var envio = parseFloat($('#checkout_carrito .envio .total').html().replace('$','').replace('.-','').replace('.','').replace(',','.'));
        
        
        var totalConEnvio = totalProductos + envio;
        var totalFinal = totalConEnvio - thisClass.descuento - thisClass.bonificacion;
        
        (totalFinal >= 1000) ? $('.datos-adicionales').show() : $('.datos-adicionales').hide();
        $("#paso3_montoTotal").val(totalFinal);
        
        thisClass.totalFinal = totalFinal;
        
        var descuento = new String(thisClass.descuento.toFixed(2)).replace(".", ",");
        var bonificacion = new String(thisClass.bonificacion.toFixed(2)).replace(".", ",");
        var totalProductos = new String(totalProductos.toFixed(2)).replace(".", ",");
        var totalConEnvio = new String(totalConEnvio.toFixed(2)).replace(".", ",");
        var totalFinal =  new String(totalFinal.toFixed(2)).replace(".", ",");
        
        
        $('#checkout_carrito .descuento .total').html( '($' + descuento + ').-' );
        $('#checkout_carrito .bonificacion .total').html( '($' + bonificacion + ').-' );
        
        var totalDiv = $('#checkout_carrito .checkoutTotal .total');
        totalDiv.html( '$' + totalFinal );
        totalDiv.formatCurrency( { digitGroupSymbol: '.', decimalSymbol: ',' } );

        // Promo American Enero 2015
        var $promo = $('#CAPAA-enero-2015');
        if (thisClass.totalFinal < 399) {
          $promo.hide()
            .find('input[type="radio"]')
            .removeAttr('checked');
          
          if ($("[name='paso3[tipoPago]']:checked").length === 0) {
            $('label[for="paso3_tipoPago_MP"]').click();
          }
        } 
        else {
          $promo.show();
        }
    };

    this.init();
};