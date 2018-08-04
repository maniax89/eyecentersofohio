<?php
/*
 * @version		$Id: mod_allvideosharegallery.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Include the syndicate functions only once
if( ! defined( 'DS' ) ) define( 'DS',DIRECTORY_SEPARATOR );
require_once( dirname( __FILE__ ).DS.'helper.php' );
require_once( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_allvideoshare'.DS.'libraries'.DS.'utils.php' );

$items = AllVideoShareGalleryHelper::getItems( $params );
$config = AllVideoShareUtils::getConfig();

$doc = JFactory::getDocument();

if( $config->load_bootstrap_css ) {
	$doc->addStyleSheet( JURI::root( true ) . "/components/com_allvideoshare/assets/css/bootstrap.css", "text/css", "screen" );
}
		
if( $config->load_icomoon_font ) {
	$doc->addStyleSheet( JURI::root( true ) . "/media/jui/css/icomoon.css", "text/css", "screen" );
}
		
$doc->addStyleSheet( JURI::root( true ) . "/components/com_allvideoshare/assets/css/allvideoshare.css", "text/css", "screen" );

if( ! empty( $config->custom_css ) ) {
	$doc->addStyleDeclaration( $config->custom_css );
}

require ( JModuleHelper::getLayoutPath( 'mod_allvideosharegallery', 'default_' . $params->get( 'type' ) ) );