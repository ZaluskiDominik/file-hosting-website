'use strict';

class UploadWindow extends ModalWindow
{
	constructor(wnd, bcg)
	{
		super(wnd, bcg);
	}

	openClose()
	{
		super.openClose();
		if (this.open)
			this.initUploadPlugin();
	}

	//user clicked start upload button
	onStartUploadClicked()
	{
		console.log("files: ", $("#uploadInput")[0].files);
	}

	initUploadPlugin()
	{
		$("#uploadInput").fileupload({
			dataType : "json",
			autoUpload : false,

			//upload completed
			done : function(e, data) {
				console.log("done", data);
			},

			//upload failed
			fail : function(e, data) {
				console.log("fail ", data);
			},

			//file has been choosen
			add : function (e, data){
				data.context = $("#startUploadBtn").click(function () {
                    data.submit();
                });
			},

			//progress tracking
			progressall: function (e, data) {
        		var progress = Math.round(data.loaded / data.total * 100, 10);
        		//increase progress bar value
        		$("#progressBar").css("width", progress + "%");
        		//set percentage progress
        		$("#progressPercentage").html(progress + "%");
    		}
		});
	}
}

//create instance of UploadWindow
let uploadWindow;
$(document).ready( () => {
	uploadWindow = new UploadWindow( $("#uploadWindow")[0], $("#uploadWindowBcg")[0] );

	//listen for form submition event
	$("#uploadWindow form").submit( (e) => {
		e.preventDefault();
		uploadWindow.onStartUploadClicked();
	});
})