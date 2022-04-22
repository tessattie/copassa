<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Business Entity
 *
 * @property int $id
 * @property string $name
 * @property string $business_number
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee[] $employees
 * @property \App\Model\Entity\Grouping[] $groupings
 */
class Business extends Entity
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
        'business_number' => true,
        'created' => true,
        'modified' => true,
        'employees' => true,
        'groupings' => true,
        'tenant_id' => true
    ];
}
