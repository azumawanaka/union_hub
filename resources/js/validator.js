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
