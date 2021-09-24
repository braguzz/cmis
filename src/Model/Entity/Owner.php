<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Owner Entity
 *
 * @property string|null $id
 * @property string|null $cmu
 * @property string|null $name
 * @property string|null $title
 *
 * @property \App\Model\Entity\Accountmail[] $accountmails
 * @property \App\Model\Entity\Alldevnonassegnati[] $alldevnonassegnatis
 * @property \App\Model\Entity\Allocation[] $allocations
 * @property \App\Model\Entity\Exallocation[] $exallocations
 * @property \App\Model\Entity\Querynomail[] $querynomail
 * @property \App\Model\Entity\Selectsimabbinate[] $selectsimabbinates
 * @property \App\Model\Entity\Simnonassegnate[] $simnonassegnate
 * @property \App\Model\Entity\Simphone[] $simphones
 */
class Owner extends Entity
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
        'id' => true,
        'cmu' => true,
        'name' => true,
        'title' => true,
        'accountmails' => true,
        'alldevnonassegnatis' => true,
        'allocations' => true,
        'exallocations' => true,
        'querynomail' => true,
        'selectsimabbinates' => true,
        'simnonassegnate' => true,
        'simphones' => true,
    ];
}
