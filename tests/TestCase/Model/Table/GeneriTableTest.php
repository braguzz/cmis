<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GeneriTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GeneriTable Test Case
 */
class GeneriTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GeneriTable
     */
    protected $Generi;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Generi',
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
        $config = $this->getTableLocator()->exists('Generi') ? [] : ['className' => GeneriTable::class];
        $this->Generi = $this->getTableLocator()->get('Generi', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Generi);

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
