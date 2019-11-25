<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MyCompany Entity
 *
 * @property int $id
 * @property string $name
 * @property string $kana
 * @property string $tel
 * @property string $fax
 * @property string $email
 * @property string $postal_code
 * @property string $address
 * @property string $banchi
 * @property string $tatemono
 * @property string $url
 * @property string $notes
 * @property int $owner
 */
class MyCompany extends Entity
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
