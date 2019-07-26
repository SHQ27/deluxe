var aws = function()
{   
	var thisClass = this;

	this.init = function()
	{		
	      google.load('visualization', '1', {'callback': function() { return false; },'packages':['corechart']});

	      google.setOnLoadCallback(drawChart);

	      function drawChart() {
              var data = google.visualization.arrayToDataTable(instancesChartsData);
              
              var options = {
                    title: 'Uso del Procesador (%)',
                    vAxis: {minValue: 0, maxValue: 100},
                    width:800,
                    height:300,
                    fontSize: '11px',
                    chartArea:{left:40,width:"70%"}
              };

              var chart = new google.visualization.LineChart(document.getElementById('instances_div'));
              chart.draw(data, options);
              
              
              var data = google.visualization.arrayToDataTable(dbChartData);
              
              var options = {
                      title: 'Uso del Procesador (%)',
                      vAxis: {minValue: 0, maxValue: 100},
                      width:800,
                      height:300,
                      fontSize: '11px',
                      chartArea:{left:40,width:"70%"}
                          
              };

              var chart = new google.visualization.LineChart(document.getElementById('db_div'));
              chart.draw(data, options);
              
	      }

	      setTimeout(function(){
	          window.location.reload(1);
	       }, 60000);

	      
	}
	
	this.init();   
}

$(document).ready( function() { new aws(); } );