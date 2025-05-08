import $ from 'jquery';
import 'jquery-validation';
window.$ = window.jQuery = $;
 //  admin login form
$("#admin_login_form").validate({
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

//admin chat box
$('#admin_chat_box').validate({
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

//admin create task form
$('#admin_create_task').validate({
    rules: {
        title: {
            required: true,
            minlength: 3
        },
        description: {
            required: true,
            minlength: 10
        },
        deadline: {
            required: true,
            date: true,
            min: function() {
                return new Date().toISOString().split('T')[0];
            }
        },
        'interns[]': {
            required: true
        }
    },
    messages: {
        title: {
            required: "Please enter a task title",
            minlength: "Title must be at least 3 characters"
        },
        description: {
            required: "Please provide a task description",
            minlength: "Description must be at least 10 characters"
        },
        deadline: {
            required: "Please set a deadline",
            date: "Please enter a valid date",
            min: "Deadline cannot be earlier than today"
        },
        'interns[]': {
            required: "Please select at least one intern"
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

//admin create task form
$('#admin_edit_task').validate({
    rules: {
        title: {
            required: true,
            minlength: 3
        },
        description: {
            required: true,
            minlength: 10
        },
        deadline: {
            required: true,
            date: true,
            min: function() {
                return new Date().toISOString().split('T')[0];
            }
        },
        'interns[]': {
            required: true
        }
    },
    messages: {
        title: {
            required: "Please enter a task title",
            minlength: "Title must be at least 3 characters"
        },
        description: {
            required: "Please provide a task description",
            minlength: "Description must be at least 10 characters"
        },
        deadline: {
            required: "Please set a deadline",
            date: "Please enter a valid date",
            min: "Deadline cannot be earlier than today"
        },
        'interns[]': {
            required: "Please select at least one intern"
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

//admin create intern form
$('#admin_create_intern').validate({
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
            required: "Please enter intern's name",
            minlength: "Name must be at least 2 characters"
        },
        email: {
            required: "Please enter an email address",
            email: "Please enter a valid email address"
        },
        password: {
            required: "Please provide a password",
            minlength: "Password must be at least 6 characters"
        },
        password_confirmation: {
            required: "Please confirm the password",
            equalTo: "Passwords do not match"
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

//admin edit intern form
$('#admin_edit_intern').validate({
    rules: {
        name: {
            required: true,
            minlength: 2
        },
        email: {
            required: true,
            email: true
        }
    },
    messages: {
        name: {
            required: "Please enter intern's name",
            minlength: "Name must be at least 2 characters"
        },
        email: {
            required: "Please enter an email address",
            email: "Please enter a valid email address"
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

$('#admin_create_role').validate({
    rules: {
        name: {
            required: true,
            minlength: 2
        },
        'permissions[]': {
            required: true
        }
    },
    messages: {
        name: {
            required: "Please enter a role name",
            minlength: "Role name must be at least 2 characters"
        },
        'permissions[]': {
            required: "Please select at least one permission"
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

$('#admin_edit_role').validate({
    rules: {
        name: {
            required: true,
            minlength: 2
        },
        'permissions[]': {
            required: true
        }
    },
    messages: {
        name: {
            required: "Please enter a role name",
            minlength: "Role name must be at least 2 characters"
        },
        'permissions[]': {
            required: "Please select at least one permission"
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

$('#admin_create_admin').validate({
    rules: {
        name: {
            required: true,
            minlength: 2
        },
        email: {
            required: true,
            email: true
        },
        role_id: {
            required: true
        },
        password: {
            required: function() {
                return !$('input[name="password"]').attr('value');
            },
            minlength: 6
        },
        password_confirmation: {
            required: function() {
                return $('input[name="password"]').val().length > 0;
            },
            equalTo: 'input[name="password"]'
        }
    },
    messages: {
        name: {
            required: "Please enter admin's name",
            minlength: "Name must be at least 2 characters"
        },
        email: {
            required: "Please enter an email address",
            email: "Please enter a valid email address"
        },
        role_id: {
            required: "Please select a role"
        },
        password: {
            required: "Please provide a password",
            minlength: "Password must be at least 6 characters"
        },
        password_confirmation: {
            required: "Please confirm the password",
            equalTo: "Passwords do not match"
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

$('#admin_edit_admin').validate({
    rules: {
        name: {
            required: true,
            minlength: 2
        },
        email: {
            required: true,
            email: true
        },
        role_id: {
            required: true
        },
        password: {
            minlength: 6
        },
        password_confirmation: {
            required: function() {
                return $('input[name="password"]').val().length > 0;
            },
            equalTo: 'input[name="password"]'
        }
    },
    messages: {
        name: {
            required: "Please enter admin's name",
            minlength: "Name must be at least 2 characters"
        },
        email: {
            required: "Please enter an email address",
            email: "Please enter a valid email address"
        },
        role_id: {
            required: "Please select a role"
        },
        password: {
            
            minlength: "Password must be at least 6 characters"
        },
        password_confirmation: {
            required: "Please confirm the password",
            equalTo: "Passwords do not match"
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
