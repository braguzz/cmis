<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LingueTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LingueTable Test Case
 */
class LingueTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LingueTable
     */
    protected $Lingue;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Lingue',
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
        $config = $this->getTableLocator()->exists('Lingue') ? [] : ['className' => LingueTable::class];
        $this->Lingue = $this->getTableLocator()->get('Lingue', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Lingue);

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
