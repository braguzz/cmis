<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AllocationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AllocationsTable Test Case
 */
class AllocationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AllocationsTable
     */
    protected $Allocations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Allocations',
        'app.Devices',
        'app.Owners',
        'app.Querynomail',
        'app.Rifproceduras',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Allocations') ? [] : ['className' => AllocationsTable::class];
        $this->Allocations = $this->getTableLocator()->get('Allocations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Allocations);

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
