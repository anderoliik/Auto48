<?php
class Picture extends DatabaseQuery 
{ 
    public static $table_name = 'pictures'; 
    public static $db_fields = [ 
        'ID', //> SERIAL 
        'product_id', //> INT 
        'name', //> VARCHAR 255 
        'added_by', //> INT 
        'added', //> DATETIME 
        'edited_by', //> INT 
        'status' //> INT 1 
    ]; 

    public $ID; 
    public $product_id; 
    public $name; 
    public $added_by; 
    public $added; 
    public $edited_by; 
    public $status; 

    public function make_thumb($src, $dest, $newWidth) { 
        $sourceImage = $this->image_create_from_any($src); 

        $oldWidth = imagesx($sourceImage); 
        $oldHeight = imagesy($sourceImage); 

        /* find the "desired height" of this thumbnail, relative to the desired width  */ 
        $newHeight = floor($oldHeight * ($newWidth / $oldWidth)); 

        /* create a new, "virtual" image */ 
        $virtualImage = imagecreatetruecolor($newWidth, $newHeight); 

        /* copy source image at a resized size */ 
        imagecopyresampled($virtualImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $oldWidth, $oldHeight); 
        /* create the physical thumbnail image to its destination */ 
        imagejpeg($virtualImage, $dest); 
    } 

    public function image_create_from_any($filepath) { 
        $type = exif_imagetype($filepath); // [] if you don't have exif you could use getImageSize() 
        $allowedTypes = array( 
            1, // [] gif 
            2, // [] jpg 
            3, // [] png 
            6   // [] bmp 
        ); 
        if (!in_array($type, $allowedTypes)) { 
            return false; 
        } 
        switch ($type) { 
            case 1 : 
                $im = imageCreateFromGif($filepath); 
                break; 
            case 2 : 
                $im = imageCreateFromJpeg($filepath); 
                break; 
            case 3 : 
                $im = imageCreateFromPng($filepath); 
                break; 
            case 6 : 
                $im = imageCreateFromBmp($filepath); 
                break; 
        } 
        return $im; 
    } 

    public function makePictureFolders() { 
        if(!file_exists(UPLOAD_PATH)) { 
            mkdir(UPLOAD_PATH, 0755); 
        } 

        if(!file_exists(UPLOAD_PATH . date("Y"))) { 
            mkdir(UPLOAD_PATH . date("Y"), 0755); 
        } 

        if(!file_exists(UPLOAD_PATH . date("Y") . "/" . date("m"))) { 
            mkdir(UPLOAD_PATH . date("Y") . "/" . date("m"), 0755); 
        } 

        if(!file_exists(UPLOAD_PATH_FULL . $this->product_id)) { 
            mkdir(UPLOAD_PATH_FULL . $this->product_id, 0755); 
        } 

        if(!file_exists(UPLOAD_PATH_FULL . $this->product_id . DS . PICTURE_MED)) { 
            mkdir(UPLOAD_PATH_FULL . $this->product_id . DS . PICTURE_MED, 0755); 
        } 

        if(!file_exists(UPLOAD_PATH_FULL . $this->product_id . DS . PICTURE_THUMB)) { 
            mkdir(UPLOAD_PATH_FULL . $this->product_id . DS . PICTURE_THUMB, 0755); 
        } 
    } 

    public function resizePicture() { 
        $this->makePictureFolders(); 

        $this->make_thumb(UPLOAD_PATH_FULL . $this->product_id . DS . $this->name, 
            UPLOAD_PATH_FULL . $this->product_id . DS . PICTURE_THUMB . DS . $this->name, PICTURE_THUMB); 

        $this->make_thumb(UPLOAD_PATH_FULL . $this->product_id . DS . $this->name, 
            UPLOAD_PATH_FULL . $this->product_id . DS . PICTURE_MED . DS . $this->name, PICTURE_MED); 

        $this->make_thumb(UPLOAD_PATH_FULL . $this->product_id . DS . $this->name, 
            UPLOAD_PATH_FULL . $this->product_id . DS . $this->name, PICTURE_FULL); 
    } 

    public static function getPictures($src) { 
        $pictures = scandir($src); 

        unset($pictures[0]); 
        unset($pictures[1]); 

        return $pictures; 
    } 

    public static function getPicturesByProduct($ID) { 
        global $database; 

        if(empty($ID)) { 
            return false; 
        } 

        $query = "SELECT * FROM " . PX . self::$table_name 
            . " WHERE product_id=" . $database->escape_value($ID); 

        $results = self::find_by_query($query); 

        return empty($results) ? false : $results; 
    } 
}

?>