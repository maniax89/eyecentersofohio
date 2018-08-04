<?php
/*
 * @version		$Id: commercials.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include library dependencies
jimport( 'joomla.filter.input' );

class AllVideoShareTableCommercials extends JTable {

	var $id = null;
	var $title = null;
	var $type = null;
	var $method = null;
	var $video = null;
	var $link = null;
	var $impressions = null;
	var $clicks = null;
	var $published = null;	
	
	public function __construct( &$db ) {
		parent::__construct( '#__allvideoshare_adverts', 'id', $db );
	}

	public function check() {
		return true;
	}
	
}