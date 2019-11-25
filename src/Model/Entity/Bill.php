<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bill Entity
 *
 * @property int $id
 * @property \Cake\I18n\Time $bill_sent_date
 * @property int $is_sent
 * @property int $business_partner_id
 * @property int $total_value
 * @property int $consumption_tax
 * @property int $total_charge
 * @property \Cake\I18n\Time $received_date
 * @property int $uncollectible
 *
 * @property \App\Model\Entity\BusinessPartner $business_partner
 * @property \App\Model\Entity\Order[] $orders
 */
class Bill extends Entity
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
