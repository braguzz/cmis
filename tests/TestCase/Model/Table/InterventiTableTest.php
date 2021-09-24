<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InterventiTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InterventiTable Test Case
 */
class InterventiTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\InterventiTable
     */
    protected $Interventi;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Interventi',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Interventi') ? [] : ['className' => InterventiTable::class];
        $this->Interventi = $this->getTableLocator()->get('Interventi', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Interventi);

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
