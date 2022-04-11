<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Policy Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $option_id
 * @property int $customer_id
 * @property string $policy_number
 * @property int $mode
 * @property \Cake\I18n\FrozenDate $effective_date
 * @property \Cake\I18n\FrozenDate $paid_until
 * @property float $premium
 * @property float $fee
 * @property int $user_id
 * @property int $active
 * @property int $lapse
 * @property int $pending
 * @property int $grace_period
 * @property int $canceled
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Option $option
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Payment[] $payments
 */
class Policy extends Entity
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
        'company_id' => true,
        'option_id' => true,
        'customer_id' => true,
        'policy_number' => true,
        'mode' => true,
        'effective_date' => true,
        'paid_until' => true,
        'premium' => true,
        'fee' => true,
        'user_id' => true,
        'active' => true,
        'lapse' => true,
        'pending' => true,
        'grace_period' => true,
        'canceled' => true,
        'created' => true,
        'modified' => true,
        'company' => true,
        'option' => true,
        'customer' => true,
        'user' => true,
        'payments' => true,
        'deductible' => true,
        'certificate' => true, 
        'usa_deductible' => true, 
        'max_coverage' => true, 
        'exclusions' => true,
        'last_premium' => true,
        'next_renewal' => true, 
        'last_renewal' => true,
        'passport_number' => true,
        'pending_business' => true,
        'tenant_id' => true
    ];
}
