<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;


/**
 * User Entity
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property int $status
 * @property int $role_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Company[] $companies
 * @property \App\Model\Entity\Customer[] $customers
 * @property \App\Model\Entity\Log[] $logs
 * @property \App\Model\Entity\Option[] $options
 * @property \App\Model\Entity\Payment[] $payments
 * @property \App\Model\Entity\Policy[] $policies
 */
class User extends Entity
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
        'username' => true,
        'password' => true,
        'status' => true,
        'role_id' => true,
        'created' => true,
        'modified' => true,
        'role' => true,
        'companies' => true,
        'customers' => true,
        'logs' => true,
        'options' => true,
        'payments' => true,
        'policies' => true,
        'tenant_id' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];

    protected function _setPassword($password){
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($password);
    }
}
