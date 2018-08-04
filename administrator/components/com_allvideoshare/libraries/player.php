<?php
/*
 * @version		$Id: player.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoSharePlayer {
	
    public $video    = '';
	public $player   = '';
	public $license  = '';
	public $isMobile = 0;

	public function build( $videoId = 1, $playerId = 1, $followURL = 0 ) {

		$app = JFactory::getApplication();	
		
		$html = '';
		
		// Get Video Data
		$isCategorySlg = 0;
		if( 'com_allvideoshare' == $app->input->get('option') && 'category' == $app->input->get('view') ) {
		 	$isCategorySlg = 1;
		}
		 
		$slug = AllVideoShareUtils::getSlug();
		if( $followURL == 1 && ! empty( $slug ) && ! $isCategorySlg ) {
		 	$this->video = $this->getVideoBySlug();
		} else {
		 	$this->video = $this->getVideoById( $videoId );
		}
		
		$this->license = $this->getLicenseData();
		 
		// If Video Found
		if( ! empty( $this->video ) ) {
		 
			// Get Player Settings
			$this->player = $this->getPlayerById( $playerId );
			
			// Get Player Engine
			$engine = 'flash';

			if( 'youtube' == $this->video->type ) {
				$engine = 'html';
			}
			 
			if( preg_match( '/iPhone|iPod|iPad|BlackBerry|Android/', $_SERVER['HTTP_USER_AGENT'] ) ) {
				$engine = 'html';
				$this->isMobile = 1;
			}
			
			if( 'thirdparty' == $this->video->type ) {
				$engine = 'thirdparty';
			}

			// Build
			switch( $engine ) {
				case 'thirdparty' :
					$html = sprintf( '<div class="avs-player">%s</div>', $this->video->thirdparty );
					break;
				case 'html' :
					$html = $this->getHtml5Player();
					break;	
				default :
					$html = $this->getFlashPlayer();	
			}
			 
			// Add Custom Meta
			if( 'com_allvideoshare' == $app->input->get('option') && 'video' == $app->input->get('view') && '' != $slug ) {
			 	$this->addCustomMeta();
			}
			 
			// Update Views
			$this->updateViews( $this->video->slug );
			 
		 }
		 
		 // Return...
		 return $html;
		 
	}

	public function getHtml5Player() {
	
		$html = '<div class="avs-player">';
		
		if( 'youtube' == $this->video->type ) {
		 
	     	$queryString = parse_url( $this->video->video, PHP_URL_QUERY );
  	    	parse_str( $queryString, $args );
			$src = 'https://www.youtube.com/embed/'.$args['v'].'?rel=0&showinfo=0&iv_load_policy=3&modestbranding=1';
			if( ! $this->isMobile ) {
				if( $this->player->autostart ) $src .= '&autoplay=1';
				if( $this->player->loop ) $src .= '&loop=1';
			}

			$html .= sprintf( '<iframe src="%s" frameborder="0" allowfullscreen></iframe>', $src );
			
		} else if( 'rtmp' == $this->video->type ) {
		 
	     	$html .= sprintf( '<video onclick="this.play();" poster="%s" controls><source src="%s" type="application/x-mpegurl" /></video>', $this->video->preview, $this->video->hls );
			
		} else {

	    	$html .= sprintf( '<video onclick="this.play();" poster="%s" controls><source src="%s" /></video>', $this->video->preview, $this->video->video );
			
        }
		
		$html .= '</div>';
		 
		return $html;
		 
	}
	
	public function getFlashPlayer() {

		$app = JFactory::getApplication();
		$config = JFactory::getConfig();
		
		$isRewriteEnabled = ( $config->get( 'sef' ) == 1 ) ? 1 : 0; 
		
		$flashvars = 'base='.JURI::root().'&vid='.$this->video->id.'&pid='.$this->player->id.'&sef='.$isRewriteEnabled;
		if( $lang = $app->input->get('lang') ) {
			$flashvars .= '&amp;lang='.$lang;
		}
		
		$swf = JURI::root().'components/com_allvideoshare/player.swf?random='.rand();
				
		$html  = '<div class="avs-player">';
		$html .= '<object name="player" width="100%" height="100%">';
    	$html .= '<param name="movie" value="' . $swf . '" />';
    	$html .= '<param name="wmode" value="opaque" />';
    	$html .= '<param name="allowfullscreen" value="true" />';
    	$html .= '<param name="allowscriptaccess" value="always" />';
    	$html .= '<param name="flashvars" value="' . $flashvars . '" />';
    	$html .= '<object type="application/x-shockwave-flash" data="' . $swf . '" width="100%" height="100%">';
      	$html .= '<param name="movie" value="' . $swf . '" />';
      	$html .= '<param name="wmode" value="opaque" />';
      	$html .= '<param name="allowfullscreen" value="true" />';
      	$html .= '<param name="allowscriptaccess" value="always" />';
      	$html .= '<param name="flashvars" value="' . $flashvars . '" />';
    	$html .= '</object>';
  	 	$html .= '</object>';
		$html .= '</div>';
		 
		return $html;
		
	}

	public function getVideoBySlug() {	
		 
         $db = JFactory::getDBO();
		 
		 $slug = AllVideoShareUtils::getSlug();
         $query = "SELECT * FROM #__allvideoshare_videos WHERE slug=" . $db->Quote( $slug );
         $db->setQuery( $query );
         $item = $db->loadObject();
		 
         return $item;
		 
	}
	
	public function getVideoById( $id ) {
	
         $db = JFactory::getDBO();
		 
         $query = "SELECT * FROM #__allvideoshare_videos WHERE published=1 AND id=" . (int) $id;
         $db->setQuery( $query );
         $item = $db->loadObject();
		 
         return $item;
		 
	}

	public function getPlayerById( $id ) {
	
         $db = JFactory::getDBO();
		 
         $query = "SELECT * FROM #__allvideoshare_players WHERE published=1 AND id=" . (int) $id;
         $db->setQuery( $query );
         $item = $db->loadObject();
		 
		 // Fallback to the default player profile
		 if( empty( $item ) ) {
		 	$query = "SELECT * FROM #__allvideoshare_players WHERE id=1";
        	$db->setQuery( $query );
        	$item = $db->loadObject();
		 }
		 
         return $item;
		 
	}
	
	public function getPreroll() {
	
         $db = JFactory::getDBO();
		 
         $query  = "SELECT id, video, link FROM #__allvideoshare_adverts WHERE published=1 AND (type=".$db->Quote( 'preroll' )." OR type=".$db->Quote( 'both' ).")";
		 $query .= " ORDER BY RAND() LIMIT 1";
         $db->setQuery( $query );
         $item = $db->loadObject();
		
		return $item;
		
	}
	
	public function getPostroll() {
	
        $db = JFactory::getDBO();
		 
        $query  = "SELECT id, video, link FROM #__allvideoshare_adverts WHERE published=1 AND (type=".$db->Quote( 'postroll' )." OR type=".$db->Quote( 'both' ).")";
		$query .= " ORDER BY RAND() LIMIT 1";
        $db->setQuery( $query );
        $item = $db->loadObject();		 
		 
		return $item;
		 
	}
	
	public function getLicenseData() {
	
         $db = JFactory::getDBO();
		 
         $query = "SELECT * FROM #__allvideoshare_licensing WHERE id=1";
         $db->setQuery( $query );
         $item = $db->loadObject();

         return $item;
		 
	}
	
	public function addCustomMeta() {
	
		 $doc = JFactory::getDocument();

         $doc->addCustomTag( '<meta property="og:title" content="'.$this->video->title.'" />' );
         $doc->addCustomTag( '<meta property="og:image" content="'.$this->video->preview.'" />' );
		 		 
	}
	
	public function updateViews() {

		$app = JFactory::getApplication();	
		$db = JFactory::getDBO();
		$session = JFactory::getSession();
		
		$avs = array();
		$arr = array();
		
		if( $session->get( 'avs' ) ) {
			$arr = $session->get( 'avs' );
		}
		
		if( ! in_array( $this->video->slug, $arr ) ) {
	    	$avs = $arr;
		    $avs[] = $this->video->slug;				
	 
		 	$query = "UPDATE #__allvideoshare_videos SET views=views+1 WHERE slug=".$db->Quote( $this->video->slug );
    	 	$db->setQuery ( $query );
		 	$db->query();
		 
		 	$session->set( 'avs', $avs );
		}
		
	}
	
	public function buildEmbed( $videoId = 1, $playerId = 1 ) {
	
		$html  = '<!DOCTYPE html>';
		$html .= '<html>';
		$html .= '<head>';
		$html .= '<link rel="stylesheet" href="'.JURI::root().'components/com_allvideoshare/assets/css/allvideoshare.css" />';
		$html .= '<style type="text/css">body, iframe{ margin: 0 !important; padding: 0 !important; background: transparent !important; }</style>';
		$html .= '<script src="'.JURI::root().'media/jui/js/jquery.min.js" type="text/javascript"></script>';
  		$html .= '<script src="'.JURI::root().'components/com_allvideoshare/assets/js/allvideoshare.js" type="text/javascript"></script>';
		$html .= '</head>';
		$html .= '<body>';
		$html .= $this->build( $videoId, $playerId );
		$html .= '</body>';
		$html .= '</html>';
		
		return $html;
		
	}
		
}