<?php
/*
 * @version		$Id: category.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareControllerCategory extends AllVideoShareController {
	
	public function category() {
	
		$doc = JFactory::getDocument();
		$type = $doc->getType();
	
		$model = $this->getModel( 'category' );
		
	    $view = $this->getView( 'category', $type );	
        $view->setModel( $model, true );
		$view->setLayout( 'default' );
		$view->display();
		
	}
			
}