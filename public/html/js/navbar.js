'use strict'

let navbar = {
	//updates displayed stata how much giga bytes user uses from max storage size
	updateStorageSpaceUsage : function()
	{
		//max storage size in GB
		let maxSizeGB = Math.round(account.upload.maxStorageSize / GB, 2);
		$("#storageMaxSize").html(maxSizeGB);
		//size of files in GB uploaded by user
			let usedSizeGB = (Math.round(user.storageUsedSize / GB * 100) / 100)
			.toFixed(2);
		$("#storageUsedSize").html(usedSizeGB);

		//display used size and max size in KB within tooltip
		let maxSizeKB = Math.round(account.upload.maxStorageSize / KB, 0);		
		let usedSizeKB = Math.round(user.storageUsedSize / KB, 0);
		$("#storageInfo").attr('data-wenk', usedSizeKB + '/' + maxSizeKB + ' KB');
	}
};