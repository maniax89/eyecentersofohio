<?php
/*
 * @version		$Id: category.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareModelCategory extends AllVideoShareModel {
	
	public function getItem() {
	
        $db = JFactory::getDBO();
		 
		$slug = AllVideoShareUtils::getSlug();		 
        $query = "SELECT * FROM #__allvideoshare_categories WHERE published=1 AND slug=" . $db->Quote( $slug );
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
         
         $query = "SELECT * FROM #__allvideoshare_videos WHERE published=1 AND category=" . $db->Quote( $category );
		 
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
	
		 $db = JFactory::getDBO();
         
         $query = "SELECT COUNT(id) FROM #__allvideoshare_videos WHERE published=1 AND category=" . $db->Quote( $category );
         $db->setQuery( $query );
         $total = $db->loadResult();
		 
         return $total;
		 
	}
	
	public function getPagination( $category ) {
	
    	 jimport( 'joomla.html.pagination' );
		 $pagination = new JPagination( $this->getTotal( $category ), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		 
         return $pagination;
		 
	}
	
	public function getSubCategories( $parent, $orderby ) {
	
         $db = JFactory::getDBO();
		 
         $query = "SELECT * FROM #__allvideoshare_categories WHERE published=1 AND parent=" . $db->Quote( $parent );
		 
		 switch( $orderby ) {
		 	case 'latest' :
		 		$query .= ' ORDER BY id DESC';
				break;
			case 'random' :
				$query .= ' ORDER BY RAND()';
				break;
			default :
				$query .= " ORDER BY ordering";
		 }	

         $db->setQuery( $query );		 
         $items = $db->loadObjectList();
		 
         return $items;
		 
	}
	
}