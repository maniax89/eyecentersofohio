<?php
/*
 * @version		$Id: default_comments.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$jcomments = JPATH_SITE.DS.'components'.DS.'com_jcomments'.DS.'jcomments.php';
$komento   = JPATH_SITE.DS.'components'.DS.'com_komento'.DS.'bootstrap.php';

// Load JComments ( only if applicable )
if( file_exists( $jcomments ) && $this->config->comments_type == 'jcomments' ) {
	require_once( $jcomments );
    echo JComments::showComments( $this->item->id, 'com_allvideoshare', $this->item->title );	
}

// Load Komento ( only if applicable )
if( file_exists( $komento ) && $this->config->comments_type == 'komento' ) {
	$item = new stdClass;
	$item->id = $this->item->id;
	$item->catid = $this->item->category;
	$item->text = $this->item->description;
	$item->introtext = $this->item->description;
		
	require_once( $komento );
	echo Komento::commentify( 'com_allvideoshare', $item, array() );
}

// Load FaceBook ( only if applicable )
if( $this->config->comments_type == 'facebook' ) : ?>
	<?php
		$db = JFactory::getDBO();		
		$fields_config = $db->getTableColumns( '#__allvideoshare_config' );

		// If upgraded to 3.0 from old All Video Share versions
		if( array_key_exists( 'responsive', $fields_config ) ) {
			$url = JURI::getInstance()->toString();
		} 
		
		// Else
		else {
			$url = JURI::root().'index.php?option=com_allvideoshare&view=video&slg='.$this->item->slug;
		}
	?>
	<h2><?php echo JText::_( 'ADD_YOUR_COMMENTS' ); ?></h2>
	<div id="fb-root"></div>
	<div class="fb-comments"
    	data-href="<?php echo $url; ?>"
        data-num-posts="<?php echo $this->config->comments_posts; ?>"
        data-width="100%"
        data-colorscheme="<?php echo $this->config->comments_color; ?>">
    </div>
<?php 
endif;