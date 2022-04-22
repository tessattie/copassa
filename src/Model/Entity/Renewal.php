<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Renewal Entity
 *
 * @property int $id
 * @property int $business_id
 * @property int $group_id
 * @property float $total
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property string $year
 *
 * @property \App\Model\Entity\Business $business
 * @property \App\Model\Entity\Group $group
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Transaction[] $transactions
 */
class Renewal extends Entity
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
        'business_id' => true,
        'total' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'renewal_number' => true,
        'year' => true,
        'business' => true,
        'user' => true,
        'paid' => true,
        'transactions' => true,
        'tenant_id' => true
    ];
}
