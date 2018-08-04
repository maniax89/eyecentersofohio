<?php
/*
 * @version		$Id: add.php 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

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
	
			document.formvalidator.setHandler( 'video', function( value ) {
				if( 'upload' == t ) {
					var value = f.upload_video.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /mp4|m4v|mov|flv/.test( url.toLowerCase() ) : true;
				} else if( 'url' == t ) {
					var value = f.video.value;
					var url = value.split('.').pop();
					return /mp4|m4v|mov|flv/.test( url.toLowerCase() );
				};
				
				return true;
			});
			
			document.formvalidator.setHandler( 'hd', function( value ) {
				if( 'upload' == t ) {
					var value = f.upload_hd.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /mp4|m4v|mov|flv/.test( url.toLowerCase() ) : true;
				} else if( 'url' == t ) {
					var value = f.hd.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /mp4|m4v|mov|flv/.test( url.toLowerCase() ) : true;
				};
				
				return true;
			});
			
			document.formvalidator.setHandler( 'thumb', function( value ) {
				if( 'upload' == t ) {
					var value = f.upload_thumb.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /jpg|jpeg|png|gif/.test( url.toLowerCase() ) : true;
				} else if( 'url' == t ) {
					var value = f.thumb.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /jpg|jpeg|png|gif/.test( url.toLowerCase() ) : true;
				};
					
				return true;
			});
			
			document.formvalidator.setHandler( 'preview', function( value ) {
				if( 'upload' == t ) {
					var value = f.upload_preview.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /jpg|jpeg|png|gif/.test( url.toLowerCase() ) : true;
				} else if( 'url' == t ) {
					var value = f.preview.value;
					var url = value.split('.').pop();
					return ( url != '' ) ? /jpg|jpeg|png|gif/.test( url.toLowerCase() ) : true;
				};
				
				return true;
			});
			
			document.formvalidator.setHandler( 'rtmp', function( value ) {
				if( 'rtmp' == t ) {
					return value !== '';
				};
				
				return true;
			});
			
			document.formvalidator.setHandler( 'hls', function( value ) {
				if( 'rtmp' == t ) {
					var url = value.split('.').pop();
					return ( url !== '' ) ? /m3u8/.test( url.toLowerCase() ) : true;
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

<div id="avs-videos" class="avs videos add">
  	<form action="index.php" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate" enctype="multipart/form-data">
      	<div class="row-fluid">
        
        	<!-- GENERAL_SETTINGS -->
            <fieldset>
            
            	<legend><?php echo JText::_( 'GENERAL_SETTINGS' ); ?></legend>
                
                <div class="control-group">
                    <label class="control-label" for="title"><?php echo JText::_( 'TITLE' ); ?><span class="star">&nbsp;*</span></label>
                    <div class="controls">
                        <input type="text" id="title" name="title" class="required" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="slug"><?php echo JText::_( 'SLUG' ); ?></label>
                    <div class="controls">
                        <input type="text" id="slug" name="slug" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="category"><?php echo JText::_( 'SELECT_A_CATEGORY' ); ?><span class="star">&nbsp;*</span></label>
                    <div class="controls">
                        <?php echo AllVideoShareHtml::ListCategories( 'category', '', 'class="required"' ); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="type"><?php echo JText::_( 'TYPE' ); ?></label>
                    <div class="controls">
                        <?php
                            echo AllVideoShareHtml::ListTypes(
                                'type',
                                array(
                                    'url'    => JText::_( 'DIRECT_URL' ),
                                    'upload' => JText::_( 'UPLOAD' ),
                                    'rtmp'   => JText::_( 'RTMP_STREAMING' )
                                ),							
                                'url'
                            );
                        ?>
                    </div>
                </div> 
                
                <div class="control-group avs-toggle-fields avs-rtmp-fields">
                    <label class="control-label" for="streamer"><?php echo JText::_( 'STREAMER' ); ?><span class="star">&nbsp;*</span></label>
                    <div class="controls">
                        <input type="text" id="streamer" name="streamer" class="required validate-rtmp" />
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-url-fields avs-rtmp-fields">
                    <label class="control-label" for="video"><?php echo JText::_( 'VIDEO' ); ?><span class="star">&nbsp;*</span></label>
                    <div class="controls">
                        <input type="text" id="video" name="video" class="required validate-video" />
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-url-fields">
                    <label class="control-label" for="hd"><?php echo JText::_( 'HD_VIDEO' ); ?></label>
                    <div class="controls">
                        <input type="text" id="hd" name="hd" class="validate-hd" />
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-rtmp-fields">
                    <label class="control-label" for="hls"><?php echo JText::_( 'HLS' ); ?></label>
                    <div class="controls">
                        <input type="text" id="hls" name="hls" class="validate-hls" />
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-url-fields avs-rtmp-fields">
                    <label class="control-label" for="thumb"><?php echo JText::_( 'THUMB' ); ?></label>
                    <div class="controls">
                        <input type="text" id="thumb" name="thumb" class="validate-thumb" />
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-url-fields avs-rtmp-fields">
                    <label class="control-label" for="preview"><?php echo JText::_( 'PREVIEW' ); ?></label>
                    <div class="controls">
                        <input type="text" id="preview" name="preview" class="validate-preview" />
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
                
                <div class="control-group avs-toggle-fields avs-upload-fields">
                    <label class="control-label" for="avs-hd-upload-text-field"><?php echo JText::_( 'HD_VIDEO' ); ?></label>
                    <div class="controls">
                        <input type="file" name="upload_hd" id="avs-hd-upload-file-field" style="display: none" />
                        <input type="text" id="avs-hd-upload-text-field" class="validate-hd" style="pointer-events: none" />
                        <a class="btn avs-browse-btn" data-type="hd"><?php echo JText::_( 'BROWSE' ); ?></a>
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-upload-fields">
                    <label class="control-label" for="avs-thumb-upload-text-field"><?php echo JText::_( 'THUMB' ); ?></label>
                    <div class="controls">
                        <input type="file" name="upload_thumb" id="avs-thumb-upload-file-field" style="display: none" />
                        <input type="text" id="avs-thumb-upload-text-field" class="validate-thumb" style="pointer-events: none" />
                        <a class="btn avs-browse-btn" data-type="thumb"><?php echo JText::_( 'BROWSE' ); ?></a>
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-upload-fields">
                    <label class="control-label" for="avs-preview-upload-text-field"><?php echo JText::_( 'PREVIEW' ); ?></label>
                    <div class="controls">
                        <input type="file" name="upload_preview" id="avs-preview-upload-file-field" style="display: none" />
                        <input type="text" id="avs-preview-upload-text-field" class="validate-preview" style="pointer-events: none" />
                        <a class="btn avs-browse-btn" data-type="preview"><?php echo JText::_( 'BROWSE' ); ?></a>
                    </div>
                </div>
                
                <div class="control-group avs-toggle-fields avs-rtmp-fields">
                    <label class="control-label" for="token"><?php echo JText::_( 'TOKEN' ); ?></label>
                    <div class="controls">
                        <input type="text" id="token" name="token" />
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="user"><?php echo JText::_( 'USER' ); ?></label>
                    <div class="controls">
                        <?php echo AllVideoShareHtml::ListUsers( 'user', ALLVIDEOSHARE_USERNAME ); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="access"><?php echo JText::_( 'ACCESS' ); ?></label>
                    <div class="controls">
                        <?php
                            echo AllVideoShareHtml::ListItems(
                                'access',
                                array(
                                    'public'     => JText::_( 'PUBLIC' ),
                                    'registered' => JText::_( 'REGISTERED' )
                                ),							
                                'public'
                            );
                        ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="featured"><?php echo JText::_( 'FEATURED' ); ?></label>
                    <div class="controls">
                        <?php echo AllVideoShareHtml::ListBoolean( 'featured' ); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="published"><?php echo JText::_( 'PUBLISH' ); ?></label>
                    <div class="controls">
                        <?php echo AllVideoShareHtml::ListBoolean( 'published' ); ?>
                    </div>
                </div>
                
                <div class="control-group">
                    <label class="control-label" for="description"><?php echo JText::_( 'DESCRIPTION' ); ?></label>
                    <div class="controls">
                        <?php echo AllVideoShareHtml::Editor( 'description' ); ?>
                    </div>
                </div>
  
            </fieldset>
            
            <!-- ADVANCED_SETTINGS -->
            <fieldset>
            
            	<legend><?php echo JText::_( 'ADVANCED_SETTINGS' ); ?></legend>

                <div class="control-group">
                    <label class="control-label" for="tags"><?php echo JText::_( 'META_KEYWORDS' ); ?></label>
                    <div class="controls">
                        <textarea name="tags" rows="3"></textarea>
                        <span class="help-block"><?php echo JText::_( 'META_KEYWORDS_DESCRIPTION' ); ?></span>
                    </div>
                </div>
                
                 <div class="control-group">
                    <label class="control-label" for="metadescription"><?php echo JText::_( 'META_DESCRIPTION' ); ?></label>
                    <div class="controls">
                        <textarea name="metadescription" rows="3"></textarea>
                    </div>
                </div>
                
            </fieldset>
        
        </div>
        <input type="hidden" name="boxchecked" value="1" />
        <input type="hidden" name="option" value="com_allvideoshare" />
        <input type="hidden" name="view" value="videos" />
        <input type="hidden" name="task" value="" />
        <?php echo JHTML::_( 'form.token' ); ?>
  	</form>
</div>