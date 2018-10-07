'use strict';

class UploadWindow extends ModalWindow
{
	constructor(wnd, bcg)
	{
		super(wnd, bcg);
		// this.requestUserAccountInfo();
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

	//opens an alert with info about state of uploaded files(errors or succes)
	openStatusAlert(alertType, msg)
	{
		//remove previous arert if it existed
		this.closeStatusAlert();
		//create object responsible for showing upload's status alert after upload is done
		let statusAlert = new Alert( $("#uploadStatus")[0], alertType, msg  + 
			"<br/><b>Przesłanych plików: " + this.numSuccessFiles + "/" + this.numSentFiles + "</b>" );
		statusAlert.open();
	}

	//clsoes upload status alert
	closeStatusAlert()
	{
		$("#uploadStatus").children().remove();
	}

	//add a log about uploaded file(success or error and type of error) inside div with upload logs
	addLog(alertType, msg)
	{
		let statusAlert = new Alert( $("#uploadLogs")[0], alertType, msg );
		statusAlert.open();	
	}

	//remove all logs inside uploadLogs
	clearLogs()
	{
		$("#uploadLogs").children().remove();
	}

	//returns the number of currently being uploaded files
	getNumActiveUploads()
	{
		return $("#uploadInput").fileupload("active");
	}

	//initialize  jquery upload plugin, set all callbacks
	initUploadPlugin()
	{
		let _self = this;

		$("#uploadInput").fileupload({
			dataType : "json",
			//id of the div when files can be dragged over and dropped 
			dropZone : "#dropFilesArea",
			autoUpload : false,
			//list all files from one drop/browse in data var in callack functions
			singleFileUploads : false,

			//upload completed succesfully(no error http status code)
			done : function(e, data) {
				//retrieve object response and eventual errors
				let resp = data.jqXHR.responseJSON;
				let errors = resp.errors.perFile;

				//if all files were uploaded without any erorr
				if (resp.success)
				{
					//increase the number of succesfully uploaded files
					_self.numSuccessFiles += data.files.length;
					//display success alert
					_self.openStatusAlert("success", "Pliki zostały przesłane.");
					//add logs for each file informing about success
					for (let i = 0 ; i < errors.length ; i++)
					{
						_self.addLog("success", "Plik: " + resp.files[i].name + "<br/>Udało się przesłać plik." +
							"<br/>Link do pliku: <a target='_blank' href='" + resp.files[i].url + "'>" + 
							resp.files[i].url + "</a>");
					}
				}
				else
				{
					//some errors occured
					//if it was a global error(it concerns all files)
					if (resp.errors.global != "")
					{
						//display an alert with msg from server
						_self.openStatusAlert("danger", resp.errors.global);
					}
					else
					{
						//errors are concerning only sigle files
						//for each file display an alert with success or error message
						for (let i = 0 ; i < errors.length ; i++)
						{
							if (errors[i] == "")
							{
								//file was uploaded succesfully
								_self.numSuccessFiles++;
								_self.addLog("success", "Plik: " + resp.files[i].name + "<br/>Udało się przesłać plik." +
									"<br/>Link do pliku: <a target='_blank' href='" + resp.files[i].url + "'>" + 
									resp.files[i].url + "</a>");
							}
							else
								_self.addLog("warning", "Plik: " + resp.files[i].name + "<br/>" + errors[i]);
						}

						//display error upload status alert
						_self.openStatusAlert("danger", "Wystąpiły błędy podczas przesyłania plików." +
							" Sprawdź logi aby uzyskać więcej informacji.");
					}
				}
			},

			//upload failed(error http code returned)
			fail : function(e, data) {
				_self.openStatusAlert("alert-warning", 
					"Wystąpił nieznany błąd podczas przesyłania plików. Spróbuj jeszcze raz.");
			},

			//callback send always after upload was done or aborted
			always : function(e, data){
				//if all upload were completed
				if ( _self.getNumActiveUploads() - data.files.length <= 0 )
					$("#cancelUploadBtn").hide();
			},

			//files have been choosen
			add : function (e, data){
				//if there are no active uploads
				if ( !_self.getNumActiveUploads() )
				{
					//reset counter of sent files and counter of succesfully uploaded files
					_self.numSentFiles = 0;
					_self.numSuccessFiles = 0;
					//clear previous logs and status alert
					_self.closeStatusAlert();
					_self.clearLogs();
					//show cancel upload button
					$("#cancelUploadBtn").show();
				}

				_self.numSentFiles += data.files.length;
				data.submit();
			},

			//callback to files submition
			send : function(e, data){

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