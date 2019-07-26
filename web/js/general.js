var general = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        // Inicializo el Helper
        self.generalHelper = new generalHelper(false), false;
        
        // Inits
        this.initCustomSelect();
        this.initCustomRadio();
        this.initStyles();
        
        // Promo Modals
        this.promoModal();
        
        var now = new Date();
        var timestamp = now.getTime();

        if ( !(                
                ( 1463410800000 <= timestamp  &&  timestamp < 1463418000000 ) ||
                ( 1463428800000 <= timestamp  &&  timestamp < 1463436000000 ) ||
                ( 1463500800000 <= timestamp  &&  timestamp < 1463508000000 ) ||
                ( 1463518800000 <= timestamp  &&  timestamp < 1463526000000 )
              )
           ) {
            self.generalHelper.newsletterCookie();
           }
        
        // Agregados al pop up del newsletter
        $(".alreadyRegisterLink").click( function() {
            $("#suscripcionModal").dialog('close');
        } );
        
        // Inicializo placeholders
        $('input, textarea').placeholder();
    };
    
    this.initStyles = function()
    {
        $(".categorias .sub").css('display', 'block');
        $(".categorias .sub").css('visibility', 'hidden');

        $(".categorias ul.first").each( function(i,e) {
            
            var heightCategories = $(e).height();
            var heightStickers = $(e).height();
            
            if ( heightCategories > heightStickers ) {
                $(e).parent().find('.stickers').height( heightCategories );        
            }
        });
       
        $(".categorias .sub").css('display', '');
        $(".categorias .sub").css('visibility', '');
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

    
    this.promoModal = function()
    {        
        setTimeout( function(){
            thisClass.configPromoModal();
        }, 60000);
        
        setInterval( function(){
            thisClass.configPromoModal();
        }, 300000);
    };
    
    this.configPromoModal = function()
    {
        var now = new Date();
        var timestamp = now.getTime();

        if ( 1463410800000 <= timestamp  &&  timestamp < 1463418000000 ) {
            thisClass.openPromoModal('promoModal-a');
        } else if ( 1463428800000 <= timestamp  &&  timestamp < 1463436000000 ) {
            thisClass.openPromoModal('promoModal-b');
        } else if ( 1463500800000 <= timestamp  &&  timestamp < 1463508000000 ) {
            thisClass.openPromoModal('promoModal-c');
        } else if ( 1463518800000 <= timestamp  &&  timestamp < 1463526000000 ) {
            thisClass.openPromoModal('promoModal-d');
        }
    };
        
    
    this.openPromoModal = function(modalName)
    {
        $("#" + modalName).dialog( {
            width: 616,
            height: 500,
            modal: true,
            zindex: 99999,
            closeOnEscape: true,
            resizable: false,
            dialogClass: "dialog-promo-modal"
        });

        $(".ui-widget-overlay").click(function(){ $("#" + modalName).dialog('close') });
        
        $('#audioCampana')[0].play();
    };
    
    

    
    
    this.init();
}

var general;
$(document).ready( function() { general = new general(); } );