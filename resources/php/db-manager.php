<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/file_upload/resources/php/config.php');
require_once($phpPaths['PHP'] . "db-connect.php");
require_once($phpPaths['PHP'] . "get-ip-function.php");

//class for getting often required info from db
class DBManager
{
	public function __construct($userId)
	{
		$this->userId = $userId;
	}

	//returns associative array with info about account's type and limits
	public function getAccountInfo()
	{
		$conn = connectToDB();
		//if it's not registered user
		if ( $this->userId === null )
		{
			//guest account
			return $conn->query("SELECT * FROM account_types WHERE name = 'guest'")->fetch();
		}
		else
		{
			//user has an account
			$stmt = $conn->prepare("SELECT acc.* FROM account_types AS acc, users AS u INNER JOIN users 
				ON acc.id = u.account_type_id WHERE u.id = ?");
			$stmt->execute([ $this->userId ]);
			return $stmt->fetch();
		}
	}

	//returns associative array with user's data
	public function getUserData()
	{
		$conn = connectToDB();
		$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
		$stmt->execute([ $this->userId ]);
		return $stmt->fetch();
	}

	//return info about uploaded files of user with id $userId
	//if $userId is null, search after ip address of client
	public function getUserFiles()
	{
		$conn = connectToDB();
		if ($this->userId !== null)
		{
			//it's a logged in user
			$stmt = $conn->prepare("SELECT * FROM uploaded_files WHERE owner_id = ?");
			$stmt->execute([ $this->userId ]);
		}
		else
		{
			//search after ip
			$stmt = $conn->prepare("SELECT * FROM uploaded_files WHERE owner_ip = ?");
			$stmt->execute([ getClientIp() ]);
		}

		$files = [];
		while ( $row = $stmt->fetch() )
			$files[] = $row;

		return $files;
	}

	//returns total size of uploaded files that belongs to this user
	public function getUserStorageSize()
	{
		$totalSize = 0;
		$filesData = $this->getUserFiles();
		foreach ($filesData as $file)
		{
			if ( file_exists($file['path']) )
				$totalSize += filesize( $file['path'] );
		}

		return $totalSize;
	}
}
?>