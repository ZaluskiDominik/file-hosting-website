<?php
require_once($phpPaths['PHP'] . '/account-data.php');
require_once($phpPaths['PHP'] . '/user-data.php');
require_once($phpPaths['PHP'] . '/ip-retriever.php');

class UserStorage
{
	//constructs UserStrage instance for curren client
	public static function constructCurrentClient()
	{
		//is user is logged in call constructUserId function
		if ( isset($_SESSION['user']) )
			return static::constructUserId($_SESSION['user']['id']);

		//else create new instance of UserStorage
		$inst = new UserStorage();
		//get all client uploaded files by client ip address and sum their size
		$uploadedFiles = $inst->getUploadedFilesByUserIp();
		$inst->calcUsedSize($uploadedFiles);

		return $inst;
	}

	//constructs UserStrage instance for user with id $userId
	public static function constructUserId(int $userId)
	{
		//get sum of uploaded files by this user
		$inst = new UserStorage($userId);
		$uploadedFiles = $inst->getUploadedFilesByUserId();
		$inst->calcUsedSize($uploadedFiles);

		return $inst;
	}

	//returns total size of files uploaded by this users
	public function getUsedSize()
	{
		return $this->usedSize;
	}

	//returns max size that user's upload storage can reach
	public function getMaxSize()
	{
		return $this->totalSize;
	}

	//PRIATE SECTION

	private $userId;
	private $totalSize;
	private $usedSize;

	private function __construct($userId = null)
	{
		$this->userId = $userId;
		$this->fetchTotalSize();
	}

	//calculates sum of files' sizes from $uploadedFilesStmt array
	//$uploadedFilesStm - array containing files' pathes
	private function calcUsedSize(array $uploadedFilesStmt)
	{
		$usedSize = 0;

		foreach ($uploadedFilesStmt as $upload)
		{
			if ( file_exists($upload['path']) )
				$usedSize += filesize($upload['path']);
		}

		$this->usedSize = $usedSize;
	}

	//fetches to $totalSize max size of user's upload storage
	private function fetchTotalSize()
	{
		$user = UserData::constructCurrentClient();
		$account = new AccountData($user->get()['accountType']);
		$this->totalSize = $account->getUploadConstraints()['maxStorageSize'];
	}

	//returns paths of all uploaded files by this user based on user's id
	private function getUploadedFilesByUserId()
	{
		$db = connectToDB();
		$stmt = $db->prepare("SELECT path FROM uploaded_files
			WHERE owner_id = ?");
		$stmt->execute([ $this->userId ]);

		return $stmt->fetchAll();
	}

	//returns paths of all uploaded files by this user based on user's ip adddres
	private function getUploadedFilesByUserIp()
	{
		$clientIp = getClientIp();

		$db = connectToDB();
		$stmt = $db->prepare("SELECT path FROM uploaded_files
			WHERE owner_ip = ?");
		$stmt->execute([ $clientIp ]);

		return $stmt->fetchAll();
	}
}