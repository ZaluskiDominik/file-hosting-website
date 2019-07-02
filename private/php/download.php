<?php
require_once($phpPaths['PHP'] . '/ip-retriever.php');
require_once($phpPaths['PHP'] . '/db-connect.php');
require_once($phpPaths['PHP'] . '/account-data.php');
require_once($phpPaths['PHP'] . '/user-data.php');

class Download
{
    public function __construct()
    {
        //if user is logged in get his/her id
        if (isset($_SESSION['user']))
            $this->userId = $_SESSION['user']['id'];
        //else retrieve ip address of the user
        else
            $this->userIp = getClientIp();

        $this->fetchMaxSpeedLimit();
    }

    //returns array consisting of number of user's downloads
    //between now and now - MAX_NUM_DURATION
    //and timestampp of first download during that period
    /*
    [
        'num'
        'startedAt'
    ]
    */
    public function getNumDownloadsLimitInfo()
    {
        $db = connectToDB();
        $stmt = $db->prepare("SELECT COUNT(*) AS num, MIN(start_time) AS startedAt 
            FROM downloads
            WHERE start_time >= DATE_ADD(CURRENT_TIMESTAMP, INTERVAL -? SECOND)
            AND " . ( ( $this->userId === null ) ? 'owner_ip' : 'owner_id' )
            . " = ?");
        $stmt->execute([ 
            $GLOBALS['downloadConf']['MAX_NUM_DURATION'],
            ( $this->userId === null ) ? $this->userIp : $this->userId 
        ]);

        return $stmt->fetch();
    }

    //returns true if number of downloads in MAX_NUM_DURATION period of time is exceeded
    //integer var must be passed as reference, after function execution it will be
    //containing number of seconds user must wait before next download
    //if limit wasn't reached it will be 0
    public function isNumDownloadsLimitReached(int &$numWaitSeconds)
    {
        $account = new AccountData( 
        UserData::constructCurrentClient()->get()['accountType'] );
        //max number of downloads fo user's account
        $maxNumDownloads = $account->getDownloadConstraints()['maxNum'];
        
        $info = ( new Download() )->getNumDownloadsLimitInfo();
        //number of seconds to wait before next download can be started
        $numWaitSeconds = ( $info['num'] == 0 ) ? 0 : 
            $GLOBALS['downloadConf']['MAX_NUM_DURATION'] 
            - ( time() - strtotime($info['startedAt']) );
        
        return ( $maxNumDownloads !== null && $info['num'] >= $maxNumDownloads );
    }

    //inserts new entry to downloads table
    public function insertDownloadToDB(string $filePath)
    {
        $db = connectToDB();        
        $stmt = $db->prepare("INSERT INTO downloads
            (owner_id, owner_ip, upload_id)
            VALUES(?, ?, (SELECT id FROM uploaded_files WHERE path = ?))");
        $stmt->execute([ $this->userId, $this->userIp, $filePath ]);
    }

    //returns max speed limit with which user can download files
    //if user's account has no limit then null is returned
    public function getMaxSpeed()
    {
        return $this->maxSpeed;
    }

    //PRIVATE SECTION

    private $userId = null;
    private $userIp = null;
    private $maxSpeed;

    private function fetchMaxSpeedLimit()
    {
        $this->maxSpeed = ( new AccountData( 
            UserData::constructCurrentClient()->get()['accountType'])
            )->getDownloadConstraints()['maxSpeed'];
    }
}