var logistica = function()
{
    var thisClass = this;
    
    this.init = function()
    {
        $("ul .faltantes a").click( function(ev){
            ev.preventDefault();
            var rel = $(this).attr('rel');
            var data = rel.split('-');
            var idMarca = data[1]; 
            var idCampana = data[0];
            
            $('<form>', {
                "id": "temp",
                "html": '<input type="hidden" name="faltante_filters[marca]" value="' + idMarca + '"><input type="hidden" name="faltante_filters[campana]" value="' + idCampana + '">',
                "action": '/backend/faltantes/filter/action',
                "method": 'post'
            }).appendTo(document.body).submit();
        } )
    };
    
    this.init();
}

$(document).ready( function() { new logistica(); } );