/*
 * @version		$Id: allvideoshare.js 3.1 2017-06-30 $
 * @package		All Video Share
 * @copyright   Copyright (C) 2012-2017 MrVinoth
 * @license     GNU/GPL http://www.gnu.org/licenses/gpl-2.0.html
*/

jQuery( document ).ready(function() {
		
	// On browse button clicked
	jQuery( '.avs-browse-btn' ).on( 'click', function() {
													  
		var type = jQuery( this ).data( 'type' );
		
		jQuery( '#avs-'+type+'-upload-file-field' ).trigger( 'click' );
	
		jQuery( '#avs-'+type+'-upload-file-field' ).off( 'change' ).on( 'change', function() {
			jQuery( '#avs-'+type+'-upload-text-field' ).val( jQuery( this ).val() );
		});     
		
	});
	
	// Videos: On type change
	jQuery( '#type', '#avs-videos' ).on( 'change', function() {
					
		var type = jQuery( this ).val();
		
		jQuery( '.avs-toggle-fields', '#avs-videos' ).hide();
		jQuery( '.avs-'+type+'-fields', '#avs-videos' ).show();
		
		// Set required
		jQuery( '#streamer, #video, #avs-video-upload-text-field', '#avs-videos' ).removeClass( 'required' ).removeAttr( 'required' );
		switch( type ) {
			case 'url' :
				jQuery( '#video', '#avs-videos' ).addClass( 'required' );
				break;
			case 'upload' :
				jQuery( '#avs-video-upload-text-field', '#avs-videos' ).addClass( 'required' );
				break;
			case 'rtmp' :
				jQuery( '#streamer, #video', '#avs-videos' ).addClass( 'required' );
				break;
		}
		
	}).trigger( 'change' );
	
});