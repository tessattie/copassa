<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folder Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $tenant_id
 *
 * @property \App\Model\Entity\Folder $parent_folder
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Tenant $tenant
 * @property \App\Model\Entity\Folder[] $child_folders
 * @property \App\Model\Entity\File[] $files
 */
class Folder extends Entity
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
        'created' => true,
        'modified' => true,
        'is_policies' => true, 
        'is_claims' => true, 
        'is_renewals' => true,
        'user_id' => true,
        'tenant_id' => true,
        'user' => true,
        'tenant' => true,
    ];
}
