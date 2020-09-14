
      
                    <script>
        window.onload = function() {
         
        var updateInterval = <?php echo $updateInterval ?>;
        var dataPoints1 = <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>;
        var dataPoints2 = <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>;
        var yValue1 = <?php echo $y1 ?>;
        var yValue2 = <?php echo $y2 ?>;
        var xValue = <?php echo $x ?>;
         
        var chart = new CanvasJS.Chart("chartContainer", {
          zoomEnabled: true,
          title: {
            text: "Beta Readings From The Brain"
          },
          axisX: {
            title: "chart updates every " + updateInterval / 1000 + " secs"
          },
          axisY:{
            suffix: " Betas",
            includeZero: false
          }, 
          toolTip: {
            shared: true
          },
          legend: {
        cursor:"pointer",
        verticalAlign: "top",
        fontSize: 22,
        fontColor: "dimGrey",
        itemclick : toggleDataSeries
    },
    data: [{ 
            type: "line",
            name: "line A <40000",
            xValueType: "dateTime",
            yValueFormatString: "#,### Beta",
            xValueFormatString: "hh:mm:ss TT",
            showInLegend: true,
            legendText: "{name} " + yValue1 + " Beta",
            dataPoints: dataPoints1
        },
        {               
            type: "line",
            name: "Line B >4" ,
            xValueType: "dateTime",
            yValueFormatString: "#,### Beta",
            showInLegend: true,
            legendText: "{name} " + yValue2 + " Beta",
            dataPoints: dataPoints2
    }]
});
 
chart.render();
setInterval(function(){updateChart()}, updateInterval);
 
function toggleDataSeries(e) {
    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
        e.dataSeries.visible = false;
    }
    else {
        e.dataSeries.visible = true;
    }
    chart.render();
}
 
function updateChart() {
    var deltaY1, deltaY2;
    xValue += updateInterval;
    // adding random value
   
 
    // pushing the new values
    dataPoints1.push({
        x: xValue,
        y: yValue1
    });
    dataPoints2.push({
        x: xValue,
        y: yValue2
    });
 
    // updating legend text with  updated with y Value 
    chart.options.data[0].legendText = "line A <40000 " + yValue1 + " Beta";
    chart.options.data[1].legendText = " line B>=40000 " + yValue2+ " Beta"; 
    chart.render();
}
 
}
        </script>
