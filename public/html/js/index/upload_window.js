'use strict';

let uploadWnd = {
	//DOM reference to upload window
	wnd : null,
	//array of added alerts to upload logs div
	alerts : [],
	//array with files object from server response after uploads
	//keeps track of succesfully uploaded files
	uploadedFiles : [],
	//number of files that were sent to upload(succesfully uploaded + uploaded
	//wit errors)
	numSentFiles : 0,

	//inits upload window and upload plugin
	init()
	{
		this.alerts = [];
		this.uploadedFiles = [];
		this.numSentFiles = 0;
		this.initWindow();
		this.initUploadPlugin();
		this.initUploadResultsSwitch();
	},

	//inits window
	initWindow : function()
	{
		this.wnd = new ModalWindow($("#uploadWindow")[0], $("#uploadBtn"));
	},

	//adds click events for btns for switching between upload logs and links to
	//uploaded files
	//initially selects uploadLogs btn as active 
	initUploadResultsSwitch : function()
	{
		//switch to logs on click
		$("#uploadLogsBtn").click( () => {
			this.switchResultsDiv("uploadLogs", "uploadLogsBtn");
		});

		//switch to download links on click
		$("#uploadLinksBtn").click( () => {
			this.switchResultsDiv("uploadedFileLinks", "uploadLinksBtn");
		});

		this.switchResultsDiv("uploadLogs", "uploadLogsBtn");
	},

	//displays div with given ID inside uploadResults and hides rest of them
	switchResultsDiv : function(displayedDivId, activeBtnId)
	{
		$("#uploadResults").children("div").hide();
		$("#" + displayedDivId).show();

		this.selectSwitchBtn(activeBtnId);
	},

	selectSwitchBtn : function(btnId)
	{
		//remove selected class from previously selected switch btn		
		$("#uploadSwitchResults").children("button")
			.removeClass("uploadSelectedSwitch");
		//select new btn		
		$("#" + btnId).addClass("uploadSelectedSwitch");
	},

	//returns the number of currently uploaded files
	getNumActiveUploads : function()
	{
		return $("#uploadInput").fileupload("active");
	},

	//adds upload alert to logs
	addAlert : function(type, msg, clientValidation = false)
	{
		let alert = new UploadAlert($("#uploadLogs")[0], 
			type, msg, () => {
				//remove alert from alerts list on close btn click
				this.alerts.splice(this.alerts.indexOf(alert), 1);
		}, clientValidation);

		this.alerts.push(alert);
	},

	//opens popover window above uploadResults div with given message
	openUploadStatusPopover(type, msg)
	{
		popover.open({
			target: $("#progress")[0],		
			alignV : "bottom",
			type : type,
			msg : msg
		});
	},

	//removes all alerts that were added cause of client side uplaod validation
	removeClientValidationAlerts : function()
	{
		for (let i = this.alerts.length - 1 ; i >= 0 ; i--)
		{
			if (this.alerts[i].clientValidation)
			{
				this.alerts[i].close();
				this.alerts.splice(i, 1);
			}
		}
	},

	//initialize jquery upload plugin, set all callbacks
	initUploadPlugin : function()
	{
		let _self = this;

		$("#uploadInput").fileupload({
			dataType : "json",
			//id of the div when files can be dragged over and dropped 
			dropZone : "#dropFilesArea",
			autoUpload : true,
			//list all files from one drop/browse in data var in callack functions
			singleFileUploads : false,

			//upload completed succesfully(no error http status code)
			done : (e, data) => { _self.successUpload(data.jqXHR.responseJSON); },

			//upload failed(error http code returned)
			fail : (e, data) => { _self.failedUpload(data.jqXHR, data); },

			//callback send always after upload was done or aborted
			always : function(e, data){
				//display info about how many files were uploaded with success
				_self.displayNumSuccessUploads();
				//show switch between upload logs and download link to uploaded
				//files
				$("#uploadSwitchResults").css("visibility", "visible");
			},

			//files have been choosen by browse or drag and drop action.lengh
			add : (e, data) => { _self.addedFiles(data); },

			//progress tracking
			progressall: function (e, data) {
        		let progress = Math.round(data.loaded / data.total * 100, 10);
        		//increase progress bar value
        		$("#progressBar").css("width", progress + "%");
        		//set percentage progress
        		$("#progressPercentage").html(progress + "%");
    		}
		});
	},

	//returns type of alert based on value file.errorId returned by server response
	//after upload
	getAlertTypeByFileUploadResp : function(file)
	{
		switch (file.errorId)
		{
		//file uploaded sucesfully
		case 0:
			return "success";
		//file didn't match constraints
		case 1:
			return "warning";
		//error occured
		default:
			return "danger";
		}
	},

	//returns alert message based on value file.errorId returned by server response
	//after upload
	getAlertMsgByFileUploadResp : function(file)
	{
		switch (file.errorId)
		{
		case 0:
			return "Przesłano plik<b> " + file.clientName + "</b>";
		default:
			return "Plik <b>" + file.clientName + "</b>: " + file.errorMsg;
		}
	},

	//returns true if all files were uploaded without error
	//respJson - response returned from server after upload was done
	filesUploadedWithoutErrors : function(respJson)
	{
		respJson.forEach( (file) => {
			//if errorId != 0 then error occered or upload constraint
			//wasn't matched by a file
			if (file.errorId)
				return false;
		});

		return true;
	},

	//callback to end of upload with 200 http code returned
	successUpload : function(respJson)
	{
		//foreach response to sent file add alert with information about
		//success, error, or not match upload constraints
		respJson.forEach( (file) => {
			//add alert
			this.addAlert( this.getAlertTypeByFileUploadResp(file),
				this.getAlertMsgByFileUploadResp(file) );
			//if file was uploaded without any error add it to array with
			//uploaded files and display download link in links section
			if ( !file.errorId )
			{
				this.uploadedFiles.push(file);
				this.addDownloadLink(file);
			}
		});

		//open success or warning popover depending on whether all files were
		//uploaded succesfully
		this.handleUploadDonePopover(respJson);

		//refetch storage used space by user and display it within navbar
		user.get();
	},

	//display information in uploadResultsTitle how much files were uploaded
	//and how much with success
	displayNumSuccessUploads : function()
	{
		$("#uploadResultsTitle").html("Udało się przesłać<b> " + 
			this.uploadedFiles.length
			+ "</b> plików z <b>" +
			this.numSentFiles + "</b>");
	},

	//adds download link for uploaded file to links section
	addDownloadLink : function(file)
	{
		let link = DOWNLOAD_PAGE_URL + file.serverName;
		
		$("<div></div>").addClass("downloadLinkRow")
			.append( $("<span></span>").html(file.clientName) )
			.append( $("<a></a>")
						.html(link)
						.attr("href", link)
						.attr("target", "_blank")
			)
			.appendTo( $("#uploadedFileLinks") );
	},

	//opens popover with information about wheter files were uploaded without
	//any error
	//called when upload retuned 200 http code
	handleUploadDonePopover : function(respJson)
	{
		//if all files were succesfully uploaded display popover success message
		if (this.filesUploadedWithoutErrors(respJson))
			this.openUploadStatusPopover("success", "Pliki zostały przesłane");
		else
		{
			//error occured or one of upload constraints wasn't matched 
			this.openUploadStatusPopover("warning", 
				"Wystąpiły błędy podczas przesyłania plików");
		}
	},

	//callback to error occurance while uploading files
	failedUpload : function(xhr, data)
	{
		request.fail(xhr);
		//open popover with information about error
		this.openUploadStatusPopover("fatal", "Nie udało się przesłać plików");
		//add logs for each file that unknown error occered
		data.files.forEach( (file) => {
			this.addAlert("danger", "Plik <b>" + file.name
				+ "</b>: Wystąpił nieznany błąd");			
		})
	},

	//callback to browse files or drag & drop files by user
	addedFiles : function(data)
	{
		//clear logs from client validation logs
		this.removeClientValidationAlerts();

		//don't start upload if one of files didn't pass validation
		if ( !this.validateFiles(data.files) )
			return;

		//increase counter of sent files and submit them to upload
		this.numSentFiles += data.files.length;
		data.submit();
	},

	//returns true if all files match upload constraints
	//if not warning alert will be added to upload logs and popover
	//informing about not matched constraints will be displayed
	validateFiles : function(files)
	{
		return ( this.validateMaxNumUploads(files) 
				&& this.validateMaxStorageSize(files)
				&& this.validateMaxFileSize(files) );
	},

	//returns true if each file's size is less that the max file size
	validateMaxFileSize : function(files)
	{
		let exceeded = false;
		//message to display in case of exceed file size limit
		let maxSizeMsg = "Przekroczono maksymalny rozmiar pliku " +
			round(account.upload.maxFileSize / GB, 0) + "GB";

		files.forEach( (file) => {
			//if file size was exceeded
			if (file.size > account.upload.maxFileSize)
			{
				exceeded = true;
				//add alert to upload logs
				this.addAlert("warning", "Plik <b>" + file.name + 
					"</b>: " + maxSizeMsg, true);
			}
		});

		//open warning popover if at least one file exceeded max file size
		if (exceeded)
		{
			console.log("warn");
			this.openUploadStatusPopover("warning", maxSizeMsg);
		}

		return !exceeded;
	},

	//returns true if files won't exceed max storage size of this user
	//after upload
	validateMaxStorageSize : function(files)
	{
		//sum file sizes
		let sumSize = 0;
		files.forEach( (file) => { sumSize += file.size; });

		//available storage space for use
		let freeSpace = ( account.upload.maxStorageSize * GB ) 
			- user.storageUsedSize;

		//if sum of files sizes to upload + already used storage space by the user
		//exceed the limit open warning popover
		if (sumSize > freeSpace)
		{
			this.openUploadStatusPopover("warning", "Brakuje miejsca na dysku."
				+ " Pozostało " + round(freeSpace / GB, 2) + "GB");
			return false;
		}

		return true;
	},

	//returns true if number of files don't exceed the limit
	validateMaxNumUploads : function(files)
	{
		if (files.length > account.upload.maxNum)
		{
			this.openUploadStatusPopover("warning", "Maksymalnie możesz"
				+ " przesłać " + account.upload.maxNum + " plików naraz");
			return false;
		}

		return true;
	}
};

$(document).ready( () => {
	uploadWnd.init();
});

//prevent default behaviour of browser on drag and drop
$(document).bind('drop dragover', function (e) {
    e.preventDefault();
});