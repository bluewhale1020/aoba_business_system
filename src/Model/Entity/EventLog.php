<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EventLog Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $created
 * @property string $event
 * @property string|null $action_type
 * @property string|null $table_name
 * @property int|null $record_id
 * @property int $user_id
 * @property string|null $remote_addr
 * @property string|null $old_val
 * @property string|null $new_val
 *
 * @property \App\Model\Entity\Record $record
 * @property \App\Model\Entity\User $user
 */
class EventLog extends Entity
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
        'created' => true,
        'event' => true,
        'action_type' => true,
        'table_name' => true,
        'record_id' => true,
        'user_id' => true,
        'remote_addr' => true,
        'old_val' => true,
        'new_val' => true,
        'record' => true,
        'user' => true
    ];
}
