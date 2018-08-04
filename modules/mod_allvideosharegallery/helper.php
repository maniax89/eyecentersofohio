<?php
/*
 * @version		$Id: helper.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareGalleryHelper {

    public static function getItems( $params ) {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();

		if( $params->get( 'type' ) == 'videos' ) {

			$query = "SELECT * FROM #__allvideoshare_videos WHERE published=1";
			
			$category = self::getCategory( $params->get( 'category' ) );
			if( $category ) {
				$query .= " AND category=" . $db->quote( $category );
			}
			
			$slug = AllVideoShareUtils::getSlug();
			if( ! empty( $slug ) ) {
				$query .= " AND slug!=" . $db->Quote( $slug );
			}
			
			switch( $params->get( 'orderby' ) ) {
				case 'latest' :
					$query .= ' ORDER BY id DESC';
					break;
				case 'popular' :
					$query .= ' ORDER BY views DESC';
					break;
				case 'random' :
					$query .= ' ORDER BY RAND()';
					break;
				case 'featured' :
					$query .= ' AND featured=1 ORDER BY ordering';
					break;
				default:
					$query .= ' ORDER BY ordering';
			}	
			
		} else {
		
			$query = "SELECT * FROM #__allvideoshare_categories WHERE published=1 AND parent=0";
			
			switch( $params->get( 'orderby' ) ) {
				case 'latest' :
					$query .= ' ORDER BY id DESC';
					break;
				case 'random' :
					$query .= ' ORDER BY RAND()';
					break;
				default:
					$query .= ' ORDER BY ordering';
			}

		}
		
		$limit = (int) $params->get( 'rows' ) * (int) $params->get( 'columns' );
		$query .= " LIMIT $limit";
		
		$db->setQuery( $query );
       	$items = $db->loadObjectList();
			
        return $items;
		
    }
	
	public static function hasMore( $params ) {
	
		$hasMore = 0;
		
		if( (int) $params->get( 'more' ) ) {
		
			$db = JFactory::getDBO();
			
			$limit = (int) $params->get( 'rows' ) * (int) $params->get( 'columns' );
	
			if( $params->get( 'type' ) == 'videos' ) {
	
				$query = "SELECT COUNT(id) FROM #__allvideoshare_videos WHERE published=1";
				
				$category = self::getCategory( $params->get( 'category' ) );
				if( $category ) {
					$query .= " AND category=".$db->quote( $category );
				}
				
				$slug = AllVideoShareUtils::getSlug();
				if( ! empty( $slug ) ) {
					$query .= " AND slug!=" . $db->Quote( $slug );
				}
				
				if( 'featured' == $params->get( 'orderby' ) ) {
					$query .= ' AND featured=1';
				}	
				
			} else {
			
				$query = "SELECT COUNT(id) FROM #__allvideoshare_categories WHERE published=1 AND parent=0";
	
			}
			
			$query .= " LIMIT ".( $limit + 1 );
			
			$db->setQuery( $query );
			$count = $db->loadResult();
				
			$hasMore = ( $count > $limit ) ? 1 : 0;
		
		}
		
		return $hasMore;
		
    }
	
	public static function getCategory( $slug ) {
	
		$name = '';
		
		if( ! empty( $slug ) ) {
		
        	$db = JFactory::getDBO();		
			$query = "SELECT name FROM #__allvideoshare_categories WHERE slug=" . $db->quote( $slug );
        	$db->setQuery( $query );
        	$name = $db->loadResult();
		
		}
		
        return $name;
		
	}
		
}