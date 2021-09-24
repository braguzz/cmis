<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategorieLibriTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategorieLibriTable Test Case
 */
class CategorieLibriTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategorieLibriTable
     */
    protected $CategorieLibri;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.CategorieLibri',
        'app.Libri',
        'app.Categorie',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CategorieLibri') ? [] : ['className' => CategorieLibriTable::class];
        $this->CategorieLibri = $this->getTableLocator()->get('CategorieLibri', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CategorieLibri);

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
