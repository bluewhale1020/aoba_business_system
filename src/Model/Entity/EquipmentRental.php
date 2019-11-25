<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EquipmentRental Entity
 *
 * @property int $id
 * @property int $work_id
 * @property \Cake\I18n\FrozenDate|null $start_date
 * @property \Cake\I18n\FrozenDate|null $end_date
 * @property int $equipment_id
 *
 * @property \App\Model\Entity\Work $work
 * @property \App\Model\Entity\Equipment $equipment
 */
class EquipmentRental extends Entity
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
        'work_id' => true,
        'start_date' => true,
        'end_date' => true,
        'equipment_id' => true,
        'work' => true,
        'equipment' => true
    ];
}
