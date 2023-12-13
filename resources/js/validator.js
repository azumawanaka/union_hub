jQuery(".form-service").validate({
    rules: {
        "service_type_id": {
            required: !0
        },
        "client_id": {
            required: !0
        },
        "name": {
            required: !0,
            minlength: 3
        },
    },
    messages: {
        "service_type_id": "Please select a service!",
        "client_id": "Please select a client for that service!",
        "name": {
            required: "Please enter a service name!",
            minlength: "Service name must consist of at least 3 characters"
        },
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
    },
});

jQuery(".form-event").validate({
    rules: {
        "name": {
            required: !0,
            minlength: 3
        },
        "description": {
            required: !0,
            minlength: 5
        },
        "start_end_date": {
            required: !0,
        },
        "category": {
            required:!0
        },
        "max_participants": {
            required: !0,
            min: 1
        }
    },
    messages: {
        "category": "Please select a category!",
        "start_end_date": "Please select a start & end date!",
        "name": {
            required: "Please enter a service name!",
            minlength: "Service name must consist of at least 3 characters"
        },
        "description": {
            required: "Please enter a description!",
            minlength: "Description must have atleast 5 minimum length"
        },
        "max_participants": {
            required: "Please enter desired participants number!",
            minlength: "Minimum number of participants must be at least 1."
        },
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
    },
});

$(".form-user").validate({
    rules: {
        "first_name": {
            required: true,
            minlength: 3
        },
        "gender": {
            required: true
        },
        "email": {
            required: true,
            email: true,
        },
        "password": {
            required: true,
            minlength: 6
        },
    },
    messages: {
        "first_name": {
            required: "Please enter a first name!",
            minlength: "First name must consist of at least 3 characters"
        },
        "gender": "Please select gender!",
        "email": {
            required: "Please enter an email address",
            email: "Please enter a valid email address",
        },
        "password": {
            required: "Please enter a password ",
            minlength: "Password must consist of at least 6 characters"
        },
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        jQuery(e).remove();
    },
});

$(".form-user-edit").validate({
    rules: {
        "first_name": {
            required: true,
            minlength: 3
        },
        "gender": {
            required: true
        },
        "email": {
            required: true,
            email: true,
        },
    },
    messages: {
        "first_name": {
            required: "Please enter a first name!",
            minlength: "First name must consist of at least 3 characters"
        },
        "last_name": {
            required: "Please enter a last name!",
            minlength: "Last name must consist of at least 3 characters"
        },
        "gender": "Please select gender!",
        "email": {
            required: "Please enter an email address",
            email: "Please enter a valid email address",
        },
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        jQuery(e).remove();
    },
});

$(".form-client").validate({
    rules: {
        "name": {
            required: true,
            minlength: 3
        },
        "email": {
            required: true,
            email: true,
        },
    },
    messages: {
        "name": {
            required: "Please enter a first name!",
            minlength: "First name must consist of at least 3 characters"
        },
        "email": {
            required: "Please enter an email address",
            email: "Please enter a valid email address",
        },
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        jQuery(e).remove();
    },
});
