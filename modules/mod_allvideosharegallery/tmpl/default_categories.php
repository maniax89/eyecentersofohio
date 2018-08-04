<?php 
/*
 * @version		$Id: default_categories.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

$app = JFactory::getApplication();

$itemId  = $app->input->getInt('Itemid') ? '&Itemid='.$app->input->getInt('Itemid') : '';

$columns = (int) $params->get( 'columns' );
$span    = 'span' . floor( 12 / $columns );
$column  = 0;

$more = AllVideoShareGalleryHelper::hasMore( $params );
$moreURL = AllVideoShareUtils::buildRoute( 0, 'category' );
?>

<div class="avs categories <?php echo htmlspecialchars( $params->get( 'moduleclass_sfx' ) ); ?>">
	<div class="row-fluid">
    	<ul class="thumbnails">
        	<?php
			foreach( $items as $key => $item ) {
			
				if( $column >= $columns ) {
					echo '</ul><ul class="thumbnails">';
					$column = 0;
				}
				
				$image  = AllVideoShareUtils::getImage( $item->thumb );	
				$target = JRoute::_( 'index.php?option=com_allvideoshare&view=category&slg='.$item->slug );
				?>
                <li class="<?php echo $span; ?>">
                	<div class="thumbnail">
    					<a href="<?php echo $target; ?>" class="avs-thumbnail">
                        	<div class="avs-image" style="background-image: url(<?php echo $image; ?>);">&nbsp;</div>
                        </a>
                        <div class="caption">
        					<h4><a href="<?php echo $target; ?>"><?php echo $item->name; ?></a></h4>
                        </div>
  	  				</div> 
    			</li>      
            	<?php
				if( $column >= $columns ) echo '</ul>';
		  		$column++;
			}			
			?> 
        </ul>
  	</div>
    
    <?php if( $more ) : ?>
		<a class="btn" href="<?php echo $moreURL; ?>"><?php echo JText::_( 'MORE' ); ?></a>
	<?php endif; ?>
</div>