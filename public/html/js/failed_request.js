'use strict'

let request = {
	//outputs to console response from XHR object and opens error popover
	fail : function(xhr)
	{
		console.log('AJAX ERROR ' + xhr.responseText);

		popover.open({
			type : "fatal",
			msg : "Wystąpił nieznany bład!"
		});
	}
};