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
	
	// Categories: On type change
	jQuery( 'input[type="radio"][name="type"]', '#avs-categories' ).on( 'change', function() {
					
		var type = jQuery( 'input[name="type"]:checked' ).val();
		
		jQuery( '.avs-toggle-fields', '#avs-categories' ).hide();
		jQuery( '.avs-'+type+'-fields', '#avs-categories' ).show();
		
	}).trigger( 'change' );
	
	// Videos: On type change
	jQuery( '#type', '#avs-videos' ).on( 'change', function() {
					
		var type = jQuery( this ).val();
		
		if( 'pro_only' == type ) {
			alert( 'Sorry, this is a PRO feature.' );
			jQuery( this ).val( 'url' );
			type = 'url';
		}
		
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
	
	// Commercials: On method change
	jQuery( 'input[type="radio"][name="method"]', '#avs-commercials' ).on( 'change', function() {
					
		var type = jQuery( 'input[name="method"]:checked' ).val();
		
		jQuery( '.avs-toggle-fields', '#avs-commercials' ).hide();
		jQuery( '.avs-'+type+'-fields', '#avs-commercials' ).show();
		
		// Set required
		jQuery( '#video, #avs-video-upload-text-field', '#avs-commercials' ).removeClass( 'required' ).removeAttr( 'required' );
		switch( type ) {
			case 'url' :
				jQuery( '#video', '#avs-commercials' ).addClass( 'required' );
				break;
			case 'upload' :
				jQuery( '#avs-video-upload-text-field', '#avs-commercials' ).addClass( 'required' );
				break;
		}
		
	}).trigger( 'change' );
	
	// Players: On type change
	jQuery( 'input[type="radio"][name="type"]', '#avs-players' ).on( 'change', function() {
					
		var type = jQuery( 'input[name="type"]:checked' ).val();
		
		jQuery( '.avs-toggle-fields', '#avs-players' ).hide();
		jQuery( '.avs-'+type+'-fields', '#avs-players' ).show();
		
	}).trigger( 'change' );
	
	// Configuration Page: On layout changed
	jQuery( '#layout', '#avs-config' ).on( 'change', function() {
					
		var type = jQuery( this ).val();
		
		jQuery( '.avs-toggle-fields', '#avs-config' ).hide();
		jQuery( '.avs-'+type+'-fields', '#avs-config' ).show();
		
	}).trigger( 'change' );
	
	// Configuration Page: On comments type changed
	jQuery( '#comments_type', '#avs-config' ).on( 'change', function() {
					
		var type = jQuery( this ).val();
		
		jQuery( '.avs-facebook-fields', '#avs-config' ).hide();
		jQuery( '.avs-jcomments-fields', '#avs-config' ).hide();
		
		jQuery( '.avs-'+type+'-fields', '#avs-config' ).show();
		
	}).trigger( 'change' );
	
	// Licensing: On type change
	jQuery( 'input[type="radio"][name="type"]', '#avs-licensing' ).on( 'change', function() {
					
		var type = jQuery( 'input[name="type"]:checked' ).val();
		
		jQuery( '.avs-toggle-fields', '#avs-licensing' ).hide();
		jQuery( '.avs-'+type+'-fields', '#avs-licensing' ).show();
		
	}).trigger( 'change' );

});