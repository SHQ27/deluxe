var miCuentaHelper = function()
{
    var self = this;

    this.init = function()
    {
        self.initMenu();
        self.initDatosPersonales();
        self.initDevoluciones();
        self.initVerificarEnvio();
        self.initDesactivarCuenta();
                        
        $(".verPedidos").click( function(e) {
            e.preventDefault();
            $("#verPedidos").html('<span class="loading">Cargando...<span>');
            $("#verPedidos").load(this.href, function() {
                $("#verPedidos .cerrar").click(function(){ $("#verPedidos").dialog('close'); });
            });
            
            if (!isMobile) {
                $("#verPedidos").dialog({
                    width: 720,
                    height: 500,
                    modal: true,
                    resizable: false,
                    zindex: 99999
                });
            }
            else {
                $("#verPedidos").dialog({
                    width: "90%",
                    height: 500,
                    left: "5%",
                    right: "5%",
                    modal: true,
                    resizable: false,
                    zindex: 99999,
                    dialogClass: "pedidoDetallePop"
                });
            }

            $(".ui-widget-overlay").click(function(){ $("#verPedidos").dialog('close'); });
        });
        
        $(".ocaTracking").click( function(e) {
            e.preventDefault();
            $("#ocaTracking").html('<span class="loading">Cargando...<span>');
            $("#ocaTracking").load(this.href, function() {
                $("#ocaTracking .cerrar").click(function(){ $("#ocaTracking").dialog('close'); });
            });
            
            if (!isMobile) {
                $("#ocaTracking").dialog({
                    width: 720,
                    height: 500,
                    modal: true,
                    resizable: false,
                    zindex: 99999
                });
            }
            else {
                $("#ocaTracking").dialog({
                    width: "90%",
                    height: 500,
                    left: "5%",
                    right: "5%",
                    modal: true,
                    resizable: false,
                    zindex: 99999,
                    dialogClass: "ocaTrackingPop"
                });
            }

            $(".ui-widget-overlay").click(function(){ $("#ocaTracking").dialog('close'); });
        });
        
    };
    
    this.initMenu = function()
    {
        $(".miCuentaMenu a").click( function(){
            $("#mi_cuenta .seccion").hide();
            $("#" + $(this).attr("rel")).show();
            $(".miCuentaMenu .item").removeClass("selected");
            $(this).addClass("selected");
        } );
    };
    
    this.initDatosPersonales = function()
    {   
        $(".direccionEntregaUsuario .button").click( function(el){
            $(".direccionEntregaUsuario .button").hide();

            $("#direccionEntrega").removeClass("hide");
            $("#direccionEntrega").addClass("show");
            
            $("#direccionEntrega").css("height","0");
            $("#direccionEntrega").animate({"height": "446px" }, 500 );
        } );
    };
    
    
    
    
    this.initDevoluciones = function()
    {
        self.devolucionesPaso1();
                
        $("#button_devolverProducto").click( function(){
            $('#devoluciones_main').show();
            $('#devoluciones_historial').hide();
            $("#button_devolverProducto").hide();
            $("#button_historial").show();
        } );
        
        $("#button_historial").click( function(){
            $('#devoluciones_main').hide();
            $('#devoluciones_historial').show();
            $("#button_devolverProducto").show();
            $("#button_historial").hide();
        } );
        
        $("#paso-1 .buttonDevolver").click( function(){ self.devolucionesValidacionPaso1(); } );
        $("#paso-2 .buttonSiguiente").click( function(){ self.devolucionesValidacionPaso2();  } );
        $("#paso-3 .buttonSiguiente").click( function(){ self.devolucionesValidacionPaso3(); } );
                
        $("#paso-2 .buttonAnterior").click( function(){
            $("#devoluciones #paso-2").hide();
            $("#devoluciones #paso-1").show();
            self.devolucionSeleccionarPaso(1);
        } );
        
        $("#paso-3 .buttonAnterior").click( function(){
            $("#devoluciones #paso-3").hide();
            $("#devoluciones #paso-2").show();
            self.devolucionSeleccionarPaso(2);
        } );
        
        $("#paso-4 .buttonAnterior").click( function(){
            $("#devoluciones #paso-4").hide();
            $("#devoluciones #paso-3").show();
            self.devolucionSeleccionarPaso(3);
        } );
        
    };
    
    this.devolucionesPaso1 = function()
    {           
        $(".item .formInputButton").click( function(){
            if ( $(this).hasClass('selected') ) { 
                $(this).removeClass('selected');
                $(this).val('SELECCIONAR');
            } else {
                $(this).addClass('selected');
                $(this).val('SELECCIONADO');
            }
        });
        
        $('[name*="devoluciones[pedido_producto_item_cantidad]"]').change( function(){
            var precio = $(".precio", $(this).parent().parent().parent() );
            var calculo = precio.attr("rel") * $(this).val();
            calculo = new String(calculo.toFixed(2)).replace(".", ",");
            precio.html( '$ ' + calculo  );
        });
        
        $("#devoluciones_motivo").change( function(){
            if ( $(this).val() == "OTROS" || $(this).val() == "FALLA" || $(this).val() == "INCOR" ) {
                $("#devoluciones_motivo_abierto").show();
            } else {
                $("#devoluciones_motivo_abierto").hide();
            }
        } );

    };
    
    this.devolucionesValidacionPaso1 = function()
    {                           
        $('[name*="devoluciones[pedido_producto_item_id]"]').prop('checked', false);
        
        $(".item .formInputButton").each( function(i, e){
            if ( $(e).hasClass('selected') ) {
                var index = $(e).attr('rel');
                $('[name*="devoluciones[pedido_producto_item_id][' + index + ']"]').prop('checked', true);   
            }
        });
        
        var seleccionados = $('[name*="devoluciones[pedido_producto_item_id]"]:checked').length;
        
        if ( seleccionados == 0 )
        {
            $("#devoluciones #paso-1 .error").html('Tenés que seleccionar al menos un producto');
            return;
        }
        
        if ( ($("#devoluciones_motivo").val() == "OTROS" || $("#devoluciones_motivo").val() == "FALLA" || $("#devoluciones_motivo").val() == "INCOR") && $("#devoluciones_motivo_abierto").val() == "" )
        {
            $("#devoluciones #paso-1 .error").html('Te faltó describir el motivo de la devolución');
            return;
        }
                
        if ( $("#devoluciones_motivo").val() != 'FALLA' && $("#devoluciones_motivo").val() != 'INCOR' )
        {
            $("#oca_aclaracion").html('(El retiro del producto en domicilio tiene un costo extra que será debitado del reintegro)');
        }
        else
        {
            $("#oca_aclaracion").html('');
        }
        
        // Verifico si quiere devolver un producto con categoria restringida
        $.arrayIntersect = function(a, b)
        {
            return $.grep(a, function(i)
            {
                return $.inArray(i, b) > -1;
            });
        };
        
        var idCategoriasSeleccionadas = [];
        $('[name*="devoluciones[pedido_producto_item_id]"]:checked').each
        (
            function(i, e)
            {
                idCategoriasSeleccionadas.push( parseInt( idCategorias[ $(e).val() ] ) );
            }
        );
        
        var interseccion = $.arrayIntersect(idCategoriasRestringidas, idCategoriasSeleccionadas);
        
        if ( $("#devoluciones_motivo").val() !== 'FALLA' && $("#devoluciones_motivo").val() !== 'INCOR' ) {

            if ( interseccion.length  )
            {   
                $("#devoluciones #paso-1 .error").html(mensajeCategoriasRestringidas);
                return;
            } else  {

                var hayOutlet = false;
                
                $('[name*="devoluciones[pedido_producto_item_id]"]:checked').each
                (
                    function(i, e)
                    {
                        if ( outlet[ $(e).val() ] ) {
                            hayOutlet = true;
                            return false;
                        } 
                    }
                );

                if ( hayOutlet ) {
                    $("#devoluciones #paso-1 .error").html('Los productos del outlet, no tienen cambio ni devolución exceptuando fallas');
                    return;
                }
            }

        }

        
        $("#devoluciones #paso-1 .error").html('');
                
        $("#devoluciones #paso-1").hide();
        $("#devoluciones #paso-2").show();
        self.devolucionSeleccionarPaso(2);
        
    };
    
    this.devolucionesValidacionPaso2 = function()
    {   
        $("#devoluciones #paso-2").hide();
        $("#devoluciones #paso-3").show();
        self.devolucionSeleccionarPaso(3);
        self.devolucionesPaso3();
    };
    
    this.devolucionesPaso3 = function()
    {           
        self.devolucionesCalcularPeso();

        $(".direccionEntrega").show();    
        
        $("#devoluciones_codigo_postal").unbind( 'change' );
        $("#devoluciones_codigo_postal").change( function(ev){
            ev.preventDefault();
            self.devolucionesCalcularPeso();
        } );
        
    };
    
    this.devolucionSeleccionarPaso = function(paso)
    {   
        $('html, body').animate({scrollTop : topPosition },800);
        $("#devoluciones .steps .step").removeClass("selected");
        $("#devoluciones .steps .step[rel=" + paso + "]").addClass("selected");
    };
    
    this.showHideDireccionEntrega = function(input)
    {   
        if ( input.val() == 'OCA' ) {
            $(".direccionEntrega").show();
        } else {
            $(".direccionEntrega").hide();
        }
        
        $("#devoluciones #paso-3 .error").html('');
        
    };
    
    this.devolucionesCalcularPeso = function()
    {           
        var pesoTotal = 0;
        $('[name*="devoluciones[pedido_producto_item_id]"]:checked').each( function(i,elem) {
            var tr = $(elem).parent().parent();
            
            var peso = parseFloat( $(".cantidad",tr).data().peso );
            pesoTotal +=peso;
            
        } );
        
        var codigoPostal = $("#devoluciones_codigo_postal").val();
    
        if ( $("#devoluciones_motivo").val() != 'FALLA' && $("#devoluciones_motivo").val() != 'INCOR' )
        {
            $.ajax
            (
                {
                  type: "POST",
                  url: "/ajax/cotizarRET",
                  dataType: "text",
                  data: "codigoPostal=" + codigoPostal + "&peso=" + pesoTotal,
                  success: function(data)
                  {               
                      $("#devoluciones .costoEnvio span").html( data );
                  }
                }
            );
        }
        else
        {
            $("#devoluciones .costoEnvio span").html('00,00');
        }
    };
    
    this.devolucionesValidacionPaso3 = function()
    {           
        if ( $("#devoluciones_entrega_OCA:checked").length == 0 || ( $("#devoluciones_entrega_OCA:checked").length && $("#devoluciones_nombre").val().trim() && $("#devoluciones_apellido").val().trim() && $("#devoluciones_calle").val() && $("#devoluciones_numero").val() && $("#devoluciones_codigo_postal").val() && $("#devoluciones_localidad").val() ) )
        {
            $("#devoluciones #paso-3").hide();
            $("#devoluciones #paso-4").show();
            self.devolucionSeleccionarPaso(4);
            self.devolucionesPaso4();
        }
        else
        {
            $("#devoluciones #paso-3 .error").html('Faltan completar datos de la direccion de envío');
        }
    };
    
    this.devolucionesPaso4 = function()
    {             
        $("#paso-4 .listProductItems").html("");
        
        $('[name*="devoluciones[pedido_producto_item_id]"]:checked').each( function(i, el){
            var item = $(el).parents('.item').first();
            var cantidad = item.find('select').val();
            item = item.clone();
            item.find('.select').parent().html( cantidad );    
            $("#paso-4 .listProductItems").append(item);
        });

        $("#paso-4 .item .formInputButton").remove();
            
        var leyenda = '';
        
        if ( $('[name="devoluciones[entrega]"]:checked').val() == 'OCA' ) {
            leyenda += '<li>';
            
            leyenda += 'Retiramos el producto por tu domicilio. ';
            
            if ( $("#devoluciones_motivo").val() != 'FALLA' && $("#devoluciones_motivo").val() != 'INCOR' ) {
                leyenda += '<br />(Tiene un costo extra de $ ' + $("#devoluciones .costoEnvio span").html() + ' que sera debitado del reintegro)';    
            }
            
            leyenda += '</li>';

        } else {
            leyenda += '<li>Se entrega el producto en nuestras oficinas</li>';   
        }

        if ( $('[name="devoluciones[credito]"]:checked').val() == 'MP' ) {
            leyenda += '<li>Se solicita la devolución del dinero por medio de Mercado pago</li>';    
        } else {
            leyenda += '<li>Se deja el crédito en Deluxebuys para futuras compras</li>';   
        }
        
        $("#paso-4 .leyenda").html( leyenda );
    };
    
    this.initVerificarEnvio = function()
    {        
        $("#consultaEnvio form").click(function(ev){
            ev.preventDefault();
            var url = "/mi-cuenta/verificarEnvio";
            var idPedido = $("#verificar_id_pedido").val();
            var success = function (response) { 
                $("#respuesta_consultaEnvio").html(response);
            };
            $.post(url, {idPedido: idPedido}, success, 'text');
        });
    };
    
    this.initDesactivarCuenta = function()
    {
        $("#desactivarCuenta .desactivarCuenta").click( function(){
            $("#desactivarCuenta .leyenda").show();
            $("#desactivarCuenta .si").show();
            $("#desactivarCuenta .no").show();
            $("#desactivarCuenta .desactivarCuenta").hide();
        });

        $("#desactivarCuenta .no").click( function(){
            $("#desactivarCuenta .leyenda").hide();
            $("#desactivarCuenta .si").hide();
            $("#desactivarCuenta .no").hide();
            $("#desactivarCuenta .desactivarCuenta").show();
        });
    };
    
    this.init();
};