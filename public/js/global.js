"use strict";

jQuery(document).ready(function () {
	$(".campaign-type").click(function () {
        $("#campaign-type").val($(this).attr('type'))
        $("#link-tab2").click()
    });

    $("#plus-button-id").click(function (){
        if($("#keyword1").css('display') == 'none'){
            $("#keyword1").show();
            $("#minus-button-id1").show();
            $("#keyword1").prop('required',true);
        }
        else if($("#keyword2").css('display') == 'none'){
            $("#keyword2").show();
            $("#minus-button-id1").css('visibility','hidden');
            $("#minus-button-id2").show();
            $("#keyword2").prop('required',true);
        }
        else if($("#keyword3").css('display') == 'none'){
            $("#keyword3").show();
            $("#minus-button-id2").css('visibility','hidden');
            $("#minus-button-id3").show();
            $("#keyword3").prop('required',true);
        }
        else if($("#keyword4").css('display') == 'none'){
            $("#keyword4").show();
            $("#minus-button-id3").css('visibility','hidden');
            $("#minus-button-id4").show();
            $("#plus-button-id").css('visibility','hidden');
            $("#keyword4").prop('required',true);
        }
    });

    $("#minus-button-id1").click(function(){
        $("#keyword1").hide();
        $("#keyword1").val('');
        $("#minus-button-id1").hide();
        $("#keyword1").prop('required',false);
    });
    $("#minus-button-id2").click(function (){
        $("#keyword2").hide();
        $("#keyword2").val('');
        $("#minus-button-id1").css('visibility','visible');
        $("#minus-button-id2").hide();
        $("#keyword2").prop('required',false);
    });
    $("#minus-button-id3").click(function (){
        $("#keyword3").hide();
        $("#keyword3").val('');
        $("#minus-button-id2").css('visibility','visible');
        $("#minus-button-id3").hide();
        $("#keyword3").prop('required',false);
    });
    $("#minus-button-id4").click(function (){
        $("#keyword4").hide();
        $("#keyword4").val('');
        $("#minus-button-id3").css('visibility','visible');
        $("#minus-button-id4").hide();
        $("#plus-button-id").css('visibility','visible');
        $("#keyword4").prop('required',false);
    });

    // $(".btn--next").click(function () {
    //     $("#campaign-keyword").val($("#keyword").val());
    //     $("#campaign-keyword1").val($("#keyword1").val());
    //     $("#campaign-keyword2").val($("#keyword2").val());
    //     $("#campaign-keyword3").val($("#keyword3").val());
    //     $("#campaign-keyword4").val($("#keyword4").val());
    // });



    // $(".notification-type").click(function (){
    //     $("#campaign-notification").val($(this).attr('type'))
    //     if($('#keyword').val() == '')
    //     {
    //         $("#link-tab2").click()
    //         return false;
    //     }

    //     console.log($(this).attr('type'));
    // });
});
