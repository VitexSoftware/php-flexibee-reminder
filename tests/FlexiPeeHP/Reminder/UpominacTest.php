<?php

namespace Tests\FlexiPeeHP\Reminder;

use FlexiPeeHP\Reminder\Upominac;
/**
 * Generated by PHPUnit_SkeletonGenerator on 2018-12-10 at 23:40:56.
 */
class UpominacTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Upominac
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Upominac;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::getCustomersDebts
     * @todo   Implement testGetCustomersDebts().
     */
    public function testGetCustomersDebts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::everythingPaidOff
     * @todo   Implement testEverythingPaidOff().
     */
    public function testEverythingPaidOff()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::enableCustomer
     * @todo   Implement testEnableCustomer().
     */
    public function testEnableCustomer()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::processAllDebts
     * @todo   Implement testProcessAllDebts().
     */
    public function testProcessAllDebts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::processUserDebts
     * @todo   Implement testProcessUserDebts().
     */
    public function testProcessUserDebts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::getCustomerScore
     * @todo   Implement testGetCustomerScore().
     */
    public function testGetCustomerScore()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::posliUpominku
     * @todo   Implement testPosliUpominku().
     */
    public function testPosliUpominku()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::processNotifyModules
     * @todo   Implement testProcessNotifyModules().
     */
    public function testProcessNotifyModules()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::processModules
     * @todo   Implement testProcessModules().
     */
    public function testProcessModules()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::getEvidenceDebts
     * @todo   Implement testGetEvidenceDebts().
     */
    public function testGetEvidenceDebts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::getAllDebts
     * @todo   Implement testGetAllDebts().
     */
    public function testGetAllDebts()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::getCustomerList
     * @todo   Implement testGetCustomerList().
     */
    public function testGetCustomerList()
    {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers FlexiPeeHP\Reminder\Upominac::formatTotals
     */
    public function testFormatTotals()
    {
        $this->assertEquals('10,10 CZK,1,20 EUR', Upominac::formatTotals(['CZK'=>10.1,'EUR'=>1.2]));
    }
}