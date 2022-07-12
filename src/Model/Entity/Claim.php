<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Claim Entity
 *
 * @property int $id
 * @property int $policy_id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $status
 * @property int $tenant_id
 *
 * @property \App\Model\Entity\Policy $policy
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Type[] $types
 */
class Claim extends Entity
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
        'title' => true,
        'description' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'status' => true,
        'tenant_id' => true,
        'policy' => true,
        'user' => true,
        'tenant' => true,
        'types' => true,
    ];
}
