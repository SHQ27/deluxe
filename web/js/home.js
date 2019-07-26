var home = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        
        if ( $('#carrousel-banners li').length > 1 )
        {
            $('#carrousel-banners').jcarousel({
                wrap: 'circular',
                easing: 'easeOutQuad',
                animation: 800,
                scroll: 1
            });
            
            setInterval( function(){ $('.campain.banner .jcarousel-next ').click() }, 5000 );
        }
        
        if ( $('#carrousel-proximas-campanas li').length > 4 )
        {
            $('#carrousel-proximas-campanas').jcarousel({
                wrap: 'circular',
                easing: 'easeOutQuad',
                animation: 800,
                scroll: 2
            });
        }
       
        $('#carrousel-banner-principal li').css('visibility', 'visible');
        
        if ( $('#carrousel-banner-principal li').length > 1 )
        {
            $('#carrousel-banner-principal').jcarousel({
                wrap: 'circular',
                easing: 'easeOutQuad',
                animation: 0,
                scroll: 1
            });
            
            setInterval( function(){ $('#mainCampaign .jcarousel-next').click() }, 1000 );
        }
        
    }
        
    this.init();
}

$(document).ready( function() { new home(); } );