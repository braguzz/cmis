<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Autore Entity
 *
 * @property int $id
 * @property string|null $nome
 * @property string|null $cognome
 * @property string|null $note
 * @property int $genere_id
 *
 * @property \App\Model\Entity\Genere $genere
 * @property \App\Model\Entity\Disco[] $dischi
 * @property \App\Model\Entity\Libro[] $libri
 */
class Autore extends Entity
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
        'nome' => true,
        'cognome' => true,
        'note' => true,
        'genere_id' => true,
        'genere' => true,
        'dischi' => true,
        'libri' => true,
    ];
}
