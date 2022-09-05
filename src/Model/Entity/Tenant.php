<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tenant Entity
 *
 * @property int $id
 * @property string $full_name
 * @property string $email
 * @property string $phone
 * @property string $identification
 * @property string $company
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $status
 *
 * @property \App\Model\Entity\User $user
 */
class Tenant extends Entity
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
        'full_name' => true,
        'email' => true,
        'phone' => true,
        'identification' => true,
        'company' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'bucket' => true,
        'plan' => true, 
        'subscription' => true,
        'status' => true,
        'user' => true,
    ];
}
