var carritoPaso2Helper = function(esEshop)
{
    var self = this;
    self.esEshop = esEshop;

    self.nombresServicio = {
      'N': 'Estandar',
      'P': 'Prioritario'
    };
    
    this.init = function()
    {
        $("#goToPaso3").click( function(){  self.goToPaso3(); } );
        
        $("[name='SUC[idProvincia]']").change( function(){ self.makeLocalidadOptions( $("[name='SUC[idProvincia]']").val()); } );       

        $(document).on('click', ".envio.SUC .radio", function(){
          var sucursalId = $(this).parent('.opcion').first().data().sucursalId
          self.dataSucursal( sucursalId );
        } );
        
        $(document).on('click', ".envio.SUC .radioLabel", function(){
          var sucursalId = $(this).parent('.opcion').first().data().sucursalId
          self.dataSucursal( sucursalId );
        } );

        self.fillForm();
    };

    this.fillForm = function()
    {   
        self.fillFormDefault();

        if (!carritoEnvio) return;

        $("#tipoEnvio_" +  carritoEnvio.tipo ).click();
        
        if (carritoEnvio.tipo == 'SUC')
        {
            $("#checkout_carrito .form.DOM").removeClass("selected");
            $("#checkout_carrito .form.SUC").addClass("selected");

            if ( isMobile ) {
              $("#checkout_carrito .formDOM").slideUp("slow");
              $("#checkout_carrito .formSUC").slideDown("slow");
            }

            $("[name='SUC[nombre]']").val( carritoEnvio.nombre );
            $("[name='SUC[apellido]']").val( carritoEnvio.apellido );
            $("[name='SUC[idProvincia]']").val( carritoEnvio.idProvincia );
            $("[name='SUC[idProvincia]']").parent().find('.select').html( $("[name='SUC[idProvincia]'] option:selected").html() );
            self.makeLocalidadOptions( $("[name='SUC[idProvincia]']").val());
            
            var idLocalidad = $("[name='SUC[idLocalidad]']").val();
        }
        else
        {
            $("#checkout_carrito .form.SUC").removeClass("selected");
            $("#checkout_carrito .form.DOM").addClass("selected");


            if ( isMobile ) {
              $("#checkout_carrito .formSUC").slideUp("slow");
              $("#checkout_carrito .formDOM").slideDown("slow");
            }


            $("[name='tipoEnvio']").each( function(i,e){ if ($(e).val() == 'DOM') $(e).attr("checked","checked"); } );           
            
            $("[name='DOM[nombre]']").val( carritoEnvio.nombre );
            
            $("[name='DOM[apellido]']").val( carritoEnvio.apellido );
            
            $("[name='DOM[calle]']").val( carritoEnvio.calle );
            
            $("[name='DOM[numero]']").val( carritoEnvio.numero );
            
            $("[name='DOM[piso]']").val( carritoEnvio.piso );
            
            $("[name='DOM[depto]']").val( carritoEnvio.depto );
            
            $("[name='DOM[idProvincia]']").val( carritoEnvio.idProvincia );
            $("[name='DOM[idProvincia]']").parent().find('.select').html( $("[name='DOM[idProvincia]'] option:selected").html() );
                        
            $("[name='DOM[localidad]']").val( carritoEnvio.localidad );
            
            $("[name='DOM[codigoPostal]']").val( carritoEnvio.codigoPostal );

            self.cotizarDOM( carritoEnvio.codigoPostal, carritoEnvio.idProvincia );
        }
        
    };
    
    
    this.fillFormDefault = function()
    {   
        if (direccionEnvioDefault )
        {
            $("[name='tipoEnvio']").each( function(i,e){ if ($(e).val() == 'DOM') $(e).attr("checked","checked"); } );
            
            $("[name='SUC[nombre]']").val( direccionEnvioDefault.nombre );
            $("[name='DOM[nombre]']").val( direccionEnvioDefault.nombre );           
            
            $("[name='SUC[apellido]']").val( direccionEnvioDefault.apellido );
            $("[name='DOM[apellido]']").val( direccionEnvioDefault.apellido );
                        
            $("[name='DOM[calle]']").val( (direccionEnvioDefault.calle) ? direccionEnvioDefault.calle : "" );
            
            $("[name='DOM[numero]']").val( (direccionEnvioDefault.numero) ? direccionEnvioDefault.numero : "" );
            
            $("[name='DOM[piso]']").val( (direccionEnvioDefault.piso) ? direccionEnvioDefault.piso : "" );
            
            $("[name='DOM[depto]']").val( direccionEnvioDefault.depto ? direccionEnvioDefault.depto : "" );
            
            $("[name='DOM[idProvincia]']").val( direccionEnvioDefault.provincia.idProvincia );
            $("[name='DOM[idProvincia]']").parent().find('.select').html( $("[name='DOM[idProvincia]'] option:selected").html() );
            
            $("[name='DOM[localidad]']").val( direccionEnvioDefault.localidad );
            
            if ( direccionEnvioDefault.codigoPostal && direccionEnvioDefault.provincia.idProvincia ) {
              $("[name='DOM[codigoPostal]']").val( direccionEnvioDefault.codigoPostal );  
              self.cotizarDOM( direccionEnvioDefault.codigoPostal, direccionEnvioDefault.provincia.idProvincia );
            } else {
              $("[name='DOM[codigoPostal]']").val("");
            }
        }
    };
    
    
    this.makeLocalidadOptions = function(idProvincia)
    {               
        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/localidades",
              dataType: "json",
              data: "idProvincia=" + idProvincia,
              success: function(localidades)
              {
                    self.removeOptions("[name='SUC[idLocalidad]']", 'Seleccionar');
                    if (!localidades) return;
                    
                    for(i in localidades)
                    {
                        var localidad = localidades[i];
                        var truncateLimit = ( self.esEshop  ) ? 50 : 25;
                        $("[name='SUC[idLocalidad]']").append($('<option value="' + localidad.id + '">').text( self.truncate( localidad.nombre, truncateLimit ) )); 
                    }
                                        
                    
                    if (carritoEnvio)
                    {                       
                        $("[name='SUC[idLocalidad]']").val( carritoEnvio.idLocalidad );
                        $("[name='SUC[idLocalidad]']").parent().find('.select').html( $("[name='SUC[idLocalidad]'] option:selected").html() );
                        self.makeSucursalOptions( $("[name='SUC[idLocalidad]']").val() );
                    }
              }
            }
        );
    };
    
    this.makeSucursalOptions = function(idLocalidad)
    {       
        if ( !idLocalidad ) {
          return;
        }

        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/sucursales",
              dataType: "json",
              data: "idLocalidad=" + idLocalidad,
              success: function(data)
              {
                $(".envio.SUC .boxPrecios tbody").html('');

                var c = data.length;
                for ( i = 0 ; i < c ; i++ ) {
                  var sucursal = data[i];
                  self.cotizarSUC( sucursal );
                }  
              }
            }
        );
    };
    
    this.removeOptions = function(selector, textoDefault)
    {
        $(selector).parent().find('span').html( textoDefault );
        
        $(selector)
        .find('option')
        .remove()
        .end()
        .append('<option value="">' + textoDefault + '</option>')
        .val('');
    };
    
    this.goToPaso3 = function()
    {       
        var tipoEnvio = $("[name='tipoEnvio']:checked").val();
        var nombre = $("[name='" + tipoEnvio +"[nombre]']").val();
        var apellido = $("[name='" + tipoEnvio +"[apellido]']").val();
        var calle = $("[name='DOM[calle]']").val();
        var numero = $("[name='DOM[numero]']").val();
        var piso = $("[name='DOM[piso]']").val();
        var depto = $("[name='DOM[depto]']").val();
        var codigoPostal = $("[name='DOM[codigoPostal]']").val();
        var idProvincia = $("[name='" + tipoEnvio +"[idProvincia]']").val();
        var idProvincia = ( idProvincia ) ? idProvincia : null;
        var idLocalidad = $("[name='SUC[idLocalidad]']").val();
        var localidad = $("[name='DOM[localidad]']").val();


        var cotizacion = $("[name='" + tipoEnvio +"[cotizacion]']:checked").val();
        cotizacion = ( cotizacion != undefined ) ? cotizacion : '';

        $.ajax
        (
            {
              type: "POST",
              url: "/carrito/savePaso2",
              dataType: "json",
              data: "tipoEnvio=" + tipoEnvio + "&nombre=" + nombre + "&apellido=" + apellido + "&calle=" + calle + "&numero=" + numero + "&piso=" + piso + "&depto=" + depto + "&codigoPostal=" + codigoPostal + "&idProvincia=" + idProvincia + "&idLocalidad=" + idLocalidad + "&localidad=" + localidad  + "&cotizacion=" + cotizacion,
              success: function(response)
              {
                  if (response.status == 'OK')
                  {
                      window.location.href = "/carrito/paso-3";
                  }
                  else
                  {
                      $("#generalError").html( response.message );
                      $("#generalError").removeClass('hide').addClass('show');
                  }
              }
            }
        )
        
    };
    
    this.cotizarDOM = function(codigoPostal, idProvincia )
    {
      if ( self.esEshop ) {
        self.cotizarDOMEshop( codigoPostal, idProvincia );
      } else {
        self.cotizarDOMDeluxe( codigoPostal, idProvincia ); 
      }
    };

    this.cotizarDOMDeluxe = function(codigoPostal, idProvincia)
    {
        $("#checkout_carrito .envio.DOM .boxPrecios table").hide();
        $("#checkout_carrito .envio.DOM .boxPrecios .cargando").show();

        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/cotizarDOM",
              dataType: "json",
              data: "codigoPostal=" + codigoPostal + "&idProvincia=" + idProvincia + "&idCampana=" + $("#idCampana").val(),
              success: function(data)
              {               
                $(".envio.DOM .boxPrecios tbody").html('');

                var c = data.length;
                for ( i = 0 ; i < c ; i++ ) {
                  var cotizacion = data[i];
                  var id = cotizacion.servicio;

                  var nombreServicio = self.nombresServicio[ cotizacion.servicio ];

                  var valor;
                  if ( cotizacion.valor > 0 ) {
                    valor = '$' + cotizacion.valor;
                  } else {
                    valor = 'Gratis';
                  }

                  $(".envio.DOM .boxPrecios tbody").append('<tr><td class="border"><div class="opcion"><div class="pink sprite radio fleft"><input id="cotizacion_' + id + '" type="radio" name="DOM[cotizacion]" value="' + id + '"/></div><label class="radioLabel" for="cotizacion_' + id + '">' + nombreServicio + '</label></div></td><td class="border center">' + valor + '</td><td class="center">' + cotizacion.horas_entrega + ' horas hábiles</td></tr>');
                }

                $('.boxPrecios .opcion label').first().click();

                if (carritoEnvio && carritoEnvio.cotizacion ) {
                  $("#cotizacion_" + carritoEnvio.cotizacion).parent().click();  
                }

                $("#checkout_carrito .envio.DOM .boxPrecios table").show();
                $("#checkout_carrito .envio.DOM .boxPrecios .cargando").hide();

              }
            }
        );
    };

    this.cotizarDOMEshop = function(codigoPostal, idProvincia)
    {


        $("#checkout_carrito .envio.DOM .boxPrecios table").hide();
        $("#checkout_carrito .envio.DOM .boxPrecios .cargando").show();

        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/cotizarDOM",
              dataType: "json",
              data: "codigoPostal=" + codigoPostal + "&idProvincia=" + idProvincia + "&idCampana=" + $("#idCampana").val(),
              success: function(data)
              {               
                $(".envio.DOM .boxPrecios tbody").html('');

                var c = data.length;
                for ( i = 0 ; i < c ; i++ ) {
                  var cotizacion = data[i];
                  var id = cotizacion.servicio;

                  var nombreServicio = self.nombresServicio[ cotizacion.servicio ];
                  
                  var valor;

                  if ( cotizacion.valor > 0 ) {
                    valor = '$' + cotizacion.valor;
                  } else {
                    valor = 'Gratis';
                  }

                  $(".envio.DOM .boxPrecios tbody").append('<tr><td class="border MS-13 color4"><div class="opcion"><div class="radio"><input id="cotizacion_' + id + '" type="radio" name="DOM[cotizacion]" value="' + id + '"/></div><label class="radioLabel" for="cotizacion_' + id + '">' + nombreServicio + '</label></div></td><td class="border center MS-13 color4">' + valor + '</td><td class="center MS-13 color4">' + cotizacion.horas_entrega + ' hs. hábiles</td></tr>');
                }

                $('.boxPrecios .opcion label').first().click();

                if (carritoEnvio && carritoEnvio.cotizacion ) {
                  $("#cotizacion_" + carritoEnvio.cotizacion).parent().click();  
                }

                $("#checkout_carrito .envio.DOM .boxPrecios table").show();
                $("#checkout_carrito .envio.DOM .boxPrecios .cargando").hide();

              }
            }
        );
    };


    this.cotizarSUC = function( sucursal )
    {
      if ( self.esEshop ) {
        self.cotizarSUCEshop( sucursal );
      } else {
        self.cotizarSUCDeluxe( sucursal ); 
      }
    };

    this.cotizarSUCDeluxe = function(sucursal)
    {
        $("#checkout_carrito .envio.SUC .boxPrecios table").hide();
        $("#checkout_carrito .envio.SUC .boxPrecios .cargando").show();

        self.hideDataSucursal();

        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/cotizarSUC",
              dataType: "json",
              data: "codigoPostal=" + sucursal.codigo_postal + "&correo=" + sucursal.correo.id + "&idCampana=" + $("#idCampana").val(),
              success: function(data)
              {               

                var c = data.length;
                for ( i = 0 ; i < c ; i++ ) {
                  var cotizacion = data[i];
                  var id = cotizacion.correo.id + '_' + cotizacion.servicio + '_' + sucursal.id;
                  var truncateLimit = ( self.esEshop  ) ? 50 : 25;
                  var direccion = self.truncate( sucursal.calle + ' ' + sucursal.numero + ' ' + sucursal.piso + ' ' + sucursal.depto, truncateLimit );

                  var valor;
                  if ( cotizacion.valor > 0 ) {
                    valor = '$' + cotizacion.valor;
                  } else {
                    valor = 'Gratis';
                  }

                  $(".envio.SUC .boxPrecios tbody").append('<tr><td class="border"><div class="opcion" data-sucursal-id="' + sucursal.id + '"><div class="pink sprite radio fleft"><input id="cotizacion_' + id + '" type="radio" name="SUC[cotizacion]" value="' + id + '"/></div><label class="radioLabel" for="cotizacion_' + id + '"><img src="' + host_static + '/images/enviopack/' + cotizacion.correo.id + '.png"/><br/>' + direccion + '</label></div></td><td class="border center">' + valor + '</td><td class="center">' + cotizacion.horas_entrega + ' hs. hábiles</td></tr>');
                }

                if (carritoEnvio && carritoEnvio.cotizacion ) {

                  if ( $("#cotizacion_" + carritoEnvio.cotizacion).length !== 0 ) {
                    $("#cotizacion_" + carritoEnvio.cotizacion).parent().click();
                    self.dataSucursal( carritoEnvio.idSucursal ); 
                  }
                }

                $("#checkout_carrito .envio.SUC .boxPrecios table").show();
                $("#checkout_carrito .envio.SUC .boxPrecios .cargando").hide();

              }
            }
        );
    };


    this.cotizarSUCEshop = function(sucursal)
    {
        $("#checkout_carrito .envio.SUC .boxPrecios table").hide();
        $("#checkout_carrito .envio.SUC .boxPrecios .cargando").show();

        self.hideDataSucursal();

        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/cotizarSUC",
              dataType: "json",
              data: "codigoPostal=" + sucursal.codigo_postal + "&correo=" + sucursal.correo.id + "&idCampana=" + $("#idCampana").val(),
              success: function(data)
              {               

                var c = data.length;
                for ( i = 0 ; i < c ; i++ ) {
                  var cotizacion = data[i];
                  var id = cotizacion.correo.id + '_' + cotizacion.servicio + '_' + sucursal.id;
                  var truncateLimit = ( self.esEshop  ) ? 50 : 25;
                  var direccion = self.truncate( sucursal.calle + ' ' + sucursal.numero + ' ' + sucursal.piso + ' ' + sucursal.depto, truncateLimit );

                  var valor;
                  if ( cotizacion.valor > 0 ) {
                    valor = '$' + cotizacion.valor;
                  } else {
                    valor = 'Gratis';
                  }

                  $(".envio.SUC .boxPrecios tbody").append('<tr><td class="border MS-13 color4"><div class="opcion" data-sucursal-id="' + sucursal.id + '"><div class="pink sprite radio fleft"><input id="cotizacion_' + id + '" type="radio" name="SUC[cotizacion]" value="' + id + '"/></div><label class="radioLabel" for="cotizacion_' + id + '"><img src="' + host_static + '/images/enviopack/' + cotizacion.correo.id + '.png"/><br/>' + direccion + '</label></div></td><td class="border center MS-13 color4">' + valor + '</td><td class="center MS-13 color4">' + cotizacion.horas_entrega + ' hs. hábiles</td></tr>');
                }

                if (carritoEnvio && carritoEnvio.cotizacion ) {

                  if ( $("#cotizacion_" + carritoEnvio.cotizacion).length !== 0 ) {
                    $("#cotizacion_" + carritoEnvio.cotizacion).parent().click();
                    self.dataSucursal( carritoEnvio.idSucursal ); 
                  }
                }

                $("#checkout_carrito .envio.SUC .boxPrecios table").show();
                $("#checkout_carrito .envio.SUC .boxPrecios .cargando").hide();

              }
            }
        );
    };

    this.dataSucursal = function(idSucursal)
    {
        if ( !idSucursal ) { return; }

        $.ajax
        (
            {
              type: "POST",
              url: "/ajax/sucursal",
              dataType: "json",
              data: "idSucursal=" + idSucursal,
              success: function(sucursal)
              {               
                  var direccion = self.clean( sucursal.calle + ' ' + sucursal.numero + ' ' + sucursal.piso + ' ' + sucursal.depto );
                  $("#infoSucursal .data").html('<p><strong>Direccion:</strong><br />' + direccion + '<p/><p><strong>Horario de Atención</strong><br />' + sucursal.horario.replace('|','<br/>') + '<p/><p><strong>Télefono:</strong><br />' + sucursal.telefono + '<p/>');
                  $("#infoSucursal").removeClass("hide");

                   if ( self.esEshop ) {
                    $.ajax
                    (
                        {
                          type: "POST",
                          url: "/ajax/cotizarSUC",
                          dataType: "text",
                          data: "codigoPostal=" + sucursal.codigo_postal,
                          success: function(data)
                          {               
                            $("#costoEnvioSUC").html('Costo de Envio $' + data);
                          }
                        }
                    );
                  }

              }
            }
        );
    };


    this.hideDataSucursal = function()
    {
        $("#infoSucursal").addClass("hide");
    };



    this.clean = function(text)
    {
      return text.replace(new RegExp('null', 'g'),'');
    };

    this.truncate = function(text, limit)
    {
      text = self.clean(text);
      return (text.length > limit) ? text.substring(0, (limit - 3) ) + '...' : text;
    };


    
    this.init();
};
