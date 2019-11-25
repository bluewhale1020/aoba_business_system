<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImportDataConversion Entity
 *
 * @property int $id
 * @property string $category
 * @property string $name
 * @property string $item_name
 * @property string $tb_name
 * @property int|null $is_id_number
 * @property string|null $id_tb_name
 */
class ImportDataConversion extends Entity
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
        'category' => true,
        'name' => true,
        'item_name' => true,
        'tb_name' => true,
        'is_id_number' => true,
        'id_tb_name' => true
    ];
}
