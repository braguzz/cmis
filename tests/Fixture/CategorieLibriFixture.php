<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CategorieLibriFixture
 */
class CategorieLibriFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'categorie_libri';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'libro_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'categoria_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'libro_id' => ['type' => 'index', 'columns' => ['libro_id'], 'length' => []],
            'categoria_id' => ['type' => 'index', 'columns' => ['categoria_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'categorie_libri_ibfk_2' => ['type' => 'foreign', 'columns' => ['categoria_id'], 'references' => ['categorie', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'categorie_libri_ibfk_1' => ['type' => 'foreign', 'columns' => ['libro_id'], 'references' => ['libri', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'libro_id' => 1,
                'categoria_id' => 1,
            ],
        ];
        parent::init();
    }
}
