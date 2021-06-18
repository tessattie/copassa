<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Dependant Entity
 *
 * @property int $id
 * @property int|null $relation
 * @property \Cake\I18n\FrozenDate|null $dob
 * @property int|null $sexe
 * @property string $limitations
 * @property int $policy_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Policy $policy
 * @property \App\Model\Entity\User $user
 */
class Dependant extends Entity
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
        'relation' => true,
        'dob' => true,
        'sexe' => true,
        'limitations' => true,
        'policy_id' => true,
        'user_id' => true,
        'created' => true,
        'modified' => true,
        'policy' => true,
        'user' => true,
        'name' => true
    ];
}
