'use strict'

let user = {
	name : null,
	surname : null,
	email : null,
	accountType : 'guest',
	ip : null,
	storageUsedSize : 0,

	//fetches user's data from server
	get : function()
	{
		$.get(API_PATH + '/user/data/get.php')
		.done( (json) => {
			let user = json.user;
			this.name = user.name;
			this.surname = user.surname;
			this.email = user.email;
			this.accountType = user.name;
			this.ip = user.ip;
			this.storageUsedSize = user.storageUsedSize;

			//display in navbar how much bytes are used from upload storage
			navbar.updateStorageSpaceUsage();
		})
		.fail( request.fail.bind(request) );
	}
};

user.get();