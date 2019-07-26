var waitList = function()
{
	var thisClass = this;
	var dataProductoItems = {};

	this.init = function()
	{		
		$(document).on('click', ".waitList .open", function(){ thisClass.showForm(this) } );
	}
	
	this.showForm = function(elem)
	{
		if (!isLogged)
		{
			window.location = loginURL;
			return;
		}
		
		var divWaitList = $(elem).parent();
		
		$(".form",  divWaitList).show();
		$(elem).hide();
		
		var idProducto = $("#id_producto",  divWaitList).val();
		var selectTalle = $("#talle",  divWaitList);
		var selectColor = $("#color",  divWaitList);
		var selectCantidad = $("#cantidad",  divWaitList);
		
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/producto/getDataProductoItem",
			  dataType: "json",
			  data: "idProducto=" + idProducto,
			  success: function(result)
			  			{
				  			dataProductoItems[idProducto] = result;
				  			thisClass.makeTalleOptions(idProducto, selectTalle);
				  		}
			}
		);
		
		$("#talle",  divWaitList).change( function(){ thisClass.makeColorOptions( idProducto, selectTalle, selectColor, selectCantidad ); } );
		$("#color",  divWaitList).change( function(){ thisClass.makeStockOptions( selectCantidad ); } );
				
		$("form",  divWaitList).submit( function(ev){ thisClass.addWaitList( ev, divWaitList ); } );
				
		$(".no-gracias a",  divWaitList).click( function(){ $(".form",  divWaitList).hide(); $(elem).show(); } );		
		
        $('.greySelect select').each( function(){
            
            if ( $('.greySelect select').last().data().stylized ) return;
            $(this).data( { stylized: true } );
            
            var title = $(this).attr('title');
            if( $('option:selected', this).val() != '' ) {
                title = $('option:selected',this).text();
                title = ( title ) ? title : '&nbsp;';
            }
            
            $(this).css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
                   .after('<span class="select">' + title + '</span>')
                   .change(function(){
                        val = $('option:selected',this).text();
                        $(this).next().text(val);
                   });
        });
		
	}
	
	this.makeTalleOptions = function(idProducto, selectTalle)
	{	
		thisClass.removeOptions( selectTalle, 'Seleccionar');
		
		for(idProductoTalle in dataProductoItems[idProducto])
		{
		    var rowTalle = dataProductoItems[idProducto][idProductoTalle]
		    selectTalle.append($('<option value="' + rowTalle.idProductoTalle  + '">').text(rowTalle.denominacion)); 
		}
	}
		
	this.makeColorOptions = function( idProducto, selectTalle, selectColor, selectCantidad  )
	{						
		thisClass.removeOptions( selectColor, 'Seleccionar');
		thisClass.removeOptions( selectCantidad, '00');
		
		if (!dataProductoItems[idProducto][selectTalle.val()]) return;
		
	    for(idProductoColor in dataProductoItems[idProducto][selectTalle.val()].childs)
	    {	    	
	    	var rowColor = dataProductoItems[idProducto][selectTalle.val()].childs[idProductoColor];
	    	selectColor.append($('<option value="' + rowColor.idProductoColor  + '">').text(rowColor.denominacion)); 
		}
		
	}
	
	this.makeStockOptions = function( selectCantidad )
	{
		thisClass.removeOptions(selectCantidad, '00');
		
	    for(i = 1 ; i <= 5 ; i++ )
	    {
	    	selectCantidad.append($('<option value="' + i  + '">').text( ('0' + i).slice(-2) ) ); 
		}
	}

	this.removeOptions = function(selector, textoDefault)
	{
		$(selector)
	    .find('option')
	    .remove()
	    .end()
	    .append('<option value="">' + textoDefault + '</option>')
	    .val('');
	}
		
	this.addWaitList = function(ev, divWaitList)
	{		
		ev.preventDefault();
		
		var idProducto = $("#id_producto",  divWaitList).val();
		var valTalle = $("#talle",  divWaitList).val();
		var valColor = $("#color",  divWaitList).val();
		var valCantidad = $("#cantidad",  divWaitList).val();
		
		// Validacion
        if ( valTalle == '' ){
            $("#talle",  divWaitList).parent().addClass("error");
        } 
        
        if ( valColor  == '' ){
            $("#color",  divWaitList).parent().addClass("error");
        } 
        
        if ( valCantidad == 0  ){
            $("#cantidad",  divWaitList).parent().addClass("error");
        } 
		
		if ( valTalle == '' || valColor == '' || valCantidad == 0 ) return;
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/producto/addWaitList",
			  dataType: "json",
			  data: "idProducto=" + idProducto + "&idTalleProducto=" + valTalle + "&idColorProducto=" + valColor + "&cantidad=" + valCantidad,
			  success: function(response)
			  			{
				  			if (response.status == 'REDIRECT')
				  			{
				  				window.location = response.url;
				  			}
				  			
				  			if (response.status == 'OK')
				  			{
				  				$(".form",  divWaitList).hide(); 
				  				$(".done",  divWaitList).show(); 
				  			}
				  
				  		}
			}
		);
		
	}
	

	

	
	this.init();   
}

$(document).ready( function() { new waitList(); } );