<?php
require_once($phpPaths['PHP'] . '/account-data.php');

class CompareAccountsTableContent
{
    public function __construct()
    {
        $this->changeConstraintsToContent([
            'guest' => ( new AccountData('guest') )->getConstraints(),
            'regular' => ( new AccountData('regular') )->getConstraints(),
            'premium' => ( new AccountData('premium') )->getConstraints()
        ]);
    }

    /*Returns array of [
        'guest' => <constraints array>,
        'regular' => <constraints array>,
        'premium' > <constraints array>
    ]
    where each <constraints array> is an array returned by getConstraints()
    method from AccountData object for each account
    content will be formatted to html output to compare accounts table
    for user to see
    */
    public function get()
    {
        return $this->content;
    }

    //PRIVATE SECTION

    private $content;

    //returns string number of gigabates + 'GB' postfix
    //float types cause int is too small
    private function bytesToGB(float $bytes, int $precision = 0)
    {
        return round($bytes / GB, $precision) . 'GB';
    }

    /*constraints - associative array of [ 'guest' => ..., 
    'regular' => ..., 'premium' => ... ]
    where each ... is array of constraints for given account(array retured by
    getConstraints() method from AccountData class)
    changes content of constraints array to content that will be dsplayed
    in table comparing constraints for different account types
    */
    private function changeConstraintsToContent(array $constraints)
    {
        $this->content = $constraints;
        $this->changeUploadConstraints();
        $this->changeDownloadConstraints();
    }

    //helper of changeConstraintsToContent function doing its job for upload
    //constraints
    private function changeUploadConstraints()
    {
        foreach ($this->content as &$account)
        {
            //max number of uploads at once
            $this->replaceIfNull($account['upload']['maxNum'], 'Nieograniczona');
            //max file size
            $account['upload']['maxFileSize'] = $this->bytesToGB(
                $account['upload']['maxFileSize']);
            //max storage size
            $account['upload']['maxStorageSize'] = $this->bytesToGB(
                $account['upload']['maxStorageSize']);
        }
    }

    //helper of changeConstraintsToContent function doing its job for download
    //constraints
    private function changeDownloadConstraints()
    {
        foreach ($this->content as &$account)
        {
            //max upload speed
            if ($account['download']['maxSpeed'] !== null)
                $account['download']['maxSpeed'] .= ' Kb/s';
            $this->replaceIfNull($account['download']['maxSpeed'], 'Nieograniczona');
            //max num downloads per $downloadConf['MAX_NUM_DURATION'] seconds
            $this->replaceIfNull($account['download']['maxNum'], 'Nieograniczona');
        }
    }

    //changes value of $field variable to $replacement value if $field is null
    //also adds <b> tag so that css on client side will be able to format
    //this text
    //used for premium account where access is unlimited
    private function replaceIfNull(&$field, $replacement)
    {
        if ($field === null)
            $field = '<b>' . $replacement . '</b>';
    }
}