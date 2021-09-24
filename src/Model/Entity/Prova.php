<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Prova Entity
 *
 * @property int $CODPROG
 * @property string $VERSIONE
 * @property string $DATANUCLEO
 * @property string|null $FLAGB
 * @property string|null $COD_TIPOCRITICITA_NV
 * @property string|null $COD_TIPOSOLUZIONE_NV
 * @property string|null $DATACOMASS
 * @property string|null $SOL_GR_A
 * @property string|null $DATA_SOL_GR
 * @property string|null $CRITICITA_NDV
 */
class Prova extends Entity
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
         'CODPROG' => true,
        'VERSIONE' => true,
        'DATANUCLEO' => true,
        'FLAGB' => true,
        'COD_TIPOCRITICITA_NV' => true,
        'COD_TIPOSOLUZIONE_NV' => true,
        'DATACOMASS' => true,
        'SOL_GR_A' => true,
        'DATA_SOL_GR' => true,
        'CRITICITA_NDV' => true,
    ];
}
