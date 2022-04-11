<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Folder Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $parent_id
 * @property int|null $lft
 * @property int|null $rght
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 *
 * @property \App\Model\Entity\ParentFolder $parent_folder
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\ChildFolder[] $child_folders
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
        'parent_id' => true,
        'lft' => true,
        'rght' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'parent_folder' => true,
        'user' => true,
        'child_folders' => true,
        'files' => true,
        'tenant_id' => true
    ];
}
