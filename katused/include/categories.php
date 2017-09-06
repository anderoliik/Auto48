<?php
 
	$db = mysqli_connect('localhost', 'TAK15_Liik', '123456');
	if (!$db) {
		die('Not connected : ' . mysqli_error());
	}

	
	$db_selected = mysqli_select_db($db, 'TAK15_Liik' );
	if (!$db_selected) {
		die ('Can\'t use TAK15_Liik : ' . mysqli_error($db));
	}


/** 
 * Function that checks if a category has a child. 
 * 
 * @param int ID of the category 
 * @return boolean TRUE if at least one child was found, FALSE otherwise 
 */ 
function hasChild($id) 
{ 
    $db = $GLOBALS['db']; 
    $result = $db->getOne("SELECT COUNT(*) FROM nested_categories WHERE id = " . intval($id)); 
    if (!PEAR::isError($result) && intval($result) > 0) { 
        return true; 
    } 
    return false; 
} 

/** 
 * Function that outputs a tree. 
 * 
 * @param int ID of the category from where we start building the tree 
 * @param int Shows how deep we are into the tree, serves only decorative (indentation) purposes 
 * @return void 
 */ 
function dumpTree($parent = 0, $level = 0) 
{ 
    $db = $GLOBALS['db']; // the database object 
    // select all categories that have the parent with which the function was called 
    $cats = $db->getAll("SELECT * FROM nested_categories WHERE parent_id = " . intval($parent)); 
    foreach ($cats AS $cat) { 
        // output the category, putting two dashes for every level 
        // echo '<option value="'. $cat['id'] .'">' . str_repeat("-", $level*2) . $cat['name'] . "</option>";  
        echo str_repeat("-", $level*2) . $cat['name'] . "<br />";  
        if (hasChild($cat['id'])) { // check if this category that we just listed has a child 
            dumpTree($cat['id'], $level+1); 
                                           
                                             
                                            
        } 
    } 
} 

dumpTree(); // plant a tree here  