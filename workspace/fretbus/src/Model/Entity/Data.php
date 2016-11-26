<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Data Entity.
 *
 * @property int $id
 * @property int $bus_id
 * @property \App\Model\Entity\Bus $bus
 * @property string $lat
 * @property string $lon
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 */
class Data extends Entity
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
        '*' => true,
        'id' => false,
    ];
}
