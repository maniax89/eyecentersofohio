<?php
/*
 * @version		$Id: add.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

JHTML::_( 'behavior.formvalidation' );
JHtml::_( 'jquery.framework' );

$doc = JFactory::getDocument();
$doc->addStyleSheet( JURI::root( true ) . "/administrator/components/com_allvideoshare/assets/css/allvideoshare.css", "text/css", "screen" );
$doc->addScript( JURI::root( true ) . '/administrator/components/com_allvideoshare/assets/js/allvideoshare.js' );
$doc->addScriptDeclaration("
	Joomla.submitbutton = function( pressbutton ) {
	
    	if( pressbutton == 'cancel' ) {
		
        	submitform( pressbutton );
			
    	} else {
		
			var f = document.adminForm;	
			var m = f.method.value;			
	
			document.formvalidator.setHandler( 'video', function( value ) {
				if( 'upload' == m ) {
					var value = f.upload_video.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /mp4|m4v|mov|flv/.test( url.toLowerCase() ) : true;
				} else if( 'url' == m ) {
					var value = f.video.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /mp4|m4v|mov|flv/.test( url.toLowerCase() ) : true;
				};
				
				return true;
			});
			
        	if( document.formvalidator.isValid( f ) ) {
            	submitform( pressbutton );    
        	};
			
    	};  
		
	};
");
?>

<div id="avs-commercials" class="avs commercials add">
  	<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate" enctype="multipart/form-data">
  		<div class="control-group">
        	<label class="control-label" for="title"><?php echo JText::_( 'TITLE' ); ?><span class="star">&nbsp;*</span></label>
        	<div class="controls">
          		<input type="text" id="title" name="title" class="required" />
        	</div>
      	</div> 
        
        <div class="control-group">
        	<label class="control-label" for="type"><?php echo JText::_( 'TYPE' ); ?></label>
        	<div class="controls">
				<?php
                	echo AllVideoShareHtml::ListItems(
						'type',
						array(
							'preroll'  => JText::_( 'PREROLL' ),
					  		'postroll' => JText::_( 'POSTROLL' ),
					  		'both'     => JText::_( 'BOTH' )
						),							
						'both'
					);
				?>
            </div>
      	</div> 
        
        <div class="control-group">
        	<label class="control-label">&nbsp;</label>
            <div class="controls">
            	<?php
                	echo AllVideoShareHtml::RadioGroup(
						'method',
						array(
							'url'    => JText::_( 'DIRECT_URL' ),
					  		'upload' => JText::_( 'UPLOAD' )
						),							
						'upload'
					);
				?>
            </div>
       	</div> 
        
        <div class="control-group avs-toggle-fields avs-url-fields">
        	<label class="control-label" for="video"><?php echo JText::_( 'VIDEO' ); ?><span class="star">&nbsp;*</span></label>
        	<div class="controls">
            	<input type="text" name="video" id="video" class="required validate-video" />
            </div>
      	</div> 
        
        <div class="control-group avs-toggle-fields avs-upload-fields">
        	<label class="control-label" for="avs-video-upload-text-field"><?php echo JText::_( 'VIDEO' ); ?><span class="star">&nbsp;*</span></label>
        	<div class="controls">
            	<input type="file" name="upload_video" id="avs-video-upload-file-field" style="display: none" />
				<input type="text" id="avs-video-upload-text-field" class="required validate-video" style="pointer-events: none" />
		        <a class="btn avs-browse-btn" data-type="video"><?php echo JText::_( 'BROWSE' ); ?></a>
            </div>
      	</div> 
        
        <div class="control-group">
        	<label class="control-label" for="link"><?php echo JText::_( 'ADVERTISEMENT_LINK' ); ?></label>
        	<div class="controls"><input type="text" id="link" name="link" /></div>
      	</div> 
        
        <div class="control-group">
        	<label class="control-label" for="published"><?php echo JText::_( 'PUBLISH' ); ?></label>
        	<div class="controls"><?php echo AllVideoShareHtml::ListBoolean( 'published' ); ?></div>
      	</div> 

        <input type="hidden" name="boxchecked" value="1" />
        <input type="hidden" name="option" value="com_allvideoshare" />
        <input type="hidden" name="view" value="commercials" />
        <input type="hidden" name="task" value="" />
    	<?php echo JHTML::_( 'form.token' ); ?>
  	</form>
</div>