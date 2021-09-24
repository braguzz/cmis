<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Libro Entity
 *
 * @property int $id
 * @property string $titolo
 * @property string|null $numero_scaffale
 * @property int $lingua_id
 * @property int|null $autore_id
 * @property bool $disponibile
 * @property \Cake\I18n\FrozenDate|null $data_acquisto
 *
 * @property \App\Model\Entity\Lingua $lingua
 * @property \App\Model\Entity\Autore $autore
 * @property \App\Model\Entity\Categoria[] $categorie
 */
class Libro extends Entity
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
        'titolo' => true,
        'numero_scaffale' => true,
        'lingua_id' => true,
        'autore_id' => true,
        'disponibile' => true,
        'data_acquisto' => true,
        'lingua' => true,
        'autore' => true,
        'categorie' => true,
    ];
}
