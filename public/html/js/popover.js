'use strict';

let popover = {
	//array of living instances of PopOver class
	instances : [],

	//displays new popover according to passed options
	/*options:
	msg - string, text to display
	type - one of ('success', 'warning', 'fatal')
	target - DOM node over which popover will be displayed
	alignH - one of ('left', 'center', 'right')
	alignV - one of ('top', 'bottom')
	duration - in miliseconds how long popover will be displayed
	dontOverride - boolean value, false if popover should be instantly closed when another 
					popover withe the same target is opened
	width - width of a popover, if null then width will automatically adjust to content
	gapV - vertical translation in outside direction from target
	*/
	open : function(options)
	{
		let newInst = new PopOver(options, this.close.bind(this));
		this.instances.push(newInst);

		for (let i = 0 ; i < this.instances.length ; i++)
		{
			if ( this.instances[i] !== newInst
				&& this.instances[i].options.dontOverride === false
				&& this.instances[i].options.target === newInst.options.target )
			{
				this.close(this.instances[i--]);
			}
		}
	},

	close : function(instance)
	{
		$(instance.div).remove();
		this.instances.splice(this.instances.indexOf(instance), 1);
	}
};

class PopOver
{
	constructor(options, closeCallback)
	{
		this.options = options;
		this.closeCallback = closeCallback;
		this.fillDefault();
		this.create();
	}

	//if one of options properties wasn't give set it to default value
	fillDefault()
	{
		for (let prop in PopOver.defaultOptions)
			if ( typeof(this.options[prop]) === "undefined" )
				this.options[prop] = PopOver.defaultOptions[prop];
	}

	//create popover div
	create()
	{
		//create
		this.div = $("<div></div>")
			.html(this.options.msg)
			.addClass("popOver")[0];

		//apply options
		this.applyOptions();
		//append to DOM structure
		this.appendToTarget();
	}

	//apply specified options parameters to this popover
	applyOptions()
	{
		//target
		if (this.options.target === document.body)
			$(this.div).addClass("popOverTargetless");

		//msg
		$(this.div).html(this.options.msg);

		//type
		$(this.div).addClass(
			this.getClassName("popOver", this.options.type));

		//alignH
		$(this.div).addClass(
			this.getClassName("popOverAlign", this.options.alignH));

		//alignV
		$(this.div).css(this.options.alignV, 
			(-this.options.height - this.options.gapV) + "px");

		//width
		if (this.options.width !== null)
			$(this.div).css("width", this.options.width + "px");

		//height
		$(this.div).css("height", this.options.height + "px");
	}

	getClassName(basePart, optionVal)
	{
		return basePart + optionVal.slice(0, 1).toUpperCase()
			+ optionVal.slice(1);
	}

	//appends popover to target in DOM
	appendToTarget()
	{
		//if position of target is static change it to relative
		if ( $(this.options.target).css("position") == "static" )
			$(this.options.target).css("position", "relative");

		//append to DOM
		$(this.options.target).append(this.div);
		$(this.div).fadeIn(500)
			.delay(this.options.duration)
			.fadeOut(500, () => { this.closeCallback(this); });
	}
}

//object with default options properties to open function
//if options argument passed in open function don't contain a property
//then value of that property will be set to default value from defaultOptions object

$(document).ready( () => {
	PopOver.defaultOptions = {
		msg : "",
		type : "success",
		target : document.body,
		alignH : "center",
		alignV : "top",
		duration : 5000,
		dontOverride : false,
		width : null,
		height : 34,
		gapV : 10
	};
});
