<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DischiTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DischiTable Test Case
 */
class DischiTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DischiTable
     */
    protected $Dischi;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Dischi',
        'app.Lingue',
        'app.Autori',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Dischi') ? [] : ['className' => DischiTable::class];
        $this->Dischi = $this->getTableLocator()->get('Dischi', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Dischi);

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
