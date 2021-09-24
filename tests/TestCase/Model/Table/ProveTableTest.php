<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProveTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProveTable Test Case
 */
class ProveTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProveTable
     */
    protected $Prove;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Prove',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Prove') ? [] : ['className' => ProveTable::class];
        $this->Prove = $this->getTableLocator()->get('Prove', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Prove);

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
