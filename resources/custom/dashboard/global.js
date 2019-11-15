"use strict";

jQuery(document).ready(function () {
	$(".campaign-type").click(function () {
        $("#campaign-type").val($(this).attr('type'))
        console.log($(this).attr('type'))
        $("#link-tab2").click()
    });

    $(".btn--next").click(function () {
        $("#campaign-keyword").val($("#keyword").val());
        if($('#keyword').val() == '')
            return false;
        $('#link-tab3').click();
        console.log($("#keyword").val());
    });

    $(".notification-type").click(function (){
        $("#campaign-notification").val($(this).attr('type'))
        if($('#keyword').val() == '')
        {
            $("#link-tab2").click()
            return false;
        }
        $('#step-form').submit();
        console.log($(this).attr('type'));
    });
});