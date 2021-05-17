<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Log Entity
 *
 * @property int $id
 * @property string $comment
 * @property int $user_id
 * @property int $status
 * @property int $created
 * @property int $modified
 * @property int $type
 *
 * @property \App\Model\Entity\User $user
 */
class Log extends Entity
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
        'comment' => true,
        'user_id' => true,
        'status' => true,
        'created' => true,
        'modified' => true,
        'type' => true,
        'user' => true,
        'old_data' => true,
        'new_data' => true,
        'code' => true
    ];
}
