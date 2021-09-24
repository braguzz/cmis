<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cronoprogramma Entity
 *
 * @property string $VERSIONE
 * @property int $IDINT
 * @property string $CODATTIV
 * @property string|null $DESATTIV
 * @property string|null $PESOATTIV
 * @property int|null $FSP
 * @property int|null $FSI
 * @property int|null $FSL
 * @property string|null $RESTATTIV
 * @property string|null $DATAINIPREV
 * @property string|null $DATAFINEPREV
 * @property string|null $DATAINIEFF
 * @property string|null $DATAFINEFF
 * @property string|null $STATOATTUAZ
 * @property string|null $PERCATTUAZ
 *
 * @property \App\Model\Entity\Intervento[] $interventi
 */
class Cronoprogramma extends Entity
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
        'VERSIONE' => true,
        'IDINT'  => true,
        'CODATTIV' => true,
        'DESATTIV' => true,
        'PESOATTIV' => true,
        'FSP' => true,
        'FSI' => true,
        'FSL' => true,
        'RESTATTIV' => true,
        'DATAINIPREV' => true,
        'DATAFINEPREV' => true,
        'DATAINIEFF' => true,
        'DATAFINEFF' => true,
        'STATOATTUAZ' => true,
        'PERCATTUAZ' => true,
        'interventi' => true,
    ];
}
