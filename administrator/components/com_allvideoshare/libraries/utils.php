<?php
/*
 * @version		$Id: utils.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareUtils {

	public static function subMenus() {
	
		$app = JFactory::getApplication();
		
		$views = array(
			'dashboard'   => false,
			'categories'  => false,
			'videos'      => false, 
			'approval'    => false,
			'commercials' => false,
			'players'     => false,
			'config'      => false,
			'licensing'   => false
		);
		$view = $app->input->get( 'view', 'dashboard' );
		$views[ $view ] = true;		
		
		JSubMenuHelper::addEntry( JText::_( 'DASHBOARD' ), 'index.php?option=com_allvideoshare', $views['dashboard'] );	
		JSubMenuHelper::addEntry( JText::_( 'CATEGORIES' ), 'index.php?option=com_allvideoshare&view=categories', $views['categories'] );		
		JSubMenuHelper::addEntry( JText::_( 'VIDEOS' ), 'index.php?option=com_allvideoshare&view=videos', $views['videos'] );
		JSubMenuHelper::addEntry( JText::_( 'APPROVAL_QUEUE' ), 'index.php?option=com_allvideoshare&view=approval', $views['approval'] );
		JSubMenuHelper::addEntry( JText::_( 'ADVERTISEMENTS' ), 'index.php?option=com_allvideoshare&view=commercials', $views['commercials'] );
		JSubMenuHelper::addEntry( JText::_( 'PLAYERS' ), 'index.php?option=com_allvideoshare&view=players', $views['players'] );	
		JSubMenuHelper::addEntry( JText::_( 'CONFIGURATION' ), 'index.php?option=com_allvideoshare&view=config', $views['config'] );
		JSubMenuHelper::addEntry( JText::_( 'LICENSING' ), 'index.php?option=com_allvideoshare&view=licensing', $views['licensing'] );
		
	}
	
	public static function checkToken() {
	
		if( JSession::checkToken( 'get' ) ) {
			JSession::checkToken( 'get' ) or die( 'Invalid Token' );
		} else {
			JSession::checkToken() or die( 'Invalid Token' );
		}
		
	}
	
	public static function safeString( $value = '' ) {

		return htmlspecialchars( trim( $value ) );
		
	}
	
	public static function stringURLSafe( $string ) {
	
		jimport( 'joomla.filter.output' );
		
    	if( 1 == JFactory::getConfig()->get('unicodeslugs') ) {
        	$output = JFilterOutput::stringURLUnicodeSlug( $string );
    	} else {
        	$output = JFilterOutput::stringURLSafe( $string );
    	}
    	
		return $output;
		
	}
	
	public static function Truncate( $text, $length = 150 ) {
	
		$text = strip_tags( $text );
		
    	if( $length > 0 && JString::strlen( $text ) > $length ) {
        	$tmp = JString::substr( $text, 0, $length );
            $tmp = JString::substr( $tmp, 0, JString::strrpos( $tmp, ' ' ) );

            if( JString::strlen( $tmp ) >= $length - 3 ) {
            	$tmp = JString::substr( $tmp, 0, JString::strrpos( $tmp, ' ' ) );
            }
 
            $text = $tmp.'...';
        }
 
        return $text;
		
	}
	
	public static function getCategorySlug( $row ) {
	
		$slug = self::stringURLSafe( $row->slug );
		
		if( empty( $slug ) ) {
			$slug = self::stringURLSafe( $row->name );
			
			$db = JFactory::getDBO();		
			$query = 'SELECT COUNT(id) FROM #__allvideoshare_categories WHERE slug='.$db->Quote( $slug );
			$db->setQuery( $query );
         	$count = $db->loadResult();
			
			if( $count ) $slug = '';
		}
		
		if( empty( $slug ) ) {
			$slug = JHTML::_( 'date', 'now', 'Y-m-d-H-i-s', false );
		}
		
		return $slug;
	
	}
	
	public static function getVideoSlug( $row ) {
	
		$slug = self::stringURLSafe( $row->slug );
		
		if( empty( $slug ) ) {
			$slug = self::stringURLSafe( $row->title );
			
			$db = JFactory::getDBO();		
			$query = 'SELECT COUNT(id) FROM #__allvideoshare_videos WHERE slug='.$db->Quote( $slug );
			$db->setQuery( $query );
         	$count = $db->loadResult();
			
			if( $count ) $slug = '';
		}
		
		if( empty( $slug ) ) {
			$slug = JHTML::_( 'date', 'now', 'Y-m-d-H-i-s', false );
		}
		
		return $slug;
	
	}
	
	public static function getSlug() {
	
         return $slug = str_replace( ":", "-", JRequest::getVar('slg') );
		 
	}
	
	public static function getConfig() {
	
         $db = JFactory::getDBO();
		 
         $query = "SELECT * FROM #__allvideoshare_config WHERE id=1";
         $db->setQuery( $query );
         $item = $db->loadObject();
		 
         return $item;
		 
	}	
	
	public static function getCategories( $exclude_category = '' ) {
	
        $db = JFactory::getDBO();
		
		$query = 'SELECT * FROM #__allvideoshare_categories';
		
		if( ! empty( $exclude_category ) ) {
			$query .= ' WHERE name!=' . $db->quote( $exclude_category );
		}
		
		$query .= ' ORDER BY ordering ASC';
		$db->setQuery( $query );
		$mitems = $db->loadObjectList();
		
		$children = array();
		if( $mitems ) {
			foreach( $mitems as $v ) {
				$v->title = $v->name;
				$v->parent_id = $v->parent;
				$pt = $v->parent;				
				$list = @$children[ $pt ] ? $children[ $pt ] : array();
				array_push( $list, $v );
				$children[ $pt ] = $list;
			}
		}
		
		$list = JHTML::_( 'menu.treerecurse', 0, '', array(), $children, 9999, 0, 0 );	
			
		return $list;
		
	}
	
	public static function getYouTubeVideoId( $url ) {
	
    	$videoId = false;
    	$url = parse_url( $url );
		
    	if( strcasecmp( $url['host'], 'youtu.be' ) === 0 ) {
        	$videoId = substr( $url['path'], 1 );
    	} else if( strcasecmp( $url['host'], 'www.youtube.com' ) === 0 ) {
        	if( isset( $url['query'] ) ) {
           		parse_str( $url['query'], $url['query'] );
            	if( isset( $url['query']['v'] ) ) {
               		$videoId = $url['query']['v'];
            	}
        	}
			
        	if( $videoId == false ) {
            	$url['path'] = explode( '/', substr( $url['path'], 1 ) );
            	if( in_array( $url['path'][0], array( 'e', 'embed', 'v' ) ) ) {
                	$videoId = $url['path'][1];
            	}
        	}
    	}
		
    	return $videoId;
		
	}
	
	public static function getYouTubeVideoImg( $id ) {
	
		$resolution = array (
        	'maxresdefault',
        	'sddefault',
        	'mqdefault',
        	'hqdefault',
        	'default'
    	);

    	for( $x = 0; $x < sizeof( $resolution ); $x++ ) {
        	$url = '//img.youtube.com/vi/' . $id . '/' . $resolution[ $x ] . '.jpg';
        	if( get_headers( $url )[0] == 'HTTP/1.0 200 OK' ) {
            	break;
        	}
    	}
    	
		return $url;
	
	}
	
	public static function getVimeoVideoId( $url ) {
	
		$videoId = '';
    	$isVimeo = preg_match( '/vimeo\.com/i', $url );
	
		if( $isVimeo ) {
    		$pattern = '/\/\/(www\.)?vimeo.com\/(\d+)($|\/)/';
    		preg_match( $pattern, $url, $matches );
    		if( count( $matches ) ) {
      			$videoId = $matches[2];
    		}
  		}
		
    	return $videoId;
		
	}
	
	public static function getVimeoVideoImg( $id ) {
	
		$vimeo = unserialize( file_get_contents( "https://vimeo.com/api/v2/video/$id.php" ) );
		return $vimeo[0]['thumbnail_large'];
	
	}
	
	public static function getImage( $file = '' ) {

		$default = JURI::root().'components/com_allvideoshare/assets/images/default.jpg';
		
		if( empty( $file ) ) {
			return $default;
		}
		
		$pos = strpos( $file, 'img.youtube.com/vi/default.jpg' );		
		if( $pos !== false ) {			
			return $default;
		}
		
		return $file;
		
	}
	
	public static function buildRoute( $slug = 0, $view = 'video', $itemId = 0 ) {

		$is_exact_match_found = 0;
		
		// Check if there is a menu item with the given SLUG value for the view
		$itemId = self::_findItem( $slug, $view );
		if( $itemId > 0 ) $is_exact_match_found = 1;
		
		// Check if there is a menu item atleast for the view
		if( empty( $itemId ) ) {
			$itemId = self::_findItem( "%", $view );
		}
		
		// Fallback to the current itemId
		if( empty( $itemId ) ) {
			$app = JFactory::getApplication();
			$itemId = $app->input->getInt( 'Itemid', 0 );
		}

		// Build Route
		if( $is_exact_match_found ) {
			$url = "index.php?Itemid=$itemId";
		} else {
			$url = "index.php?option=com_allvideoshare&view=$view&slg=$slug";
			if( $itemId > 0 ) $url .= '&Itemid='.$itemId;
		}
		
		return JRoute::_( $url );
	
	}
	
	protected static function _findItem( $slug, $view, $itemId = 0 ) {
	
		$db = JFactory::getDBO();
		
		$query  = "SELECT id FROM #__menu";
		if( "%" == $slug ) {
			$query .= " WHERE link LIKE ".$db->Quote( "index.php?option=com_allvideoshare&view=$view&slg=$slug" );
		} else {
			$query .= " WHERE link=".$db->Quote( "index.php?option=com_allvideoshare&view=$view&slg=$slug" );
		}
		$query .= " AND published=1 LIMIT 1";
		$db->setQuery( $query );
		if( $id = $db->loadResult() ) {
			$itemId = $id;
		}
		
		return $itemId;

	}
	
	public static function deleteFile( $file = '' ) {
	
		if( empty( $file ) ) return;
		
		// If an uploaded file
		$isUploaded = strpos( $file, 'media/com_allvideoshare/' );		
		if( $isUploaded !== false ) {
		
			jimport( 'joomla.filesystem.folder' );
			jimport( 'joomla.filesystem.file' );
			
			// Remove Protocols
			$file = explode( 'media', $file );
			$file = '/media'.$file[1];
			$file = JPATH_ROOT.str_replace( '/', DS, $file );
			
			// Delete if the file exists
			if( JFile::exists( $file ) ) {
				JFile::delete( $file );
			}
			
			// Delete the parent directory if empty
			$directory = pathinfo( $file, PATHINFO_DIRNAME );
			if( JFolder::exists( $directory ) ) {
				$files = array_diff( scandir( $directory ), array( '.', '..' ) );
				if( empty( $files ) ) {
					JFolder::delete( $directory );
				}
			}
			
		}
	
	}
	
}