'use strict';

class ModalWindow
{
	constructor(wnd, bcg)
	{
		//whether upload window is displayed
		this.opened = false;
		this.window = wnd;
		this.background = bcg;
	}

	//displays window if it's closed or hide it if it's opened
	openClose()
	{
		//open or close window
		if (this.opened)
			$(this.window).fadeOut(1000);
		else
			$(this.window).fadeIn(1000);

		//open or close background
		$(this.background).css( "display", (this.opened) ? "none" : "block" );
		//change opened state to opposite
		this.opened = !this.opened;
	}
}