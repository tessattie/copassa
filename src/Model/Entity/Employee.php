<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Employee Entity
 *
 * @property int $id
 * @property int $business_id
 * @property string $first_name
 * @property string $last_name
 * @property string $membership_number
 * @property float $deductible
 * @property int $grouping_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Business $business
 * @property \App\Model\Entity\Grouping $grouping
 * @property \App\Model\Entity\Family[] $families
 */
class Employee extends Entity
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
        'business_id' => true,
        'first_name' => true,
        'last_name' => true,
        'membership_number' => true,
        'deductible' => true,
        'grouping_id' => true,
        'created' => true,
        'modified' => true,
        'business' => true,
        'grouping' => true,
        'families' => true,
        'effective_date' => true, 
        'status' => true
    ];

    protected function _getName()
    {
        return strtoupper($this->last_name) . ' ' . ucfirst(strtolower($this->first_name));
    }
}
