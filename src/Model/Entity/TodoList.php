<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TodoList Entity
 *
 * @property int $id
 * @property string $description
 * @property \Cake\I18n\FrozenDate|null $due_date
 * @property string $priority
 * @property bool|null $done
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 */
class TodoList extends Entity
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
        'description' => true,
        'due_date' => true,
        'priority' => true,
        'done' => true,
        'created' => true,
        'modified' => true
    ];
}
