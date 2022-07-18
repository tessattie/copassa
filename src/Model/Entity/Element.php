<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Element Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $video
 * @property string|null $photo
 * @property string|null $text
 * @property int $position
 * @property int $category_id
 *
 * @property \App\Model\Entity\Category $category
 */
class Element extends Entity
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
        'title' => true,
        'subtitle' => true,
        'video' => true,
        'photo' => true,
        'text' => true,
        'position' => true,
        'category_id' => true,
        'category' => true,
    ];
}
