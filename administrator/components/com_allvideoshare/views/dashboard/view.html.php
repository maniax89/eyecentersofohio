<?php
/*
 * @version		$Id: view.html.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

class AllVideoShareViewDashboard extends AllVideoShareView {

    public function display( $tpl = null ) {
	
	    $model = $this->getModel();
		
		$this->serverDetails = $model->getServerDetails();
		$this->recentVideos  = $model->getRecentVideos();
		$this->popularVideos = $model->getPopularVideos();
		
		JToolBarHelper::title( JText::_( 'ALL_VIDEO_SHARE' ), 'home' );		
		
		AllVideoShareUtils::subMenus();	
		
        parent::display( $tpl );
		
    }
	
}