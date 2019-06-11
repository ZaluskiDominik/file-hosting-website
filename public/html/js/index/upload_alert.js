'use strict';

//creates alert(success, warning or danger) with given message
class UploadAlert
{
	//type(warning, danger, success)
	//clientSide - true if displays alert about client side validation result
	constructor(parent, type, msg, closeCallback, clientValidation = false)
	{
		this.parent = parent;
		this.type = type;
		this.msg = msg;
		this.closeCallback = closeCallback;
		this.clientValidation = clientValidation;
	
		this.create();
	}

	//creates and displays alert
	create()
	{
		let alertTypeClass = this.type.substr(0, 1).toUpperCase() + 
			this.type.substr(1);

		this.alert = $("<div></div>")
			.addClass("alert alert-dismissible uploadAlert alert-" + this.type
				+ " uploadAlert" + alertTypeClass)
			//message
			.append( $("<span></span>").html(this.msg) )
			//close button
			.append( $("<button></button>")
				.click( this.closeCallback.bind(this) )
				.prop("tabindex", "-1")
				.attr("data-dismiss", "alert")
				.html("&times;")
		)[0];
		
		this.parent.prepend(this.alert);
	}

	//removes alert from DOM
	close()
	{
		this.alert.remove();
	}
}