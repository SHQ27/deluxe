var prepararEnvio = function()
{
	var self = this;

	this.init = function()
	{		

    if ( mostrarPreFiltro ) {

      $("form").hide();

      $(".filtrado .unicaMarca").click( function(){
        $(".filtrado").hide();
        self.showHidePedidos('unicaMarca');
        $("form").show();
      } );

      $(".filtrado .distintasMarca").click( function(){
        $(".filtrado").hide();
        self.showHidePedidos('distintasMarca');
        $("form").show();
      } );

      $(".filtrado .todos").click( function(){
        $(".filtrado").hide();
        $("form").show();
      } );

      $(".prepararEnvio .reload").live('click', function(){
        location.reload();
      } );

    } else {
      $(".filtrado").hide();
    }

		$('#prepararEnvio_selectAll').change( function(){
			$('[name*="prepararEnvio[id_pedido]"]').attr('checked', $('#prepararEnvio_selectAll').attr('checked'));
		} );
	};


  this.showHidePedidos = function(tipo)
  {   
    $(".prepararEnvio table tbody tr").each( function(i, e){
        var marca = $(e).find('.marcas').html();

        if ( tipo == 'unicaMarca' ) {
          if ( marca.indexOf(',') != -1 || marca.indexOf(marcaIngresoMercaderia) == -1  ) { $(e).remove(); }
        } else {
          if ( marca.indexOf(',') == -1 || marca.indexOf(marcaIngresoMercaderia) == -1  ) { $(e).remove(); }
        }

        var disponibles = $(".prepararEnvio table tbody tr").length;

        if ( disponibles == 0 ) {
          $(".prepararEnvio table tbody").append('<tr><td colspan="13" class="center">No hay envios disponibles para la opcion elegida.<br /><br /><a class="reload">Si desea volver a elegir opcion haga click aqui</a></td></tr>');
          $(".prepararEnvio .button").hide();
        }

    });
  };
  
	
	this.init();   
}

$(document).ready( function() { new prepararEnvio(); } );