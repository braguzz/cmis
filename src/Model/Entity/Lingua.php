<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Lingua Entity
 *
 * @property int $id
 * @property string|null $title
 *
 * @property \App\Model\Entity\Disco[] $dischi
 * @property \App\Model\Entity\Libro[] $libri
 */
class Lingua extends Entity
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
        'title' => true,
        'dischi' => true,
        'libri' => true,
    ];
}
