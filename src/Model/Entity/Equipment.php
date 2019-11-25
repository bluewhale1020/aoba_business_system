<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Equipment Entity
 *
 * @property int $id
 * @property string $name
 * @property int $equipment_type_id
 * @property string $xray_type
 * @property int $transportable
 * @property int $number_of_times
 * @property int $status_id
 * @property string $notes
 *
 * @property \App\Model\Entity\EquipmentType $equipment_type
 * @property \App\Model\Entity\Status $status
 */
class Equipment extends Entity
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
