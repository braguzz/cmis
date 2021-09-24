<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OwnersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OwnersTable Test Case
 */
class OwnersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OwnersTable
     */
    protected $Owners;

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
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Owners') ? [] : ['className' => OwnersTable::class];
        $this->Owners = $this->getTableLocator()->get('Owners', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Owners);

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
}
