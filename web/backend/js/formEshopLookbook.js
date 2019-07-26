var formEshopLookbook = function()
{
    var self = this;
    self.dataLookbook = {}; 
    
    this.init = function()
    {
      this.doDraggable();
      this.updateDataPointers();

      $("#eshop_lookbook_asignacion_results .add").live('click',function(ev, el){
        setTimeout(self.generateDataPointers, 500);
      });

      $("#eshop_lookbook_asignacion_selectedItems").delegate(".remove", 'click',function(ev){
        var el  = ev.currentTarget;
        var tr = $(el).parents('tr').first()
        var idProducto = tr.attr('rel');
        console.log(idProducto);
        $(".lookbookImage .pointer[rel=" + idProducto + "]").remove();
        setTimeout(self.updateDataPointers, 500);
      });

    };

    this.doDraggable = function()
    {
      $(".lookbookImage .pointer").draggable({
        containment: ".lookbookImage img",
        stop: function( event, ui ) { self.updateDataPointers() }
      });
    };

    this.generateDataPointers = function()
    {
      $("#eshop_lookbook_asignacion_selectedItems .remove").each( function(i,e) {
          var tr = $(e).parents('tr').first()
          var idProducto = tr.attr('rel');
          if (typeof self.dataLookbook[idProducto] == 'undefined') {
            var r = 1 + Math.floor(Math.random() * 250);
            var g = 1 + Math.floor(Math.random() * 250);
            var b = 1 + Math.floor(Math.random() * 250);
            $(".lookbookImage .image").append('<div rel="' + idProducto + '" style="top: 0px ;left: 0px; background-color: rgb(' + r + ',' + g + ',' + b + ');" class="pointer ui-draggable"></div>');
          }
      });

      self.doDraggable();
      self.updateDataPointers();
    }
 
    this.updateDataPointers = function()
    {
      $("#eshop_lookbook_asignacion_selectedItems tr .referencia").remove();

      var data = {};
      $(".lookbookImage .pointer").each( function(i,e) {
        var idProducto = $(e).attr('rel');
        var top = $(e).css('top');
        var left = $(e).css('left');
        var backgroundColor = $(e).css('background-color');

        var td = $("#eshop_lookbook_asignacion_selectedItems tr[rel="+ idProducto +"] td").first();
        td.append('<div class="referencia" style="background-color: ' + backgroundColor + '"></div>');

        var info = {
          top: top,
          left: left,
          backgroundColor: backgroundColor
        };

        data[idProducto] = info;
      });

      self.dataLookbook = data;

      var json = JSON.stringify( data );
      $("#eshop_lookbook_asignacion_data").val(json);
    };

    this.init();
}

var formEshopLookbook;
$(document).ready( function() { formEshopLookbook = new formEshopLookbook(); } );