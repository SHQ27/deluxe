var carritoRapido = function()
{
    var thisClass = this;

    this.init = function()
    {               
        $(document).on('click', ".delete[id*=carritoRapidoProductoItem_]", function(e){ thisClass.removeProducto(this); } );
    };      

        
    this.removeProducto = function(elem)
    {
        $(elem).parents(".item").remove();
        
        var idCarritoProductoItem = $(elem).attr("id").replace('carritoRapidoProductoItem_','');

        $("#carritoRapidoProductoItem_" + idCarritoProductoItem).parents(".item").remove();
        
        $.ajax
        (
            {
              type: "POST",
              url: "/carrito/removeProducto",
              dataType: "json",
              data: "idCarritoProductoItem=" + idCarritoProductoItem,
              success: function(){}
            }
        );


        thisClass.updateTotal();
        
    };
    
    this.updateTotal = function()
    {
        var total = 0;
        $("#header #onlineBag .item .price").each( function(i, elem) {
            total += parseFloat( $(elem).html().replace('$','').replace('.','').replace(',','.') );
        } );

        total = new String(total.toFixed(2)).replace(".", ",");
        $("#header #onlineBag .totalPrice").html( '$' + total );
        
        // En el carrito para mobile no realiza este calculo
        if ( !isMobile ) {
            var cantidad = 0;
            $("#header #onlineBag .cantidad").each( function(i, elem) {
                cantidad += parseInt( $(elem).html() );
                console.log(cantidad);
            } );
            console.log(cantidad);
            $(".carritoRapidoTotalPrendas").html( cantidad );
        }
    };
    
    this.init();   
};

$(document).ready( function() { new carritoRapido(); } );