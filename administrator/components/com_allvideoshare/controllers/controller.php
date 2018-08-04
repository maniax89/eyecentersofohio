<?php
/*
 * @version		$Id: controller.php 3.0 2017-01-10 $
 * @package		Joomla
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class AllVideoShareController extends JControllerLegacy {
	
	public function display( $cachable = false, $urlparams = array() ) {
	
		parent::display( $cachable, $urlparams );
		
	}
		
}