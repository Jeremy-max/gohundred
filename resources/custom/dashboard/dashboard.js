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
        let last_index = $('#job').attr('value');
        let keyword_id = $('#table_keyword').attr('value');
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
                        var fb = Number(res['fb_cnt'])-Number(localStorage.getItem('last_fb'));
                        var tw = Number(res['tw_cnt'])-Number(localStorage.getItem('last_tw'));
                        var yt = Number(res['yt_cnt'])-Number(localStorage.getItem('last_yt'));
                        var web = Number(res['web_cnt'])-Number(localStorage.getItem('last_web'));
                        $('.fb_cnt').text(fb);
                        $('.tw_cnt').text(tw);
                        $('.yt_cnt').text(yt);
                        $('.web_cnt').text(web);
                        $.post('/saveNewcomments', {keyword_id: keyword_id, fb: fb, tw: tw, yt: yt, web: web},
                            function(returnedData){
                                console.log(returnedData);
                        });
                        clearInterval(jobTimer);
                    }else{
                        if(res['last_index'] > localStorage.getItem('last_index')){
                            demo1();
                            datatable.reload();
                            $('.total_cnt').text(Number(res['last_index'])-Number(localStorage.getItem('last_index')));
                            var fb = Number(res['fb_cnt'])-Number(localStorage.getItem('last_fb'));
                            var tw = Number(res['tw_cnt'])-Number(localStorage.getItem('last_tw'));
                            var yt = Number(res['yt_cnt'])-Number(localStorage.getItem('last_yt'));
                            var web = Number(res['web_cnt'])-Number(localStorage.getItem('last_web'));
                            $('.fb_cnt').text(fb);
                            $('.tw_cnt').text(tw);
                            $('.yt_cnt').text(yt);
                            $('.web_cnt').text(web);
                            $.post('/saveNewcomments', {keyword_id: keyword_id, fb: fb, tw: tw, yt: yt, web: web},
                                function(returnedData){
                                    console.log(returnedData);
                            });
                            localStorage.setItem('last', res['last_index']);

                        }
                    }

                });
            }

        }
    }
});

"use strict";

