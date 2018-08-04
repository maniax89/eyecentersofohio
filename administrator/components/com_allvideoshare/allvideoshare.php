<?php
/*
 * @version		$Id: allvideoshare.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$app = JFactory::getApplication();

// Register Libraries
JLoader::register( 'AllVideoShareController', JPATH_COMPONENT.'/controllers/controller.php' );
JLoader::register( 'AllVideoShareModel', JPATH_COMPONENT.'/models/model.php' );
JLoader::register( 'AllVideoShareView', JPATH_COMPONENT.'/views/view.php' );
JLoader::register( 'AllVideoShareHtml', JPATH_COMPONENT.'/libraries/html.php' );
JLoader::register( 'AllVideoShareUpload', JPATH_COMPONENT.'/libraries/upload.php' );
JLoader::register( 'AllVideoShareUtils', JPATH_COMPONENT.'/libraries/utils.php' );

// Define constants for all pages
$user = JFactory::getUser();

if( ! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
define( 'ALLVIDEOSHARE_UPLOAD_DIR', DS.'media'.DS.'com_allvideoshare'.DS );
define( 'ALLVIDEOSHARE_UPLOAD_BASE', JPATH_ROOT.ALLVIDEOSHARE_UPLOAD_DIR );
define( 'ALLVIDEOSHARE_UPLOAD_BASEURL', JURI::root( true ).str_replace( DS, '/', ALLVIDEOSHARE_UPLOAD_DIR ) );
define( 'ALLVIDEOSHARE_USERID', $user->get( 'id' ) );
define( 'ALLVIDEOSHARE_USERNAME', $user->get( 'username' ) );

// Require the base controller
$view = $app->input->get( 'view', 'dashboard' );
$controller = JString::strtolower( $view );
require_once JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php';

// Initialize the controller
$obj = 'AllVideoShareController'.$controller;
$controller = new $obj();

// Perform the Request task
$task = $app->input->get( 'task', $view );
$controller->execute( $task );
$controller->redirect();