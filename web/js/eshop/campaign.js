var campaign = function()
{    
    var self = this;

    this.init = function()
    {
        
        if ( $(".bannerCampaign .slides li").length > 1 ) {
            
            $(".bannerCampaign" ).flexslider({
                animation: "slide",
                controlNav: true,
                slideshowSpeed: 5000,
                prevText: "",
                nextText: ""
            });
    
        }
       
        // Window Resize
        $(".bannerCampaign .flex-direction-nav").hide();
        $( window ).resize(function(ev) { self.windowResize(); });           
        setTimeout( function(){ $(window).resize(); }, 500 );
    };


    this.windowResize = function()
    {
        var top = $(".bannerCampaign .flex-viewport").height()*(3/7);
        $(".bannerCampaign .flex-prev").css('top', top );
        $(".bannerCampaign .flex-next").css('top', top );
                                    
        var left = $(".bannerCampaign .flex-viewport").width() - 90;
        $(".bannerCampaign .flex-next").css('left', left );
        
        $(".bannerCampaign .flex-direction-nav").show();
    };
    
        
    this.init();
}

$(document).ready( function() { new campaign(); } );