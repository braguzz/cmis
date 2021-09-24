<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LibriFixture
 */
class LibriFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'libri';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'titolo' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '', 'precision' => null],
        'numero_scaffale' => ['type' => 'decimal', 'length' => 3, 'precision' => 0, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => ''],
        'lingua_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'autore_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'disponibile' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'data_acquisto' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null],
        '_indexes' => [
            'autore_id' => ['type' => 'index', 'columns' => ['autore_id'], 'length' => []],
            'lingua_id' => ['type' => 'index', 'columns' => ['lingua_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'libri_ibfk_3' => ['type' => 'foreign', 'columns' => ['lingua_id'], 'references' => ['lingue', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'libri_ibfk_2' => ['type' => 'foreign', 'columns' => ['autore_id'], 'references' => ['autori', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
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
                'id' => 1,
                'titolo' => 'Lorem ipsum dolor sit amet',
                'numero_scaffale' => 1.5,
                'lingua_id' => 1,
                'autore_id' => 1,
                'disponibile' => 1,
                'data_acquisto' => '2021-08-05',
            ],
        ];
        parent::init();
    }
}
