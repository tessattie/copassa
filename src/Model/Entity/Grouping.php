<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Grouping Entity
 *
 * @property int $id
 * @property int $business_id
 * @property string $grouping_number
 * @property int $company_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Business $business
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Employee[] $employees
 */
class Grouping extends Entity
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
        'grouping_number' => true,
        'company_id' => true,
        'created' => true,
        'modified' => true,
        'business' => true,
        'company' => true,
        'employees' => true,
        'effective_date' => true,
        'tenant_id' => true
    ];
}
