<?php

/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 17.03.2017
 * Time: 11:40
 */
class ProductLanguage extends DatabaseQuery
{
    public static $table_name = 'products_lang';
    public static $db_fields = [
        'ID', //> SERIAL
        'product_id', //> INT
        'table_column', //> VARCHAR 255
        'column_value', //> TEXT
        'language', //> VARCHAR 2
        'added', //> DATETIME
        'added_by', //> INT
        'edited_by', //> INT
        'status' //> INT 1
    ];

    public $ID;
    public $product_id;
    public $table_column;
    public $column_value;
    public $language;
    public $added;
    public $added_by;
    public $edited_by;
    public $status;

    public static function findByColumnLangProduct($column, $lang, $product_id) {
        global $database;

        $query = "SELECT * FROM " . PX . self::$table_name
            . " WHERE table_column='". $database->escape_value($column)
            ."' AND language='".$database->escape_value($lang)
            ."' AND product_id=" . $database->escape_value($product_id);

        $results = static::find_by_query($query);

        $result = array_shift($results);

        return !empty($result) ? $result : false;
    }

    public static function findByProductId($ID, $l) {
        global $database;

        $query = "SELECT * FROM " . PX . self::$table_name
            . " WHERE product_id=". $database->escape_value($ID)
            . " AND language = '". $database->escape_value($l) ."'";

        $results = static::find_by_query($query);

        return !empty($results) ? $results : false;
    }

    public static function translate($field, $product, $translations) {

        if(LANG == DEFAULT_LANG) {
            return $product->$field;
        }

        if (isset($translations->$field)) {
            return $translations->$field;
        }

        return $product->$field;
    }

}