<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * File Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $location
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $folder_id
 * @property int $user_id
 * @property string|null $description
 * @property int $tenant_id
 *
 * @property \App\Model\Entity\Folder $folder
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tenant $tenant
 */
class File extends Entity
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
        'location' => true,
        'created' => true,
        'modified' => true,
        'folder_id' => true,
        'user_id' => true,
        'policy_id' => true, 
        'claim_id' => true, 
        'renewal_id' => true,
        'description' => true,
        'tenant_id' => true,
        'folder' => true,
        'user' => true,
        'tenant' => true,
    ];
}
