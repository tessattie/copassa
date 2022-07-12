<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ClaimsType Entity
 *
 * @property int $id
 * @property int $claim_id
 * @property int $type_id
 * @property string $title
 * @property string|null $description
 * @property string|null $attachment
 * @property float $amount
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $tenant_id
 *
 * @property \App\Model\Entity\Claim $claim
 * @property \App\Model\Entity\Type $type
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tenant $tenant
 */
class ClaimsType extends Entity
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
        'claim_id' => true,
        'type_id' => true,
        'title' => true,
        'description' => true,
        'attachment' => true,
        'service_date' => true,
        'processed_date' => true,
        'received_date' => true,
        'amount' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'tenant_id' => true,
        'claim' => true,
        'type' => true,
        'user' => true,
        'tenant' => true,
    ];
}
