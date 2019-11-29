"use strict";

// Class definition
var KTamChartsStockChartsDemo = function() {

    AmCharts.themes.light.AmStockChart.colors = [
        "#007bff",
        "#00aced",
        "#ffb822",
        "#fd397a",
        "#0abb87",
        "#0abb87",
    ]

    // Private functions
    var demo1 = function() {
        var keyword_id = $('#table_keyword').val();
        var chartData = [];
        var firstDate = new Date();

        $.get('/graph', {'keyword_id': keyword_id}).done(function(response){
            chartData = response;
            var chart = AmCharts.makeChart("campaign_graph", {
 //               "rtl": KTUtil.isRTL(),
                "type": "stock",
                "theme": "light",
                "dataDateFormat": "YYYY-MM-DD",
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
                    "title": "Facebook",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[0],
                    "categoryField": "date",
                    "showInCompare": "false",
                    "showInSelect": "false",
                }, {
                    "title": "Twitter",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[1],
                    "categoryField": "date",
                    "showInCompare": "false",
                    "showInSelect": "false",
                    "compared": "false"
                },{
                    "title": "Instagram",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[2],
                    "categoryField": "date",
                    "showInCompare": "false",
                    "showInSelect": "false",
                    "compared": "false"
                }, {
                    "title": "Youtube",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[3],
                    "categoryField": "date",
                    "showInCompare": "false",
                    "showInSelect": "false",
                    "compared": "false"
                }, {
                    "title": "Web",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[4],
                    "categoryField": "date",
                    "showInCompare": "false",
                    "showInSelect": "false",
                    "compared": "false"
                }],
    
                "panels": [{
                    "showCategoryAxis": false,
                    "title": "Value",
                    "recalculateToPercents" : "never",
                    "stockGraphs": [{
                        "id": "g1",
                        "valueField": "value",
                        "comparable": true,
                        "compareField": "value",
                        "balloonText": "[[title]]:<b>[[value]]</b>",
                        "compareGraphBalloonText": "[[title]]:<b>[[value]]</b>"
                    }],
                    "stockLegend": {
                        "periodValueTextComparing": "[[value.close]]",
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
                        "period": "DD",
                        "count": 10,
                        "label": "10 days"
                    }, {
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