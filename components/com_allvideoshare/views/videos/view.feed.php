<?php
/*
 * @version		$Id: view.feed.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareViewVideos extends AllVideoShareView {

	public function display( $tpl = null ) {
		
		$app = JFactory::getApplication();	
		$doc = JFactory::getDocument();	
			
		$model = $this->getModel();
		
		$config = AllVideoShareUtils::getConfig();
		
		$doc->editor = $app->getCfg( 'fromname' );
		$doc->editorEmail = $app->getCfg( 'mailfrom' );	

		$params = $app->getParams();
		
        $items = $model->getItems( $params->get( 'orderby' ), 20 );	
				 
		foreach( $items as $item ) {
			$title = $this->escape( $item->title );
			$title = html_entity_decode( $title, ENT_COMPAT, 'UTF-8' );
			
			$itemId = $app->input->getInt('Itemid') ? '&Itemid='.$app->input->getInt('Itemid') : '';
			$target = JRoute::_( "index.php?option=com_allvideoshare&view=video&slg=".$item->slug.$itemId );
			
			$description  = $item->description;				
			if( $item->preview ) $description .= '<img src="'.$item->preview.'" />';
							
			// load individual item creator class
			$feeditem = new JFeedItem();
			
			$feeditem->title	   = $title;
			$feeditem->link		   = $target;				
			$feeditem->description = $description;			
			$feeditem->category	   = $item->category;	
			$feeditem->date		   = $item->created_date;	
										
			// loads item info into rss array
			$doc->addItem( $feeditem );									
		}				
		
    }
	
}