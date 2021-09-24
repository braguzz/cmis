<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CronoprogFixture
 */
class CronoprogFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'cronoprog';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'VERSIONE' => ['type' => 'string', 'length' => 8, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'IDINT' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'CODATTIV' => ['type' => 'string', 'length' => 2, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DESATTIV' => ['type' => 'string', 'length' => 250, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'PESOATTIV' => ['type' => 'decimal', 'length' => 22, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'FSP' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'FSI' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'FSL' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'RESTATTIV' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATAINIPREV' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATAFINEPREV' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATAINIEFF' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'DATAFINEFF' => ['type' => 'string', 'length' => 8, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'STATOATTUAZ' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null],
        'PERCATTUAZ' => ['type' => 'decimal', 'length' => 22, 'precision' => 2, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['VERSIONE', 'IDINT', 'CODATTIV'], 'length' => []],
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
                'VERSIONE' => '5f542380-2fff-4c05-a135-928bc79052db',
                'IDINT' => 1,
                'CODATTIV' => '611f443d-8c66-455a-b2a4-7eb93ff65525',
                'DESATTIV' => 'Lorem ipsum dolor sit amet',
                'PESOATTIV' => 1.5,
                'FSP' => 1,
                'FSI' => 1,
                'FSL' => 1,
                'RESTATTIV' => 'Lorem ipsum dolor sit amet',
                'DATAINIPREV' => 'Lorem ',
                'DATAFINEPREV' => 'Lorem ',
                'DATAINIEFF' => 'Lorem ',
                'DATAFINEFF' => 'Lorem ',
                'STATOATTUAZ' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'PERCATTUAZ' => 1.5,
            ],
        ];
        parent::init();
    }
}
