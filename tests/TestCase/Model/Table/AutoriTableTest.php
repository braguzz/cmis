<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AutoriTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AutoriTable Test Case
 */
class AutoriTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AutoriTable
     */
    protected $Autori;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Autori',
        'app.Generi',
        'app.Dischi',
        'app.Libri',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Autori') ? [] : ['className' => AutoriTable::class];
        $this->Autori = $this->getTableLocator()->get('Autori', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Autori);

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
