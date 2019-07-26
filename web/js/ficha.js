var ficha = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        $("#newsletterModule").click( function() {
            $("#suscripcionModal").dialog( {
                    width: 825, height: 658
                });
        } );
        
        if ($('#carrousel-banners').length > 0 ){
	        $('#carrousel-banners').jcarousel({
	            wrap: 'circular',
	            easing: 'easeOutQuad',
	            animation: 800,
	            scroll: 1
	        });
        }
        
        /* FICHA */

        /* IMAGENES CHICAS */
        
        $('.product-picture').cycle({
			fx:     'scrollHorz',
			speed:  'slow',
			timeout: 0,
			pager:  '.slider',
			pagerTemplate: ''
		}); 
    	
        /* ZOOM */
        
		$('#ficha .blockContentTwo.imagesBlock img.bigImage:visible').addimagezoom({
			zoomrange: [3, 10],
			magnifierpos: 'right',
			cursorshade: true,
			magnifiersize: [430,630],
			width: 430,
			height: 640,
			largeimage: '../images/listado-oferta-box.jpg'
		});
		
		/* CARROUSEL IMAGENES CHICAS */
		
		$(".productRecordSlider").jcarousel({
			wrap: 'circular'
		});
		
		$('.row.right.sprite.blackEmptyButton').jcarouselControl({
			target: '+=1'
	    });

		$('.row.left.sprite.blackEmptyButton').jcarouselControl({
			target: '-=1'
		});
        
    }
        
    this.init();
}

$(document).ready( function() { new ficha(); } );