var datatable = null;
var KTDatatableJsonRemoteDemo = function () {
	// Private functions

	// basic demo
	var demo = function () {
		var keyword_id = $('#table_keyword').val();

		datatable = $('.kt-datatable').KTDatatable({
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
					field: 'sentiment',
                    title: 'Sentiment',
                    textAlign:'center',
					template: function(row) {
						var type = {
							'POSITIVE': "<i class='fa fa-thumbs-up fa-2x' style='color:green'></i>",
							'NEGATIVE': "<i class='fa fa-thumbs-down fa-2x' style='color:red'></i>",
							'NEUTRAL': "<span style='font-size:25px;'>&#128528;</span>",
                            'MIXED':  "<span style='font-size:25px;'>&#128552;</span>",
                            'INVALID': "<span style='font-size:25px;'>&#128528;</span>"
                        };
						return type[row.sentiment];
                    },
                    autoHide: false,
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
                        <a href="'+url+'" class="btn btn-hover-warning btn-icon btn-pill dashboard-table-url" title="Go to page">\
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

        $('#kt_sentiment_filter').on('change', function() {
        	datatable.search($(this).val().toUpperCase(), 'sentiment');
        });

        $('#kt_title_language').on('change', function() {
        	datatable.search($(this).val().toLowerCase(), 'lang_type');
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
        $('#kt_sentiment_filter').selectpicker();

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
            window.open(e.currentTarget.href, "_blank");
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

"use strict";

jQuery(document).ready(function () {
	$("#slack-modal-button").on("click", function() {
        $("#kt_modal_4").modal("show");
        $("#slack_campaign_id").val($("#slack_campaign_select option:selected").val());
    });
    $("#slack_campaign_select").on("click", function() {
        var campaign_id = $("#slack_campaign_select option:selected").val();
        $("#slack_campaign_id").val(campaign_id);
    });
});

! function(t) {
    function e(o) {
        if (n[o]) return n[o].exports;
        var r = n[o] = {
            i: o,
            l: !1,
            exports: {}
        };
        return t[o].call(r.exports, r, r.exports, e), r.l = !0, r.exports
    }
    var n = {};
    e.m = t, e.c = n, e.d = function(t, n, o) {
        e.o(t, n) || Object.defineProperty(t, n, {
            configurable: !1,
            enumerable: !0,
            get: o
        })
    }, e.n = function(t) {
        var n = t && t.__esModule ? function() {
            return t.default
        } : function() {
            return t
        };
        return e.d(n, "a", n), n
    }, e.o = function(t, e) {
        return Object.prototype.hasOwnProperty.call(t, e)
    }, e.p = "/", e(e.s = 30)
}([function(t, e, n) {
    "use strict";

    function o(t) {
        return "[object Array]" === C.call(t)
    }

    function r(t) {
        return "[object ArrayBuffer]" === C.call(t)
    }

    function i(t) {
        return "undefined" != typeof FormData && t instanceof FormData
    }

    function a(t) {
        return "undefined" != typeof ArrayBuffer && ArrayBuffer.isView ? ArrayBuffer.isView(t) : t && t.buffer && t.buffer instanceof ArrayBuffer
    }

    function s(t) {
        return "string" == typeof t
    }

    function c(t) {
        return "number" == typeof t
    }

    function u(t) {
        return void 0 === t
    }

    function p(t) {
        return null !== t && "object" == typeof t
    }

    function f(t) {
        return "[object Date]" === C.call(t)
    }

    function l(t) {
        return "[object File]" === C.call(t)
    }

    function d(t) {
        return "[object Blob]" === C.call(t)
    }

    function h(t) {
        return "[object Function]" === C.call(t)
    }

    function m(t) {
        return p(t) && h(t.pipe)
    }

    function b(t) {
        return "undefined" != typeof URLSearchParams && t instanceof URLSearchParams
    }

    function v(t) {
        return t.replace(/^\s*/, "").replace(/\s*$/, "")
    }

    function g() {
        return ("undefined" == typeof navigator || "ReactNative" !== navigator.product) && ("undefined" != typeof window && "undefined" != typeof document)
    }

    function y(t, e) {
        if (null !== t && void 0 !== t)
            if ("object" != typeof t && (t = [t]), o(t))
                for (var n = 0, r = t.length; r > n; n++) e.call(null, t[n], n, t);
            else
                for (var i in t) Object.prototype.hasOwnProperty.call(t, i) && e.call(null, t[i], i, t)
    }

    function w() {
        function t(t, n) {
            e[n] = "object" == typeof e[n] && "object" == typeof t ? w(e[n], t) : t
        }
        for (var e = {}, n = 0, o = arguments.length; o > n; n++) y(arguments[n], t);
        return e
    }

    function x(t, e, n) {
        return y(e, function(e, o) {
            t[o] = n && "function" == typeof e ? _(e, n) : e
        }), t
    }
    var _ = n(3),
        O = n(12),
        C = Object.prototype.toString;
    t.exports = {
        isArray: o,
        isArrayBuffer: r,
        isBuffer: O,
        isFormData: i,
        isArrayBufferView: a,
        isString: s,
        isNumber: c,
        isObject: p,
        isUndefined: u,
        isDate: f,
        isFile: l,
        isBlob: d,
        isFunction: h,
        isStream: m,
        isURLSearchParams: b,
        isStandardBrowserEnv: g,
        forEach: y,
        merge: w,
        extend: x,
        trim: v
    }
}, function(t, e, n) {
    "use strict";

    function o() {}

    function r(t, e) {
        var n, r, i, a, s = R;
        for (a = arguments.length; a-- > 2;) U.push(arguments[a]);
        for (e && null != e.children && (U.length || U.push(e.children), delete e.children); U.length;)
            if ((r = U.pop()) && void 0 !== r.pop)
                for (a = r.length; a--;) U.push(r[a]);
            else "boolean" == typeof r && (r = null), (i = "function" != typeof t) && (null == r ? r = "" : "number" == typeof r ? r += "" : "string" != typeof r && (i = !1)), i && n ? s[s.length - 1] += r : s === R ? s = [r] : s.push(r), n = i;
        var c = new o;
        return c.nodeName = t, c.children = s, c.attributes = null == e ? void 0 : e, c.key = null == e ? void 0 : e.key, void 0 !== T.vnode && T.vnode(c), c
    }

    function i(t, e) {
        for (var n in e) t[n] = e[n];
        return t
    }

    function a(t) {
        !t._dirty && (t._dirty = !0) && 1 == M.push(t) && (T.debounceRendering || P)(s)
    }

    function s() {
        var t, e = M;
        for (M = []; t = e.pop();) t._dirty && S(t)
    }

    function c(t, e, n) {
        return "string" == typeof e || "number" == typeof e ? void 0 !== t.splitText : "string" == typeof e.nodeName ? !t._componentConstructor && u(t, e.nodeName) : n || t._componentConstructor === e.nodeName
    }

    function u(t, e) {
        return t.normalizedNodeName === e || t.nodeName.toLowerCase() === e.toLowerCase()
    }

    function p(t) {
        var e = i({}, t.attributes);
        e.children = t.children;
        var n = t.nodeName.defaultProps;
        if (void 0 !== n)
            for (var o in n) void 0 === e[o] && (e[o] = n[o]);
        return e
    }

    function f(t, e) {
        var n = e ? document.createElementNS("http://www.w3.org/2000/svg", t) : document.createElement(t);
        return n.normalizedNodeName = t, n
    }

    function l(t) {
        var e = t.parentNode;
        e && e.removeChild(t)
    }

    function d(t, e, n, o, r) {
        if ("className" === e && (e = "class"), "key" === e);
        else if ("ref" === e) n && n(null), o && o(t);
        else if ("class" !== e || r)
            if ("style" === e) {
                if (o && "string" != typeof o && "string" != typeof n || (t.style.cssText = o || ""), o && "object" == typeof o) {
                    if ("string" != typeof n)
                        for (var i in n) i in o || (t.style[i] = "");
                    for (var i in o) t.style[i] = "number" == typeof o[i] && !1 === F.test(i) ? o[i] + "px" : o[i]
                }
            } else if ("dangerouslySetInnerHTML" === e) o && (t.innerHTML = o.__html || "");
        else if ("o" == e[0] && "n" == e[1]) {
            var a = e !== (e = e.replace(/Capture$/, ""));
            e = e.toLowerCase().substring(2), o ? n || t.addEventListener(e, m, a) : t.removeEventListener(e, m, a), (t._listeners || (t._listeners = {}))[e] = o
        } else if ("list" !== e && "type" !== e && !r && e in t) h(t, e, null == o ? "" : o), null != o && !1 !== o || t.removeAttribute(e);
        else {
            var s = r && e !== (e = e.replace(/^xlink\:?/, ""));
            null == o || !1 === o ? s ? t.removeAttributeNS("http://www.w3.org/1999/xlink", e.toLowerCase()) : t.removeAttribute(e) : "function" != typeof o && (s ? t.setAttributeNS("http://www.w3.org/1999/xlink", e.toLowerCase(), o) : t.setAttribute(e, o))
        } else t.className = o || ""
    }

    function h(t, e, n) {
        try {
            t[e] = n
        } catch (t) {}
    }

    function m(t) {
        return this._listeners[t.type](T.event && T.event(t) || t)
    }

    function b() {
        for (var t; t = L.pop();) T.afterMount && T.afterMount(t), t.componentDidMount && t.componentDidMount()
    }

    function v(t, e, n, o, r, i) {
        q++ || (H = null != r && void 0 !== r.ownerSVGElement, z = null != t && !("__preactattr_" in t));
        var a = g(t, e, n, o, i);
        return r && a.parentNode !== r && r.appendChild(a), --q || (z = !1, i || b()), a
    }

    function g(t, e, n, o, r) {
        var i = t,
            a = H;
        if (null != e && "boolean" != typeof e || (e = ""), "string" == typeof e || "number" == typeof e) return t && void 0 !== t.splitText && t.parentNode && (!t._component || r) ? t.nodeValue != e && (t.nodeValue = e) : (i = document.createTextNode(e), t && (t.parentNode && t.parentNode.replaceChild(i, t), w(t, !0))), i.__preactattr_ = !0, i;
        var s = e.nodeName;
        if ("function" == typeof s) return E(t, e, n, o);
        if (H = "svg" === s || "foreignObject" !== s && H, s += "", (!t || !u(t, s)) && (i = f(s, H), t)) {
            for (; t.firstChild;) i.appendChild(t.firstChild);
            t.parentNode && t.parentNode.replaceChild(i, t), w(t, !0)
        }
        var c = i.firstChild,
            p = i.__preactattr_,
            l = e.children;
        if (null == p) {
            p = i.__preactattr_ = {};
            for (var d = i.attributes, h = d.length; h--;) p[d[h].name] = d[h].value
        }
        return !z && l && 1 === l.length && "string" == typeof l[0] && null != c && void 0 !== c.splitText && null == c.nextSibling ? c.nodeValue != l[0] && (c.nodeValue = l[0]) : (l && l.length || null != c) && y(i, l, n, o, z || null != p.dangerouslySetInnerHTML), _(i, e.attributes, p), H = a, i
    }

    function y(t, e, n, o, r) {
        var i, a, s, u, p, f = t.childNodes,
            d = [],
            h = {},
            m = 0,
            b = 0,
            v = f.length,
            y = 0,
            x = e ? e.length : 0;
        if (0 !== v)
            for (var _ = 0; v > _; _++) {
                var O = f[_],
                    C = O.__preactattr_,
                    j = x && C ? O._component ? O._component.__key : C.key : null;
                null != j ? (m++, h[j] = O) : (C || (void 0 !== O.splitText ? !r || O.nodeValue.trim() : r)) && (d[y++] = O)
            }
        if (0 !== x)
            for (var _ = 0; x > _; _++) {
                u = e[_], p = null;
                var j = u.key;
                if (null != j) m && void 0 !== h[j] && (p = h[j], h[j] = void 0, m--);
                else if (!p && y > b)
                    for (i = b; y > i; i++)
                        if (void 0 !== d[i] && c(a = d[i], u, r)) {
                            p = a, d[i] = void 0, i === y - 1 && y--, i === b && b++;
                            break
                        } p = g(p, u, n, o), s = f[_], p && p !== t && p !== s && (null == s ? t.appendChild(p) : p === s.nextSibling ? l(s) : t.insertBefore(p, s))
            }
        if (m)
            for (var _ in h) void 0 !== h[_] && w(h[_], !1);
        for (; y >= b;) void 0 !== (p = d[y--]) && w(p, !1)
    }

    function w(t, e) {
        var n = t._component;
        n ? B(n) : (null != t.__preactattr_ && t.__preactattr_.ref && t.__preactattr_.ref(null), !1 !== e && null != t.__preactattr_ || l(t), x(t))
    }

    function x(t) {
        for (t = t.lastChild; t;) {
            var e = t.previousSibling;
            w(t, !0), t = e
        }
    }

    function _(t, e, n) {
        var o;
        for (o in n) e && null != e[o] || null == n[o] || d(t, o, n[o], n[o] = void 0, H);
        for (o in e) "children" === o || "innerHTML" === o || o in n && e[o] === ("value" === o || "checked" === o ? t[o] : n[o]) || d(t, o, n[o], n[o] = e[o], H)
    }

    function O(t) {
        var e = t.constructor.name;
        (W[e] || (W[e] = [])).push(t)
    }

    function C(t, e, n) {
        var o, r = W[t.name];
        if (t.prototype && t.prototype.render ? (o = new t(e, n), N.call(o, e, n)) : (o = new N(e, n), o.constructor = t, o.render = j), r)
            for (var i = r.length; i--;)
                if (r[i].constructor === t) {
                    o.nextBase = r[i].nextBase, r.splice(i, 1);
                    break
                } return o
    }

    function j(t, e, n) {
        return this.constructor(t, n)
    }

    function k(t, e, n, o, r) {
        t._disable || (t._disable = !0, (t.__ref = e.ref) && delete e.ref, (t.__key = e.key) && delete e.key, !t.base || r ? t.componentWillMount && t.componentWillMount() : t.componentWillReceiveProps && t.componentWillReceiveProps(e, o), o && o !== t.context && (t.prevContext || (t.prevContext = t.context), t.context = o), t.prevProps || (t.prevProps = t.props), t.props = e, t._disable = !1, 0 !== n && (1 !== n && !1 === T.syncComponentUpdates && t.base ? a(t) : S(t, 1, r)), t.__ref && t.__ref(t))
    }

    function S(t, e, n, o) {
        if (!t._disable) {
            var r, a, s, c = t.props,
                u = t.state,
                f = t.context,
                l = t.prevProps || c,
                d = t.prevState || u,
                h = t.prevContext || f,
                m = t.base,
                g = t.nextBase,
                y = m || g,
                x = t._component,
                _ = !1;
            if (m && (t.props = l, t.state = d, t.context = h, 2 !== e && t.shouldComponentUpdate && !1 === t.shouldComponentUpdate(c, u, f) ? _ = !0 : t.componentWillUpdate && t.componentWillUpdate(c, u, f), t.props = c, t.state = u, t.context = f), t.prevProps = t.prevState = t.prevContext = t.nextBase = null, t._dirty = !1, !_) {
                r = t.render(c, u, f), t.getChildContext && (f = i(i({}, f), t.getChildContext()));
                var O, j, E = r && r.nodeName;
                if ("function" == typeof E) {
                    var N = p(r);
                    a = x, a && a.constructor === E && N.key == a.__key ? k(a, N, 1, f, !1) : (O = a, t._component = a = C(E, N, f), a.nextBase = a.nextBase || g, a._parentComponent = t, k(a, N, 0, f, !1), S(a, 1, n, !0)), j = a.base
                } else s = y, O = x, O && (s = t._component = null), (y || 1 === e) && (s && (s._component = null), j = v(s, r, f, n || !m, y && y.parentNode, !0));
                if (y && j !== y && a !== x) {
                    var A = y.parentNode;
                    A && j !== A && (A.replaceChild(j, y), O || (y._component = null, w(y, !1)))
                }
                if (O && B(O), t.base = j, j && !o) {
                    for (var U = t, R = t; R = R._parentComponent;)(U = R).base = j;
                    j._component = U, j._componentConstructor = U.constructor
                }
            }
            if (!m || n ? L.unshift(t) : _ || (t.componentDidUpdate && t.componentDidUpdate(l, d, h), T.afterUpdate && T.afterUpdate(t)), null != t._renderCallbacks)
                for (; t._renderCallbacks.length;) t._renderCallbacks.pop().call(t);
            q || o || b()
        }
    }

    function E(t, e, n, o) {
        for (var r = t && t._component, i = r, a = t, s = r && t._componentConstructor === e.nodeName, c = s, u = p(e); r && !c && (r = r._parentComponent);) c = r.constructor === e.nodeName;
        return r && c && (!o || r._component) ? (k(r, u, 3, n, o), t = r.base) : (i && !s && (B(i), t = a = null), r = C(e.nodeName, u, n), t && !r.nextBase && (r.nextBase = t, a = null), k(r, u, 1, n, o), t = r.base, a && t !== a && (a._component = null, w(a, !1))), t
    }

    function B(t) {
        T.beforeUnmount && T.beforeUnmount(t);
        var e = t.base;
        t._disable = !0, t.componentWillUnmount && t.componentWillUnmount(), t.base = null;
        var n = t._component;
        n ? B(n) : e && (e.__preactattr_ && e.__preactattr_.ref && e.__preactattr_.ref(null), t.nextBase = e, l(e), O(t), x(e)), t.__ref && t.__ref(null)
    }

    function N(t, e) {
        this._dirty = !0, this.context = e, this.props = t, this.state = this.state || {}
    }

    function A(t, e, n) {
        return v(n, t, {}, !1, e, !1)
    }
    n.d(e, "b", function() {
        return r
    }), n.d(e, "a", function() {
        return N
    }), n.d(e, "c", function() {
        return A
    });
    var T = {},
        U = [],
        R = [],
        P = "function" == typeof Promise ? Promise.resolve().then.bind(Promise.resolve()) : setTimeout,
        F = /acit|ex(?:s|g|n|p|$)|rph|ows|mnc|ntw|ine[ch]|zoo|^ord/i,
        M = [],
        L = [],
        q = 0,
        H = !1,
        z = !1,
        W = {};
    i(N.prototype, {
        setState: function(t, e) {
            var n = this.state;
            this.prevState || (this.prevState = i({}, n)), i(n, "function" == typeof t ? t(n, this.props) : t), e && (this._renderCallbacks = this._renderCallbacks || []).push(e), a(this)
        },
        forceUpdate: function(t) {
            t && (this._renderCallbacks = this._renderCallbacks || []).push(t), S(this, 2)
        },
        render: function() {}
    })
}, function(t, e, n) {
    "use strict";

    function o(t, e) {
        !r.isUndefined(t) && r.isUndefined(t["Content-Type"]) && (t["Content-Type"] = e)
    }
    var r = n(0),
        i = n(14),
        a = {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        s = {
            adapter: function() {
                var t;
                return "undefined" != typeof XMLHttpRequest ? t = n(4) : "undefined" != typeof process && (t = n(4)), t
            }(),
            transformRequest: [function(t, e) {
                return i(e, "Content-Type"), r.isFormData(t) || r.isArrayBuffer(t) || r.isBuffer(t) || r.isStream(t) || r.isFile(t) || r.isBlob(t) ? t : r.isArrayBufferView(t) ? t.buffer : r.isURLSearchParams(t) ? (o(e, "application/x-www-form-urlencoded;charset=utf-8"), "" + t) : r.isObject(t) ? (o(e, "application/json;charset=utf-8"), JSON.stringify(t)) : t
            }],
            transformResponse: [function(t) {
                if ("string" == typeof t) try {
                    t = JSON.parse(t)
                } catch (t) {}
                return t
            }],
            timeout: 0,
            xsrfCookieName: "XSRF-TOKEN",
            xsrfHeaderName: "X-XSRF-TOKEN",
            maxContentLength: -1,
            validateStatus: function(t) {
                return t >= 200 && 300 > t
            }
        };
    s.headers = {
        common: {
            Accept: "application/json, text/plain, */*"
        }
    }, r.forEach(["delete", "get", "head"], function(t) {
        s.headers[t] = {}
    }), r.forEach(["post", "put", "patch"], function(t) {
        s.headers[t] = r.merge(a)
    }), t.exports = s
}, function(t) {
    "use strict";
    t.exports = function(t, e) {
        return function() {
            for (var n = Array(arguments.length), o = 0; n.length > o; o++) n[o] = arguments[o];
            return t.apply(e, n)
        }
    }
}, function(t, e, n) {
    "use strict";
    var o = n(0),
        r = n(15),
        i = n(17),
        a = n(18),
        s = n(19),
        c = n(5),
        u = "undefined" != typeof window && window.btoa && window.btoa.bind(window) || n(20);
    t.exports = function(t) {
        return new Promise(function(e, p) {
            var f = t.data,
                l = t.headers;
            o.isFormData(f) && delete l["Content-Type"];
            var d = new XMLHttpRequest,
                h = "onreadystatechange",
                m = !1;
            if ("undefined" == typeof window || !window.XDomainRequest || "withCredentials" in d || s(t.url) || (d = new window.XDomainRequest, h = "onload", m = !0, d.onprogress = function() {}, d.ontimeout = function() {}), t.auth) {
                l.Authorization = "Basic " + u((t.auth.username || "") + ":" + (t.auth.password || ""))
            }
            if (d.open(t.method.toUpperCase(), i(t.url, t.params, t.paramsSerializer), !0), d.timeout = t.timeout, d[h] = function() {
                    if (d && (4 === d.readyState || m) && (0 !== d.status || d.responseURL && 0 === d.responseURL.indexOf("file:"))) {
                        var n = "getAllResponseHeaders" in d ? a(d.getAllResponseHeaders()) : null;
                        r(e, p, {
                            data: t.responseType && "text" !== t.responseType ? d.response : d.responseText,
                            status: 1223 === d.status ? 204 : d.status,
                            statusText: 1223 === d.status ? "No Content" : d.statusText,
                            headers: n,
                            config: t,
                            request: d
                        }), d = null
                    }
                }, d.onerror = function() {
                    p(c("Network Error", t, null, d)), d = null
                }, d.ontimeout = function() {
                    p(c("timeout of " + t.timeout + "ms exceeded", t, "ECONNABORTED", d)), d = null
                }, o.isStandardBrowserEnv()) {
                var b = n(21),
                    v = (t.withCredentials || s(t.url)) && t.xsrfCookieName ? b.read(t.xsrfCookieName) : void 0;
                v && (l[t.xsrfHeaderName] = v)
            }
            if ("setRequestHeader" in d && o.forEach(l, function(t, e) {
                    void 0 === f && "content-type" === e.toLowerCase() ? delete l[e] : d.setRequestHeader(e, t)
                }), t.withCredentials && (d.withCredentials = !0), t.responseType) try {
                d.responseType = t.responseType
            } catch (e) {
                if ("json" !== t.responseType) throw e
            }
            "function" == typeof t.onDownloadProgress && d.addEventListener("progress", t.onDownloadProgress), "function" == typeof t.onUploadProgress && d.upload && d.upload.addEventListener("progress", t.onUploadProgress), t.cancelToken && t.cancelToken.promise.then(function(t) {
                d && (d.abort(), p(t), d = null)
            }), void 0 === f && (f = null), d.send(f)
        })
    }
}, function(t, e, n) {
    "use strict";
    var o = n(16);
    t.exports = function(t, e, n, r, i) {
        var a = Error(t);
        return o(a, e, n, r, i)
    }
}, function(t) {
    "use strict";
    t.exports = function(t) {
        return !(!t || !t.__CANCEL__)
    }
}, function(t) {
    "use strict";

    function e(t) {
        this.message = t
    }
    e.prototype.toString = function() {
        return "Cancel" + (this.message ? ": " + this.message : "")
    }, e.prototype.__CANCEL__ = !0, t.exports = e
}, , , function(t, e, n) {
    t.exports = n(11)
}, function(t, e, n) {
    "use strict";

    function o(t) {
        var e = new a(t),
            n = i(a.prototype.request, e);
        return r.extend(n, a.prototype, e), r.extend(n, e), n
    }
    var r = n(0),
        i = n(3),
        a = n(13),
        s = n(2),
        c = o(s);
    c.Axios = a, c.create = function(t) {
        return o(r.merge(s, t))
    }, c.Cancel = n(7), c.CancelToken = n(27), c.isCancel = n(6), c.all = function(t) {
        return Promise.all(t)
    }, c.spread = n(28), t.exports = c, t.exports.default = c
}, function(t) {
    function e(t) {
        return !!t.constructor && "function" == typeof t.constructor.isBuffer && t.constructor.isBuffer(t)
    }

    function n(t) {
        return "function" == typeof t.readFloatLE && "function" == typeof t.slice && e(t.slice(0, 0))
    }
    t.exports = function(t) {
        return null != t && (e(t) || n(t) || !!t._isBuffer)
    }
}, function(t, e, n) {
    "use strict";

    function o(t) {
        this.defaults = t, this.interceptors = {
            request: new a,
            response: new a
        }
    }
    var r = n(2),
        i = n(0),
        a = n(22),
        s = n(23);
    o.prototype.request = function(t) {
        "string" == typeof t && (t = i.merge({
            url: arguments[0]
        }, arguments[1])), t = i.merge(r, {
            method: "get"
        }, this.defaults, t), t.method = t.method.toLowerCase();
        var e = [s, void 0],
            n = Promise.resolve(t);
        for (this.interceptors.request.forEach(function(t) {
                e.unshift(t.fulfilled, t.rejected)
            }), this.interceptors.response.forEach(function(t) {
                e.push(t.fulfilled, t.rejected)
            }); e.length;) n = n.then(e.shift(), e.shift());
        return n
    }, i.forEach(["delete", "get", "head", "options"], function(t) {
        o.prototype[t] = function(e, n) {
            return this.request(i.merge(n || {}, {
                method: t,
                url: e
            }))
        }
    }), i.forEach(["post", "put", "patch"], function(t) {
        o.prototype[t] = function(e, n, o) {
            return this.request(i.merge(o || {}, {
                method: t,
                url: e,
                data: n
            }))
        }
    }), t.exports = o
}, function(t, e, n) {
    "use strict";
    var o = n(0);
    t.exports = function(t, e) {
        o.forEach(t, function(n, o) {
            o !== e && o.toUpperCase() === e.toUpperCase() && (t[e] = n, delete t[o])
        })
    }
}, function(t, e, n) {
    "use strict";
    var o = n(5);
    t.exports = function(t, e, n) {
        var r = n.config.validateStatus;
        n.status && r && !r(n.status) ? e(o("Request failed with status code " + n.status, n.config, null, n.request, n)) : t(n)
    }
}, function(t) {
    "use strict";
    t.exports = function(t, e, n, o, r) {
        return t.config = e, n && (t.code = n), t.request = o, t.response = r, t
    }
}, function(t, e, n) {
    "use strict";

    function o(t) {
        return encodeURIComponent(t).replace(/%40/gi, "@").replace(/%3A/gi, ":").replace(/%24/g, "$").replace(/%2C/gi, ",").replace(/%20/g, "+").replace(/%5B/gi, "[").replace(/%5D/gi, "]")
    }
    var r = n(0);
    t.exports = function(t, e, n) {
        if (!e) return t;
        var i;
        if (n) i = n(e);
        else if (r.isURLSearchParams(e)) i = "" + e;
        else {
            var a = [];
            r.forEach(e, function(t, e) {
                null !== t && void 0 !== t && (r.isArray(t) ? e += "[]" : t = [t], r.forEach(t, function(t) {
                    r.isDate(t) ? t = t.toISOString() : r.isObject(t) && (t = JSON.stringify(t)), a.push(o(e) + "=" + o(t))
                }))
            }), i = a.join("&")
        }
        return i && (t += (-1 === t.indexOf("?") ? "?" : "&") + i), t
    }
}, function(t, e, n) {
    "use strict";
    var o = n(0),
        r = ["age", "authorization", "content-length", "content-type", "etag", "expires", "from", "host", "if-modified-since", "if-unmodified-since", "last-modified", "location", "max-forwards", "proxy-authorization", "referer", "retry-after", "user-agent"];
    t.exports = function(t) {
        var e, n, i, a = {};
        return t ? (o.forEach(t.split("\n"), function(t) {
            if (i = t.indexOf(":"), e = o.trim(t.substr(0, i)).toLowerCase(), n = o.trim(t.substr(i + 1)), e) {
                if (a[e] && r.indexOf(e) >= 0) return;
                a[e] = "set-cookie" === e ? (a[e] ? a[e] : []).concat([n]) : a[e] ? a[e] + ", " + n : n
            }
        }), a) : a
    }
}, function(t, e, n) {
    "use strict";
    var o = n(0);
    t.exports = o.isStandardBrowserEnv() ? function() {
        function t(t) {
            var e = t;
            return n && (r.setAttribute("href", e), e = r.href), r.setAttribute("href", e), {
                href: r.href,
                protocol: r.protocol ? r.protocol.replace(/:$/, "") : "",
                host: r.host,
                search: r.search ? r.search.replace(/^\?/, "") : "",
                hash: r.hash ? r.hash.replace(/^#/, "") : "",
                hostname: r.hostname,
                port: r.port,
                pathname: "/" === r.pathname.charAt(0) ? r.pathname : "/" + r.pathname
            }
        }
        var e, n = /(msie|trident)/i.test(navigator.userAgent),
            r = document.createElement("a");
        return e = t(window.location.href),
            function(n) {
                var r = o.isString(n) ? t(n) : n;
                return r.protocol === e.protocol && r.host === e.host
            }
    }() : function() {
        return function() {
            return !0
        }
    }()
}, function(t) {
    "use strict";

    function e() {
        this.message = "String contains an invalid character"
    }

    function n(t) {
        for (var n, r, i = t + "", a = "", s = 0, c = o; i.charAt(0 | s) || (c = "=", s % 1); a += c.charAt(63 & n >> 8 - s % 1 * 8)) {
            if ((r = i.charCodeAt(s += .75)) > 255) throw new e;
            n = n << 8 | r
        }
        return a
    }
    var o = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    e.prototype = Error(), e.prototype.code = 5, e.prototype.name = "InvalidCharacterError", t.exports = n
}, function(t, e, n) {
    "use strict";
    var o = n(0);
    t.exports = o.isStandardBrowserEnv() ? function() {
        return {
            write: function(t, e, n, r, i, a) {
                var s = [];
                s.push(t + "=" + encodeURIComponent(e)), o.isNumber(n) && s.push("expires=" + new Date(n).toGMTString()), o.isString(r) && s.push("path=" + r), o.isString(i) && s.push("domain=" + i), !0 === a && s.push("secure"), document.cookie = s.join("; ")
            },
            read: function(t) {
                var e = document.cookie.match(RegExp("(^|;\\s*)(" + t + ")=([^;]*)"));
                return e ? decodeURIComponent(e[3]) : null
            },
            remove: function(t) {
                this.write(t, "", Date.now() - 864e5)
            }
        }
    }() : function() {
        return {
            write: function() {},
            read: function() {
                return null
            },
            remove: function() {}
        }
    }()
}, function(t, e, n) {
    "use strict";

    function o() {
        this.handlers = []
    }
    var r = n(0);
    o.prototype.use = function(t, e) {
        return this.handlers.push({
            fulfilled: t,
            rejected: e
        }), this.handlers.length - 1
    }, o.prototype.eject = function(t) {
        this.handlers[t] && (this.handlers[t] = null)
    }, o.prototype.forEach = function(t) {
        r.forEach(this.handlers, function(e) {
            null !== e && t(e)
        })
    }, t.exports = o
}, function(t, e, n) {
    "use strict";

    function o(t) {
        t.cancelToken && t.cancelToken.throwIfRequested()
    }
    var r = n(0),
        i = n(24),
        a = n(6),
        s = n(2),
        c = n(25),
        u = n(26);
    t.exports = function(t) {
        return o(t), t.baseURL && !c(t.url) && (t.url = u(t.baseURL, t.url)), t.headers = t.headers || {}, t.data = i(t.data, t.headers, t.transformRequest), t.headers = r.merge(t.headers.common || {}, t.headers[t.method] || {}, t.headers || {}), r.forEach(["delete", "get", "head", "post", "put", "patch", "common"], function(e) {
            delete t.headers[e]
        }), (t.adapter || s.adapter)(t).then(function(e) {
            return o(t), e.data = i(e.data, e.headers, t.transformResponse), e
        }, function(e) {
            return a(e) || (o(t), e && e.response && (e.response.data = i(e.response.data, e.response.headers, t.transformResponse))), Promise.reject(e)
        })
    }
}, function(t, e, n) {
    "use strict";
    var o = n(0);
    t.exports = function(t, e, n) {
        return o.forEach(n, function(n) {
            t = n(t, e)
        }), t
    }
}, function(t) {
    "use strict";
    t.exports = function(t) {
        return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(t)
    }
}, function(t) {
    "use strict";
    t.exports = function(t, e) {
        return e ? t.replace(/\/+$/, "") + "/" + e.replace(/^\/+/, "") : t
    }
}, function(t, e, n) {
    "use strict";

    function o(t) {
        if ("function" != typeof t) throw new TypeError("executor must be a function.");
        var e;
        this.promise = new Promise(function(t) {
            e = t
        });
        var n = this;
        t(function(t) {
            n.reason || (n.reason = new r(t), e(n.reason))
        })
    }
    var r = n(7);
    o.prototype.throwIfRequested = function() {
        if (this.reason) throw this.reason
    }, o.source = function() {
        var t;
        return {
            token: new o(function(e) {
                t = e
            }),
            cancel: t
        }
    }, t.exports = o
}, function(t) {
    "use strict";
    t.exports = function(t) {
        return function(e) {
            return t.apply(null, e)
        }
    }
}, function(t, e, n) {
    "use strict";
    n.d(e, "e", function() {
        return o
    }), n.d(e, "c", function() {
        return r
    }), n.d(e, "g", function() {
        return i
    }), n.d(e, "h", function() {
        return a
    }), n.d(e, "d", function() {
        return s
    }), n.d(e, "b", function() {
        return c
    }), n.d(e, "f", function() {
        return u
    }), n.d(e, "a", function() {
        return p
    });
    var o = {
            position: "fixed",
            bottom: "20px",
            right: "20px",
            zIndex: 2147483647,
            borderRadius: "5px",
            boxSizing: "content-box",
            boxShadow: "0px 0px 20px rgba(0, 0, 0, 0.2)",
            overflow: "hidden"
        },
        r = {
            position: "fixed",
            bottom: "0px",
            right: "0px",
            zIndex: 2147483647,
            minWidth: "400px",
            boxSizing: "content-box",
            overflow: "hidden",
            minHeight: "120px"
        },
        i = {
            position: "fixed",
            bottom: "0px",
            right: "0px",
            zIndex: 2147483647,
            minWidth: "400px",
            boxSizing: "content-box",
            overflow: "hidden",
            minHeight: "120px"
        },
        a = {
            position: "fixed",
            top: 0,
            right: 0,
            bottom: 0,
            left: 0,
            zIndex: 2147483647,
            width: "100%",
            height: "100%",
            overflowY: "visible",
            boxSizing: "content-box"
        },
        s = {
            height: "40px",
            lineHeight: "30px",
            fontSize: "20px",
            display: "flex",
            justifyContent: "space-between",
            padding: "5px 0 5px 20px",
            fontFamily: "Lato, sans-serif",
            color: "#fff",
            cursor: "pointer",
            boxSizing: "content-box",
            mozBoxSizing: "content-box",
            webkitBoxSizing: "content-box"
        },
        c = {
            display: "flex",
            justifyContent: "center",
            position: "absolute",
            top: "38px",
            right: "20px",
            height: "60px",
            width: "60px",
            border: 0,
            borderRadius: "50%",
            boxShadow: "0px 0px 20px rgba(0, 0, 0, 0.2)"
        },
        u = {
            display: "block",
            position: "absolute",
            top: "46px",
            right: "20px",
            height: "52px",
            width: "52px",
            border: 0,
            borderRadius: "50%",
            boxShadow: "0px 0px 20px rgba(0, 0, 0, 0.2)"
        },
        p = {
            width: "100%",
            height: "auto",
            borderRadius: "999px"
        }
}, function(t, e, n) {
    "use strict";

    function o(t, e) {
        void 0 === e && (e = ""), t = t.replace(/[[]/, "\\[").replace(/[]]/, "\\]");
        var n = RegExp("[\\?&]" + t + "=([^&#]*)"),
            o = n.exec(document.getElementById("botmanWidget").getAttribute("src"));
        return null === o ? e : decodeURIComponent(o[1].replace(/\+/g, " "))
    }

    function r() {
        var t = document.createElement("div");
        t.id = "botmanWidgetRoot", document.getElementsByTagName("body")[0].appendChild(t);
        var e = {};
        try {
            e = JSON.parse(o("settings", "{}"))
        } catch (t) {}
        var n = window.botmanWidget || {},
            r = c({}, s.a, e, n),
            u = r.frameEndpoint;
        Object(i.c)(Object(i.b)(a.a, {
            isMobile: 500 > window.screen.width,
            iFrameSrc: u,
            conf: r
        }), t)
    }
    Object.defineProperty(e, "__esModule", {
        value: !0
    });
    var i = n(1),
        a = n(31),
        s = n(37),
        c = this && this.__assign || Object.assign || function(t) {
            for (var e, n = 1, o = arguments.length; o > n; n++) {
                e = arguments[n];
                for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r])
            }
            return t
        };
    window.attachEvent ? window.attachEvent("onload", r) : window.addEventListener("load", r, !1)
}, function(t, e, n) {
    "use strict";
    var o = n(10),
        r = n.n(o),
        i = n(1),
        a = n(32),
        s = n(33),
        c = n(34),
        u = n(35),
        p = n(36),
        f = n(29),
        l = this && this.__extends || function() {
            var t = Object.setPrototypeOf || {
                __proto__: []
            }
            instanceof Array && function(t, e) {
                t.__proto__ = e
            } || function(t, e) {
                for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n])
            };
            return function(e, n) {
                function o() {
                    this.constructor = e
                }
                t(e, n), e.prototype = null === n ? Object.create(n) : (o.prototype = n.prototype, new o)
            }
        }(),
        d = this && this.__assign || Object.assign || function(t) {
            for (var e, n = 1, o = arguments.length; o > n; n++) {
                e = arguments[n];
                for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r])
            }
            return t
        };
    e.a = function(t) {
        function e() {
            var e = t.call(this) || this;
            return e.toggle = function() {
                var t = {
                    pristine: !1,
                    isChatOpen: !e.state.isChatOpen,
                    wasChatOpened: e.state.wasChatOpened
                };
                e.state.isChatOpen || e.state.wasChatOpened || (e.props.conf.sendWidgetOpenedEvent && setTimeout(function() {
                    e.sendOpenEvent()
                }, 500), t.wasChatOpened = !0), e.setState(t)
            }, e.state.isChatOpen = !1, e.state.pristine = !0, e.state.wasChatOpened = !1, e
        }
        return l(e, t), e.prototype.componentDidMount = function() {
            window.botmanChatWidget = new p.a(this)
        }, e.prototype.render = function(t, e) {
            var n = t.conf,
                o = t.isMobile,
                r = e.isChatOpen,
                p = e.pristine,
                l = {
                    width: o ? n.mobileWidth : n.desktopWidth
                },
                h = window.innerHeight - 100 < n.desktopHeight ? window.innerHeight - 90 : n.desktopHeight;
            n.wrapperHeight = h;
            var m;
            return m = r || !o && !n.alwaysUseFloatingButton ? o ? f.h : (r || this.state.wasChatOpened) && r ? d({}, f.e, l) : d({}, f.c) : d({}, f.g), Object(i.b)("div", {
                style: m
            }, !o && !n.alwaysUseFloatingButton || r ? (r || this.state.wasChatOpened) && r ? Object(i.b)("div", {
                style: d({
                    background: n.mainColor
                }, f.d),
                onClick: this.toggle
            }, Object(i.b)("div", {
                style: {
                    display: "flex",
                    alignItems: "center",
                    padding: "0px 30px 0px 0px",
                    fontSize: "15px",
                    fontWeight: "normal",
                    color: n.headerTextColor
                }
            }, n.title), Object(i.b)(u.a, {
                isOpened: r
            })) : Object(i.b)(c.a, {
                onClick: this.toggle,
                conf: n
            }) : Object(i.b)(s.a, {
                onClick: this.toggle,
                conf: n
            }), Object(i.b)("div", {
                key: "chatframe",
                style: {
                    display: r ? "block" : "none",
                    height: o ? n.mobileHeight : h
                }
            }, p ? null : Object(i.b)(a.a, d({}, this.props))))
        }, e.prototype.open = function() {
            this.setState({
                pristine: !1,
                isChatOpen: !0,
                wasChatOpened: !0
            })
        }, e.prototype.close = function() {
            this.setState({
                pristine: !1,
                isChatOpen: !1
            })
        }, e.prototype.sendOpenEvent = function() {
            var t = new FormData;
            t.append("driver", "web"), t.append("eventName", "widgetOpened"), t.append("eventData", this.props.conf.widgetOpenedEventData), r.a.post(this.props.conf.chatServer, t).then(function(t) {
                (t.data.messages || []).forEach(function(t) {
                    window.botmanChatWidget.writeToMessages(t)
                })
            })
        }, e
    }(i.a)
}, function(t, e, n) {
    "use strict";
    var o = n(1),
        r = this && this.__extends || function() {
            var t = Object.setPrototypeOf || {
                __proto__: []
            }
            instanceof Array && function(t, e) {
                t.__proto__ = e
            } || function(t, e) {
                for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n])
            };
            return function(e, n) {
                function o() {
                    this.constructor = e
                }
                t(e, n), e.prototype = null === n ? Object.create(n) : (o.prototype = n.prototype, new o)
            }
        }(),
        i = this && this.__assign || Object.assign || function(t) {
            for (var e, n = 1, o = arguments.length; o > n; n++) {
                e = arguments[n];
                for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r])
            }
            return t
        };
    e.a = function(t) {
        function e() {
            return null !== t && t.apply(this, arguments) || this
        }
        return r(e, t), e.prototype.shouldComponentUpdate = function() {
            return !1
        }, e.prototype.render = function(t) {
            var e = t.iFrameSrc,
                n = t.isMobile,
                r = t.conf,
                a = window.botmanWidget || {},
                s = encodeURIComponent(JSON.stringify(i({}, r, a)));
            return Object(o.b)("iframe", {
                id: "chatBotManFrame",
                src: e + "?conf=" + s,
                width: "100%",
                height: n ? "94%" : "100%",
                frameBorder: "0",
                allowTransparency: !0,
                style: "background-color:transparent"
            })
        }, e
    }(o.a)
}, function(t, e, n) {
    "use strict";
    var o = n(1),
        r = n(29),
        i = this && this.__extends || function() {
            var t = Object.setPrototypeOf || {
                __proto__: []
            }
            instanceof Array && function(t, e) {
                t.__proto__ = e
            } || function(t, e) {
                for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n])
            };
            return function(e, n) {
                function o() {
                    this.constructor = e
                }
                t(e, n), e.prototype = null === n ? Object.create(n) : (o.prototype = n.prototype, new o)
            }
        }(),
        a = this && this.__assign || Object.assign || function(t) {
            for (var e, n = 1, o = arguments.length; o > n; n++) {
                e = arguments[n];
                for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r])
            }
            return t
        };
    e.a = function(t) {
        function e() {
            return null !== t && t.apply(this, arguments) || this
        }
        return i(e, t), e.prototype.render = function(t) {
            var e = t.conf;
            return Object(o.b)("div", {
                style: {
                    position: "relative",
                    cursor: "pointer"
                },
                onClick: this.props.onClick
            }, Object(o.b)("div", {
                className: "mobile-closed-message-avatar",
                style: a({
                    background: e.bubbleBackground
                }, r.f)
            }, "" === e.bubbleAvatarUrl ? Object(o.b)("svg", {
                style: {
                    paddingTop: 4
                },
                fill: "#FFFFFF",
                height: "24",
                viewBox: "0 0 24 24",
                width: "24",
                xmlns: "http://www.w3.org/2000/svg"
            }, Object(o.b)("path", {
                d: "M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 9h12v2H6V9zm8 5H6v-2h8v2zm4-6H6V6h12v2z"
            }), Object(o.b)("path", {
                d: "M0 0h24v24H0z",
                fill: "none"
            })) : -1 !== e.bubbleAvatarUrl.indexOf("/") ? Object(o.b)("img", {
                src: e.bubbleAvatarUrl,
                style: a({}, r.a)
            }) : Object(o.b)("div", {
                style: {
                    display: "flex",
                    alignItems: "center"
                }
            }, Object(o.b)("br", null), e.bubbleAvatarUrl)))
        }, e
    }(o.a)
}, function(t, e, n) {
    "use strict";
    var o = n(1),
        r = n(29),
        i = this && this.__extends || function() {
            var t = Object.setPrototypeOf || {
                __proto__: []
            }
            instanceof Array && function(t, e) {
                t.__proto__ = e
            } || function(t, e) {
                for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n])
            };
            return function(e, n) {
                function o() {
                    this.constructor = e
                }
                t(e, n), e.prototype = null === n ? Object.create(n) : (o.prototype = n.prototype, new o)
            }
        }(),
        a = this && this.__assign || Object.assign || function(t) {
            for (var e, n = 1, o = arguments.length; o > n; n++) {
                e = arguments[n];
                for (var r in e) Object.prototype.hasOwnProperty.call(e, r) && (t[r] = e[r])
            }
            return t
        };
    e.a = function(t) {
        function e() {
            return null !== t && t.apply(this, arguments) || this
        }
        return i(e, t), e.prototype.render = function(t) {
            var e = t.conf;
            return Object(o.b)("div", {
                style: {
                    position: "relative",
                    cursor: "pointer"
                },
                onClick: this.props.onClick
            }, Object(o.b)("div", {
                className: "desktop-closed-message-avatar",
                style: a({
                    background: e.bubbleBackground
                }, r.b)
            }, "" === e.bubbleAvatarUrl ? Object(o.b)("svg", {
                style: {
                    width: "60%",
                    height: "auto"
                },
                width: "1792",
                height: "1792",
                viewBox: "0 0 1792 1792",
                xmlns: "http://www.w3.org/2000/svg"
            }, Object(o.b)("path", {
                d: "M1664 1504v-768q-32 36-69 66-268 206-426 338-51 43-83 67t-86.5 48.5-102.5 24.5h-2q-48 0-102.5-24.5t-86.5-48.5-83-67q-158-132-426-338-37-30-69-66v768q0 13 9.5 22.5t22.5 9.5h1472q13 0 22.5-9.5t9.5-22.5zm0-1051v-24.5l-.5-13-3-12.5-5.5-9-9-7.5-14-2.5h-1472q-13 0-22.5 9.5t-9.5 22.5q0 168 147 284 193 152 401 317 6 5 35 29.5t46 37.5 44.5 31.5 50.5 27.5 43 9h2q20 0 43-9t50.5-27.5 44.5-31.5 46-37.5 35-29.5q208-165 401-317 54-43 100.5-115.5t46.5-131.5zm128-37v1088q0 66-47 113t-113 47h-1472q-66 0-113-47t-47-113v-1088q0-66 47-113t113-47h1472q66 0 113 47t47 113z",
                fill: "#fff"
            })) : -1 !== e.bubbleAvatarUrl.indexOf("/") ? Object(o.b)("img", {
                src: e.bubbleAvatarUrl,
                style: a({}, r.a)
            }) : Object(o.b)("div", {
                style: {
                    display: "flex",
                    alignItems: "center"
                }
            }, Object(o.b)("br", null), e.bubbleAvatarUrl)))
        }, e
    }(o.a)
}, function(t, e, n) {
    "use strict";
    var o = n(1),
        r = this && this.__extends || function() {
            var t = Object.setPrototypeOf || {
                __proto__: []
            }
            instanceof Array && function(t, e) {
                t.__proto__ = e
            } || function(t, e) {
                for (var n in e) e.hasOwnProperty(n) && (t[n] = e[n])
            };
            return function(e, n) {
                function o() {
                    this.constructor = e
                }
                t(e, n), e.prototype = null === n ? Object.create(n) : (o.prototype = n.prototype, new o)
            }
        }();
    e.a = function(t) {
        function e() {
            return null !== t && t.apply(this, arguments) || this
        }
        return r(e, t), e.prototype.render = function(t) {
            var e = t.isOpened;
            return Object(o.b)("div", null, e ? Object(o.b)("svg", {
                style: {
                    marginRight: 15,
                    marginTop: 6,
                    verticalAlign: "middle"
                },
                fill: "#FFFFFF",
                height: "15",
                viewBox: "0 0 15 15",
                width: "15",
                xmlns: "http://www.w3.org/2000/svg"
            }, Object(o.b)("line", {
                x1: "1",
                y1: "15",
                x2: "15",
                y2: "1",
                stroke: "white",
                "stroke-width": "1"
            }), Object(o.b)("line", {
                x1: "1",
                y1: "1",
                x2: "15",
                y2: "15",
                stroke: "white",
                "stroke-width": "1"
            })) : Object(o.b)("svg", {
                style: {
                    marginRight: 15,
                    marginTop: 6,
                    verticalAlign: "middle"
                },
                fill: "#FFFFFF",
                height: "24",
                viewBox: "0 0 24 24",
                width: "24",
                xmlns: "http://www.w3.org/2000/svg"
            }, Object(o.b)("path", {
                d: "M2.582 13.891c-0.272 0.268-0.709 0.268-0.979 0s-0.271-0.701 0-0.969l7.908-7.83c0.27-0.268 0.707-0.268 0.979 0l7.908 7.83c0.27 0.268 0.27 0.701 0 0.969s-0.709 0.268-0.978 0l-7.42-7.141-7.418 7.141z"
            })))
        }, e
    }(o.a)
}, function(t, e) {
    "use strict";
    e.a = function() {
        function t(t) {
            this.widget = t
        }
        return t.prototype.open = function() {
            this.widget.open()
        }, t.prototype.close = function() {
            this.widget.close()
        }, t.prototype.toggle = function() {
            this.widget.toggle()
        }, t.prototype.isOpen = function() {
            return !0 === this.widget.state.isChatOpen
        }, t.prototype.callChatWidget = function(t) {
            if (this.isOpen()) document.getElementById("chatBotManFrame").contentWindow.postMessage(t, "*");
            else try {
                this.open(), setTimeout(function() {
                    document.getElementById("chatBotManFrame").contentWindow.postMessage(t, "*")
                }, 750)
            } catch (t) {}
        }, t.prototype.writeToMessages = function(t) {
            this.callChatWidget({
                method: "writeToMessages",
                params: [t]
            })
        }, t.prototype.sayAsBot = function(t) {
            this.callChatWidget({
                method: "sayAsBot",
                params: [t]
            })
        }, t.prototype.say = function(t) {
            this.callChatWidget({
                method: "say",
                params: [t]
            })
        }, t.prototype.whisper = function(t) {
            this.callChatWidget({
                method: "whisper",
                params: [t]
            })
        }, t
    }()
}, function(t, e, n) {
    "use strict";
    n.d(e, "a", function() {
        return o
    });
    var o = {
        chatServer: "/botman",
        frameEndpoint: "/botman/chat",
        timeFormat: "HH:MM",
        dateTimeFormat: "m/d/yy HH:MM",
        title: "GoHundred Chat Room",
        cookieValidInDays: 1,
        introMessage: "",
        placeholderText: "Send a message...",
        displayMessageTime: !0,
        sendWidgetOpenedEvent: !1,
        widgetOpenedEventData: "",
        mainColor: "#408591",
        headerTextColor: "#333",
        bubbleBackground: "#408591",
        bubbleAvatarUrl: "",
        desktopHeight: 450,
        desktopWidth: 370,
        mobileHeight: "100%",
        mobileWidth: "300px",
        videoHeight: 160,
        aboutLink: "https://botman.io",
        aboutText: "⚡ Powered by BotMan",
        chatId: "",
        userId: "",
        alwaysUseFloatingButton: !1
    }
}]);
