"use strict";

// Class definition
var demo1 = null;
var KTamChartsStockChartsDemo = function() {

    AmCharts.themes.light.AmStockChart.colors = [
        "#007bff",
        "#00aced",
        // "#ffb822",
        "#fd397a",
        "#0abb87",
        "#0abb87",
    ]

    // Private functions
    demo1 = function() {
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
                    "dateFormat": "YYYY-MM-DD",
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
                },

                "listeners": [{
                    "event": "rendered",
                    "method": function(ev) {
                        $('.amChartsInputField').datepicker({
                            format: 'yyyy-mm-dd',
                            startDate: '2019-11-11',
                            todayBtn: 'linked',
                            todayHighlight: true,
                            clearBtn: true
                        });
                    }
                }]
            });
        });

        $('.amChartsInputField').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '2019-11-11',
            todayBtn: 'linked',
            todayHighlight: true,
            clearBtn: true
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
    if ($("#job").length > 0)
    {
        var last_index = $('#job').attr('value');
        localStorage.setItem('last_index', $('#job').attr('value'));
        localStorage.setItem('last_fb', $('#job').data('fb'));
        localStorage.setItem('last_tw', $('#job').data('tw'));
        localStorage.setItem('last_yt', $('#job').data('yt'));
        localStorage.setItem('last_web', $('#job').data('web'));

        if(last_index){
            var jobTimer = setInterval(jobFunc, 5000);
            function jobFunc(){
                $.ajaxSetup({
                    headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                  });
                $.post('/job').done(function (res){
                    if(res['status'] == 'end'){
                        demo1();
                        datatable.reload();
                        $('.total_cnt').text(Number(res['last_index'])-Number(localStorage.getItem('last_index')));
                        $('.fb_cnt').text(Number(res['fb_cnt'])-Number(localStorage.getItem('last_fb')));
                        $('.tw_cnt').text(Number(res['tw_cnt'])-Number(localStorage.getItem('last_tw')));
                        $('.yt_cnt').text(Number(res['yt_cnt'])-Number(localStorage.getItem('last_yt')));
                        $('.web_cnt').text(Number(res['web_cnt'])-Number(localStorage.getItem('last_web')));
                        clearInterval(jobTimer);
                    }else{
                        if(res['last_index'] > localStorage.getItem('last_index')){
                            demo1();
                            datatable.reload();
                            $('.total_cnt').text(Number(res['last_index'])-Number(localStorage.getItem('last_index')));
                            $('.fb_cnt').text(Number(res['fb_cnt'])-Number(localStorage.getItem('last_fb')));
                            $('.tw_cnt').text(Number(res['tw_cnt'])-Number(localStorage.getItem('last_tw')));
                            $('.yt_cnt').text(Number(res['yt_cnt'])-Number(localStorage.getItem('last_yt')));
                            $('.web_cnt').text(Number(res['web_cnt'])-Number(localStorage.getItem('last_web')));
                            localStorage.setItem('last', res['last_index']);
                        }
                    }

                });
            }

        }
    }
});
