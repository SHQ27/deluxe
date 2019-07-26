var productoDetalleHelper = function(esEshop)
{
    var self = this;
    self.esEshop = esEshop;

    this.init = function()
    {
        self.showOpaqueBlocks();

        // Formulario        
        self.makeTalleOptions();
        $("#talle").change( function(){ self.makeColorOptions( $("#talle").val() ); } );

        $(".colorBlock").click(function(){ self.selectColorOption( $("#talle").val(), $(this).attr('value'),  $(this));})
        $("#addProductoForm").submit( function(ev){ self.addProductoForm(ev); } );
        
        // Fitting Room
        if ( $(".probadorOnline").length ){
            this.fittingRoom();
        }     
        
    };

    // Arma los bloques de colores
    this.showOpaqueBlocks = function(){
        var imgs = [];
        for(idProductoTalle in dataProductoItems){
            for(idProductoColor in dataProductoItems[idProductoTalle].childs)
                imgs[dataProductoItems[idProductoTalle].childs[idProductoColor].idProductoColor] = {denominacion: dataProductoItems[idProductoTalle].childs[idProductoColor].denominacion, img: dataProductoItems[idProductoTalle].childs[idProductoColor].imagen};
        }

        for (idProductoColor in imgs){
            denominacion = imgs[idProductoColor].denominacion.replace(/\s+/g, '_');
            img = imgs[idProductoColor].img;
            $('#colorBlocks').append($('<img value='+idProductoColor+' id="colorBlock'+denominacion+'" class="opaqueBlockColor colorBlock" src="http://deluxebuys-uploads.s3-website-us-east-1.amazonaws.com/familiaColor/' +img+'" title="'+denominacion+'">')); 
        }
    }
    
    this.makeTalleOptions = function()
    {       
        for(idProductoTalle in dataProductoItems)
        {
            var rowTalle = dataProductoItems[idProductoTalle];
            $('#talle').append($('<option value="' + rowTalle.idProductoTalle  + '">').text(rowTalle.denominacion)); 
        }
    };
    
    this.removeOptions = function(selector, textoDefault)
    {
        $(selector)
        .find('option')
        .remove()
        .end()
        .append('<option value="">' + textoDefault + '</option>')
        .val('');
    };

    this.unselectColorBlocksSelected = function()
    {
         $('img.colorBlock').removeClass('colorBlockSelected');
    }
    
    this.makeColorOptions = function(idProductoTalle, color)
    {               

        self.removeOptions('#color', 'Seleccionar');
        self.removeOptions('#cantidad', '00');
        self.unselectColorBlocksSelected();
        
        $( ".colorBlock" ).addClass('opaqueBlockColor');
        if (!dataProductoItems[idProductoTalle]) return;
        
        var number_of_colors_available = 0;
        for(idProductoColor in dataProductoItems[idProductoTalle].childs)
        {   
            denominacion = dataProductoItems[idProductoTalle].childs[idProductoColor].denominacion.replace(/\s+/g, '_');
            $('#colorBlock'+denominacion).removeClass('opaqueBlockColor');

            var rowColor = dataProductoItems[idProductoTalle].childs[idProductoColor];
            $('#color').append($('<option value="' + rowColor.idProductoColor  + '">').text(rowColor.denominacion)); 
            number_of_colors_available += 1;
        }

        if(number_of_colors_available == 1){
            denominacion = dataProductoItems[idProductoTalle].childs[idProductoColor].denominacion.replace(/\s+/g, '_');
            $( '#colorBlock'+denominacion ).trigger( "click" );
        }
    };
    
    this.selectColorOption = function(idProductoTalle, color, block){
        if( ! block.hasClass('opaqueBlockColor') ){ 
            self.unselectColorBlocksSelected();
            block.addClass("colorBlockSelected"); 
                     
            $('#color').val( color );
            $('#cantidad').val( 0 );
            self.makeStockOptions( idProductoTalle, color );
        }
    }

    this.makeStockOptions = function(idProductoTalle, idProductoColor)
    {
        self.removeOptions('#cantidad', '00');
        
        if (!dataProductoItems[idProductoTalle].childs[idProductoColor]) return;
        
        var rowColor = dataProductoItems[idProductoTalle].childs[idProductoColor];
                
        var stock = (rowColor.stock > 0)? rowColor.stock : 0;

        for(var i = 1 ; i <= stock ; i++ )
        {
            if ( i > 3 ) { break; }
            $('#cantidad').append($('<option value="' + i  + '">').text( ('0' + i).slice(-2) ) ); 
        }
    };


    
    this.addProductoForm = function(ev)
    {       
        ev.preventDefault();
        
        // Validacion por restriccion de mezcla
        if ( $("#mostrarCartelMezcla").val() == 1 )
        {
            self.mostrarAlertaMezcla();
            return;
        }
        
        // Validacion de ingreso de datos
        if ( $("#talle").val() == '' || $("#color").val() == '' || $("#cantidad").val() == 0 )
        {
            if (!isMobile) {
                $("#alerta_agregar_producto").dialog({
                    width: 430,
                    height: 300,
                    modal: true,
                    resizable: false,
                    zindex: 99999,
                    dialogClass: "alert"
                });
            }
            else {
                $("#alerta_agregar_producto").dialog({
                    width: "90%",
                    height: 300,
                    left: "5%",
                    right: "5%",
                    modal: true,
                    resizable: false,
                    zindex: 99999,
                    dialogClass: "alert"
                });                
            }
            
            $("#alerta_agregar_producto").click(function(){ $("#alerta_agregar_producto").dialog('close'); });
            $(".ui-widget-overlay").click(function(){ $("#alerta_agregar_producto").dialog('close'); });

            return;
        }
        
        var idProducto = $("#id_producto").val();
        var price = productoPrice * $("#cantidad").val();

        $.ajax
        (
            {
              type: "POST",
              url: "/carrito/addProduct",
              dataType: "json",
              data: "idProducto=" + idProducto + "&idProductoTalle=" + $("#talle").val() + "&idProductoColor=" + $("#color").val() + "&cantidad=" + $("#cantidad").val(),
              success: function(result)
                        {
                            
                            if (result.status == 'KO')
                            {
                                if (result.message == 'MEZCLA')
                                {
                                    self.mostrarAlertaMezcla();
                                }
                                else
                                {
                                    $('#addProductoForm div.alert').html(result.message);
                                }
                            }
                            else
                            {
                                // Facebook Ads
                                if ( window._fbq ) {
                                    if ( self.esEshop ) {
                                        window._fbq('track', 'AddToCart', { content_ids: [idProducto], content_type: 'product' });    
                                    } else {
                                        window._fbq.push(['track', 'AddToCart', { content_ids: [idProducto], content_type: 'product' }]);    
                                    }
                                }

                                if ( typeof _cartstack !== "undefined" ) {

                                    var talle = $("#talle option[value=" + $("#talle").val() + "]").html();
                                    var color = $("#color option[value=" + $("#color").val() + "]").html();

                                    _cartstack.push(['setCartItem', {
                                     'quantity': $("#cantidad").val(),
                                     'productID': idProducto,
                                     'productName': productoNombre,
                                     'productDescription': 'Talle: ' + talle + '|  Color:' + talle,
                                     'productURL': productoURL, 
                                     'productImageURL': productoImagenURL,
                                     'productPrice': productoPrice
                                    }]);
                                }

                                // Redirect
                                window.location.href = result.urlCarrito;
                            }
                        }
            }
        );      
    };
    
    this.mostrarAlertaMezcla = function(ev)
    {
               
        $("#alerta_mezcla").dialog({
            width: 515,
            height: 258,
            modal: true,
            resizable: false,
            zindex: 99999,
            dialogClass: "alert"
        });
        
        $("#alerta_mezcla").click(function(){ $("#alerta_mezcla").dialog('close'); });
        $(".ui-widget-overlay").click(function(){ $("#alerta_mezcla").dialog('close'); });
        
    };
    
    this.fittingRoom = function()
    {       
        $(".probadorOnline").click( function(){
            $("#probadorOnline").dialog( {
                width: 500,
                height: ( self.esEshop ) ? 700 : 560,
                modal: true,
                zindex: 99999,
                resizable: false
            });
            
            $(".ui-widget-overlay").click(function(){ $("#probadorOnline").dialog('close'); });
        });
                 
        var c = zonasJson.length;
        for ( var i = 0 ; i < c ; i++ )
        {
            $( "#probadorOnline #spinner_" + zonasJson[i].idTalleZona).spinner({ 'min': zonasJson[i].min, 'max': zonasJson[i].max });
            
            if (medidasUsuarioJson)
            {
                $( "[id=spinner_" + zonasJson[i].idTalleZona + "]").val( medidasUsuarioJson[zonasJson[i].idTalleZona] );
            }
            else
            {
                $( "[id=spinner_" + zonasJson[i].idTalleZona + "]").val( parseInt( (parseInt(zonasJson[i].min) + parseInt(zonasJson[i].max)) / 2 ) );
            }
        }
        
        $(".ui-spinner").mouseover ( function() {
            var idZona = $(this).parents('.zona').first().attr('rel');
            
            var indicador = $(".indicador");
            indicador.removeAttr('class');
            indicador.attr('class', 'indicador');
            indicador.addClass("indicador_" + idZona);
            
            $(".detalleProbador .itemDetalleProbador").hide();
            $(".detalleProbador_" + idZona).show();
        });
        
        $(".zona input").after('<span class="cm">cm</span>');
        
        
        $('#probadorOnline .button').click( function(){ 
                       
            var result = [];
            
            $('#probadorOnline .zona').each( function(i,elem) {
                
                var idZona = $(elem).attr('rel');
                var dataValue = $('#probadorOnline #spinner_' + idZona).val();

                for (var idProductoTalle in talleSetJson[idZona]['data'])
                {   
                    var zona  = talleSetJson[idZona]['denominacion'];
                    var talle = talleSetJson[idZona]['data'][idProductoTalle]['denominacion'];
                    var desde = parseInt(talleSetJson[idZona]['data'][idProductoTalle]['data']['desde']);
                    var hasta = parseInt(talleSetJson[idZona]['data'][idProductoTalle]['data']['hasta']);
                    var orden = parseInt(talleSetJson[idZona]['data'][idProductoTalle]['data']['orden']);
                                       
                    if ( desde <= dataValue && dataValue <= hasta )
                    {
                        result.push( {'zona' : zona, 'talle' : talle, 'idProductoTalle' : idProductoTalle, 'orden': orden, 'idZona': idZona} ); 
                    }   
                }
            } );
            
            var maxOrden = -1;
            var maxTalle = null;
            var c = result.length;
            
            for (i = 0 ; i < c ; i++ )
            {
                var orden = parseInt(result[i].orden);
                if (orden > maxOrden)
                {
                    maxOrden = orden;
                    maxTalle = result[i].talle;
                }
            }
            
            
            var response = { 'result' : { 'maxOrden' : maxOrden, 'maxTalle' : maxTalle }, 'data' : [] };
            
            for (i = 0 ; i < c ; i++ )
            {
                response['data'].push( { 'idZona': result[i].idZona, 'zona': result[i].zona, 'distance' : maxOrden - parseInt(result[i].orden) } );
            }
                       
            $('#probadorOnline .paso-1').hide();
            $('#probadorOnline .paso-2').show();
            $('#probadorOnline .paso-2 .talle').html(response.result.maxTalle);
            
             
            var dataSeleccionada = [];
            c = response.data.length;
            for (i = 0 ; i < c ; i++ )
            {
                var dataValue = $('#probadorOnline #spinner_' + response['data'][i].idZona ).val();
                dataSeleccionada.push( response['data'][i].idZona + '-' + dataValue );               
            }
            
            $.ajax
            (
                {
                  type: "POST",
                  url: "/producto/saveMedidas",
                  dataType: "json",
                  data: 'medidas=' + dataSeleccionada.join(','),
                  success: function(result) {}
                }
            );
                      
            $(".indicadorOff").show();
            
        });
        
    };
    
    this.init();
};