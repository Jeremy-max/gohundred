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
					selector: {class: 'kt-checkbox--solid',id:'kt-id'},
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
                    width: 100
				}, 
				{
					field: 'url',
					title: 'URL',
                    type: 'url',
					textAlign: 'center',
					autoHide: false,
					template: function(row){
						return '<a href="'+row.url+'">'+row.url+'</a>';
					}
				},	{
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					autoHide: false,
					textAlign: 'center',
					overflow: 'visible',
					template: function(row) {
                        var url = row.url;
                        return '\
                        <a href="'+url+'" class="btn btn-hover-warning btn-icon btn-pill" title="Go to page">\
							<i class="fas fa-external-link-alt"></i>\
						</a>\
                        <button class="btn btn-hover-danger btn-icon btn-pill btn-delete" title="Delete" name='+row.id+'>\
                            <i class="la la-trash"></i>\
                        </button>';
					},
                }
            ],

		});

        $('#kt_form_status').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'social_type');
        });

        $('#kt_form_country').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'date');
        });

        // $('#kt_form_country').on('change', function() {
        //     var search = $(this).val() == "AC" ? '' : $(this).val().toLowerCase()
        //     datatable.search(search, 'ShipCountry');
        // });/deleteRow?rowId='+row.id+'

        $('#kt_form_status').selectpicker();

        $('body').on('click', '.btn-delete', function() {
            var rowId = $(this).attr('name');
//            console.log(rowId);
            $.get('/deleteRow', {'rowId': rowId}).done(function(response){
            //    console.log(response);
                datatable.load();
            });
//            var row = datatable.row('kt-id',);
 //           console.log(row);
 //           datatable.remove();

        });

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