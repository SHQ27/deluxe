var tiendas = function()
{    
    var self = this;
    self.map = null; 
    
    this.init = function()
    {
        this.initMap();

        // El reordenamiento de categorizacion solo se utiliza en la version desktop
        if ( !isMobile ) { this.initCategorizacion(); }
    };
    

    this.initCategorizacion = function()
    {
        // Plugin para reordenamiento al hacer click
        $('#tiendas .items').isotope({ itemSelector: '.item', layoutMode: 'fitRows' });
        
      
        $(".barra .menu li a").click( function(ev){
            
            ev.preventDefault();
            
            var clase = $(this).attr("href");
            
            $(".barra .menu .current").removeClass("current");
            $(this).parent().addClass("current");
            
            setTimeout(function(){ self.showHideMarkers(clase); }, 100);
            $('#tiendas .items').isotope({ filter: clase });
                        
        });
    };

    this.showHideMarkers = function(clase)
    {
        clase = clase.replace('.', '');
        clase = clase.replace('categoria-', '');
        
        for(var i in jsonTiendas)
        {
            if ( jsonTiendas[i].marker )
            {
                
                if(clase == "*" || jsonTiendas[i].clases.indexOf( clase ) != -1 )
                {
                    jsonTiendas[i].marker.setMap(self.map);
                }
                else
                {
                    jsonTiendas[i].marker.setMap(null);
                }
            }
        }        
    }

    
    this.initMap = function()
    {
        // Creo el mapa
        var mapOptions = {
            center: new google.maps.LatLng(-34.591457, -58.4658051),
            zoom: 13,
            mapTypeControl: false,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            styles : [
              {
                "stylers": [
                  { "saturation": -100 }
                ]
              },{
                "elementType": "labels.text.stroke",
                "stylers": [
                  { "visibility": "off" }
                ]
              },{
                "elementType": "geometry.stroke",
                "stylers": [
                  { "visibility": "off" }
                ]
              },{
                "stylers": [
                  { "lightness": 31 }
                ]
              },{
                "featureType": "administrative.locality",
                "elementType": "labels.text",
                "stylers": [
                  { "lightness": -60 }
                ]
              },{
                "featureType": "administrative.neighborhood",
                "elementType": "labels.text.fill",
                "stylers": [
                  { "lightness": -48 }
                ]
              },{
                "featureType": "road.local",
                "elementType": "labels.icon",
                "stylers": [
                  { "visibility": "on" }
                ]
              },{
              }
            ]
        };

        self.map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);
    
        // Cargo las tiendas
        var markers = [];
        for(var i in jsonTiendas)
        {
            
            if ( jsonTiendas[i].lat && jsonTiendas[i].lng ) {
                var myLatlng = new google.maps.LatLng(jsonTiendas[i].lat, jsonTiendas[i].lng);

                marker = new google.maps.Marker({
                    position: myLatlng,
                    map: self.map,
                    icon: "/images/eshop/" + idEshop + "/marker.png"
                });

                jsonTiendas[i].marker = marker;
                markers.push( marker );
            }
        }

        var bounds = new google.maps.LatLngBounds();
        for(i=0;i<markers.length;i++) {
         bounds.extend(markers[i].getPosition());
        }

        self.map.fitBounds(bounds);
        
    };
        
    this.init();
};

$(document).ready( function() { new tiendas(); } );