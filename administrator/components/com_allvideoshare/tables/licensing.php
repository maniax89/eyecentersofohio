<?php
/*
 * @version		$Id: licensing.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include library dependencies
jimport( 'joomla.filter.input' );

class AllVideoShareTableLicensing extends JTable {

	var $id = null;
	var $type = null;
	var $licensekey = null;
	var $logo = null;
	var $logoposition = null;
	var $logoalpha = null;
	var $logotarget = null;
	var $displaylogo = null;

	public function __construct( &$db ) {
		parent::__construct( '#__allvideoshare_licensing', 'id', $db );
	}

	public function check() {
		return true;
	}
	
}