<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Devmodel Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $brand
 * @property string $tipo
 * @property string|null $costo
 *
 * @property \App\Model\Entity\Device[] $devices
 * @property \App\Model\Entity\Devsim[] $devsims
 * @property \App\Model\Entity\Freedev[] $freedevs
 */
class Devmodel extends Entity
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
        'brand' => true,
        'tipo' => true,
        'costo' => true,
        'devices' => true,
        'devsims' => true,
        'freedevs' => true,
    ];
}
