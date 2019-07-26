var tyc = function()
{
    var self = this;

    this.init = function()
    {
        
        $('.scroll').click(function(event) {
            var href = $(this).attr('href'),
            offsetTop = $(href).offset().top - 20;
            
            $("#terminos .menu .current").removeClass("current");           
            $(this).parent().addClass("current");
            
            $('html, body').stop().animate({scrollTop: offsetTop}, 1500);
        });
    };
    

    this.init();
};

$(document).ready( function() { new tyc(); } );