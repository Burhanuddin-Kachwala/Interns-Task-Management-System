import $ from 'jquery';
import 'jquery-validation';
window.$ = window.jQuery = $;

$(document).ready(function () {
    //  intern registration form
    $("#intern_register_form").validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        messages: {
            name: {
                required: "Please enter your name.",
                minlength: "Name must be at least 2 characters."
            },
            email: {
                required: "Please enter your email.",
                email: "Enter a valid email address."
            },
            password: {
                required: "Please provide a password.",
                minlength: "Password must be at least 6 characters."
            },
            password_confirmation: {
                required: "Please confirm your password.",
                equalTo: "Passwords do not match."
            }
        },
        errorElement: 'p',
        errorClass: 'text-red-500 text-sm mt-1',
        highlight: function (element) {
            $(element).addClass('border-red-500');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-500');
        }
    });

    //  intern login form
    $("#intern_login_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "Please enter your email.",
                email: "Enter a valid email address."
            },
            password: {
                required: "Please provide a password.",
                minlength: "Password must be at least 6 characters."
            }
        },
        errorElement: 'p',
        errorClass: 'text-red-500 text-sm mt-1',
        highlight: function (element) {
            $(element).addClass('border-red-500');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-500');
        }
    });

    //intern comment form
    $("#intern_comment_form").validate({
        rules: {
            comment: {
                required: true,
                minlength: 2
            }
        },
        messages: {
            comment: {
                required: "Please enter your comment.",
                minlength: "Comment must be at least 2 characters."
            }
        },
        errorElement: 'p',
        errorClass: 'text-red-500 text-sm mt-1',
        highlight: function (element) {
            $(element).addClass('border-red-500');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-500');
        }
    });
    //intern chat box
    $('#intern_chat_box').validate({
        rules:{
            message:{
                required:true,
                minlength:2
            }
        },
        messages:{
            message:{
                required:"Please enter your message.",
                minlength:"Message must be at least 2 characters."
            }
        },
        errorElement: 'p',
        errorClass: 'text-red-500 text-sm mt-1',
        highlight: function (element) {
            $(element).addClass('border-red-500');
        },
        unhighlight: function (element) {
            $(element).removeClass('border-red-500');
        }
    })
});

