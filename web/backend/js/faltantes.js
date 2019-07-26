var faltantes = function()
{
	var thisClass = this;
	
	this.init = function()
	{		
		thisClass.changeEshop();	    

		$("#faltantes_id_eshop").change( function(){
			thisClass.changeEshop();
		} );

		$("#faltantes_campana").change( function(){
			thisClass.makeSelectMarcas();
		} );

		$("#faltantes_id_marca").change( function(){
			thisClass.makeSelectProductos();
		} );					

		$("#faltantes_producto").change( function(){ 
			thisClass.makeSelectProductoItems();
		} );		


		$(".faltantes form").submit( function(ev){
			thisClass.executeForm(ev);
		} );

	};


	this.changeEshop = function()
	{
		var idEshop = $("#faltantes_id_eshop").val();

		if ( idEshop == '' ) {
			$(".row.marca").show();
			$(".row.campana").show();
		} else {
			$(".row.marca").hide();
			$(".row.campana").hide();
			$("#faltantes_campana").val('STKPER');
			thisClass.makeSelectProductos();
		}
	};

	this.makeSelectMarcas = function()
	{				
    var idCampana = $("#faltantes_campana").val();
    idCampana = (idCampana === 'STKPER' || idCampana === 'OUTLET' ) ? '' : idCampana;
	    

		$(".row.marca .procesando").css('display', 'inline');

		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/ajax/getMarcasByIdCampana",
			  dataType: "json",
			  data: "idCampana=" + idCampana,
			  success: function(marcas)
			  {

		      $("#faltantes_id_marca").find('option').remove();

		      var c = marcas.length;

		      if ( c > 1 ) {
		        $("#faltantes_id_marca").append('<option value="">Todas</option>');  
		      }                

		      for ( i = 0 ; i < c ; i ++ )
		      {
		          $("#faltantes_id_marca").append('<option value="' + marcas[i].id + '">' + marcas[i].nombre + '</option>');
		      }   

		      $(".row.marca .procesando").hide();
				    
			    thisClass.makeSelectProductos();
			  }
			}
		);
	};

	this.makeSelectProductos = function()
	{				
    var idEshop = $("#faltantes_id_eshop").val();
    var idCampana = $("#faltantes_campana").val();

    if ( idEshop == '' ) {
    	var idMarca = $("#faltantes_id_marca").val();	
    } else {
    	var idMarca = '';
    }
    
    $(".row.producto .procesando").css('display', 'inline');
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/faltantes/listProductos",
			  dataType: "json",
			  data: "idCampana=" + idCampana + "&idMarca=" + idMarca + "&idEshop=" + idEshop,
			  success: function(productos)
			  {
					$("#faltantes_producto").find('option').remove().end().val('');
					
				  	if (!productos) return;
				  	
				    for(i in productos)
				    {
				    	var producto = productos[i];
					    $("#faltantes_producto").append($('<option value="' + producto.idProducto + '">').text(producto.denominacion));
						}
				    
				    $(".row.producto .procesando").hide();
				    thisClass.makeSelectProductoItems();
			  }
			}
		);
	};
	
	this.makeSelectProductoItems = function()
	{				
		var idCampana = $("#faltantes_campana").val();
		var idEshop = $("#faltantes_id_eshop").val();
		var idProducto = $("#faltantes_producto").val();

		$(".row.productoItem .procesando").css('display', 'inline');
		
		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/faltantes/listProductoItems",
			  dataType: "json",
			  data: "idCampana=" + idCampana + "&idEshop=" + idEshop + "&idProducto=" + idProducto,
			  success: function(productoItems)
			  {
					$("#faltantes_productoItem").find('option').remove().end().val('');
					
			  	if (!productoItems) return;
			  	
			    for(i in productoItems)
			    {
			    	var productoItem = productoItems[i];
				    $("#faltantes_productoItem").append($('<option value="' + productoItem.idProductoItem + '">').text(productoItem.denominacion));
					}

					$(".row.productoItem .procesando").hide();

			  }
			}
		);
	};

	this.executeForm = function(ev)
	{
		ev.preventDefault();

		var idCampana = $("#faltantes_campana").val();
		var idEshop = $("#faltantes_id_eshop").val();
		var idProductoItem = $("#faltantes_productoItem").val();

		$.ajax
		(
			{
			  type: "POST",
			  url: "/backend/faltantes/generarResultado",
			  dataType: "html",
			  data: "idCampana=" + idCampana + "&idEshop=" + idEshop + "&idProductoItem=" + idProductoItem,
			  success: function(html)
			  {
					$(".resultado").html(html);
			  }
			}
		);
	}
	
	
	this.init();   
};

$(document).ready( function() { new faltantes(); } );