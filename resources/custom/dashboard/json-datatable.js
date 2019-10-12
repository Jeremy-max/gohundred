"use strict";
// Class definition

var KTDatatableJsonRemoteDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: '/data/dashboard/table-data.json',
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
					field: 'RecordID',
					title: '#',
					sortable: false,
					width: 20,
					type: 'number',
					selector: {class: 'kt-checkbox--solid'},
					textAlign: 'center',
				}, {
					field: 'Status',
					title: 'Type of data',
					// callback function support for column rendering
					template: function(row) {
						var status = {
							1: {'title': 'Facebook', 'class': 'kt-badge--primary'},
							2: {'title': 'Twitter', 'class': 'kt-badge--info'},
							3: {'title': 'Reddit', 'class': ' kt-badge--warning'},
							4: {'title': 'YouTube', 'class': ' kt-badge--danger'},
							5: {'title': 'Web', 'class': ' kt-badge--success'},
							// 5: {'title': 'Info', 'class': ' kt-badge--info'},
							// 6: {'title': 'Danger', 'class': ' kt-badge--danger'},
							// 7: {'title': 'Warning', 'class': ' kt-badge--warning'},
						};
						return '<span class="kt-badge ' + status[row.Status].class + ' kt-badge--inline kt-badge--pill">' + status[row.Status].title + '</span>';
					},
				}, 
				// {
				// 	field: 'OrderID',
				// 	title: 'Order ID',
				// },
				//  
				// }, 
				{
					field: 'ShipAddress',
					title: 'Article Name',
				}, {
					field: 'ShipDate',
					title: 'Date',
					type: 'date',
					format: 'MM/DD/YYYY',
				}, 
				// {
	
				// 	field: 'Type',
				// 	title: 'Type',
				// 	autoHide: false,
				// 	// callback function support for column rendering
				// 	template: function(row) {
				// 		var status = {
				// 			1: {'title': 'Online', 'state': 'danger'},
				// 			2: {'title': 'Retail', 'state': 'primary'},
				// 			3: {'title': 'Direct', 'state': 'success'},
				// 		};
				// 		return '<span class="kt-badge kt-badge--' + status[row.Type].state + ' kt-badge--dot"></span>&nbsp;<span class="kt-font-bold kt-font-' + status[row.Type].state + '">' +
				// 				status[row.Type].title + '</span>';
				// 	},
				// },	
				{
					field: 'Country',
					title: 'URL',
					template: function(row) {
						return row.Country + ' ' + row.ShipCountry;
					},
				},	{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					width: 110,
					autoHide: false,
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
      datatable.search($(this).val().toLowerCase(), 'Status');
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