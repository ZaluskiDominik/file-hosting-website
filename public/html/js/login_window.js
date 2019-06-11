'use strict';

let loginWnd = {
	//reference to ModalWindow object that creates window
	wnd : null,

	//inits login window and inits login btn click event that opens that window
	init()
	{
		this.wnd = new ModalWindow( $(".loginWnd"), $("nav").find(".loginBtn")[0] );
	}
};

$(document).ready( () => {
	//if user isn't logged in init login window
	if ( !user.isLoggedIn )
		loginWnd.init();
});