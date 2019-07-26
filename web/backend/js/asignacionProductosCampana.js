var asignacionProductosCampana = function()
{
    var self = this;
    
    this.init = function()
    {
        $(".filtrar").click( function(){ self.updateResults() } );

        $(".restablecer").click( function(){
            
            $("#marca").val('');
            
            var tableData = $('.results tbody');
            tableData.find('tr').remove();
            tableData.append( $('<tr><td colspan="14" style="text-align: center;">Debe aplicar filtros para mostrar los productos</td></tr>') );
        } )

        $(".all").click( function(){
            var checked = $(this).attr('checked');
            var inputs = $(this).parents('table').first().find('tbody input');
            inputs.each( function(i,e){
                $(e).attr('checked', checked);
            });
        });

        $(".asignar").click( function(){ self.asignar() } );
        $(".desasignar").click( function(){ self.desasignar() } );
    };


    this.updateResults = function()
    {
        var idMarca = $("#marca").val();

        if ( !idMarca ) return;

        $.ajax
        (
            {
              type: "POST",
              url: "/backend/ajax/getProductosByFilters",
              dataType: "json",
              data: "idMarca=" + idMarca,
              success: function(productos)
              {
                    var tableData = $('.results tbody');
                    tableData.html('');
                                        
                    if (productos.length)
                    {
                        for(i in productos)
                        {
                            var producto = productos[i];
                                                                
                            var esOferta = ( producto.es_oferta == 1 ) ? 'oferta' : 'stockPermanente';
                            var tr = $('<tr class="' + esOferta + '"></tr>');

                            tr.append('<td><input type="checkbox" value="' + producto.idProducto + '"></td>');
                            tr.append('<td>' + producto.denominacion + '</td>');
                            tr.append('<td>' + producto.marca + '</td>');
                            tr.append('<td>' + producto.categoria + '</td>');

                            var warningClass = ( producto.diversidad != 'Stock Permanente' && producto.diversidad != denominacionCampana ) ? 'class="warning"' : '';

                            tr.append('<td ' + warningClass + '>' + producto.diversidad + '</td>');
                            tr.append('<td>' + producto.activo + '</td>');
                            tr.append('<td>' + producto.stockPermanente + '</td>');
                            tr.append('<td>' + producto.stockCampana + '</td>');
                            tr.append('<td>' + producto.stockOutlet + '</td>');
                            
                            if ( producto.sticker )
                            {
                                tr.append('<td><div class="relative">' + producto.sticker + '</div>' + producto.imagen + '</td>');
                            }
                            else
                            {
                                tr.append('<td>' + producto.imagen + '</td>');
                            }
                            
                            tr.append('<td>' + producto.precio_lista + '</td>');
                            tr.append('<td class="precioDeluxe">' + producto.precio_deluxe + '</td>');
                            tr.append('<td>' + producto.costo + '</td>');
                            
                            tableData.append(tr);
                        }
                    }
                    else
                    {
                      tableData.append( $('<tr><td colspan="14" style="text-align: center;">No hay productos para los filtros aplicados</td></tr>') );  
                    }
              }
            }
        );
    }

    
    this.asignar = function()
    {
        var idsProductos = [];
        $(".results tbody input:checked").each( function(i, e){

            var idProducto = $(e).val();
            var existe = $('.selectedItems input[value=' + idProducto + ']').parents('tr').first().length;
            if (!existe) idsProductos.push( idProducto );
        } );

        if ( !idsProductos ) { return; }

        $(".loader").show();

        $.ajax
        (
            {
              type: "POST",
              url: "/backend/campanas/agregarProductos",
              dataType: "text",
              data: "idCampana=" + idCampana + "&idsProductos=" + idsProductos.join(','),
              success: function(response) { 

                for (i in idsProductos) {
                    self.addItem( idsProductos[i] );
                }

                $(".loader").hide();
              }
            }
        );

    };

    this.desasignar = function()
    {

        var idsProductos = [];
        $(".selectedItems tbody input:checked").each( function(i, e){
            var idProducto = $(e).val();
            idsProductos.push( idProducto );
        } );

        if ( !idsProductos ) { return; }


        $(".loader").show();

        var desactivarProductos = $(".inputDesactivarProductos").attr('checked');

        $.ajax
        (
            {
              type: "POST",
              url: "/backend/campanas/eliminarProductos",
              dataType: "text",
              data: "idCampana=" + idCampana + "&idsProductos=" + idsProductos.join(',') + "&desactivarProductos=" + desactivarProductos,
              success: function(response) { 

                for (i in idsProductos) {
                    self.removeItem( idsProductos[i] );
                }

                $(".loader").hide();
              }
            }
        );

    };

    this.addItem = function(idProducto)
    {                
        $('.selectedItems tr[rel=0]').remove();
        var tr = $('.results input[value=' + idProducto + ']').parents('tr').first().clone();
        
        $('.selectedItems table tbody').append( tr );
    }
    
    this.removeItem = function(idProducto)
    {
        var tr = $('.selectedItems input[value=' + idProducto + ']').parents('tr').first();
        tr.remove();
        
        var cantidadRows = $('.selectedItems tr').length;
                
        if (cantidadRows <= 1)
        {
            $('.selectedItems table tbody').append( '<tr rel="0"><td colspan="14">No hay productos asignados</td></tr>' );
        }
    }

    this.init();
    
}

$(document).ready( function() { new asignacionProductosCampana(); } );