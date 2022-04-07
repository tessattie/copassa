<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pending Entity
 *
 * @property int $id
 * @property string $name
 * @property int $company_id
 * @property int $option_id
 * @property int $dependants
 * @property int $country_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int $user_id
 * @property int $status
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Option $option
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\User $user
 */
class Pending extends Entity
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
        'company_id' => true,
        'option_id' => true,
        'dependants' => true,
        'country_id' => true,
        'created' => true,
        'modified' => true,
        'user_id' => true,
        'status' => true,
        'company' => true,
        'option' => true,
        'country' => true,
        'last_contact_date' => true,
        'user' => true,
    ];
}
