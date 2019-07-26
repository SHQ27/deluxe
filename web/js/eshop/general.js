var general = function()
{
    var self = this;
    
    this.init = function()
    {        
        // Inicializo el Helper
        var genero = $("#suscripcionModal [name=sexo]").val();
        self.generalHelper = new generalHelper(true, genero);
        self.generalHelper.newsletterCookie();

        // Inits
        this.initMoveToUp();
        this.initCustomSelect();
        this.initCustomRadio();

        // Inicializo las configuraciones propias para desktop
        if (!isMobile) { this.initDesktop(); }

        // Inicializo las configuraciones propias para mobile
        if (isMobile)  { this.initMobile(); }
    };

    this.initMobile = function()
    {
        self.initNavMobile();
    };

    this.initDesktop = function()
    {
        setTimeout( function(){ self.initNavDesktop(); }, 500 );
        this.initBarraFlotante();
        this.initTopBar();  
    };

    this.initNavDesktop = function()
    {
        var width = 25;
        $("#nav .menu .li").each( function(i,e){  
            if ( $(e).css('display') !== 'none' ) {
                width += $(e).outerWidth(true);    
            }
        });
        
        $("#nav .menu").width(width + 10);
        $("#nav .menu").css("visibility","visible");
    }

    this.initNavMobile = function()
    {
        $(".toolbar .iconCarrito").click( function() {
            $(".navUserNotLogged").slideUp("slow");
            $(".toolbar .iconMenu").removeClass("cross");
            $(".navMenu").slideUp("slow");
            $(".navUserLogged").slideUp("slow");
            $(".navCarrito").slideToggle("slow");
        });

        $(".toolbar .iconUserLogged").click( function() {
            $(".navUserNotLogged").slideUp("slow");
            $(".toolbar .iconMenu").removeClass("cross");
            $(".navMenu").slideUp("slow");
            $(".navCarrito").slideUp("slow");
            $(".navUserLogged").slideToggle("slow");
        });

        $(".toolbar .iconUserNotLogged").click( function() {
            $(".navUserLogged").slideUp("slow");
            $(".toolbar .iconMenu").removeClass("cross");
            $(".navMenu").slideUp("slow");
            $(".navCarrito").slideUp("slow");
            $(".navUserNotLogged").slideToggle("slow");
        });

        $(".toolbar .iconMenu").click( function() {
            $(".navMenu .lisubmenu").removeClass("active");
            $(".navMenu .lisubmenu").find("ul").slideUp("slow");

            $(".navUserLogged").slideUp("slow");
            $(".navUserNotLogged").slideUp("slow");
            $(".navCarrito").slideUp("slow");
            $(".navMenu").slideToggle("slow");
            $(this).toggleClass("cross");
        });

        $(".navMenu .titsubmenu").click( function() {
            var parent = $(this).parent();

            parent.toggleClass("active");

            parent.find("ul").slideToggle("slow");
        });
    }
    
    this.initBarraFlotante = function()
    {
        if (!useMenuFlotante) { return; }

        $("#nav .menu").clone().appendTo(".barraFlotante .menuContainer");
        $(".header .items.derecha").clone().appendTo(".barraFlotante .buttonsContainer");
        $(".barraFlotante .buttonsContainer .signin").remove();
        $(".barraFlotante .btMiCarro").attr("rel", "barraFlotante");
        $(".barraFlotante .btMiCuenta").attr("rel", "barraFlotante");

        var limit = $(".header").first().height() - 65;

        $(window).scroll(function () {
            var positionY = $(window).scrollTop();
            if ( positionY >= limit ) {
                $(".barraFlotante").show();
            } else {
                $(".barraFlotante").hide();
            }
        });
    }    


    this.initTopBar = function()
    {

        $(document).on('click', ".btMiCarro", function(e){
            var divContainer = $(this).attr("rel");
            $("." + divContainer + " #onlineBag").slideToggle(150);
            $("." + divContainer + " #d-micuenta").slideUp(150);
            $("body").one("click", function() {
                $("." + divContainer + " #onlineBag").slideUp(150);
            });
            e.stopPropagation();
            return false;
        });
        
        $(document).on('click', ".btMiCuenta", function(e){
            var divContainer = $(this).attr("rel");
            $("." + divContainer + " #d-micuenta").slideToggle(150);
            $("." + divContainer + " #onlineBag").slideUp(150);
            $("body").one("click", function() {
                $("." + divContainer + " #d-micuenta").slideUp(150);
            });
            e.stopPropagation();
            return false;
        });
    };

    this.initCustomSelect = function()
    {
        $('.customSelect select').each( function(){
            var title = $(this).attr('title');
            if( $('option:selected', this).val() != '' ) {
                title = $('option:selected',this).text();
            }
            
            title = ( title ) ? title : '&nbsp;';
            
            $(this).css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                   .after('<span class="select">' + title + '</span>')
                   .change(function(){
                        val = $('option:selected',this).text();
                        $(this).next().text(val);
                   });
        });   
    };


    this.initCustomRadio = function()
    {
        $(document).on('click', ".radio", function(ev){
            if( $(ev.currentTarget).find("input").is(':checked') === false && !$(ev.currentTarget).hasClass("selected") ){
                var name = $(ev.currentTarget).find("input").attr('name');
                $('.radio input[name="' + name + '"]').prop('checked', false);
                $(ev.currentTarget).find("input").prop('checked', true);
                $('.radio input[name="' + name + '"]').parent().removeClass("selected");
                $(ev.currentTarget).addClass("selected");
            }
        });
        
        $(document).on('click', ".radioLabel", function(ev){
            ev.preventDefault();
            var id = $(this).attr('for');
            var name = $("#" + id).attr('name');
            $('.radio input[name="' + name + '"]').prop('checked', false);
            $("#" + id).prop('checked', true);
            $('.radio input[name="' + name + '"]').parent().removeClass("selected");
            $("#" + id).parent().addClass("selected");
        });
    };
    
    this.initMoveToUp = function()
    {
        $(window).scroll(function(){
            if ($(this).scrollTop() > 200) {
                $('.scrollToTop').fadeIn();
            } else {
                $('.scrollToTop').fadeOut();
            }
        });
        
        $('.scrollToTop').click(function(){
            $('html, body').animate({scrollTop : 0},800);
            return false;
        });         
        
    };
        
    this.init();
}

var general;
$(document).ready( function() { general = new general(); } );