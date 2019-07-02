'use strict';

let loginWnd = {
	//reference to ModalWindow object that creates window
	wnd : null,

	init : function()
	{
		this.initWnd();
		this.initLoginSubmitEvent();
	},

	//inits login window and inits login btn click event that opens that window
	initWnd : function()
	{
		this.wnd = new ModalWindow( $(".loginWnd"), $("nav").find(".loginBtn")[0] );
	},

	//inits callback to submitting login form
	initLoginSubmitEvent : function()
	{
		$("#loginSubmitBtn").click( (e) => {
			e.preventDefault();

			if ($("#email")[0].checkValidity())
				this.validateCredentials();
		});
	},

	//sends ajax requst checking if entered credentials are valid
	//if yes then ser will be redirected to login script
	//if no error will be displayed
	validateCredentials : function()
	{
		$.post(API_PATH + '/user/login/validate.php', 
			$(".loginWnd form").serialize())
		.done( (json) => {
			//if user with typed credentials was found
			if (json.valid)
				this.proceedLogin();
			else
				this.displayWrongCredentialsMsg();
		})
		.fail(request.fail.bind(request));
	},

	//displays error message that login or password is incorrect
	displayWrongCredentialsMsg : function()
	{
		$("#loginErr").html("Nieprawidłowy login lub hasło!");
	},

	//redirects to login php script
	proceedLogin : function()
	{
		$(".loginWnd form").submit();
	}
};

$(document).ready( () => {
	loginWnd.init();
});