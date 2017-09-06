<?php

/**
 * Created by PhpStorm.
 * User: andero.liik
 * Date: 9.03.2017
 * Time: 14:13
 */
class Product extends DatabaseQuery
{
    public static $table_name = 'products';
    public static $db_fields = [
        'ID', //> SERIAL
        'name', //> VARCHAR 50
        'price', //> DECIMAL(6,2)
        'description', //> VARCHAR 50
        'category_id', //> int
        'added', //> DATETIME 50
        'added_by', //> int
        'edited_by', //> DATETIME
        'status' //> INT 1
    ];

    public $ID;
    public $name;
    public $price;
    public $description;
    public $category_id;
    public $added;
    public $added_by;
    public $edited_by;
    public $status;

    public static function find_by_name($s = "") {
        global $database;

        if(empty($s)) {
            return false;
        }

        $query = "SELECT * FROM " . PX . self::$table_name
            . " WHERE name LIKE '%" . $database->escape_value($s) . "%'";

        $results = self::find_by_query($query);

        return empty($results) ? false : $results;
    }

    public static function find_by_category($categories = null) {
        global $database;

        if(empty($categories)) {
            return false;
        }

        $query = "SELECT * FROM " . PX . self::$table_name
            . " WHERE category_id IN (" . $database->escape_value($categories) . ")";

        $results = self::find_by_query($query);

        return empty($results) ? false : $results;
    }

    public function showPrice() {
        return $this->price;
    }

}