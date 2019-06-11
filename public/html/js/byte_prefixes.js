//storage capacity prefixes
const KB = 1024;
const MB = KB * 1024;
const GB = MB * 1024;

//changes size given in bytes to size in KB, MB or GB so that there won't be 0 before comma
//returns that that calculated size with prefix B, KB, MB or GB
function getChangedBytes(size)
{
	let pref = ['B', 'KB', 'MB', 'GB'];
	for (var i = 0; i < 3 && size >= 1 ; i++)
		size /= 1024;

	if (size < 1)
	{
		i--;
		size *= 1024;
	}

	return size + ' ' + pref[i];
}