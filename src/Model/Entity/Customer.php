<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $email
 * @property string|null $home_area_code
 * @property string|null $home_phone
 * @property string|null $cell_area_code
 * @property string|null $cell_phone
 * @property string $other_area_code
 * @property string|null $other_phone
 * @property int $user_id
 * @property string|null $address
 * @property int $status
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Policy[] $policies
 */
class Customer extends Entity
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
        'name' => true,
        'email' => true,
        'home_area_code' => true,
        'home_phone' => true,
        'cell_area_code' => true,
        'cell_phone' => true,
        'other_area_code' => true,
        'other_phone' => true,
        'user_id' => true,
        'address' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'payments' => true,
        'policies' => true,
        'dob' => true,
        'country_id' => true,
        'tenant_id' => true,
        'agent_id' => true
    ];
}
