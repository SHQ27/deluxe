var filtro = function(rangoDefault) {
    var self = this;
    self.values = {
        "categorias" : [],
        "talles" : [],
        "colores" : [],
        "order" : '',
        "rango" : rangoDefault
    };

    this.init = function() {
        
        $('.acordion .titulo.closed').next().hide();
        
        this.initPrinceRange();
        this.initOrder();
        this.setDefaultValues();
        this.initRemoveFilter();
        this.initAddFilter();
        this.initEffects();
        $(".acordion .elementos").mCustomScrollbar();
    };
    
    this.initAddFilter = function() {
        $(".filtro .elemento").click(function() {
            var value = $(this).data().value.toString();
            var name = $(this).data().name;
            self.values[name].push(value);
            self.values[name] = $.unique(self.values[name]);
            self.submitFilter();
        });
    };
    
    this.initRemoveFilter = function() {
        $(".filtro #actual .items .item .inline").click(function() {
            var value = $(this).data().value.toString();
            var name = $(this).data().name;

            self.values[name] = jQuery.grep(self.values[name], function(val) {
                return val != value;
            });
            self.submitFilter();
        });

        $(".filtro #actual #btLimpiar").click(function() {
            baseUrl = window.location.hostname + window.location.pathname;
            return window.location.href = "http://" + baseUrl;
        });
    };
    
    this.initPrinceRange = function() {
        var precioMin = self.values['rango'][0];
        var precioMax = self.values['rango'][1];
        
        var precios = $( "#slider-range" ).slider({
            range: true,
            min: precioMin,
            max: precioMax,
            step: 5,
            values: [ self.values['rango'][2], self.values['rango'][3] ],
            slide: function( event, ui ) {
                var min = ui.values[ 0 ];
                var max = ui.values[ 1 ];
                $( "#amount .min" ).text( "$" + min);
                $( "#amount .max" ).text( "$" + max);

                setTimeout( function() {
                    self.values['rango'][2] = ui.values[ 0 ];
                    self.values['rango'][3] = ui.values[ 1 ];
                    self.submitFilter();
                }, 1000);
            }
        });
        
        $( "#amount .min" ).text( "$" + $( "#slider-range" ).slider( "values", 0 ));
        $( "#amount .max" ).text( "$" + $( "#slider-range" ).slider( "values", 1 ));
    };
    
    this.initOrder = function() {
        $('#orden').ddslick({ defaultSelectedIndex: 0 });
        $("#orden .dd-option").click( function(){
            var value = $(this).find('.dd-option-value').val();
            value = value ? value : '';
            self.values['order'] = value;
            self.submitFilter();            
        });
    };
    
    this.showHideEliminarFiltros = function() {
        
        
        var estaFiltrandoRango = self.values['rango'][0] != self.values['rango'][2] || self.values['rango'][1] != self.values['rango'][3];
        var estaFiltrandoResto = $(".filtro #actual .items .item").length;
        
        if ( estaFiltrandoRango || estaFiltrandoResto ) {
            $(".filtro #actual #btLimpiar").show();
        } else {
            $(".filtro #actual #btLimpiar").hide();
        }
    };

    this.submitFilter = function() {
        
        this.showHideEliminarFiltros();

        // Se arma el querystring
        parameters = "";

        for (name in self.values) {
            var values = ( name == 'order' ) ? self.values[name] : self.values[name].join(",");
            parameters += '&' + name + '=' + values;
        }

        parameters = parameters.substring(1); // delete first &

        // Se hace el redirect
        baseUrl = window.location.hostname + window.location.pathname;
        url = baseUrl + "?" + parameters;
        return window.location.href = "http://" + url;

        /*
         * 
         * parameters += '&rango=' + rangeMin + ',' + rangeMax + ',' +
         * rangeSettedMin + ',' + rangeSettedMax;
         * 
         */

    }

    this.setDefaultValues = function() {
        if (window.location.search.length > 0) {
            $(window.location.search.substring(1).split("&"))
                    .each(
                            function(i, e) {
                                var arr = e.split("=");
                                var name = arr[0];
                                var values = arr[1];

                                if (values.trim() != '') {
                                    values = values.split(",");

                                    self.values[name] = values;

                                    for (i in values) {
                                        var opcion = $(".filtro .elemento[data-name='" + name + "'][data-value='" + values[i] + "']");
                                        opcion.addClass("selected");
                                        var title = opcion.attr('title');

                                        if (title) {
                                            $(".filtro #actual .items").append( '<div class="item OS-11 color4" title="' + name + '. ' + title + '"><span class="inline" data-name="' + name + '" data-value="' + values[i] + '"></span>' + name + '. ' + title + '</div>');
                                        }
                                    }
                                }
                            });
            
            // Seteo el valor inicial del select de orden
            $("#orden .dd-option input").each( function(i, el){
                if ( $(el).val() == self.values['order'] ) {
                    $('#orden').ddslick('select', {index: i + 1 });     
                }
            });
            
        }
                
        self.showHideEliminarFiltros();
    };
    
    this.initEffects = function()
    {
        $('.acordion .titulo').click(function() {
            if($(this).hasClass("closed"))
            {
                $(this).removeClass("closed");
                $(this).next().slideDown(300);
            }
            else
            {
                $(this).addClass("closed");
                $(this).next().slideUp(300);
            }
            return false;
        });
    };

    this.init();
};