<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Intervento Entity
 *
 * @property int $id
 * @property string $VERSIONE
 * @property int $IDINT
 * @property string|null $DESLDITEMP
 * @property string|null $TITOLOINT
 * @property string|null $DESCRINT
 * @property string|null $ANNODEFR
 * @property int|null $FLAGPQPO
 * @property string|null $CODCMU
 * @property string|null $MATRESPOP
 * @property string|null $NOTEANAG
 * @property string|null $NOTECRONOPROG
 * @property int|null $INTMONITORATO
 * @property string|null $MONITSTATO
 * @property string|null $ANNOINIZIOINT
 * @property string|null $STATOINT
 * @property string|null $MATRCSG
 * @property string|null $CODLOCPROG
 * @property string|null $INSVERS
 */
class Intervento extends Entity
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
        'IDINT' => true,
        'DESLDITEMP' => true,
        'TITOLOINT' => true,
        'DESCRINT' => true,
        'ANNODEFR' => true,
        'FLAGPQPO' => true,
        'CODCMU' => true,
        'MATRESPOP' => true,
        'NOTEANAG' => true,
        'NOTECRONOPROG' => true,
        'INTMONITORATO' => true,
        'MONITSTATO' => true,
        'ANNOINIZIOINT' => true,
        'STATOINT' => true,
        'MATRCSG' => true,
        'CODLOCPROG' => true,
        'INSVERS' => true,
    ];
}
