<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PoliciesRider Entity
 *
 * @property int $id
 * @property int $policy_id
 * @property int $rider_id
 *
 * @property \App\Model\Entity\Policy $policy
 * @property \App\Model\Entity\Rider $rider
 */
class PoliciesRider extends Entity
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
        'policy_id' => true,
        'rider_id' => true,
        'policy' => true,
        'rider' => true,
    ];
}
