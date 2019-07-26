var pmWidgetTalleSetAssign = function(formName, identifier)
{
	var thisClass = this;
	this.formName = formName;
	
	this.init = function()
	{
	    $(".pmWidgetTalleSetAssign .addTalle a.add").click( function(e){ thisClass.addTalle(e) } );
	    $(".pmWidgetTalleSetAssign .addZona a.add").click( function(e){ thisClass.addZonas(e) } );
	    $(".pmWidgetTalleSetAssign table a.remove").live( 'click', function(e){ thisClass.removeRow(e, $(this)) } );
	    $(".pmWidgetTalleSetAssign table .zonas a.deleteZone").live( 'click', function(e){ thisClass.removeZona(e, $(this)) } );
	    
	    $(".pmWidgetTalleSetAssign table a.remove").live( 'click', function(e){ thisClass.removeRow(e, $(this)) } );
	    
	    $(".pmWidgetTalleSetAssign .addZona a.finish").click(
	            function(e){
	                $(".pmWidgetTalleSetAssign .addZona").hide();
	                $(".pmWidgetTalleSetAssign .addTalle").show();
	            }
	    );
	    
	    this.rowSortables();
	    
	}
	
    this.addZonas = function(e, elem)
    {
        e.preventDefault();
        
        var valueZona = $("#" + identifier + "_zona option").filter(":selected").val();
        var denominacionZona = $("#" + identifier + "_zona option").filter(":selected").html();
        
        this.initTable();
                
        if ( !$(".pmWidgetTalleSetAssign table .zona[rel=" + valueZona + "]").length )
        {            
            $(".pmWidgetTalleSetAssign table .zonas").append('<th class="zona" colspan="2" rel="' + valueZona + '">' + denominacionZona + ' <a class="deleteZone" rel="' + valueZona + '">(X)</a> </th>');
            $(".pmWidgetTalleSetAssign table .zonas .acciones").remove();
            $(".pmWidgetTalleSetAssign table .zonas").append('<th class="acciones"></th>');
            $(".pmWidgetTalleSetAssign table .rangos").append('<th rel="zona-' + valueZona + '">Desde</th>');
            $(".pmWidgetTalleSetAssign table .rangos").append('<th rel="zona-' + valueZona + '">Hasta</th>');
            
            var colspan = $(".pmWidgetTalleSetAssign table .titleZonas").attr('colspan');
            $(".pmWidgetTalleSetAssign table .titleZonas").attr('colspan',  colspan + 2);
        }               
    }
    
    this.removeZona = function(e, elem)
    {
    	e.preventDefault();
    	
    	idZona = elem.attr('rel');
    	$(".pmWidgetTalleSetAssign table").find("[rel='zona-" + idZona + "']").remove();
    	elem.parent().remove();

    	totalZonasMostradas = $(".pmWidgetTalleSetAssign table .zonas th.zona").length;

    	if (totalZonasMostradas == 0)
		{
    		$(".pmWidgetTalleSetAssign .addTalle").hide();
    		$(".pmWidgetTalleSetAssign .addZona").show();
            $(".pmWidgetTalleSetAssign table").html('<thead></thead>');
		}
    	
    }
    
    this.addTalle = function(e, elem)
    {
        e.preventDefault();
        
        var valueTalle = $("#" + identifier + "_talle option").filter(":selected").val();
        var denominacionTalle = $("#" + identifier + "_talle option").filter(":selected").html();
        
        this.initTable();
                                
        var tr = $('<tr></tr>');
        
        tr.append('<td class="acciones">Drag Me</td>');
        tr.append('<td class="talle" rel="' + valueTalle + '">' + denominacionTalle + '</td>');
        
        var c = $(".pmWidgetTalleSetAssign table .zona").length;
        for (i = 0 ; i < c ; i++)
        {
            var idZona = $(".pmWidgetTalleSetAssign table .zona").eq( i).attr('rel');
            tr.append('<td rel="zona-' + idZona + '"><input name="' + formName + '[asignacion][' + idZona + '][' + valueTalle + '][desde]" type="text"/></td>');
            tr.append('<td rel="zona-' + idZona + '"><input name="' + formName + '[asignacion][' + idZona + '][' + valueTalle + '][hasta]" type="text"/></td>');
        }
        
        $(".pmWidgetTalleSetAssign table .rangos .acciones")
        
        tr.append('<td class="acciones"><a class="remove">(X)</a></td>');
        $(".pmWidgetTalleSetAssign table").append(tr);
     
        this.rowSortables();
    }
    
    
    this.initTable = function()
    {        
        var table = $(".pmWidgetTalleSetAssign table");
        
        if (table.html() == '<thead></thead>')
        {
            var html = '';
            html += '  <tr>';
            html += '    <th rowspan="4"></th>';
            html += '    <th rowspan="4">Talle</th>';
            html += '    <th class="titleZonas" colspan="0" >Zonas</th>';
            html += '    <th class="acciones"></th>';
            html += '  </tr>';
            html += '  <tr class="zonas"></tr>';
            html += '  <tr class="rangos"></tr>';
            
            table.html(html);
        }
    }
    
    this.removeRow = function(e, elem)
    {
        elem.parents('tr').first().remove();
    }
    
    this.rowSortables = function()
    {
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
        
        $( ".pmWidgetTalleSetAssign table tbody").sortable ( { helper: fixHelper, placeholder: "sortable-placeholder" } );
    }
    	
	this.init();   
}
