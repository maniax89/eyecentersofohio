<?php
/*
 * @version		$Id: user.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareModelUser extends AllVideoShareModel {

	public function getItems() {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();	
		 
		$limit = $app->getUserStateFromRequest( 'global.list.limit', 'limit', 10, 'int' );
		$limitstart = $app->input->get( 'limitstart', '0', 'INT' );
		$limitstart = ( $limit != 0 ? ( floor( $limitstart / $limit ) * $limit ) : 0 );
 
		$this->setState( 'limit', $limit );
		$this->setState( 'limitstart', $limitstart );		 
		 
		$s = $app->getUserStateFromRequest( 'com_allvideoshare.user.search', 's', '', 'string' );	
		$s = JString::strtolower( $s );
    	 	 
		$searchWord = $db->Quote( '%'.$db->escape( $s, true ).'%', false );		
		$query  = "SELECT * FROM #__allvideoshare_videos WHERE user=" . $db->quote( ALLVIDEOSHARE_USERNAME ) . " AND (title LIKE $searchWord OR category LIKE $searchWord OR tags LIKE $searchWord)";
		$query .= " ORDER BY id DESC";
		 
    	$db->setQuery ( $query, $limitstart, $limit );
    	$items = $db->loadObjectList();
		 
        return $items;
		 
	}
	
	public function getTotal() {
	
		$app = JFactory::getApplication();
        $db = JFactory::getDBO();
		 
		$s = $app->getUserStateFromRequest( 'com_allvideoshare.user.search', 's', '', 'string' );	
		$s = JString::strtolower( $s );
		 
		$searchWord = $db->Quote( '%'.$db->escape( $s, true ).'%', false );	
        $query = "SELECT COUNT(id) FROM #__allvideoshare_videos WHERE user=" . $db->quote( ALLVIDEOSHARE_USERNAME ) . " AND (title LIKE $searchWord OR category LIKE $searchWord OR tags LIKE $searchWord)";
        $db->setQuery( $query );
        $total = $db->loadResult();
		 
        return $total;
		 
	}
	
	public function getPagination() {
	
    	 jimport( 'joomla.html.pagination' );
		 $pagination = new JPagination( $this->getTotal(), $this->getState( 'limitstart' ), $this->getState( 'limit' ) );
		 
         return $pagination;
		 
	}
	
	public function getItem() {
		 
		 $app = JFactory::getApplication();
		 $id = $app->input->getInt('id');
		 
         $row = JTable::getInstance( 'Videos', 'AllVideoShareTable' );
         $row->load( $id );

         return $row;
		 
	}
	
	public function save() {
	
		$app = JFactory::getApplication();
		 
		$id = $app->input->getInt('id', 0);
		 
	  	$row = JTable::getInstance( 'Videos', 'AllVideoShareTable' );
      	$row->load( $id );
	
		$post = $app->input->post->getArray();
      	if( ! $row->bind( $post ) ) {
			$app->enqueueMessage( $row->getError(), 'error' );
	  	}	  	 
		
		$row->title = AllVideoShareUtils::safeString( $row->title );
		$row->slug  = AllVideoShareUtils::getVideoSlug( $row );
		 
	  	$row->description = $app->input->post->get( 'description', '', 'HTML' );

		if( $row->type == 'upload' ) {	
			
			jimport( 'joomla.filesystem.folder' );
			
		 	$folder = 'videos' . DS . JHTML::_( 'date', 'now', 'Y-m', false );	
		 	if( ! JFolder::exists( ALLVIDEOSHARE_UPLOAD_BASE . $folder . DS ) ) {
				JFolder::create( ALLVIDEOSHARE_UPLOAD_BASE . $folder . DS );
			}
		
			$row->video = AllVideoShareUpload::doUpload( 'upload_video', $folder, $row->video );
			$row->hd = AllVideoShareUpload::doUpload( 'upload_hd', $folder, $row->hd );
	  		$row->thumb = AllVideoShareUpload::doUpload( 'upload_thumb', $folder, $row->thumb );
			$row->preview = AllVideoShareUpload::doUpload( 'upload_preview', $folder, $row->preview );
			
	  	} else {
			
			$row->video = AllVideoShareUtils::safeString( $row->video );
			$row->hd = AllVideoShareUtils::safeString( $row->hd );
			$row->streamer = AllVideoShareUtils::safeString( $row->streamer );
			$row->hls = AllVideoShareUtils::safeString( $row->hls );
			
		}
		 
		if( ! $row->id ) {
		 	$config = AllVideoShareUtils::getConfig();
			
		 	$row->user      = ALLVIDEOSHARE_USERNAME;
			$row->access    = 'public';
			$row->published = $config->auto_approval;
		 }
		 
		 $row->reorder( "category='".$row->category."'" );
		 
	  	 if( ! $row->store() ) {
			$app->enqueueMessage( $row->getError(), 'error' );
	  	 }

		 $itemId = '';
		 if( $app->input->getInt('Itemid') ) {
		 	$itemId = '&Itemid='.$app->input->getInt('Itemid');
		 }
		 $link = JRoute::_( 'index.php?option=com_allvideoshare&view=user'.$itemId, false );
		 
		 $app->redirect( $link, JText::_( 'SAVED' ) );
		 	 
	}

	public function delete() {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();	
		
		$id = $app->input->getInt('id');
		
		// Delete media files
		$query = "SELECT video,hd,thumb,preview FROM #__allvideoshare_videos WHERE id=".$id;
		$db->setQuery( $query );
		$item = $db->loadObject();
		
		AllVideoShareUtils::deleteFile( $item->video );
		AllVideoShareUtils::deleteFile( $item->hd );
		AllVideoShareUtils::deleteFile( $item->thumb );
		AllVideoShareUtils::deleteFile( $item->preview );
       
	   	// Delete from the database
		$query = "DELETE FROM #__allvideoshare_videos WHERE id=".$id;
        $db->setQuery( $query );
        $db->query();
		
         $itemId = '';
		 if( $app->input->getInt('Itemid') ) {
		 	$itemId = '&Itemid='.$app->input->getInt('Itemid');
		 }
		 $link = JRoute::_( 'index.php?option=com_allvideoshare&view=user'.$itemId, false );
		 
		 $app->redirect( $link ); 
		 
	}
		
}