<?php
/*
 * @version		$Id: allvideoshare.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$app = JFactory::getApplication();

// Register Libraries
JLoader::register( 'AllVideoShareController', JPATH_COMPONENT_ADMINISTRATOR.'/controllers/controller.php' );
JLoader::register( 'AllVideoShareModel', JPATH_COMPONENT_ADMINISTRATOR.'/models/model.php' );
JLoader::register( 'AllVideoShareView', JPATH_COMPONENT_ADMINISTRATOR.'/views/view.php' );
JLoader::register( 'AllVideoShareHtml', JPATH_COMPONENT_ADMINISTRATOR.'/libraries/html.php' );
JLoader::register( 'AllVideoShareUpload', JPATH_COMPONENT_ADMINISTRATOR.'/libraries/upload.php' );
JLoader::register( 'AllVideoShareUtils', JPATH_COMPONENT_ADMINISTRATOR.'/libraries/utils.php' );

// Define constants for all pages
$user = JFactory::getUser();

if( ! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
define( 'ALLVIDEOSHARE_UPLOAD_DIR', DS.'media'.DS.'com_allvideoshare'.DS );
define( 'ALLVIDEOSHARE_UPLOAD_BASE', JPATH_ROOT.ALLVIDEOSHARE_UPLOAD_DIR );
define( 'ALLVIDEOSHARE_UPLOAD_BASEURL', JURI::root( true ) . str_replace( DS, '/', ALLVIDEOSHARE_UPLOAD_DIR ) );
define( 'ALLVIDEOSHARE_USERID', $user->get( 'id' ) );
define( 'ALLVIDEOSHARE_USERNAME', $user->get( 'username' ) );

// Require the base controller
$slug = AllVideoShareUtils::getSlug();
if( 'category' == $app->input->get('view') && empty( $slug ) ) {
	$app->input->set('view', 'categories');
} else if( 'video' == $app->input->get('view') && ! ( $slug || $app->input->get('tmpl') ) ) {
	$app->input->set('view', 'videos');
}
$view = $app->input->get('view', 'categories');

$controller = JString::strtolower( $view );
require_once JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

// Initialize the controller
$obj = 'AllVideoShareController'.$controller;
$controller = new $obj();

// Perform the Request task
$controller->execute( $app->input->get('task', $view) );
$controller->redirect();