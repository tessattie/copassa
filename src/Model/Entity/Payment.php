<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payment Entity
 *
 * @property int $id
 * @property int $customer_id
 * @property int $policy_id
 * @property float $amount
 * @property int $status
 * @property int $user_id
 * @property int $rate_id
 * @property float $daily_rate
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Policy $policy
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Rate $rate
 */
class Payment extends Entity
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
        'customer_id' => true,
        'policy_id' => true,
        'amount' => true,
        'status' => true,
        'user_id' => true,
        'rate_id' => true,
        'daily_rate' => true,
        'created' => true,
        'modified' => true,
        'customer' => true,
        'policy' => true,
        'user' => true,
        'rate' => true,
        'memo' => true, 
        'confirmed' => true
    ];
}
