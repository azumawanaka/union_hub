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
        "rate": {
            required: !0,
            numberOrFloat: true
        }
    },
    messages: {
        "service_type_id": "Please select a service!",
        "client_id": "Please select a client for this service.",
        "name": {
            required: "Please enter a name for this service.",
            minlength: "Service name must consist of at least 3 characters."
        },
        "rate": {
            required: "Please select a rate for this service.",
            numberOrFloat: "Please enter a valid number or float for this service."
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

jQuery.validator.addMethod("numberOrFloat", function(value, element) {
   // Check for leading zeros in the integer part
   let hasLeadingZeros = /^0+/.test(value);

   // Remove leading zeros from the integer part
   let cleanedValue = value.replace(/^0+/, '');

   // Use a regular expression to check if the cleaned value is a number or a float
   let isValidNumberOrFloat = /^-?\d+\.?\d*$/.test(cleanedValue);

   return !hasLeadingZeros && isValidNumberOrFloat;
}, "Please enter a valid number or float.");


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
        // "email": {
        //     required: true,
        //     email: true,
        // },
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
        // "email": {
        //     required: "Please enter an email address",
        //     email: "Please enter a valid email address",
        // },
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

$.validator.addMethod(
    "phoneValidation",
    function(value, element) {
      // Define a regular expression for both regular telephone and cell phone numbers
      const phoneRegex = /^(\+?\d{12}|\d{11})$/;

      // Check if the phone number matches the regular expression
      return this.optional(element) || phoneRegex.test(value);
    },
    "Please enter a valid phone number."
);

$(".form-profile").validate({
    rules: {
      "first_name": {
        required: true,
        minlength: 3
      },
      "mobile": {
        phoneValidation: true  // Use the custom phoneValidation method
      }
    },
    messages: {
      "first_name": {
        required: "Please enter a first name!",
        minlength: "First name must consist of at least 3 characters"
      },
      "mobile": {
        phoneValidation: "Please enter a valid phone number."
      }
    },
    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
      jQuery(a).parents(".form-group > div").append(e);
    },
    highlight: function(e) {
      jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
    },
    success: function(e) {
      jQuery(e).closest(".form-group").removeClass("is-invalid");
      jQuery(e).remove();
    },
});

$(".form-password").validate({
    rules: {
        "old_password": {
            required: true,
            minlength: 6,
            remote: {
                url: "/check-old-password",
                type: "post",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    old_password: function() {
                        return $("#old_password").val();
                    },
                    user_id: function () {
                        return $("#user_id").val();
                    }
                }
            }
        },
        "new_password": {
            required: true,
            minlength: 6,
            notEqualTo: "#old_password",
            containsSpecialChar: true,
            containsNumber: true
        }
    },
    messages: {
        "old_password": {
            required: "Please enter your old password!",
            minlength: "Password must consist of at least 6 characters",
            remote: "Incorrect old password"
        },
        "new_password": {
            required: "Please enter your new password!",
            minlength: "Password must consist of at least 6 characters",
            notEqualTo: "New password must be different from old password",
            containsSpecialChar: "Password must contain at least one special character",
            containsNumber: "Password must contain at least one number"
        }
    },
    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function(e, a) {
        jQuery(a).parents(".form-group > div").append(e);
    },
    highlight: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid");
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        jQuery(e).remove();
    },
});

// Custom validation method for notEqualTo
$.validator.addMethod("notEqualTo", function(value, element, param) {
    return value !== $(param).val();
}, "Please choose a different value.");

// Custom validation method for containing special character
$.validator.addMethod("containsSpecialChar", function(value) {
    return /[!@#$%^&*(),.?":{}|<>]/.test(value);
}, "Password must contain at least one special character");

// Custom validation method for containing number
$.validator.addMethod("containsNumber", function(value) {
    return /\d/.test(value);
}, "Password must contain at least one number");

$("#service_requests_form").validate({
    rules: {
        "preferred_date_time": {
            required: true,
        },
        "location": {
            required: true,
        },
        "details": {
            required: true,
        },
    },
    messages: {
        "preferred_date_time": {
            required: "Please enter a your preferred date and time."
        },
        "location": {
            required: "Please enter a your preferred location."
        },
        "details": {
            required: "Please enter a important details about your requests."
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

$.validator.addMethod("safeDescription", function(value, element) {
    // Define your blacklist patterns here
    var blacklist = [
        /<script/i,
        /<iframe/i,
        /<object/i,
        /onload=/i,
        // Add more patterns if needed
    ];

    // Check if any of the patterns match the input value
    for (var i = 0; i < blacklist.length; i++) {
        if (blacklist[i].test(value)) {
            return false; // Found a match, return false to indicate invalid input
        }
    }

    return true; // No matches found, input is considered valid
}, "Description contains potentially harmful content.");

$("#report-form").validate({
    rules: {
        "category": {
            required: true,
        },
        "description": {
            required: true,
            minlength: 15,
            safeDescription: true,
        },
    },
    messages: {
        "category": {
            required: "Please select type of report.",
        },
        "description": {
            required: "Oops, you can't leave this empty.",
            minlength: "Description must be at least 15 characters long."
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
    unhighlight: function(element) {
        $(element).closest(".form-group").removeClass("is-invalid").addClass("is-valid");
    },
    success: function(e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid");
        jQuery(e).remove();
    },
});
