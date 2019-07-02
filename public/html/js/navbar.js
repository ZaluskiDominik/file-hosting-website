'use strict'

let navbar = {
	//updates displayed stata how much giga bytes user uses from max storage size
	updateStorageSpaceUsage : function()
	{
		//max storage size in GB
		let maxSizeGB = Math.round(account.upload.maxStorageSize / GB, 2);
		$("#storageMaxSize").html(maxSizeGB);
		//size of files in GB uploaded by user
		let usedSizeGB = round(user.storageUsedSize / GB, 2);
		$("#storageUsedSize").html(usedSizeGB);
	}
};