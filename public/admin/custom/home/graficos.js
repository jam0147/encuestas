$(function () {
    myUrl = $("#myurl").val();
    //console.log("url de ajax " + myUrl );
    //myUrl = "http://localhost:8000/admin/home/estadsticas";
    $.get(myUrl, function (data) {
        console.log("metodo estadisticas en IndexController" + JSON.stringify(data ));
        console.log("metodo estadisticas en IndexController" + data );

        // Create the chart
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: "Cantidad de encuestas poor categoria"
            },
            subtitle: {
                text: '*-*'
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y}'
                        /* format: '{point.y:.1f}%' */
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
            },

            "series": [
                {
                    "name": "Browsers",
                    "colorByPoint": true,
                    "data": [
                        {
                            "name": data.total_encuestas_por_categoria[1].name,
                            "y": data.total_encuestas_por_categoria[1].tot_enc,
                            "drilldown": null
                        },
                        {
                            "name": data.total_encuestas_por_categoria[0].name,
                            "y": data.total_encuestas_por_categoria[0].tot_enc,
                            "drilldown": null
                        },
                        {
                            "name": "Total encuestas",
                            "y": data.total,
                            "drilldown": null
                        }
                    ]
                }
            ]
        });

        
        $("body")
            .append("Name: " + data.name) // John
            .append("Time: " + data.time); //  2pm
    }, "json");
    
});
    