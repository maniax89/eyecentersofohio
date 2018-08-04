<?php
/*
 * @version		$Id: categories.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include library dependencies
jimport( 'joomla.filter.input' );

class AllVideoShareTableCategories extends JTable {

	var $id = null;
	var $name = null;
	var $slug = null;
	var $parent = null;
	var $type = null;
	var $thumb = null;
	var $access = null;
	var $ordering = null;
	var $metakeywords = null;
	var $metadescription = null;
	var $published = null;	
	
	public function __construct( &$db ) {
		parent::__construct( '#__allvideoshare_categories', 'id', $db );
	}

	public function check() {
		return true;
	}
	
}