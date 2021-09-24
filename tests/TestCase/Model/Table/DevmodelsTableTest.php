<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DevmodelsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DevmodelsTable Test Case
 */
class DevmodelsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DevmodelsTable
     */
    protected $Devmodels;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Devmodels',
        'app.Devices',
        'app.Devsims',
        'app.Freedevs',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Devmodels') ? [] : ['className' => DevmodelsTable::class];
        $this->Devmodels = $this->getTableLocator()->get('Devmodels', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Devmodels);

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
