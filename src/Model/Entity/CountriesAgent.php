<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CountriesAgent Entity
 *
 * @property int $id
 * @property int $country_id
 * @property int $agent_id
 *
 * @property \App\Model\Entity\Country $country
 * @property \App\Model\Entity\Agent $agent
 */
class CountriesAgent extends Entity
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
        'country_id' => true,
        'agent_id' => true,
        'country' => true,
        'agent' => true,
    ];
}
