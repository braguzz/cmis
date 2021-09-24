<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Device Entity
 *
 * @property string $id
 * @property string $utenza_imei
 * @property int $devmodel_id
 * @property \Cake\I18n\FrozenDate $data_carico
 * @property \Cake\I18n\FrozenDate|null $data_scarico
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $mac
 *
 * @property \App\Model\Entity\Devmodel $devmodel
 * @property \App\Model\Entity\Alldevnonassegnati[] $alldevnonassegnatis
 * @property \App\Model\Entity\Allocation[] $allocations
 * @property \App\Model\Entity\Devicesim[] $devicesims
 * @property \App\Model\Entity\Exallocation[] $exallocations
 * @property \App\Model\Entity\Simnonassegnate[] $simnonassegnate
 * @property \App\Model\Entity\Simphone[] $simphones
 * @property \App\Model\Entity\Upload[] $uploads
 * @property \App\Model\Entity\Uploadsim[] $uploadsims
 */
class Device extends Entity
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
        'utenza_imei' => true,
        'devmodel_id' => true,
        'data_carico' => true,
        'data_scarico' => true,
        'created' => true,
        'modified' => true,
        'mac' => true,
        'devmodel' => true,
        'alldevnonassegnatis' => true,
        'allocations' => true,
        'devicesims' => true,
        'exallocations' => true,
        'simnonassegnate' => true,
        'simphones' => true,
        'uploads' => true,
        'uploadsims' => true,
    ];
}
