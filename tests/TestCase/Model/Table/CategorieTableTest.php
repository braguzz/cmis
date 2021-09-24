<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategorieTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategorieTable Test Case
 */
class CategorieTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategorieTable
     */
    protected $Categorie;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Categorie',
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
        $config = $this->getTableLocator()->exists('Categorie') ? [] : ['className' => CategorieTable::class];
        $this->Categorie = $this->getTableLocator()->get('Categorie', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Categorie);

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
