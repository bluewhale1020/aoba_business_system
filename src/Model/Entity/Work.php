<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Work Entity
 *
 * @property int $id
 * @property int $order_id
 * @property int $equipmentA_id
 * @property int $equipmentB_id
 * @property int $equipmentC_id
 * @property int $equipmentD_id
 * @property int $equipmentE_id
 * @property int $start_no
 * @property int $end_no
 * @property string $absent_nums
 * @property int $staff1_id
 * @property int $staff2_id
 * @property int $staff3_id
 * @property int $staff4_id
 * @property int $staff5_id
 * @property int $staff6_id
 * @property int $staff7_id
 * @property int $staff8_id
 * @property int $staff9_id
 * @property int $staff10_id
 * @property int $technician1_id
 * @property int $technician2_id
 * @property int $technician3_id
 * @property int $technician4_id
 * @property int $technician5_id
 * @property int $technician6_id
 * @property int $technician7_id
 * @property int $technician8_id
 * @property int $technician9_id
 * @property int $technician10_id
 *
 * @property \App\Model\Entity\Order $order
 * @property \App\Model\Entity\EquipmentA $equipment_a
 * @property \App\Model\Entity\EquipmentB $equipment_b
 * @property \App\Model\Entity\EquipmentC $equipment_c
 * @property \App\Model\Entity\EquipmentD $equipment_d
 * @property \App\Model\Entity\EquipmentE $equipment_e
 * @property \App\Model\Entity\Staff1 $staff1
 * @property \App\Model\Entity\Staff2 $staff2
 * @property \App\Model\Entity\Staff3 $staff3
 * @property \App\Model\Entity\Staff4 $staff4
 * @property \App\Model\Entity\Staff5 $staff5
 * @property \App\Model\Entity\Staff6 $staff6
 * @property \App\Model\Entity\Staff7 $staff7
 * @property \App\Model\Entity\Staff8 $staff8
 * @property \App\Model\Entity\Staff9 $staff9
 * @property \App\Model\Entity\Staff10 $staff10
 * @property \App\Model\Entity\Technician1 $technician1
 * @property \App\Model\Entity\Technician2 $technician2
 * @property \App\Model\Entity\Technician3 $technician3
 * @property \App\Model\Entity\Technician4 $technician4
 * @property \App\Model\Entity\Technician5 $technician5
 * @property \App\Model\Entity\Technician6 $technician6
 * @property \App\Model\Entity\Technician7 $technician7
 * @property \App\Model\Entity\Technician8 $technician8
 * @property \App\Model\Entity\Technician9 $technician9
 * @property \App\Model\Entity\Technician10 $technician10
 */
class Work extends Entity
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
