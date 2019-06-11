'use strict';

//object handling uploadBtn hover animation
let uploadBtn = {
	//whether mouse's cursor is over the upload button
	mouseIn : false,
	//number of currently animated border ring
	currRingNr : -1,
	timer : null,

	//appears rings around upload button
	mouseInAnimation : function()
	{
		this.mouseIn = true;
		this.currRingNr++;
		this.animation(1);
	},

	//disappears rings around upload button
	mouseOutAnimation : function()
	{
		this.mouseOut = false;
		this.currRingNr--;
		this.animation(-1);
	},

	//sets timeout after which next border ring will be activated/disactivated 
	setTimeout : function(callback)
	{
		if ( this.timer !== null )
			clearTimeout(this.timer);
		this.timer = setTimeout(callback.bind(this), 300)
	},

	//generic upload button animation(appears rings or disappears them)
	animation : function(step)
	{
		let divs = [ $("#uploadBtn"), $("#uploadBtnInnerOutline"), $("#uploadBtnOuterOutline") ];
		let activeClasses = [ "activeUploadBtn", "activeUploadBtnInnerOutline", "activeUploadBtnOuterOutline" ];

		let animationRecursion = () => {
			let index = this.currRingNr;
			//if index is out of range
			if ( index < 0 || index > 2 )
				return;

			//if step is is 1 then set current div to active
			if ( step == 1 ) 
				divs[index].addClass( activeClasses[index] );
			else
				divs[index].removeClass( activeClasses[index] );

			this.currRingNr += step;
			//set timer when next border will be triggered
			this.setTimeout(animationRecursion);
		};

		animationRecursion();
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