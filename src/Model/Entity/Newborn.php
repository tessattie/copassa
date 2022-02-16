<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Newborn Entity
 *
 * @property int $id
 * @property int $policy_id
 * @property \Cake\I18n\FrozenDate $due_date
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $status
 *
 * @property \App\Model\Entity\Policy $policy
 * @property \App\Model\Entity\User $user
 */
class Newborn extends Entity
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
        'due_date' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'status' => true,
        'policy' => true,
        'user' => true,
    ];
}
