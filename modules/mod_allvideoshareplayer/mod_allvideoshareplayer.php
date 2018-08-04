<?php
/*
 * @version		$Id: mod_allvideoshareplayer.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
if( ! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
require_once( dirname( __FILE__ ).DS.'helper.php' );
require_once( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_allvideoshare'.DS.'libraries'.DS.'utils.php' );
require_once( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_allvideoshare'.DS.'libraries'.DS.'player.php' );

$videoId = AllVideoSharePlayerHelper::getVideoId( $params );
$config = AllVideoShareUtils::getConfig();

$playerObj = new AllVideoSharePlayer();
$player = $playerObj->build( $videoId, $params->get( 'playerid' ), $params->get( 'autodetect' ) );

if( $video = $playerObj->video ) {
	
	$doc = JFactory::getDocument();
	$doc->addStyleSheet( JURI::root( true ) . "/components/com_allvideoshare/assets/css/allvideoshare.css", "text/css", "screen" );
	if( ! empty( $config->custom_css ) ) {
		$doc->addStyleDeclaration( $config->custom_css );
	}

	require( JModuleHelper::getLayoutPath( 'mod_allvideoshareplayer' ) );
	
}