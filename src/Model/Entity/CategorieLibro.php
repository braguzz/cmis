<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategorieLibro Entity
 *
 * @property int $id
 * @property int|null $libro_id
 * @property int|null $categoria_id
 *
 * @property \App\Model\Entity\Libro $libro
 * @property \App\Model\Entity\Categoria $categoria
 */
class CategorieLibro extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'libro_id' => true,
        'categoria_id' => true,
        'libro' => true,
        'categoria' => true,
    ];
}
