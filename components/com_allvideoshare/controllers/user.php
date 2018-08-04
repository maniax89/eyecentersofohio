<?php
/*
 * @version		$Id: user.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareControllerUser extends AllVideoShareController {
	
	public function user() {
	
		$app = JFactory::getApplication();
		
		if( 'add' == $app->input->get( 'layout' ) ) {
			$this->add();
		} else {
			$model = $this->getModel( 'user' );
			
			$view = $this->getView( 'user', 'html' );	
			$view->setModel( $model, true );
			$view->setLayout( 'default' );
			$view->display();
		}

	}
	
	public function add() {	
		
		$model = $this->getModel( 'user' );
		
	    $view = $this->getView( 'user', 'html' );	
        $view->setModel( $model, true );
		$view->setLayout( 'add' );
		$view->add();

	}
	
	public function edit() {	
		
		AllVideoShareUtils::checkToken();
		
		$model = $this->getModel( 'user' );
		
	    $view = $this->getView( 'user', 'html' );	
        $view->setModel( $model, true );
		$view->setLayout( 'edit' );
		$view->edit();

	}
	
	public function save() {		
		
		AllVideoShareUtils::checkToken();
		
		$model = $this->getModel( 'user' );
		$model->save();
		
	}
	
	public function delete() {		
		
		AllVideoShareUtils::checkToken();
		
		$model = $this->getModel( 'user' );
		$model->delete();
		
	}
			
}