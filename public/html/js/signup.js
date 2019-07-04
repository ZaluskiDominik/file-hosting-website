'use strict'

let signup = {
    //inits signup btn click event and validation of inputs
    init : function()
    {
        this.initInputEvents();
        $("#signupBtn").click( (e) => {
            e.preventDefault();
            this.signupClicked();
        });
    },

    //init blur events for inputs in rsignup form
    //when blur occurs validate each input
    initInputEvents : function()
    {
        //valid format of email
        this.initInputBlurEvent($("#email")[0], this.validateEmail.bind(this));
        //name cannot contain white characters
        this.initInputBlurEvent($("#name")[0], this.notWhitespaces.bind(this));
        //surname cannot contain white characters
        this.initInputBlurEvent($("#surname")[0], this.notWhitespaces.bind(this));
        //password must be at least 8 characters
        this.initInputBlurEvent($("#password")[0], this.passwordValidation.bind(this));
        //password and confirm password fields must be the same
        this.initInputBlurEvent($("#confirmPassword")[0],
            this.confirmPasswordValidation.bind(this));
    },

    //registers handler for blur event for given input
    //validates if input's content is not empty
    initInputBlurEvent : function(input, handler)
    {
        input.onblur = () => {
            handler(input);
            //if handler validaton was passed check if input isn't empty
            if ( !$(input).hasClass("notValid") )
                this.notEmpty(input);
        };
    },

    //opens warning popover over given input field with given message
    openBadInputPopover : function(input, msg)
    {
        popover.open({
            target : input.parentNode,
            msg : msg,
            type : "warning",
            duration : 4000,
            alignV : "top",
            width : 300
        });
    },

    //adds notValid class to input(red border)
    setNotValidClass : function(input)
    {
        if ( !$(input).hasClass("notValid") )
            $(input).addClass("notValid");
    },

    //marks input field as not valid - validation of content not passed
    //opens warning popover with validation error message
    //changes color of border to red
    markNotValid : function(input, msg)
    {
        this.openBadInputPopover(input, msg);
        this.setNotValidClass(input);
    },

    //removes effects of markNotValid function
    clearNotValid : function(input)
    {
        $(input).removeClass("notValid");
    },

    validateEmail : function(input)
    {
        if (input.checkValidity())
            this.clearNotValid(input);
        else
            this.markNotValid(input, "Email jest niepoprawny");
    },

    //checks if input doesn't containt whitespaces
    //if whites is present marks input as invalid
    notWhitespaces : function(input)
    {
        if ( /\s+/.test($(input).val()) )
            this.markNotValid(input, "Pole nie może zawierać białych znaków");
        else
            this.clearNotValid(input);
    },

    //checks if input's content is not empty
    //if empty marks input as invalid
    notEmpty : function(input)
    {
        if ($(input).val().length == 0)
            this.markNotValid(input, "Pole nie może być puste");
        else
            this.clearNotValid(input);
    },

    //checks if password has at least 8 characters
    //if not mark as invalid
    passwordValidation : function(input)
    {
        //if less that 8 characters mark as invalid
        if ($(input).val().length < 8)
            this.markNotValid(input, "Hasło musi mieć co najmniej 8 znaków");
        else
        {
            //clear notValid class if exists
            this.clearNotValid(input);

            //if content of password and confirmPassword are the same
            //clear not valid
            if ($("#confirmPassword").val() == $(input).val())
                this.clearNotValid($("#confirmPassword")[0]);
        }
    },

    //check if password and confirm password are the same
    confirmPasswordValidation : function(input)
    {
        if ($(input).val() != $("#password").val())
            this.markNotValid(input, "Hasła muszą się zgadzać");
        else
            this.clearNotValid(input);
    },

    //returns true if all inputs contain valid content
    validate : function()
    {
        let passed = true;

        //for each input
        $("#signupFormWrapper input").each( function() {
            //trigger blur event
            $(this).blur();
            //if input has notValid class validation not passed
            passed = passed && !$(this).hasClass("notValid");
        });

        return passed;
    },

    //callback to signup btn click, submits form if validation passed
    signupClicked : function()
    {
        if (this.validate())
        {
            $.post($("#signupFormWrapper form").attr("action"),
                $("#signupFormWrapper form").serialize())
            .done( (json) => {
                if (json.emailInUse)
                {
                    $("#emailInUse").show();
                    this.setNotValidClass($("#email")[0]);
                }
                else
                    window.location = "index.php";
            })
            .fail( request.fail.bind(request) );
        }
    }
};

$(document).ready( () => {
    signup.init();
});