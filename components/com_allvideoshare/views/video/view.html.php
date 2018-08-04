<?php
/*
 * @version		$Id: view.html.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// import required libraries
require_once( JPATH_ROOT.DS.'administrator'.DS.'components'.DS.'com_allvideoshare'.DS.'libraries'.DS.'player.php' );

class AllVideoShareViewVideo extends AllVideoShareView {

    public function display( $tpl = null ) {
	
	    $app = JFactory::getApplication();
		
		$this->config = AllVideoShareUtils::getConfig();
		
		$model = $this->getModel();

		$this->item = $model->getItem();
		
		if( ! $this->item ) {
			$app->enqueueMessage( JText::_( 'ITEM_NOT_FOUND' ), 'notice' );
			return true;
		}
		
		if( ! ALLVIDEOSHARE_USERID && $this->item->access == 'registered' ) {
			$uri = JFactory::getURI();
			$loginURL = JRoute::_( 'index.php?option=com_users&view=login&return='.base64_encode( $uri->toString() ).'&Itemid='.$app->input->getInt('Itemid') );
			$app->redirect( $loginURL, JText::_( 'YOU_NEED_TO_REGISTER_TO_VIEW_THIS_PAGE' ) );	
			return true;
		}
		
		$this->playerObj = new AllVideoSharePlayer();

		if( 'component' == $app->input->get('tmpl') ) {
			$this->player = $this->playerObj->buildEmbed( $this->item->id, $this->config->playerid );
			echo $this->player;
			exit();
		} else {
			$this->player = $this->playerObj->build( $this->item->id, $this->config->playerid );
		}
		
		$this->params = $app->getParams();
		
		$this->rows = $this->params->get( 'no_of_rows', $this->config->rows );
		$this->cols = $this->params->get( 'no_of_cols', $this->config->cols );

		$limit = (int) $this->rows * (int) $this->cols;
		$this->videos = $model->getVideos( $this->item->category, $this->params->get( 'orderby' ), $limit );
		$this->pagination = $model->getPagination( $this->item->category );

		$this->setHeaders();
		$this->generateBreadcrumbs( $this->item );
				
        parent::display( $tpl );
		
    }
	
	public function setHeaders() {
	
		$doc = JFactory::getDocument();
		
		$doc->setTitle( $doc->getTitle() . ' - ' . $this->item->title );
		
		if( $this->params->get( 'menu-meta_keywords' ) ) {
			$doc->setMetadata( 'keywords', $this->params->get( 'menu-meta_keywords' ) );
		}
		
		if( ! empty( $this->item->tags ) ) {
			$doc->setMetaData( 'keywords', $this->item->tags );
		}
		
		$description = '';
		
		if( $this->params->get( 'menu-meta_description' ) ) {
			$description = $this->params->get( 'menu-meta_description' );			
		}
		
		if( ! empty( $this->item->metadescription ) ) {
			$description = $this->item->metadescription;
		}
		
		if( empty( $description ) && ! empty( $this->item->description ) ) {
			$description = AllVideoShareUtils::Truncate( $this->item->description );
		}
		
		if( ! empty( $description ) ) {
			$doc->setDescription( $description );
		}

		if( $this->params->get( 'robots' ) ) {
			$doc->setMetadata( 'robots', $this->params->get( 'robots' ) );
		}
		
		if( $this->config->load_bootstrap_css ) {
			$doc->addStyleSheet( JURI::root( true ) . "/components/com_allvideoshare/assets/css/bootstrap.css", "text/css", "screen" );
		}
		
		if( $this->config->load_icomoon_font ) {
			$doc->addStyleSheet( JURI::root( true ) . "/media/jui/css/icomoon.css", "text/css", "screen" );
		}
		
		$doc->addStyleSheet( JURI::root( true ) . "/components/com_allvideoshare/assets/css/allvideoshare.css", "text/css", "screen" );
		
		if( ! empty( $this->config->custom_css ) ) {
			$doc->addStyleDeclaration( $this->config->custom_css );
		}
		
		if( $this->config->comments_type == 'facebook' ) {
			$doc->addScriptDeclaration("
				(function(d, s, id) {
					var js, fjs = d.getElementsByTagName(s)[0];
					if (d.getElementById(id)) return;
					js = d.createElement(s); js.id = id;
					js.src = '//connect.facebook.net/en_US/all.js#appId=".$this->config->fbappid."&xfbml=1';
					fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
			");
	
			if( $this->config->fbappid ) {
				$doc->addCustomTag( '<meta property="fb:app_id" content="'.$this->config->fbappid.'">' );
			}
		}
	
	}
	
	public function generateBreadcrumbs( $video ) {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();	
		
		$itemid = $app->input->getInt('Itemid');
		
		jimport( 'joomla.application.pathway' );
		$breadcrumbs = $app->getPathway();
		$crumbs = array();
	
		$index = 0;	

		$query = 'SELECT * FROM #__allvideoshare_categories WHERE name='.$db->Quote( $video->category );
		$db->setQuery( $query );
		$item = $db->loadObject();		
		
		if( $item && $item->parent > 0 ) {
			$query = 'SELECT * FROM #__allvideoshare_categories WHERE id='.$item->parent;
			$db->setQuery( $query );
			$itemLevel1 = $db->loadObject();			
					
			if( $itemLevel1->parent > 0 ) {
				$query = 'SELECT * FROM #__allvideoshare_categories WHERE id='.$itemLevel1->parent;
				$db->setQuery( $query );
				$itemLevel0 = $db->loadObject();
				
				$crumbs[ $index ][0] = $itemLevel0->name;
				$crumbs[ $index ][1] = JRoute::_( 'index.php?option=com_allvideoshare&Itemid='.$itemid.'&view=category&slg='.$itemLevel0->slug );
				$index++;	
			}
			$crumbs[ $index ][0] = $itemLevel1->name;
			$crumbs[ $index ][1] = JRoute::_( 'index.php?option=com_allvideoshare&Itemid='.$itemid.'&view=category&slg='.$itemLevel1->slug );
			$index++;
		}
		
		if( $item ) {
        	$crumbs[ $index ][0] = $item->name;		
			$crumbs[ $index ][1] = JRoute::_( 'index.php?option=com_allvideoshare&Itemid='.$itemid.'&view=category&slg='.$item->slug );
			$index++;
		}
		
		$crumbs[ $index ][0] = $video->title;
		$crumbs[ $index ][1] = JRoute::_( 'index.php?option=com_allvideoshare&Itemid='.$itemid.'&view=video&slg='.$video->slug );		

		for( $i = 0, $n = count( $crumbs ); $i < $n; $i++ ) {
			$breadcrumbs->addItem( $crumbs[ $i ][0], $crumbs[ $i ][1] );
		}
		
    }
	
}