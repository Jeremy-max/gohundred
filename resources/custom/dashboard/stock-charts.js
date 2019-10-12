"use strict";

// Class definition
var KTamChartsStockChartsDemo = function() {

    AmCharts.themes.light.AmStockChart.colors = [
        "#646c9a",
        "#5867dd",
        "#5578eb",
        "#ffb822",
        "#fd397a",
        "#0abb87",
        "#448e4d",
        "#b7b83f",
        "#b9783f",
        "#b93e3d",
        "#913167"
    ]

    // Private functions
    var demo1 = function() {
        var chartData1 = [];
        var chartData2 = [];
        var chartData3 = [];
        var chartData4 = [];
        var chartData5 = [];

        generateChartData();

        function generateChartData() {
            var firstDate = new Date();
            firstDate.setDate(firstDate.getDate() - 500);
            firstDate.setHours(0, 0, 0, 0);

            for (var i = 0; i < 500; i++) {
                var newDate = new Date(firstDate);
                newDate.setDate(newDate.getDate() + i);

                var a1 = Math.round(Math.random() * (40 + i)) + 100 + i;
                var b1 = Math.round(Math.random() * (1000 + i)) + 500 + i * 2;

                var a2 = Math.round(Math.random() * (100 + i)) + 200 + i;
                var b2 = Math.round(Math.random() * (1000 + i)) + 600 + i * 2;

                var a3 = Math.round(Math.random() * (100 + i)) + 200;
                var b3 = Math.round(Math.random() * (1000 + i)) + 600 + i * 2;

                var a4 = Math.round(Math.random() * (100 + i)) + 200 + i;
                var b4 = Math.round(Math.random() * (100 + i)) + 600 + i;

                var a5 = Math.round(Math.random() * (100 + i)) + 200 + i;
                var b5 = Math.round(Math.random() * (100 + i)) + 600 + i;                

                chartData1.push({
                    "date": newDate,
                    "value": a1,
                    "volume": b1
                });
                chartData2.push({
                    "date": newDate,
                    "value": a2,
                    "volume": b2
                });
                chartData3.push({
                    "date": newDate,
                    "value": a3,
                    "volume": b3
                });
                chartData4.push({
                    "date": newDate,
                    "value": a4,
                    "volume": b4
                });
                chartData5.push({
                    "date": newDate,
                    "value": a5,
                    "volume": b5
                });
            }
        }

        var chart = AmCharts.makeChart("kt_amcharts_1", {
            "rtl": KTUtil.isRTL(),
            "type": "stock",
            "theme": "light",
            "graphs": [{
                "type": "column",
                "fillColors": 'red',
                "lineColor": 'red'
            }, {
                "type": "column",
                "fillColors": 'blue',
                "lineColor": 'blue'
            }, {
                "type": "column",
                "fillColors": 'red',
                "lineColor": 'red'
            }, {
                "type": "column",
                "fillColors": 'blue',
                "lineColor": 'blue'
            }, {
                "type": "column",
                "fillColors": 'red',
                "lineColor": 'red'
            }],
            "dataSets": [{
                "title": "All",
                "fieldMappings": [{
                    "fromField": "value",
                    "toField": "value"
                }, {
                    "fromField": "volume",
                    "toField": "volume"
                }],
                "dataProvider": chartData1,
                "categoryField": "date"
            }, {
                "title": "Facebook",
                "fieldMappings": [{
                    "fromField": "value",
                    "toField": "value"
                }, {
                    "fromField": "volume",
                    "toField": "volume"
                }],
                "dataProvider": chartData2,
                "categoryField": "date"
            }, {
                "title": "Twitter",
                "fieldMappings": [{
                    "fromField": "value",
                    "toField": "value"
                }, {
                    "fromField": "volume",
                    "toField": "volume"
                }],
                "dataProvider": chartData2,
                "categoryField": "date"
            },{
                "title": "Reddit",
                "fieldMappings": [{
                    "fromField": "value",
                    "toField": "value"
                }, {
                    "fromField": "volume",
                    "toField": "volume"
                }],
                "dataProvider": chartData3,
                "categoryField": "date"
            }, {
                "title": "Youtube",
                "fieldMappings": [{
                    "fromField": "value",
                    "toField": "value"
                }, {
                    "fromField": "volume",
                    "toField": "volume"
                }],
                "dataProvider": chartData4,
                "categoryField": "date"
            }, {
                "title": "Web",
                "fieldMappings": [{
                    "fromField": "value",
                    "toField": "value"
                }, {
                    "fromField": "volume",
                    "toField": "volume"
                }],
                "dataProvider": chartData3,
                "categoryField": "date"
            }],

            "panels": [{
                "showCategoryAxis": false,
                "title": "Value",
                "percentHeight": 70,
                "stockGraphs": [{
                    "id": "g1",
                    "valueField": "value",
                    "comparable": true,
                    "compareField": "value",
                    "balloonText": "[[title]]:<b>[[value]]</b>",
                    "compareGraphBalloonText": "[[title]]:<b>[[value]]</b>"
                }],
                "stockLegend": {
                    "periodValueTextComparing": "[[percents.value.close]]%",
                    "periodValueTextRegular": "[[value.close]]"
                }
            }, {
                "title": "Volume",
                "percentHeight": 30,
                "stockGraphs": [{
                    "valueField": "volume",
                    "type": "column",
                    "showBalloon": false,
                    "fillAlphas": 1
                }],
                "stockLegend": {
                    "periodValueTextRegular": "[[value.close]]"
                }
            }],

            "chartScrollbarSettings": {
                "graph": "g1"
            },

            "chartCursorSettings": {
                "valueBalloonsEnabled": true,
                "fullWidth": true,
                "cursorAlpha": 0.1,
                "valueLineBalloonEnabled": true,
                "valueLineEnabled": true,
                "valueLineAlpha": 0.5
            },

            "periodSelector": {
                "position": "left",
                "periods": [{
                    "period": "MM",
                    "selected": true,
                    "count": 1,
                    "label": "1 month"
                }, {
                    "period": "YYYY",
                    "count": 1,
                    "label": "1 year"
                }, {
                    "period": "YTD",
                    "label": "YTD"
                }, {
                    "period": "MAX",
                    "label": "MAX"
                }]
            },

            "dataSetSelector": {
                "position": "left"
            },

            "export": {
                "enabled": false
            }
        });
    }
    
    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();

jQuery(document).ready(function() {
    KTamChartsStockChartsDemo.init();
});