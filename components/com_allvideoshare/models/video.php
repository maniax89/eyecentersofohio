<?php
/*
 * @version		$Id: video.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareModelVideo extends AllVideoShareModel {
	
	public function getItem() {
	
		$app = JFactory::getApplication();
        $db = JFactory::getDBO();
		 
        $query = "SELECT * FROM #__allvideoshare_videos";
		 
		if( $app->input->getInt('id') ) {
		 	$query .= " WHERE id=".$app->input->getInt('id');
		} else {		 
		 	$slug = AllVideoShareUtils::getSlug();
		 	$query .= " WHERE slug=".$db->Quote( $slug );
		}
		
        $db->setQuery( $query );
        $item = $db->loadObject();
		 
        return $item;
		 
	}
	
	public function getVideos( $category, $orderby, $limit ) {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();
		 
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $limit, 'int' );
		$limitstart = $app->input->get( 'limitstart', '0', 'INT' );
		$limitstart = ( $limit != 0 ? ( floor( $limitstart / $limit ) * $limit ) : 0 );
 
		$this->setState( 'limit', $limit );
		$this->setState( 'limitstart', $limitstart );
		 
		$slug = AllVideoShareUtils::getSlug();
        $query = "SELECT * FROM #__allvideoshare_videos WHERE published=1 AND category=" . $db->Quote( $category ) . " AND slug!=" . $db->Quote( $slug );
		 
		switch( $orderby ) {
		 	case 'latest' :
		 		$query .= ' ORDER BY id DESC';
				break;
			case 'popular' :
				$query .= ' ORDER BY views DESC';
				break;
			case 'featured' :
				$query .= ' AND featured=1 ORDER BY ordering';
				break;
			case 'random' :
				$query .= ' ORDER BY RAND()';
				break;
			default :
				$query .= " ORDER BY ordering";
		}
		 
        $db->setQuery( $query, $limitstart, $limit );
        $items = $db->loadObjectList();
		 
        return $items;
		
	}
	
	public function getTotal( $category ) {
	
		$app = JFactory::getApplication();	
		$db = JFactory::getDBO();
		 
		$slug = AllVideoShareUtils::getSlug();
        $query = "SELECT COUNT(id) FROM #__allvideoshare_videos WHERE published=1 AND category=" . $db->Quote( $category ) . " AND slug!=" . $db->Quote( $slug );
        $db->setQuery( $query );
        $total = $db->loadResult();
		 
        return $total;
		
	}
	
	public function getPagination( $category ) {
	
    	 jimport( 'joomla.html.pagination' );
		 $pagination = new JPagination( $this->getTotal( $category ), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		 
         return $pagination;
		 
	}
		
}