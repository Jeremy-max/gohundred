"use strict";

var KTDatatableJsonRemoteDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {

		var datatable = $('.kt-datatable').KTDatatable({
			// datasource definition
			data: {
				type: 'remote',
				source: {
					read: {
						url: '/adminTable',
						method: 'get'
					}
				},
				pageSize: 10,
			},

			// layout definition
			layout: {
				scroll: !0,
                height: 550,
                footer: !1
			},

			// column sorting
			sortable: true,

            pagination: true,
            
            rows: {
                autoHide: !1
            },

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
                    field: "username",
                    title: "User",
                    width: 150,
                    template: function(t) {
                        return '<div class="kt-user-card-v2">\t\t\t\t\t\t\t\t<div class="kt-user-card-v2__pic">\t\t\t\t\t\t\t\t\t<div class="kt-badge kt-badge--xl kt-badge--' + ["success", "brand", "danger", "success", "warning", "primary", "info"][KTUtil.getRandomInt(0, 6)]+ '">' + t.username.substring(0, 1).toUpperCase() + '</div>\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t\t<div class="kt-user-card-v2__details">\t\t\t\t\t\t\t\t\t<span class="kt-user-card-v2__name">' + t.username + "</span>\t\t\t\t\t\t\t\t</div>\t\t\t\t\t\t\t</div>";
                    }
                },{
                    field: "email",
                    title: "Email"
                },{
                    field: "country",
                    title: "Country"
                },{
                    field: "login_fb",
                    title: "Login via Facebook",
                    template: function(row) {
                        if(row.login_fb)
                            return 'YES';
                        else
                            return 'NO';
                    }
                },{
                    field: "login_gg",
                    title: "Login via Google",
                    template: function(row) {
                        if(row.login_gg)
                            return 'YES';
                        else
                            return 'NO';
                    }
                },{
                    field: "payment_status",
                    title: "Payment Status",
                    template: function(row) {
                        if(!row.payment_status)
                            return 'Not paid';
                        else
                            return 'Paid' + row.payment_status;
                    }
                },{
                    field: "number_campaigns",
                    title: "Number of Campaigns",
                    type: 'number',
                },{
                    field: "comment",
                    title: "Comment",
                    autoHide: true,
                    width: 'auto',
                    template: function(row){
                        if(row.comment)
                            return row.comment;
                        else
                            return 'Nothing';
                    }
                },
                {
					field: 'Actions',
					title: 'Actions',
					sortable: false,
					textAlign: 'center',
					overflow: 'visible',
					template: function(row) {
                        return '\
                        <button class="btn btn-hover-info btn-icon btn-pill btn-edit" title="Edit comments" id="'+row.id+'" name="'+row.username+'" value="'+row.comment+'">\
                            <i class="la la-edit"></i>\
                        </button>\
                        <button class="btn btn-hover-danger btn-icon btn-pill btn-delete" title="Delete" name="'+row.id+'">\
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
            var search = $(this).val() == "All" ? '' : $(this).val().toLowerCase();
        	datatable.search(search, 'country');
        });

        // $('#kt_form_country').on('change', function() {
        //     var search = $(this).val() == "AC" ? '' : $(this).val().toLowerCase()
        //     datatable.search(search, 'ShipCountry');
        // });/deleteRow?rowId='+row.id+'

        $('#kt_form_status').selectpicker();

        $('body').on('click', '.btn-delete', function() {
            var rowId = $(this).attr('name');
//            console.log(rowId);
            $.get('/deleteAdminRow', {'rowId': rowId}).done(function(response){
                datatable.load();
            });

        });
        datatable.on("click", ".btn-edit", function() {
            $('#modal-userid').val($(this).attr('id'));
            $('#modal-username').val($(this).attr('name'));
            $('#modal-comment').val($(this).attr('value'));
            $("#kt_modal_4").modal("show");
        });
        $('body').on("click", '#btn-modal-save', function() {
            var rowId = $('#modal-userid').val();
            var comment = $('#modal-comment').val();
            $.ajax({
                method: "post",
                url: '/saveAdminComment',
                data: {'rowId': rowId, 'comment': comment},
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                dataType: 'text',
                success: function(response) { 
                    datatable.load();
                    $("#kt_modal_4").modal("hide");
                }
            });
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