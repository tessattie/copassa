<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Prenewal Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $renewal_date
 * @property int $policy_id
 * @property float $premium
 * @property float|null $fee
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $policy_status
 *
 * @property \App\Model\Entity\Policy $policy
 */
class Prenewal extends Entity
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
        'renewal_date' => true,
        'policy_id' => true,
        'premium' => true,
        'fee' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'policy_status' => true,
        'policy' => true,
        'tenant_id' => true,
        'payment_date' => true,
        'memo' => true
    ];
}
