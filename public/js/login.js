$(document).ready(function ()
 {
    $.validator.addMethod("strong", function(value, element) {
    return this.optional(element)
        || /[A-Z]/.test(value)
        && /[a-z]/.test(value)
        && /\d/.test(value)
        && /[\W_]/.test(value)
        && value.length >= 8;
}, "Password must be at least 8 characters and include uppercase, lowercase, number, and special character.");

    $('#loginform').validate({
        rules:{
            email:{
                required:true,
                email:true,
            },
            password:{
                required:true,
                minlength:6,
                // strong:true,
            }

        },
        messages:{
            email:{
                required:"Please Enter Your Registered Email",
                email:"Please Enter Valid Email Address",
            },
            password:{
                required:"Please Enter Your Password",
                // strong:"Please Enter At Least One Digit,Uppercase,Lowercase,Special Character",
                minlength:"Please Enter At Least 6 Character",
            }
        },
         errorElement: 'span',
        errorClass: 'text-danger',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        }
    });
});
