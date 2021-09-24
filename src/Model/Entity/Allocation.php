<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Allocation Entity
 *
 * @property int $id
 * @property string $device_id
 * @property string $owner_id
 * @property \Cake\I18n\FrozenDate $InizioUso
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $referente
 * @property string|null $note
 * @property string|null $mail_referente
 *
 * @property \App\Model\Entity\Device $device
 * @property \App\Model\Entity\Owner $owner
 * @property \App\Model\Entity\Querynomail[] $querynomail
 * @property \App\Model\Entity\Rifprocedura[] $rifproceduras
 */
class Allocation extends Entity
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
        'device_id' => true,
        'owner_id' => true,
        'InizioUso' => true,
        'created' => true,
        'modified' => true,
        'referente' => true,
        'note' => true,
        'mail_referente' => true,
        'device' => true,
        'owner' => true,
        'querynomail' => true,
        'rifproceduras' => true,
    ];
}
