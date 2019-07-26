var generalHelper = function(esEshop, genero)
{
    var self = this;
    self.esEshop = esEshop;
    self.genero = genero;
    self.cookieNewsModal = 'show-N3ws-M0d4l';
    
    
    this.init = function()
    {
        $("#newsletterModule").click( function() {
            self.mostrarModalNewsletter();
        } );
        
        $("#newsletterForm").submit(function (ev) { ev.preventDefault(); });
        $("#suscripcionModal .enviarNewsletterBtn").click( function(){ self.enviarNewsletterModal(); } );
        
    };
    
    this.newsletterCookie = function()
    {
        if ( isLogged ) {
            return;
        }
        
        if ( !$.cookie( self.cookieNewsModal ) )
        {
            var cookieValue = { showSecondTime: false }

            var timeToAppear = (self.esEshop ) ?  5000 : 30000;            
            setTimeout(function(){ self.mostrarModalNewsletter(); }, timeToAppear);
            
            ga('send', 'pageview', '/usuario/newsletter-show');
            
            $.cookie( self.cookieNewsModal, JSON.stringify(cookieValue), {expires: 999}  );
        }
        
        $(document).mouseout( function(e) {
            var from = e.relatedTarget || e.toElement;
            
            var cookieValue = JSON.parse( $.cookie( self.cookieNewsModal ) );
            $("#suscripcionModal").hasClass('ui-dialog-content')
            if( (
                    !from || from.nodeName == 'HTML') && e.clientY <= 20 && !cookieValue.showSecondTime &&
                    (
                        ( !$("#suscripcionModal").hasClass('ui-dialog-content') ) ||
                        ( $("#suscripcionModal").hasClass('ui-dialog-content') && !$("#suscripcionModal").dialog( "isOpen" ) )
                    )                    
                ){
                
        
                self.mostrarModalNewsletter();
                    
                ga('send', 'pageview', '/usuario/newsletter-show');
                
                $.cookie( self.cookieNewsModal , JSON.stringify( { showSecondTime: true } ), {expires: 999}  );
            }
        });  
            
        
    };
    
    this.mostrarModalNewsletter = function()
    {
        if ( $(".ui-dialog").css('display') == 'block' ) return;
        
        if (!isMobile) {
            if (self.esEshop ) {
                var height = parseInt( $("#home-modal").css('height').replace('px') ) + 45;    
            } else {
                var height = 646;
            }        
                    
            $("#suscripcionModal").dialog( {
                width: ( self.esEshop ) ? 791 : 825,
                height: height,
                modal: true,
                zindex: 99999,
                closeOnEscape: false,
                resizable: false,
                dialogClass: "suscripcion"
            });
        }
        else {
            $("#suscripcionModal").dialog( {
                width: "90%",
                height: "600px",
                left: "5%",
                right: "5%",
                modal: true,
                zindex: 99999,
                closeOnEscape: false,
                resizable: false,
                dialogClass: "suscripcion"
            });
        }   

        $(".ui-widget-overlay").click(function(){ $("#suscripcionModal").dialog('close') });
    };
    
    this.enviarNewsletterModal = function()
    {   
        var nombre = $("#suscripcionModal [name=nombre]").last().val();
        var apellido = $("#suscripcionModal [name=apellido]").last().val();
        var email = $("#suscripcionModal [name=email]").last().val();
        
        if ( self.genero ) {
            var genero = self.genero;
        } else {
            var genero = $("#suscripcionModal [name=sexo]:checked").last().val();    
        }

        $.ajax(
                {
                    type: "post",
                    dataType: "html",
                    url: "/suscribir",
                    data: "nombre=" + nombre + "&apellido=" + apellido + "&genero=" + genero + "&email=" + email,
                    cache: false,
                    success: function(response)
                    {
                        console.log(response);
                        $("#suscripcionModal .alert").html(response);
                        
                        if ( response.match(/message ok/) )
                        {
                            ga('send', 'pageview', '/usuario/newsletter-ok');
                            
                            window.location.href = "/suscribir/ok";
                        }
                        
                        if ( response.match(/message error ERROR_UNIQUE/) )
                        {
                            setTimeout(function () { $("#suscripcionModal").dialog('close'); }, 750);
                        }
                    }
                }
            );
    };    
    
    this.init();

};