var reporteComerciales = function()
{   
	var thisClass = this;

	this.init = function()
	{		
	      google.load('visualization', '1', {'callback': function() { return false; },'packages':['corechart']});

	      google.setOnLoadCallback(drawChart);

	      function drawChart() {

	        // Dibujo el Chart Pie
            if ( typeof columnsData != 'undefined' )
            {
                // Create the data table.
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Topping');
                data.addColumn('number', 'Slices');
                data.addRows(pieData);
                
    	        var options = {'title':'Distribucion de venta por comercial', 'width':550, 'height':280, 'chartArea' : { 'width':350 }, 'legend' : { 'width':200 } };
    	        var chartPie = new google.visualization.PieChart(document.getElementById('chart_pie'));
    	        chartPie.draw(data, pieData);
            }
	        
            // Dibujo el Chart Bar
	        if ( typeof columnsData != 'undefined' )
	        {
    	        var data = google.visualization.arrayToDataTable(columnsData);
    
                var options = { title: 'Ventas por Comercial', 'width':550, 'height':280, 'chartArea' : { 'width':350 }, 'legend' : { 'width': 200 } };
    
                var chartBars = new google.visualization.ColumnChart(document.getElementById('chart_columns'));
                chartBars.draw(data, options);
	        }
	        
	        
	      }
	      
	      
	      $('.totalVentas').click( function() { $('.desglosePrecioDeluxe', $(this).parent()).toggle(); } )
	      $('.costo').click( function() { $('.desgloseCosto', $(this).parent()).toggle(); } )
	      $('.comision').click( function() { $('.desgloseComision', $(this).parent()).toggle(); } )

	}
	
	this.init();   
}

$(document).ready( function() { new reporteComerciales(); } );