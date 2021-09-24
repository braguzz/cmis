<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevicesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevicesTable Test Case
 */
class DevicesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DevicesTable
     */
    protected $Devices;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Devices',
        'app.Devmodels',
        'app.Alldevnonassegnatis',
        'app.Allocations',
        'app.Devicesims',
        'app.Exallocations',
        'app.Simnonassegnate',
        'app.Simphones',
        'app.Uploads',
        'app.Uploadsims',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Devices') ? [] : ['className' => DevicesTable::class];
        $this->Devices = $this->getTableLocator()->get('Devices', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Devices);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
