"use strict";

// Class definition
var KTamChartsStockChartsDemo = function() {

    AmCharts.themes.light.AmStockChart.colors = [
        "#007bff",
        "#00aced",
        "#ffb822",
        "#fd397a",
        "#0abb87"
    ]

    // Private functions
    var demo1 = function() {
        var keyword = $('#table_keyword').val();
        var chartData = [];
        var firstDate = new Date();

        $.get('/graph', {'keyword': keyword}).done(function(response){
            chartData = response;
            var chart = AmCharts.makeChart("campaign_graph", {
                "rtl": KTUtil.isRTL(),
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
                    "categoryField": "date"
                }, {
                    "title": "Twitter",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[1],
                    "categoryField": "date"
                },{
                    "title": "Instagram",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[2],
                    "categoryField": "date"
                }, {
                    "title": "Youtube",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[3],
                    "categoryField": "date"
                }, {
                    "title": "Web",
                    "fieldMappings": [{
                        "fromField": "value",
                        "toField": "value"
                    }],
                    "dataProvider": response[4],
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
"use strict";

var KTDatatableJsonRemoteDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {
		var keyword = $('#table_keyword').val();

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: '/tdata?keyword=' + keyword,
						method: 'get'
					}
				},
				pageSize: 10,
			},

			// layout definition
			layout: {
				scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
				footer: false // display/hide footer
			},

			// column sorting
			sortable: true,

			pagination: true,

			search: {
				input: $('#generalSearch')
			},

			// columns definition
			columns: [
				{
					field: 'id',
					title: '#',
					sortable: false,
					width: 20,
					type: 'number',
					selector: {class: 'kt-checkbox--solid'},
					textAlign: 'center',
				},
				// {
				// 	field: 'id',
				// 	title: 'ID',
				// 	width: 50,
				// 	type: 'number',
				// 	textAlign: 'center',
				// },
				{
					field: 'social_type',
					title: 'Social Type',
					textAlign: 'center',		
					// callback function support for column rendering
					template: function(row) {
						var type = {
							'facebook': 'kt-badge--primary',
							'twitter': 'kt-badge--info',
							'instagram': 'kt-badge--warning',
							'youtube': 'kt-badge--danger',
							'web': 'kt-badge--success',
						};
						return '<span class="kt-badge ' + type[row.social_type] + ' kt-badge--inline kt-badge--pill">' + row.social_type + '</span>';
					},
					width: 100,
				},
				{
					field: 'title',
					title: 'Title',
					textAlign: 'center',
					width: 500
				}, {
					field: 'date',
					title: 'Date',
//					type: 'date',
					format: 'YYYY-MM-DD',
					textAlign: 'center',
					sortable: 'asc',
				}, 
				{
					field: 'url',
					title: 'URL',
					type: 'url',
					textAlign: 'center',
					autoHide: false,
					template: function(row){
						return '<a href='+row.url+'>'+row.url+'</a>';
					}
				},	{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 110,
					autoHide: false,
					textAlign: 'center',
					overflow: 'visible',
					template: function() {
						return '\
						<a href="#" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Go to page">\
							<i class="fas fa-external-link-alt"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Delete">\
							<i class="fas fa-trash"></i>\
						</a>\
						<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Share(E-mail)">\
							<i class="fas fa-envelope"></i>\
						</a>\
					';
					},
				}],

		});

        $('#kt_form_status').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'social_type');
        });

        $('#kt_form_type').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'Type');
        });

        $('#kt_form_country').on('change', function() {
            var search = $(this).val() == "AC" ? '' : $(this).val().toLowerCase()
            datatable.search(search, 'ShipCountry');
        });

        $('#kt_form_status,#kt_form_type').selectpicker();

	};

	return {
		// public functions
		init: function () {
			demo();
		}
	};
}();

jQuery(document).ready(function () {
	KTDatatableJsonRemoteDemo.init();
});