<?php
require_once($phpPaths['PHP'] . '/db-connect.php');

class AccountData
{
	public function __construct(string $accountType)
	{
		$this->accountType = $accountType;
		$this->fetchAccountData();
	}	

	//returns array containing user's limit for downloading files
	/*[
		maxSpeed - Kb/s
		maxNum
	]
	*/
	public function getDownloadConstraints()
	{
		return $this->downloadConstraints;
	}

	//returns array containing user's limit for uploading files
	/*[
		maxFileSize - Bytes
		maxNum
		maxStorageSize - Bytes
	]
	*/
	public function getUploadConstraints()
	{
		return $this->uploadConstraints;
	}

	//PRIVATE SECTION

	private $accountType;
	private $downloadConstraints;
	private $uploadConstraints;

	//fetches account data to $downloadConstraints and $uploadConstraints arrays
	private function fetchAccountData()
	{
		$db = connectToDB();
		$stmt = $db->prepare("SELECT * FROM account_types WHERE name = ?");
		$stmt->execute([ $this->accountType ]);
		$data = $stmt->fetch();

		$this->formatDownloadConstraints($data);
		$this->formatUploadConstraints($data);
	}

	private function formatDownloadConstraints(array $accountStmt)
	{
		$this->downloadConstraints['maxSpeed'] = $accountStmt['max_download_speed'];
		$this->downloadConstraints['maxNum'] = $accountStmt['max_num_downloads'];
	}

	private function formatUploadConstraints(array $accountStmt)
	{
		$this->uploadConstraints['maxFileSize'] = 
			$accountStmt['max_upload_file_size'] * GB;
		
		$this->uploadConstraints['maxNum'] = $accountStmt['max_num_uploads'];
		
		$this->uploadConstraints['maxStorageSize'] = 
			$accountStmt['max_storage_size'] * GB;		
	}
}