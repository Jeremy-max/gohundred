(function ($) {

    $(".campaign-type").click(function () {
        $("#campaign-type").val($(this).attr('type'))
        console.log($(this).attr('type'))
        $("#link-tab2").click()
    });

    $(".btn--next").click(function () {
        $("#campaign-keyword").val($("#keyword").val());
        $("#campaign-domain").val($("#domain").val());
        console.log($("#keyword").val());
        console.log($("#domain").val());
    });

    $(".notification-type").click(function (){
        $("#campaign-notification").val($(this).attr('type'))
        $("#step-form").submit();
        console.log($(this).attr('type'));
    });

    try {
        var $validator = $("#step-form").validate({
            rules: {
                username: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true,
                    minlength: 3
                },
                password: {
                    required: true,
                    minlength: 8
                },
                re_password: {
                    required: true,
                    minlength: 8,
                    equalTo: '#password'
                }
            },
            messages: {
                username: {
                    required: "Enter username"
                },
    
                email: {
                    required: "Enter your email",
    
                },
                password: {
                    required: "Enter password",
                    minlength: "Password must be >= 8 character"
                },
                re_password: {
                    required: "Please confirm your password",
                    minlength: "Password must has >= 8 character",
                    equalTo: "Password doesn't equal to the previous one"
                }
            }
        });
    
        $("#step-form").bootstrapWizard({
            'tabClass': 'nav nav-pills',
            'nextSelector': '.btn--next',
            'onNext': function(tab, navigation, index) {
                // if (index == 1) {
                //     var $valid = $("#step-form").valid();
                //     if (!$valid) {
                //         $validator.focusInvalid();
                //         return false;
                //     }
                // }
            },
            'onTabClick': function (tab, navigation, index) {
                // if (index == 1) {
                //     var $valid = $("#step-form").valid();
                //     if (!$valid) {
                //         $validator.focusInvalid();
                //         return false;
                //     }
                // }
            }
    
        });
    
    }
    catch (e) {
        console.log(e)
    }

})(jQuery);