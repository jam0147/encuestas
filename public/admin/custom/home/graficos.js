$(function () {
    myUrl = $("#myurl").val();
    //console.log("url de ajax " + myUrl );
    //myUrl = "http://localhost:8000/admin/home/estadsticas";
    $.get(myUrl, function (data) {
        console.log("metodo estadisticas en IndexController" + JSON.stringify(data ));
        console.log("metodo estadisticas en IndexController" + data );  

        data.total_encuestas_por_categoria.forEach(element => {
            console.log("Hola " + element.);
        });

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
                    text: 'Total encuestas'
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
                        /*{
                            "name": data.total_encuestas_por_categoria[0].name,
                            "y": data.total_encuestas_por_categoria[0].tot_enc,
                            "drilldown": null
                        },
                        */
                        {
                            "name": "Total encuestas",
                            "y": data.total,
                            "drilldown": null
                        }
                    ]
                }
            ]
        });
        // End of chart creation

        //bixplot
        Highcharts.chart('container-2', {
            plotOptions: {
                series: {
                    // general options for all series
                },
                boxplot: {
                    // shared options for all boxplot series
                }
            },
            series: [{
                // specific options for this series instance
                type: 'boxplot'
            }]
        });


        //n new chart
        // Create the chart
        Highcharts.chart('container-2', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Browser market share, January, 2018'
            },
            subtitle: {
                text: 'Source: <a href="http://statcounter.com" target="_blank">statcounter.com</a>'
            },
            yAxis: {
                title: {
                    text: 'Total percent market share'
                }
            },
            plotOptions: {
                pie: {
                    shadow: false,
                    center: ['50%', '50%']
                }
            },
            tooltip: {
                valueSuffix: '%'
            },
            series: [{
                name: 'Browsers',
                data: browserData,
                size: '60%',
                dataLabels: {
                    formatter: function () {
                        return this.y > 5 ? this.point.name : null;
                    },
                    color: '#ffffff',
                    distance: -30
                }
            }, {
                name: 'Versions',
                data: versionsData,
                size: '80%',
                innerSize: '60%',
                dataLabels: {
                    formatter: function () {
                        // display only if larger than 1
                        return this.y > 1 ? '<b>' + this.point.name + ':</b> ' +
                            this.y + '%' : null;
                    }
                },
                id: 'versions'
            }],
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 400
                    },
                    chartOptions: {
                        series: [{
                            id: 'versions',
                            dataLabels: {
                                enabled: false
                            }
                        }]
                    }
                }]
            }
        });




        /////////////////////////////////////////////

        
        $("body")
            .append("Name: " + data.name) // John
            .append("Time: " + data.time); //  2pm
    }, "json");
    
});
    