<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * @package App\Models
 *
 * @property int $id
 * @property int $ken_id
 * @property int $city_id
 * @property int $town_id
 * @property string $zip
 * @property int $office_flg
 * @property int $delete_flg
 * @property string $ken_name
 * @property string $ken_furi
 * @property string $town_name
 * @property string $town_furi
 * @property string $town_memo
 * @property string $kyoto_street
 * @property string $block_name
 * @property string $block_furi
 * @property string $memo
 * @property string $office_name
 * @property string $office_furi
 * @property string $office_address
 * @property int $new_id
 *
 */
class Address extends Model
{
    protected $table = 'ad_address';

    public function getWholeAddress()
    {
        $address = "";
        foreach ([
                     'ken_name',
                     'city_name',
                     'town_name',
                     'town_memo',
                     'kyoto_street',
                     'block_name',
                     'memo',
                     'office_name',
                     'office_address',
                 ] as $name) {
            if (isset($this->{$name}) && $this->{$name} !== 'NULL') {
                $address .= ' ' . $this->{$name};
            }
        }

        return $address;

    }
}

/*
CREATE TABLE `ad_address` (
	`id` INTEGER NOT NULL DEFAULT 0,
	`ken_id` INTEGER DEFAULT NULL,
	`city_id` INTEGER DEFAULT NULL,
	`town_id` INTEGER DEFAULT NULL,
	`zip` TEXT DEFAULT NULL,
	`office_flg` INTEGER DEFAULT NULL,
	`delete_flg` INTEGER DEFAULT NULL,
	`ken_name` TEXT DEFAULT NULL,
	`ken_furi` TEXT DEFAULT NULL,
	`city_name` TEXT DEFAULT NULL,
	`city_furi` TEXT DEFAULT NULL,
	`town_name` TEXT DEFAULT NULL,
	`town_furi` TEXT DEFAULT NULL,
	`town_memo` TEXT DEFAULT NULL,
	`kyoto_street` TEXT DEFAULT NULL,
	`block_name` TEXT DEFAULT NULL,
	`block_furi` TEXT DEFAULT NULL,
	`memo` TEXT DEFAULT NULL,
	`office_name` TEXT DEFAULT NULL,
	`office_furi` TEXT DEFAULT NULL,
	`office_address` TEXT DEFAULT NULL,
	`new_id` INTEGER DEFAULT NULL,
	PRIMARY KEY (`id`)
)
*/

