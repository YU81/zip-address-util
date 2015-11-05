<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'ad_address';
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

