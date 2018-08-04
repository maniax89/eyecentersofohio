<?php
/*
 * @version		$Id: players.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Include library dependencies
jimport( 'joomla.filter.input' );

class AllVideoShareTablePlayers extends JTable {

	var $id = null;
	var $name = null;
	var $loop = null;
	var $autostart = null;
	var $buffer = null;
	var $volumelevel = null;
	var $stretch = null;
	var $controlbar = null;
	var $playlist = null;
	var $durationdock = null;
	var $timerdock = null; 
	var $fullscreendock = null;
	var $hddock = null;
	var $embeddock = null;
	var $facebookdock = null;
	var $twitterdock = null;	
	var $controlbaroutlinecolor = null;
	var $controlbarbgcolor = null;
	var $controlbaroverlaycolor = null;
	var $controlbaroverlayalpha = null;
	var $iconcolor = null;
	var $progressbarbgcolor = null;
	var $progressbarbuffercolor = null;
	var $progressbarseekcolor = null;
	var $volumebarbgcolor = null;
	var $volumebarseekcolor = null;
	var $playlistbgcolor = null;
	var $customplayerpage = null;
	var $preroll = null;
	var $postroll = null;
	var $published = null;	
	var $type = null;

	public function __construct( &$db ) {
		parent::__construct( '#__allvideoshare_players', 'id', $db );
	}

	public function check() {
		return true;
	}

}