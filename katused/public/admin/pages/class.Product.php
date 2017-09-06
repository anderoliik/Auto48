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
        'name', //> VARCHAR 100
        'parent', //> INT
        'added', //> DATETIME
        'status', //> INT 1
        'price', //> INT
        'category_id', //> INT
        'description', //> VARCHAR 100
        'added_by', //> DATETIME
    ];

    public $ID;
    public $name;
    public $parent;
    public $added;
    public $status;
    public $price;
    public $category_id;
    public $description;
    public $added_by;

    public static function find_parent($ID) {
        global $database;

        $sql = "SELECT * FROM "
            . PX . self::$table_name
            . " WHERE parent=" . $database->escape_value($ID) . " LIMIT 1";

        $result = static::find_by_query($sql);

        return !empty($result) ? array_shift($result) : false;
    }
}