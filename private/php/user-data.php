<?php
require_once($phpPaths['PHP'] . '/db-connect.php');
require_once($phpPaths['PHP'] . '/ip-retriever.php');

class UserData
{
	//returns UserData instance constructed for current client
	public static function constructCurrentClient()
	{
		//if user is logged in call constructUserId
		if ( isset($_SESSION['user']) )
			return static::constructUserId($_SESSION['user']['id']);

		//else user is a guest
		$inst = new UserData();
		//guest has no data only ip
		$inst->userData = [
			'name' => null,
			'surname' => null,
			'email' => null,
			'accountType' => 'guest',
			'ip' => getClientIp()
		];

		return $inst;
	}

	//returns UserData instance constructed for user with given id
	public static function constructUserId(int $userId)
	{
		$inst = new UserData($userId);
		$inst->fetchData();

		return $inst;
	}

	//returns array containing user's data
	/*[
		name
		surname
		email
		ip
		accountType
	]
	*/
	public function get()
	{
		return $this->userData;
	}

	//PRIVATE SECTION

	private $userId;
	private $userData;

	private function __construct($userId = null)
	{
		$this->userId = $userId;
	}

	//fetched user's data to $userData array
	private function fetchData()
	{
		$db = connectToDB();
		$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
		$stmt->execute([ $this->userId ]);

		$this->formatUserData($stmt->fetch());
	}

	private function formatUserData(array $userStmt)
	{
		$this->userData = [
			'name' => $userStmt['name'],
			'surname' => $userStmt['surname'],
			'email' => $userStmt['email'],
			'accountType' => $userStmt['account_type'],
			'ip' => $userStmt['ip']
		];
	}
}