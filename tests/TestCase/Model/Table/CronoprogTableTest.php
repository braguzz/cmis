<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CronoprogTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CronoprogTable Test Case
 */
class CronoprogTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CronoprogTable
     */
    protected $Cronoprog;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Cronoprog',
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
        $config = $this->getTableLocator()->exists('Cronoprog') ? [] : ['className' => CronoprogTable::class];
        $this->Cronoprog = $this->getTableLocator()->get('Cronoprog', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Cronoprog);

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
