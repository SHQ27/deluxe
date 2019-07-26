var formProducto = function()
{
	var thisClass = this;
	var inputCodigo = null
	var selectTalle = null
	var selectColor = null
	var inputStockLimite = null
	var selectAccion = null
	var selectOrigen = null
	var inputCantidad = null
	var textAreaObservacion = null
	var selectStockTipo = null
	var inputStock = null
	
	this.init = function()
	{
		this.widgetTag();
		this.addWidgetProductoItem();
		this.removeWidgetProductoItem();
		this.verWidgetProductoItem();

    	preventDoubleSubmit.init('sf_admin_form');
		
		$("[id=producto_stock_talle]").live('change', function(ev, el){ thisClass.changeTalle(this); } );
		$("[id=producto_stock_color]").live('change', function(ev, el){ thisClass.changeColor(this); } );
		$("#producto_stock_table tbody tr .remove a").click(  function(ev){ thisClass.deleteItem(this); } );
		
		thisClass.changeEsOutlet(this);
		$("[id=producto_es_outlet]").change( function(ev){
		    thisClass.changeEsOutlet(this);
		} );
		
		// Solo hace update de la marca si el form es New
		if ( !$("#producto_id_producto").val() ) this.updateMarca();    
		
		$('#producto_id_marca').change( function() {thisClass.updateMarca(); } );	
				
		this.inputCodigo = $("#producto_stock_codigo").first().clone();
		$("#producto_stock_codigo").remove();

		this.selectTalle = $("#producto_stock_talle").first().clone();
		$("#producto_stock_talle").remove();
		
		this.selectColor = $("#producto_stock_color").first().clone();
		$("#producto_stock_color").remove();

		this.selectAccion = $("#producto_stock_accion").first().clone();
		$("#producto_stock_accion").remove();

		this.selectOrigen = $("#producto_stock_origen").first().clone();
		$("#producto_stock_origen").remove();

		this.inputCantidad = $("#producto_stock_cantidad").first().clone();
		$("#producto_stock_cantidad").remove();

		this.textAreaObservacion = $("#producto_stock_observacion").first().clone();
		$("#producto_stock_observacion").remove();

		this.selectStockTipo = $("#producto_stock_stock_tipo").first().clone();
		$("#producto_stock_stock_tipo").remove();

		this.initEshopWidget();
		$("#producto_id_marca").change( function(){ thisClass.changeMarca(false); } );
		}

	this.updateMarca = function()
	{
	    var idMarca = $('#producto_id_marca').val()
	    
	       $.ajax
	        (
	            {
	              type: "POST",
	              url: "/backend/ajax/listTalleGetByMarca",
	              dataType: "json",
	              data: "idMarca=" + idMarca,
	              success: function(response)
	              {
	                  var c = response.length;
	                  $("#producto_id_talle_set").find('option').remove().end();
	                  
	                  $("#producto_id_talle_set").append('<option value=""></option>');
	                  	                  
	                  for (i = 0 ; i < c ; i++)
	                  {
	                      $("#producto_id_talle_set").append('<option value="' + response[i].id + '">' + response[i].denominacion + '</option>');
	                  }
	              }
	            }
	        );
	    
	}
    
	this.addWidgetProductoItem = function()
	{
		$( "#producto_stock_addItem" ).click
		(
				function()
				{	
					$("body").append('<div id="temp"></div>');
					
					var newTr = '<tr>';

					newTr += '<td class="center editCol"></td>';
					
					newTr += '<td class="editCol codigo">';
					$("#temp").append ( thisClass.inputCodigo );
					newTr += $("#temp").html();
					newTr += '</td>';

					$("#temp").html('');

					newTr += '<td class="editCol">';
					$("#temp").append ( thisClass.selectTalle );
					newTr += $("#temp").html();
					newTr += '</td>';
						
					$("#temp").html('');
				
					newTr += '<td class="editCol">';
					$("#temp").append ( thisClass.selectColor );
					newTr += $("#temp").html();
					newTr += '</td>';
						
					$("#temp").html('');
					
					newTr += '<td class="center">0</td>';
					newTr += '<td class="center darkGrey">0</td>';
					newTr += '<td class="center darkGrey">0</td>';
					newTr += '<td class="center darkGrey">0</td>';
					newTr += '<td class="center">0</td>';
					newTr += '<td class="center">0</td>';
					newTr += '<td class="center">0</td>';
					newTr += '<td class="center">0</td>';
					newTr += '<td class="center">0</td>';
					
					$("#temp").html('');

                    newTr += '<td class="editCol">';
                    $("#temp").append ( thisClass.selectAccion );
                    newTr += $("#temp").html();
                    newTr += '</td>';
                    
                    $("#temp").html('');
                    
                    newTr += '<td class="editCol">';
                    $("#temp").append ( thisClass.selectOrigen );
                    newTr += $("#temp").html();
                    newTr += '</td>';
                    
                    $("#temp").html('');
							
					newTr += '<td class="editCol">';
					$("#temp").append ( thisClass.inputCantidad );
					newTr += $("#temp").html();
					newTr += '&nbsp;&nbsp;u.</td>';
					
					$("#temp").html('');
					                    
                    newTr += '<td class="editCol">';
                    $("#temp").append ( thisClass.selectStockTipo );
                    newTr += $("#temp").html();
                    newTr += '</td>';
					
					$("#temp").html('');
					
                    newTr += '<td class="editCol">';
                    $("#temp").append ( thisClass.textAreaObservacion );
                    newTr += $("#temp").html();
                    newTr += '</td>';
                    
                    $("#temp").html('');
					
					newTr += '<td class="remove editCol"><a></a></td>';
					newTr += '<td class="edit editCol"></td>';
					
					newTr += '</tr>';
						
					$("#temp").remove();
					
					
					$("select", newTr).each( function(i,e){ e.selectedIndex = 0 } );
					$("input", newTr).each( function(i,e){ e.value = '' } );
					$("#producto_stock_table").append( newTr );
					thisClass.removeWidgetProductoItem();					
				}
		);
		

	}
	
	this.removeWidgetProductoItem = function()
	{
		$( "#producto_stock_table tr td.remove a" ).click
		(
				function(e)
				{
					$(e.currentTarget).parent().parent().remove();
				}
		);
	}
	
	this.verWidgetProductoItem = function()
	{
		$( "#producto_stock_table tr td.ver a" ).click
		(
				function(e)
				{
					var idProductoItem = $(e.currentTarget).parent().parent().attr("rel")
					thisClass.showInfo(idProductoItem);
				}
		);
	}
	
	this.showInfo = function(idProductoItem)
	{
		var talle = $('[rel=' + idProductoItem + ']').find('#producto_stock_talle option:selected').html();
		var color = $('[rel=' + idProductoItem + ']').find('#producto_stock_color option:selected').html();
		
		if ( !talle || !color  )
		{
			var talle = $('[rel=' + idProductoItem + ']').find('[name="producto[stock][talle][]"]').attr("rel");
			var color = $('[rel=' + idProductoItem + ']').find('[name="producto[stock][color][]"]').attr("rel");
		}
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/productos/productoItemHistory",
			  dataType: "html",
			  data: "idProductoItem=" + idProductoItem,
			  success: function(html)
			  {
				  	$( "#producto_stock_info" ).html( html );				  
				  
					$( "#producto_stock_info" ).dialog({
						autoOpen: true,
			            show: {effect: "drop", duration: 250},
			            hide: {effect: "drop", duration: 250},
			            width: 880,
			            height: 400,
			            title: 'Informacion histórica del item :: Talle = ' + talle + ' / Color ' + color,
			            zIndex: 200
					});
					
			  }
			}
		);
	}
		
	this.widgetTag = function()
	{
				
             	function split( val )
             	{
             		return val.split( /,\s*/ );
             	}
             	
             	function extractLast( term )
             	{
             		return split( term ).pop();
             	}

             	$( "#producto_tags" )
             		// 
             		.bind( "keydown", function( event )
             		{
             			if ( event.keyCode === $.ui.keyCode.TAB &&
             					$( this ).data( "autocomplete" ).menu.active ) {
             				event.preventDefault();
             			}
             		})
             		.autocomplete({
             			minLength: 0,
             			source: function( request, response )
             			{
        					$.getJSON( "/backend/ajax/getAllTags", { term: extractLast( request.term ) }, response );
        				},
             			focus: function()
             			{
             				// prevent value inserted on focus
             				return false;
             			},
             			select: function( event, ui ) {
             				var terms = split( this.value );
             				// remove the current input
             				terms.pop();
             				// add the selected item
             				terms.push( ui.item.value );
             				// add placeholder to get the comma-and-space at the end
             				terms.push( "" );
             				this.value = terms.join( ", " );
             				return false;
             			}
             		});

	};
	
	

	
	this.doImagen = function(accion, idProducto, idImagenProducto)
	{
		
		$.ajax
		(
			{
			  type: "GET",
			  dataType: "html",
			  url: '/backend/productos/' + idProducto +  '/' + accion,
			  data: 'id_producto_imagen=' + idImagenProducto,
			  success: function(response)
			  {
				  $(".administrar_imagenes").html(response);
			  }
			}
		);
		
	}
	
	   
    this.initEshopWidget = function(){
        
        var idEshop = $("#producto_id_eshop").val();
        var eshopContainer = $("#producto_id_eshop").parent();
            
        $("#producto_id_eshop").remove();
        eshopContainer.append('<select id="producto_id_eshop" name="producto[id_eshop]"></select>');
    
        this.changeMarca(idEshop);
    };

    this.changeEsOutlet = function( ){
        if ( $("[id=producto_es_outlet]").attr('checked') ) {
            $(".esOutlet").show();
        } else {
            $(".esOutlet").hide();
        }
    };
    
    this.changeMarca = function( idEshop ){
        var idMarca = $("#producto_id_marca").val();
        
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/getEshopByIdMarca",
              dataType: "json",
              data: "idMarca=" + idMarca,
              success: function(eShop)
              {                                 
                  $("#producto_id_eshop").find('option').remove().end().val('');
                  $("#producto_id_eshop").append('<option value="">Deluxe Buys</option>');
                  
                  if ( eShop ) {
                      $("#producto_id_eshop").append($('<option value="' + eShop.value + '">').text( eShop.name));    
                  }
                  
                  if ( idEshop ) {
                      $("#producto_id_eshop").val(idEshop);
                  }
              }
            }
        );
    };
    
    this.changeTalle = function( select ){
        
        var idProductoItem = $( select ).parents('tr').first().attr('rel');
        var idProductoTalle = $( select ).val();
        
        if ( !idProductoItem ) return;
        if ( this.checkCombination(select) ) return;
        
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/updateProductoItem",
              dataType: "json",
              data: "idProductoItem=" + idProductoItem + "&idProductoTalle=" + idProductoTalle,
              success: function(response) {}
            }
        );
    };
    
    this.changeColor = function( select ){
        
        var idProductoItem = $( select ).parents('tr').first().attr('rel');
        var idProductoColor = $( select ).val();
        
        if ( !idProductoItem ) return;
        if ( this.checkCombination(select) ) return;
        
        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/updateProductoItem",
              dataType: "json",
              data: "idProductoItem=" + idProductoItem + "&idProductoColor=" + idProductoColor,
              success: function(response) {}
            }
        );
    };
    
    this.deleteItem = function( el ){
        
        var idProductoItem = $( el ).parents('tr').first().attr('rel');
        console.log(idProductoItem);

        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/deleteProductoItem",
              dataType: "json",
              data: "idProductoItem=" + idProductoItem,
              success: function(response) {}
            }
        );
    };
    
    this.checkCombination = function( select ){
        
        var tr = $( select ).parents('tr').first();
        
        var idProductoTalle = $( tr  ).find('#producto_stock_talle').val();
        var idProductoColor = $( tr  ).find('#producto_stock_color').val();
        
        var existen = 0; 
        $("#producto_stock_table tbody tr").each( function(i,e){
            
            var rowTr = $(e);
            var rowIdProductoTalle = $( rowTr ).find('#producto_stock_talle').val();
            var rowIdProductoColor = $( rowTr ).find('#producto_stock_color').val();
            
            if ( idProductoTalle == rowIdProductoTalle && rowIdProductoColor== idProductoColor) {
                existen++;
            }
            
        } );
        
        $('.sf_admin_form_field_stock .error_list').remove();
        
        if ( existen > 1 ) {
            $('.sf_admin_form_field_stock').prepend('<ul class="error_list"><li>Hay 2 o mas items para el mismo talle y color</li></ul>');            
            return true;
        }
        
        return false;
    };
    
	
	this.init();   
}

var formProducto;
$(document).ready( function() { formProducto = new formProducto(); } );