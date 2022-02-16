<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Family Entity
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property int $relationship
 * @property int $employee_id
 * @property float $premium
 * @property \Cake\I18n\FrozenDate $dob
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Employee $employee
 */
class Family extends Entity
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
        'first_name' => true,
        'last_name' => true,
        'relationship' => true,
        'employee_id' => true,
        'premium' => true,
        'dob' => true,
        'created' => true,
        'modified' => true,
        'employee' => true,
        'gender' => true,
        'country' => true,
        'status' => true
    ];

    protected function _getName()
    {
        return strtoupper($this->last_name) . ' ' . ucfirst(strtolower($this->first_name));
    }
}
