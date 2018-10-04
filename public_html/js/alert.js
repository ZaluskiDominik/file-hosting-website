'use strict';

//class for creating bootstrap alert with an icon inside a parent div 
class Alert
{
	//type(warning, danger, success)
	constructor(parent, type, msg)
	{
		this.parent = parent;
		this.type = type;
		this.msg = msg;
	}

	//creates and displays alert
	open()
	{
		let attr = this.getAttributesByType();

		$(this.parent).append( $("<div></div>")
		.addClass("alert alert-dismissible " + attr.alertClass)
		//icon
		.append( $("<span></span>")
			.addClass(attr.iconClass + " alertIcon mr-1")
			.html(attr.icon)
			)
		//message
		.append( $("<span></span>")
			.html(this.msg)
			)
		//close button
		.append( $("<button></button>")
			.prop("tabindex", "-1")
			.addClass("close")
			.attr("data-dismiss", "alert")
			.html("&times;")
			)
		);
	}

	//returns differnet classes and content needed to create an alert of given type
	getAttributesByType()
	{
		switch(this.type)
		{
			case "success":
				return { alertClass : "alert-success", iconClass : "successIcon", icon : "&#10003;" };
			case "warning":
				return { alertClass : "alert-warning", iconClass : "warningIcon", icon : "&#9888;" };
			default:
				return { alertClass : "alert-danger", iconClass : "dangerIcon", icon : "X" };
		}
	}
}