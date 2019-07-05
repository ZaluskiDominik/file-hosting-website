'use strict';

//object handling uploadBtn hover animation
let uploadBtn = {
	//whether mouse's cursor is over the upload button
	mouseIn : false,
	//number of currently animated border ring
	currRingNr : 0,
	timer : null,
	msTimeBetween : 300,

	//appears rings around upload button
	mouseInAnimation : function()
	{
		this.mouseIn = true;
		this.animation(1);
	},

	//disappears rings around upload button
	mouseOutAnimation : function()
	{
		this.mouseOut = false;
		this.animation(-1);
	},

	setInterval : function(callback)
	{
		if (this.timer !== null)
			clearInterval(this.timer);
		this.timer = setInterval(callback, this.msTimeBetween);
	},

	clearInterval : function()
	{
		clearInterval(this.timer);
		this.timer = null;
	},

	//when step is 1 appears next rings around upload btn
	//when step is -1 disappears them
	animation : function(step)
	{
		//array of next rings to be displayed
		let rings = [ $("#uploadBtn"), $("#uploadBtnRing1"), $("#uploadBtnRing2") ];
		//array of classes that actually disply rings, they match rings order
		let activeClasses = [ "activeUploadBtn", "activeUploadBtnRing1", 
			"activeUploadBtnRing2" ];

		let animationHelper = () => {
			//if ring index is out of range clear Interval and exit
			if ( this.currRingNr + step < 0 || this.currRingNr + step > 2 )
			{
				this.clearInterval();
				return;
			}

			let isActive = rings[this.currRingNr]
				.hasClass(activeClasses[this.currRingNr]);

			//advance in animation
			if ( (step == 1 && isActive) || (step == -1 && !isActive) )
				this.currRingNr += step;

			//if step is 1 then set current ring to active
			if ( step == 1 ) 
				rings[this.currRingNr].addClass( activeClasses[this.currRingNr] );
			else
				rings[this.currRingNr].removeClass( activeClasses[this.currRingNr] );
		};

		this.setInterval(animationHelper.bind(this));
	},

	//adds event listeners for mouseover and mouseleave event
	initMouseEvents : function()
	{
		$("#uploadBtn").on("mouseover", this.mouseInAnimation.bind(this));
		$("#uploadBtn").on("mouseleave", this.mouseOutAnimation.bind(this));
	}
};

$(document).ready( () => {

	uploadBtn.initMouseEvents();
});