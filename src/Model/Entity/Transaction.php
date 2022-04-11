<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Transaction Entity
 *
 * @property int $id
 * @property int $type
 * @property float $credit
 * @property float $debit
 * @property int $employee_id
 * @property int $business_id
 * @property int $group_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $renewal_id
 *
 * @property \App\Model\Entity\Employee $employee
 * @property \App\Model\Entity\Business $business
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Renewal $renewal
 */
class Transaction extends Entity
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
        'type' => true,
        'credit' => true,
        'debit' => true,
        'employee_id' => true,
        'business_id' => true,
        'family_id' => true,
        'grouping_id' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'renewal_id' => true,
        'employee' => true,
        'business' => true,
        'grouping' => true,
        'user' => true,
        'renewal' => true,
        'memo' => true,
        'tenant_id' => true
    ];
}
