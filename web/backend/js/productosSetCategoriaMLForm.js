var productosSetCategoriaMLForm = function()
{
	var thisClass = this;
	
    this.init = function()
    {
       this.initTree();
              
       $("select[rel=83000]").live('change', function() { thisClass.autocompletarColorSecundario($(this)) });
       $("table select").live('change', function() { thisClass.autocompletarOtrosProductos($(this)) });
       
       $("select[rel=83000]").live('change', function() { 
           var td = $(this).parent();
           td.removeClass('OK'),
           td.removeClass('KO');
       });
       
       $("select[rel=73001]").live('change', function() {
           var td = $(this).parent();
           td.removeClass('OK'),
           td.removeClass('KO');
       });
       
       $(".setCategoriaML form").submit( function(ev) {
           thisClass.updateData();
       });
       
    };
    
    this.updateData = function(el)
    {
        $(".setCategoriaML tbody tr").each( function(i,e){
            
            var tr = $(e);
            
            var value = {};
            tr.find('select').each( function(i, el){
                value[ $(el).attr('rel') ] = $(el).val();
            });
                    
            tr.find("[name*='productosSetCategoriaML[data]']").val(JSON.stringify(value)); 
        });        
    };
    
    this.autocompletarColorSecundario = function(selectColorPrimario)
    {
        var autocompleteEnabled = $("#autocomplete_color_secundario:checked").length;
        
        if ( autocompleteEnabled )
        {
            var selectColorSecundario = selectColorPrimario.parents('tr').first().find("select[rel=73001]");
            var valueSelected = selectColorPrimario.find('option:selected').attr('rel');
            selectColorSecundario.val( selectColorSecundario.find("option[rel='" + valueSelected + "']").val() );
            
            selectColorSecundario.parent().removeClass('OK');
            selectColorSecundario.parent().removeClass('KO');            
        }
    };
    
    this.autocompletarOtrosProductos = function(select)
    {
        var autocompleteEnabled = $("#autocomplete_otros_productos:checked").length;
        
        if ( autocompleteEnabled )
        {
            var valueSelected = select.find('option:selected').attr('rel');
            
            if ( select.data().type == 'size' )
            {
                var talle = select.parents('tr').first().data().talle;                
                var selects = $("table tr[data-talle='" + talle + "'] select[rel='" + select.attr('rel') + "']");
            }
            else
            {
                var color = select.parents('tr').first().data().color;
                var selects = $("table tr[data-color='" + color + "'] select[rel='" + select.attr('rel') + "']");                
            }

            selects.val( selects.find("option[rel='" + valueSelected + "']").val() );
                        
            var c = selects.length;
            for( i = 0 ; i < c ; i++ ) {
                var rowSelect = $(selects[i]);
                
                if ( select.data().type != 'size' ) {
                    this.autocompletarColorSecundario(rowSelect);
                }
                rowSelect.parent().removeClass('OK').removeClass('KO');                
            }            
         
        }
    };
        
    this.initTree = function()
    {
        $('#categoriasTree').jstree
        (
            {
                "json_data" :
                    {
                        "ajax" :
                        {
                            "url" : "/backend/ajax/getCategoriasML",
                            "data" : function (n) { return { id : n.attr ? n.attr("id") : '1' }; }
                        }
                    },
                                                
                "plugins" : [ "themes", "json_data", "ui" ]
            }
       ).bind("click.jstree", function (event) {
           var node = $(event.target).closest("li");
           var codigo = $(node).attr('rel');
           var id = $(node).attr('id');
           
           $("#productosSetCategoriaML_categoria").val( "" );
           
           if ( $(node).hasClass('jstree-closed') )
           {
               $("#categoriasTree").jstree("open_node", "#" + id);
           }
           else if ( $(node).hasClass('jstree-open') )
           {
               $("#categoriasTree").jstree("close_node", "#" + id);
           }
           else
           {
               $.ajax
               (
                   {
                     type: "GET",
                     url: "https://api.mercadolibre.com/categories/" + codigo + "/attributes",
                     dataType: "json",
                     success: function(response)
                     {        
                         $(".categoria_ml").remove();
                         
                         for(i in response)
                         {
                             var responseData = response[i];
                             
                             if ( responseData.type == 'color' || responseData.type == 'size' )
                             {
                                 $(".setCategoriaML table thead tr").append('<th class="categoria_ml">' + responseData.name + '<br />(Mercado Libre)</th>');
                                 
                                 var select = '<select rel="' + responseData.id + '" data-type="' + responseData.type + '">';
                                 for(j in responseData.values)
                                 {         
                                     select += '<option value="' + responseData.values[j].id + '" rel="' + responseData.values[j].name + '">' + responseData.values[j].name + '</option>';                                     
                                 }
                                 select += '</select>';
                                 
                                 $(".setCategoriaML table tbody tr").each( function(i, e){
                                     $(e).append('<td class="categoria_ml">' + select + '</td>');
                                     
                                     var td = $(e).find('td').last();
                                     
                                     if ( responseData.type == 'color' )
                                     {
                                         var option = $(e).find("select[rel='" + responseData.id + "'] option[rel='" + $(e).data().color + "']");
                                         
                                         if ( option.length )
                                         {
                                             var selectElement = $(e).find("select[rel='" + responseData.id + "']");
                                             selectElement.val( option.val() );
                                             td.addClass("OK");
                                         }
                                         else
                                         {
                                             td.addClass("KO");
                                         }
                                     }
                                     
                                     if ( responseData.type == 'size' )
                                     {
                                         var option = $(e).find("select[rel='" + responseData.id + "'] option[rel='" + $(e).data().talle + "']");
                                         
                                         if ( option.length )
                                         {
                                             var selectElement = $(e).find("select[rel='" + responseData.id + "']"); 
                                             selectElement.val( option.val() );
                                             td.addClass("OK");
                                         }
                                         else
                                         {
                                             td.addClass("KO");
                                         }
                                     }
                                     
                                     
                                 } ); 
                                 
                             }
                         }                         
                         
                         if ( !$(".categoria_ml").length )
                         {
                             $(".setCategoriaML h4").hide();
                         }
                         else
                         {
                             $(".setCategoriaML h4").show();
                         }
                         
                     }
                   }
               );
               
               $("#productosSetCategoriaML_categoria").val( id );
           }           
        });
       ;       
        
    };
    
    		
		
	this.init();
}

$(document).ready( function() { new productosSetCategoriaMLForm(); } );