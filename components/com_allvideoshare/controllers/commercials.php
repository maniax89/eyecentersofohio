<?php
/*
 * @version		$Id: commercials.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class AllVideoShareControllerCommercials extends AllVideoShareController {

	public function impressions() {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();
		
       	$id = $app->input->getInt('id');
		$query = "UPDATE #__allvideoshare_adverts SET impressions=impressions+1 WHERE id=".$id;
    	$db->setQuery( $query );
		$db->query();
		
	}
	
	public function click() {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();	
			
        $id = $app->input->getInt('id');		
				
		// Update clicks count
		$query = "UPDATE #__allvideoshare_adverts SET clicks=clicks+1 WHERE id=".$id;
    	$db->setQuery( $query );
		$db->query();
		
		// Redirect
		$query = "SELECT link FROM #__allvideoshare_adverts WHERE id=".$id;
    	$db->setQuery( $query );
		$link = $db->loadResult();
		
		if( $link ) {
			$app->redirect( $link );
		} else {
			$app->redirect( '/' );
		}
		
	}
	
	public function clicks() {
	
		$app = JFactory::getApplication();
		$db = JFactory::getDBO();
		
        $id = $app->input->getInt( 'id' );		
		$query = "UPDATE #__allvideoshare_adverts SET clicks=clicks+1 WHERE id=".$id;
    	$db->setQuery( $query );
		$db->query();	
		
	}
			
}