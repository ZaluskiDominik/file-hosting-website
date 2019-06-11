'use strict';

class ModalWindow
{
	//wnd - html DOM reference to div
	//clickOpenerDOM - DOM reference to btn that after click opens window
	constructor(wnd, clickOpenerDOM)
	{
		this.wnd = wnd;
		
		this.setModalWndClass();
		this.createBackground();
		this.createCloseBtn();
		this.initOpenOnClickEvent(clickOpenerDOM);
	}

	//adds modalWindow class to wnd
	setModalWndClass()
	{
		if ( $(this.wnd).hasClass("modalWindow") === false )
			$(this.wnd).addClass("modalWindow");
	}

	//creates dark background for window
	createBackground()
	{
		this.bcg = $("<div></div>")
			.addClass("modalWindowBcg")
			.appendTo(document.body)[0];
	}

	//creates close button and inits its click event(hides window on close)
	createCloseBtn()
	{
		$("<button></button>")
			.addClass("modalWindowCloseBtn close")
			.append( $("<span></span>").html("&times;").attr("tabindex", -1) )
			.prependTo(this.wnd)
			.click( () => {
				$(this.wnd).fadeOut(1000);
				$(this.bcg).fadeOut(1000);
		});
	}

	//shows window on clickOpenerDOM click
	initOpenOnClickEvent(clickOpenerDOM)
	{
		$(clickOpenerDOM).click( () => {
			//show window
			$(this.wnd).hide().fadeIn(1000);
			//show window background
			$(this.bcg).hide().fadeIn(1000);
		});
	}
}