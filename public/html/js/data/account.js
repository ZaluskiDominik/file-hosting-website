'use strict'

let account = {
	init : function()
	{
		this.upload.get();
		this.download.get();
	},

	//constraints for uploading files for this user
	//null means that there is no constraint
	upload : {
		//max file size in bytes that can be uploaded
		maxFileSize : 1 * GB,
		//max size of all files uploaded by this user
		//(it include files already uploaded by this user on server side)
		maxStorageSize : 10 * GB,
		//max number of files that can be uploaded at once
		maxNum : 10,

		//fetches from server upload constraints for user's account type
		get()
		{
			$.get(API_PATH + '/user/constraints/upload/get.php')
			.done( (json) => {
				this.maxFileSize = json.maxFileSize;
				this.maxStorageSize = json.maxStorageSize;
				this.maxNum = json.maxNum;

				//display in navbar how much bytes are used from upload storage
				navbar.updateStorageSpaceUsage();
			})
			.fail( (xhr) => {
				console.log(xhr.responseText);
			});
		}
	},

	//constraints for downloading files for this user
	//null means that there is no constraint
	download : {
		//max speed Kb/s
		maxSpeed : 200,
		//max number of downloads during maxNumDuration seconds period
		maxNum : 1,
		maxNumDuration : 60 * 3600,

		//fetches from server download constraints for user's account type
		get()
		{
			$.get(API_PATH + '/user/constraints/download/get.php')
			.done( (json) => {
				this.maxSpeed = json.maxSpeed;
				this.maxNum = json.maxNum;
				this.maxNumDuration = json.maxNumDuration;
			})
			.fail( (xhr) => {
				console.log(xhr.responseText);
			});
		}
	}
};

account.init();