<?php
global $phpPaths;
require_once($phpPaths['PHP'] . '/account-data.php');

class AccountDataTest extends PHPUnit\Framework\TestCase
{
    //test if all download constraints for regular account type has been propertly fetched
    public function testAccountRegularGetDownloadConstrains()
    {
        $constraints = $this->getDownloadConstraints('regular');

        $this->downloadConstraintsArrayHasKeys($constraints);
        $this->downloadConstraintsCheckArrayKeyTypes($constraints);

        $this->assertEquals(250, $constraints['maxSpeed']);
        $this->assertEquals(2, $constraints['maxNum']);
    }

    //test if all download constraints for guest account type has been propertly fetched
    public function testAccountGuestGetDownloadConstrains()
    {
        $constraints = $this->getDownloadConstraints('guest');

        $this->downloadConstraintsArrayHasKeys($constraints);
        $this->downloadConstraintsCheckArrayKeyTypes($constraints);

        $this->assertEquals(200, $constraints['maxSpeed']);
        $this->assertEquals(1, $constraints['maxNum']);
    }

    //test if all upload constraints for regular account type has been propertly fetched
    public function testAccountRegularGetUploadConstraints()
    {
        $constraints = $this->getUploadConstraints('regular');

        $this->uploadConstraintsArrayHasKeys($constraints);
        $this->uploadConstraintsCheckArrayKeyTypes($constraints);

        $this->assertEquals(20, $constraints['maxNum']);
        $this->assertEquals(4 * GB, $constraints['maxFileSize']);
        $this->assertEquals(15 * GB, $constraints['maxStorageSize']);
    }

    //test if all upload constraints for guest account type has been propertly fetched
    public function testAccountGuestGetUploadConstraints()
    {
        $constraints = $this->getUploadConstraints('guest');

        $this->uploadConstraintsArrayHasKeys($constraints);
        $this->uploadConstraintsCheckArrayKeyTypes($constraints);

        $this->assertEquals(10, $constraints['maxNum']);
        $this->assertEquals(1 * GB, $constraints['maxFileSize']);
        $this->assertEquals(10 * GB, $constraints['maxStorageSize']);
    }

    //PRIVATE HELPER FUNCTIONS

    private function getDownloadConstraints(string $accountType)
    {
        $account = new AccountData($accountType);

        return $account->getDownloadConstraints();
    }

    private function getUploadConstraints(string $accountType)
    {
        $account = new AccountData($accountType);

        return $account->getUploadConstraints();
    }

    private function downloadConstraintsArrayHasKeys($constraints)
    {
        $this->assertIsArray($constraints);
        $this->assertArrayHasKey('maxSpeed', $constraints);
        $this->assertArrayHasKey('maxNum', $constraints);
    }

    private function uploadConstraintsArrayHasKeys($constraints)
    {
        $this->assertIsArray($constraints);
        $this->assertArrayHasKey('maxFileSize', $constraints);
        $this->assertArrayHasKey('maxStorageSize', $constraints);
        $this->assertArrayHasKey('maxNum', $constraints);        
    }

    private function downloadConstraintsCheckArrayKeyTypes($constraints)
    {
        $this->assertIsInt($constraints['maxSpeed']);
        $this->assertIsInt($constraints['maxNum']);
    }

    private function uploadConstraintsCheckArrayKeyTypes($constraints)
    {
        $this->assertIsFloat($constraints['maxFileSize']);
        $this->assertIsFloat($constraints['maxStorageSize']);
        $this->assertIsInt($constraints['maxNum']);
    }

}