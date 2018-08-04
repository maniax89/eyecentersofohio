<?php
/*
 * @version		$Id: categories.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareModelCategories extends AllVideoShareModel {
	
	public function getItems( $orderby, $limit ) {
	
		 $app = JFactory::getApplication();	
		 $db = JFactory::getDBO();
		 
		 $limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', $limit, 'int' );
		 $limitstart = $app->input->get( 'limitstart', '0', 'INT' ); 
		 $limitstart = ( $limit != 0 ? ( floor( $limitstart / $limit ) * $limit ) : 0 );
 
		 $this->setState( 'limit', $limit );
		 $this->setState( 'limitstart', $limitstart );

         $query = "SELECT * FROM #__allvideoshare_categories WHERE published=1 AND parent=0";
		 	
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
		 
         $db->setQuery( $query, $limitstart, $limit );
         $items = $db->loadObjectList();
		 
		 return $items;

	}
	
	public function getTotal() {
	
		 $db = JFactory::getDBO();

         $query = "SELECT COUNT(id) FROM #__allvideoshare_categories WHERE published=1 AND parent=0";		 
         $db->setQuery( $query );
         $total = $db->loadResult();
		 
		 return $total;

	}
	
	public function getPagination() {
	
    	 jimport( 'joomla.html.pagination' );
		 $pagination = new JPagination( $this->getTotal(), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		 
         return $pagination;
		 
	}
	
	public function getVideos( $orderby, $limit ) {
	
		 $db = JFactory::getDBO();	

         $query = "SELECT * FROM #__allvideoshare_videos WHERE published=1";
		 
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
		 
		 $query .= " LIMIT $limit";
		 
         $db->setQuery( $query );
         $items = $db->loadObjectList();
		 
         return $items;
		 
	}
	
}