<?php
/*
 * @version		$Id: allvideoshareplayer.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import required libraries
jimport( 'joomla.plugin.plugin' );

if( ! defined( 'DS' ) ) define( 'DS', DIRECTORY_SEPARATOR );
require_once( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_allvideoshare'.DS.'libraries'.DS.'utils.php' );
require_once( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_allvideoshare'.DS.'libraries'.DS.'player.php' );

class plgContentAllVideoSharePlayer extends JPlugin {

	protected $autoloadLanguage = true;
	
	public function onContentPrepare( $context, &$article, &$params, $page = 0 ) {
		$this->onPrepareContent( $article, $params, $page );
	}

	public function onPrepareContent( &$row, &$params, $limitstart ) {
	
		// simple performance check to determine whether bot should process further
		if( JString::strpos( $row->text, 'avsplayer' ) === false ) {
			return true;
		}
		
		// expression to search for
 		$regex = '/{avsplayer\s*.*?}/i';
		
		// find all instances of plugin and put in $matches
		preg_match_all( $regex, $row->text, $matches );

		// Number of plugins
 		$count = count( $matches[0] );
		
		$this->plgContentProcessPositions( $row, $matches, $count, $regex );

	}
	
	public function plgContentProcessPositions( $row, $matches, $count, $regex ) {
	
 		for( $i = 0; $i < $count; $i++ ) {
 			$load = str_replace( '{avsplayer', '', $matches[0][ $i ] );
 			$load = str_replace( '}', '', $load );
			$load = trim( $load );
			$load = explode( " ", $load );
			$load = implode( "&", $load );
 			
			$modules   = $this->plgContentLoadPosition( $load );
			$row->text = str_replace( $matches[0][ $i ], $modules, $row->text );
 		}

  		// removes tags without matching module positions
		$row->text = preg_replace( $regex, '', $row->text );
		
	}
	
	public function plgContentLoadPosition( $load ) {

		$config = AllVideoShareUtils::getConfig();
		
		$doc = JFactory::getDocument();
		$doc->addStyleSheet( JURI::root( true ) . "/components/com_allvideoshare/assets/css/allvideoshare.css", "text/css", "screen" );
		if( ! empty( $config->custom_css ) ) {
			$doc->addStyleDeclaration( $config->custom_css );
		}
		
		$videoid    = 1;
		$playerid   = 1;
		$autodetect = 0;
	    parse_str( $load );
		
		$playerObj = new AllVideoSharePlayer();
		return $playerObj->build( $videoid, $playerid, $autodetect );
		
	}

}