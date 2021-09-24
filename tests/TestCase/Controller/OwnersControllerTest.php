<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\OwnersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\OwnersController Test Case
 *
 * @uses \App\Controller\OwnersController
 */
class OwnersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Owners',
        'app.Accountmails',
        'app.Alldevnonassegnatis',
        'app.Allocations',
        'app.Exallocations',
        'app.Querynomail',
        'app.Selectsimabbinates',
        'app.Simnonassegnate',
        'app.Simphones',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test esportacsv method
     *
     * @return void
     */
    public function testEsportacsv(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test esportapdf method
     *
     * @return void
     */
    public function testEsportapdf(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test esportaxls method
     *
     * @return void
     */
    public function testEsportaxls(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add_ajax_belong method
     *
     * @return void
     */
    public function testAddAjaxBelong(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test addfromadd method
     *
     * @return void
     */
    public function testAddfromadd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test removeajaxbelong method
     *
     * @return void
     */
    public function testRemoveajaxbelong(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test indexexternal method
     *
     * @return void
     */
    public function testIndexexternal(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test addhabtm method
     *
     * @return void
     */
    public function testAddhabtm(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test removehabtmajaxbelong method
     *
     * @return void
     */
    public function testRemovehabtmajaxbelong(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
