"use strict";

jQuery(document).ready(function () {
	$("#slack-modal-button").on("click", function() {
        $("#kt_modal_4").modal("show");
    });
    $("#slack_campaign_select").on("click", function() {
        var campaign_id = $("#slack_campaign_select option:selected").val();
        $("#slack_campaign_id").val(campaign_id);
    });
});
