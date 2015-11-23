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
        return $this->getConcatenatedFields([
            'ken_name',
            'city_name',
            'town_name',
            'town_memo',
            'kyoto_street',
            'block_name',
            'memo',
            'office_name',
            'office_address',
        ]);
    }

    public function getWholeAddressReading()
    {
        return $this->getConcatenatedFields([
            'ken_furi',
            'city_furi',
            'town_furi',
            'block_furi',
            'office_furi',
        ]);
    }

    /**
     * @param string $zip
     * @param bool $withHyphen
     * @return string
     */
    public static function processZip($zip, $withHyphen = true)
    {
        if (!isset($zip)) {
            return '';
        }

        $returnZip = $zip;
        if ($zip !== '_' && $zip !== '-') {
            $returnZip = rawurldecode($zip);
            $returnZip = mb_convert_kana($returnZip, "a");
            mb_regex_encoding('UTF-8');
            mb_internal_encoding('UTF-8');
            $returnZip = mb_ereg_replace('[-ー－―—]', '', $returnZip);
        }

        if ($withHyphen && strlen($returnZip) === 7) {
            $returnZip = substr($returnZip, 0, 3) . '-' . substr($returnZip, 3, 4);
        }

        return $returnZip;
    }

    /**
     * @param string $furi
     * @param \Illuminate\Database\Query\Builder $q
     * @param string $colName
     */
    public static function filterQueryFuri($furi, $q, $colName)
    {
        if (isset($furi)) {
            $decoded_furi = rawurldecode($furi);
            $decoded_furi = mb_convert_kana($decoded_furi, "CK");
            if ($furi !== '_' && $furi !== '-') {
                $q->orWhere($colName, 'like', '%' . $decoded_furi . '%');
            }
        }
    }

    /**
     * @param string $kanji
     * @param \Illuminate\Database\Query\Builder $q
     * @param string $colName
     */
    public static function filterQueryKanji($kanji, $q, $colName)
    {
        if (isset($kanji)) {
            $decoded_kanji = rawurldecode($kanji);
            if ($kanji !== '_' && $kanji !== '-') {
                $q->orWhere($colName, 'like', '%' . $decoded_kanji . '%');
            }
        }
    }

    /**
     * @param string[] $fieldNames
     * @param string $separator
     * @return string
     */
    private function getConcatenatedFields($fieldNames, $separator = ' ')
    {
        $result = '';
        if (count($fieldNames) < 1) {
            return $result;
        }
        foreach ($fieldNames as $name) {
            if (isset($this->{$name}) && $this->{$name} !== 'NULL') {
                $result .= $separator . $this->{$name};
            }
        }

        return $result;
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

