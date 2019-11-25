<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Staff Entity
 *
 * @property int $id
 * @property string $name
 * @property string $kana
 * @property \Cake\I18n\Time $birth_date
 * @property string $tel
 * @property string $postal_code
 * @property string $address
 * @property string $banchi
 * @property string $tatemono
 * @property int $occupation_id
 * @property int $occupation2_id
 * @property int $title_id
 * @property string $notes
 *
 * @property \App\Model\Entity\Occupation $occupation
 * @property \App\Model\Entity\Occupation2 $occupation2
 * @property \App\Model\Entity\Title $title
 */
class Staff extends Entity
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
        '*' => true,
        'id' => false
    ];
}
