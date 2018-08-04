<?php
/*
 * @version		$Id: default.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/
 
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$app = JFactory::getApplication();
?>

<div class="avs search <?php echo htmlspecialchars( $params->get( 'moduleclass_sfx' ) ); ?>">
  	<form action="<?php echo JRoute::_( 'index.php' ); ?>" method="post" class="form-validate">
    	<input type="hidden" name="option" value="com_allvideoshare" />
    	<input type="hidden" name="view" value="search" />
    	<input type="hidden" name="Itemid" value="<?php echo $app->input->getInt( 'Itemid' ); ?>" />
    	<div class="input-append">
      		<input type="text" name="q" class="span9 required" value="<?php echo htmlspecialchars( $q ); ?>" />
      		<button type="submit" class="btn btn-default"><?php echo JText::_( 'GO' ); ?></button>
    	</div>
  	</form>
</div>
