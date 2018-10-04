'use strict';

class UploadWindow extends ModalWindow
{
	constructor(wnd, bcg)
	{
		super(wnd, bcg);
		this.requestUserAccountInfo();
		this.initUploadPlugin();
		this.initCancelBtn();
	}

	//send request to server in order to obtain informations about this user's account
	requestUserAccountInfo()
	{
		$.get(config.phpPath + "get-account-info.php").done( (resp) => {
			this.accountData = JSON.parse(resp);
		});
	}

	//setup cancel upload button
	initCancelBtn()
	{
		/*var jqXHR = $('#uploadInput').fileupload('send', {files: filesList})
    		.error(function (jqXHR, textStatus, errorThrown) {
       		 console.log(errorThrown);
    	});

    	$("#cancelUploadBtn").click( () => {
    		jqXHR.abort();
    	});*/
	}

	openStatusAlert(alertType, msg)
	{
		//remove previous arert if it existed
		this.closeStatusAlert();
		//create object responsible for showing upload's status alert after upload is done
		let statusAlert = new Alert( $("#uploadStatus")[0], alertType, msg  + 
			"<br/><b>Przesłanych plików: " + this.numSuccessFiles + "/" + this.numSentFiles + "</b>" );
		statusAlert.open();
	}

	closeStatusAlert()
	{
		$("#uploadStatus").children().remove();
	}

	addLog(alertType, msg)
	{
		let statusAlert = new Alert( $("#uploadLogs")[0], alertType, msg );
		statusAlert.open();	
	}

	clearLogs()
	{
		$("#uploadLogs").children().remove();
	}

	getNumActiveUploads()
	{
		return $("#uploadInput").fileupload("active");
	}

	initUploadPlugin()
	{
		let _self = this;

		$("#uploadInput").fileupload({
			dataType : "json",
			dropZone : "#dropFilesArea",
			autoUpload : false,
			singleFileUploads : false,

			//upload completed succesfully
			done : function(e, data) {
				let resp = data.jqXHR.responseJSON;
				if (resp.success)
				{
					_self.numSuccessFiles += data.files.length;
					_self.openStatusAlert("success", "Pliki zostały przesłane.");
					//show all logs
					let errors = resp.errors.perFile;
					for (let i = 0 ; i < errors.length ; i++)
					{
						//empty string indicates a success
						if (errors[i] == "")
							_self.addLog("success", "Plik: " + resp.files[i].name + "<br/>Udało się przesłać plik.");
						else
							_self.addLog("warning", "Plik: " + resp.files[i].name + "<br/>" + errors[i]);
					}
				}
				else
				{
					_self.openStatusAlert("danger", resp.errors.global);
				}
			},

			//upload failed(error http code returned)
			fail : function(e, data) {
				_self.openStatusAlert("alert-warning", 
					"Wystąpił nieznany błąd podczas przesyłania plików. Spróbuj jeszcze raz.");
			},

			//callback send always after upload was done or aborted
			always : function(e, data){
				//hide cancel upload button
				$("#cancelUploadBtn").hide();
			},

			//files have been choosen
			add : function (e, data){
				//if there are not active uploads reset counter of sent files and counter of succesfully uploaded files
				if ( !_self.getNumActiveUploads() )
				{
					_self.numSentFiles = 0;
					_self.numSuccessFiles = 0;
				}

				_self.numSentFiles += data.files.length;
				//remove previous status alert and logs
				_self.closeStatusAlert();
				data.submit();
			},

			//callback to files submition
			send : function(e, data){
				//show cancel upload button
				$("#cancelUploadBtn").show();
				//clear previous logs and status alert if there are no active uploads
				if ( !_self.getNumActiveUploads() )
				{
					_self.closeStatusAlert();
					_self.clearLogs();
				}
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
})

//prevent default behaviour of browser on drag and drop
$(document).bind('drop dragover', function (e) {
    e.preventDefault();
});