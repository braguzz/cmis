<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Disco Entity
 *
 * @property int $id
 * @property string $title
 * @property string|null $descrizione
 * @property int $lingua_id
 * @property int|null $autore_id
 * @property \Cake\I18n\FrozenDate $data
 * @property \Cake\I18n\FrozenTime $datetime
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $intero
 * @property bool $booleano
 * @property string|null $decimale
 *
 * @property \App\Model\Entity\Lingua $lingua
 * @property \App\Model\Entity\Autore $autore
 */
class Disco extends Entity
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
        'descrizione' => true,
        'lingua_id' => true,
        'autore_id' => true,
        'data' => true,
        'datetime' => true,
        'created' => true,
        'modified' => true,
        'intero' => true,
        'booleano' => true,
        'decimale' => true,
        'lingua' => true,
        'autore' => true,
    ];
}
