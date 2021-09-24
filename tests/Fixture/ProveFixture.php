<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProveFixture
 */
class ProveFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'prove';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'CODPROG' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'VERSIONE' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATANUCLEO' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'FLAGB' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'COD_TIPOCRITICITA_NV' => ['type' => 'string', 'length' => 5, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'COD_TIPOSOLUZIONE_NV' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATACOMASS' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'SOL_GR_A' => ['type' => 'string', 'length' => 1, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATA_SOL_GR' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'CRITICITA_NDV' => ['type' => 'string', 'length' => 50, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['CODPROG', 'VERSIONE'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'CODPROG' => 1,
                'VERSIONE' => '47793727-c1bc-49f9-8d1b-8a7f858582a0',
                'DATANUCLEO' => 'Lorem ',
                'FLAGB' => 'L',
                'COD_TIPOCRITICITA_NV' => 'Lor',
                'COD_TIPOSOLUZIONE_NV' => 'L',
                'DATACOMASS' => 'Lorem ',
                'SOL_GR_A' => 'L',
                'DATA_SOL_GR' => 'Lorem ',
                'CRITICITA_NDV' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
