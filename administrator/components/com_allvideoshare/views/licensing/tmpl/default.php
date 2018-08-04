<?php
/*
 * @version		$Id: default.php 3.1 2017-06-30 $
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
			var t = f.type.value;			
			
			document.formvalidator.setHandler( 'logo', function( value ) {
				if( 'upload' == t ) {
					var value = f.upload_logo.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /jpg|jpeg|png|gif/.test( url.toLowerCase() ) : true;
				} else if( 'url' == t ) {
					var value = f.logo.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /jpg|jpeg|png|gif/.test( url.toLowerCase() ) : true;
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

<div id="avs-licensing" class="avs licensing">
  	<form action="index.php?option=com_allvideoshare&view=licensing" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate" enctype="multipart/form-data">
    	<div class="control-group">
            <label class="control-label" for="licensekey"><?php echo JText::_( 'LICENSE_KEY' ); ?></label>
            <div class="controls">
                <input type="text" name="licensekey" value="<?php echo $this->item->licensekey; ?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="type">&nbsp;</label>
            <div class="controls">
                <?php
                    echo AllVideoShareHtml::RadioGroup(
                        'type',
                        array(
                            'url'    => JText::_( 'URL' ),
                            'upload' => JText::_( 'UPLOAD' )
                        ),							
                        $this->item->type
                    );
                ?>
            </div>
        </div> 
        
        <div class="control-group avs-toggle-fields avs-url-fields">
            <label class="control-label"><?php echo JText::_( 'LOGO' ); ?></label>
            <div class="controls">
                <input type="text" name="logo" class="validate-logo" value="<?php echo $this->item->logo; ?>" />
            </div>
        </div>
        
        <div class="control-group avs-toggle-fields avs-upload-fields">
            <label class="control-label" for="avs-logo-upload-text-field"><?php echo JText::_( 'LOGO' ); ?></label>
            <div class="controls">
                <input type="file" name="upload_logo" id="avs-logo-upload-file-field" style="display: none" />
                <input type="text" id="avs-logo-upload-text-field" class="validate-logo" value="<?php echo $this->item->logo; ?>" style="pointer-events: none" />
                <a class="btn avs-browse-btn" data-type="logo"><?php echo JText::_( 'BROWSE' ); ?></a>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="logoposition"><?php echo JText::_( 'LOGO_POSITION' ); ?></label>
            <div class="controls">
                <?php
                    echo AllVideoShareHtml::ListItems(
                        'logoposition',
                        array(
                            'topleft'     => JText::_( 'TOP_LEFT' ),
                            'topright'    => JText::_( 'TOP_RIGHT' ),
							'bottomleft'  => JText::_( 'BOTTOM_LEFT' ),
							'bottomright' => JText::_( 'BOTTOM_RIGHT' )
                        ),							
                        $this->item->logoposition
                    );
                ?>
            </div>
        </div> 
        
        <div class="control-group">
            <label class="control-label"><?php echo JText::_( 'LOGO_ALPHA' ); ?></label>
            <div class="controls">
                <input type="text" name="logoalpha" value="<?php echo $this->item->logoalpha; ?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label"><?php echo JText::_( 'LOGO_TARGET' ); ?></label>
            <div class="controls">
                <input type="text" name="logotarget" value="<?php echo $this->item->logotarget; ?>" />
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label"><?php echo JText::_( 'DISPLAY_LOGO' ); ?></label>
            <div class="controls">
            	<?php echo AllVideoShareHtml::ListBoolean( 'displaylogo', $this->item->displaylogo ); ?>
            </div>
        </div>

        <input type="hidden" name="boxchecked" value="1" />
        <input type="hidden" name="option" value="com_allvideoshare" />
        <input type="hidden" name="view" value="licensing" />
        <input type="hidden" name="task" value="" />
        <input type="hidden" name="id" value="<?php echo $this->item->id; ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>
  	</form>
</div>