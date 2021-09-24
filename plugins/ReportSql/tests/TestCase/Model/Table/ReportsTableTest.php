<?php
declare(strict_types=1);

namespace ReportSql\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use ReportSql\Model\Table\ReportsTable;

/**
 * ReportSql\Model\Table\ReportsTable Test Case
 */
class ReportsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \ReportSql\Model\Table\ReportsTable
     */
    protected $Reports;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'plugin.ReportSql.Reports',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Reports') ? [] : ['className' => ReportsTable::class];
        $this->Reports = $this->getTableLocator()->get('Reports', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Reports);

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
