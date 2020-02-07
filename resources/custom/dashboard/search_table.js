"use strict";

var KTDatatableJsonRemoteDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {
		var keyword_id = $('#table_keyword').val();

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: '/tdata?keyword_id=' + keyword_id,
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

            extensions: {
                checkbox: {}
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
					autoHide: false
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
					autoHide: false,
					// callback function support for column rendering
					template: function(row) {
						var type = {
							'facebook': 'kt-badge--primary',
							'twitter': 'kt-badge--info',
							'tiktok': 'kt-badge--warning',
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
					autoHide: true,
					width: 400
				}, {
					field: 'date',
					title: 'Date',
//					type: 'date',
					format: 'YYYY-MM-DD',
					textAlign: 'center',
                    sortable: 'asc',
                    autoHide: true,
                    width: 100
				},
				{
					field: 'url',
					title: 'URL',
                    type: 'url',
					template: function(row){
						return '<a href="'+row.url+'" class="dashboard-table-url">'+row.url+'</a>';
                    },
                    autoHide: true,
                    width: 'auto'
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
                    width: 150,
                }
            ],

        });


        $('#kt_form_status').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'social_type');
        });

        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            startDate: '2019-11-11',
            todayBtn: 'linked',
            todayHighlight: true,
            clearBtn: true
        });

        $('.datepicker').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'date');
        });

        $('#kt_form_status').selectpicker();


        datatable.on('kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated', function (e) {
            // datatable.checkbox() access to extension methods
            var ids = datatable.checkbox().getSelectedId();
            var count = ids.length;
            $('#kt_datatable_selected_number').html(count);

            if (count > 0) {
              $('#kt_datatable_group_action_form').collapse('show');
            } else {
              $('#kt_datatable_group_action_form').collapse('hide');
            }
          });


        $('body').on('click', '.btn-delete', function() {
            var rowId = $(this).attr('name');

            var tr = $(this).parentsUntil('tr').parent()[0];
            swal.fire({
              title: 'Are you sure?',
              text: "You won't be able to revert this!",
              type: 'warning',
              showCancelButton: true,
              confirmButtonText: 'Yes, delete it!'
            }).then(function(result) {
              if (result.value) {
                $.get('/deleteRow', {'rowId': rowId}).done(function(response){
                    toastr.success('Row deleted!');
                    $(tr).addClass('kt-datatable__row--active');
                    datatable.rows('.kt-datatable__row--active').remove();
                    datatable.reload();
                });

                // $.ajax({
                //     url: '/deleteRow' + rowId,
                //     type: 'delete',
                //     dataType: 'json',
                //     success: function success(response) {
                //         toastr.success('Row deleted!');
                //         $(tr).addClass('kt-datatable__row--active');
                //         datatable.rows('.kt-datatable__row--active').remove();
                //         datatable.reload();
                //     },
                //     error: function error(jqXHR, status, _error2) {}
                // });
              }
            });
        });

        $("body").on("click", ".dashboard-table-url", function (e) {
            e.preventDefault();
            window.open($(e.target).attr("href"), "_blank")
        })

        // $('#kt_datatable_delete_all').on('click', function () {
        //     var ids = datatable.checkbox().getSelectedId();

        //     var tr = $(this).parentsUntil('tr').parent()[0];
        //     swal.fire({
        //       title: 'Are you sure?',
        //       text: "You won't be able to revert this!",
        //       type: 'warning',
        //       showCancelButton: true,
        //       confirmButtonText: 'Yes, delete it!'
        //     }).then(function(result) {
        //       if (result.value) {
        //         $.ajax({
        //             url: '/deleteRow',
        //             type: 'delete',
        //             dataType: 'json',
        //             data: {ids},
        //             success: function success(response) {
        //                 toastr.success('All checked items deleted!');
        //                 datatable.reload();
        //                 datatable.rows('.kt-datatable__row--active').remove();
        //             },
        //             error: function error(jqXHR, status, _error2) {}
        //         });
        //       }
        //     });

        // });
	};

	return {
		// public functions
		init: function () {
			demo();
		}
	};
}();

jQuery(document).ready(function () {
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
	KTDatatableJsonRemoteDemo.init();
});
