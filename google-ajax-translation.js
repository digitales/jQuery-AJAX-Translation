/**
 * Google AJAX Translation
 * 2010-04-15
 */

jQuery( function() {
	jQuery('.translate_block').show(); // Show [Translate] buttons after the document is ready
	var popup_id = document.getElementById( 'translate_popup' );
	if ( popup_id ) {
		document.body.appendChild( popup_id ); // Move popup to the end of the body if it isn't already
	}
});

function google_translate( lang, type, id ) {
	var text_node = document.getElementById( ( ( 'comment' == type ) ? 'div-' : '' ) + type + '-' + id ),
		do_not_translate = '.translate_block',
		loading_id;
	if ( ! text_node && 'post' == type ) // some themes do not have the post-id divs so we fall back on our own div
		text_node = document.getElementById( 'content_div-' + id );
	if ( ! text_node && 'comment' == type ) // some themes do not have the div-comment-id divs
		text_node = document.getElementById( 'comment-' + id );
	if ( text_node ) {
		if ( 'undefined' !== typeof ga_translation_options ) {
			if ( 'undefined' !== typeof ga_translation_options['do_not_translate_selector'] ) {
				do_not_translate += ', ' + ga_translation_options['do_not_translate_selector'];
			}
		}
		loading_id = '#translate_loading_' + type + '-' + id;
		jQuery( text_node ).translate( lang, {
			fromOriginal: true,
			not: do_not_translate,
			start: function() { jQuery( loading_id ).show(); },
			complete: function() { jQuery( loading_id ).hide(); },
			error: function() { jQuery( loading_id ).hide(); }
			} );
	}
	jQuery( '#translate_popup' ).slideUp( 'fast' ); // Close the popup
}

function localize_languages( browser_lang, popup_id ) {
	var language_nodes = jQuery( '#translate_popup a' ).get(),
		llangs = [], // array that holds localized language names
		i;
	for ( i in language_nodes ) {
		llangs[i] = language_nodes[i].title; // Make array of English language names
	}
	jQuery.translate( llangs, 'en', browser_lang, {
		complete: function() {
			llangs = this.translation;
			for ( i in language_nodes ) { // copy localized language names into titles
				language_nodes[i].title = llangs[i];
			}
			jQuery( popup_id ).data( 'localized', true );
		}
	});
}

function show_translate_popup( browser_lang, type, id ) {
	var popup_id = document.getElementById( 'translate_popup' ),
		jQ_popup_id = jQuery( popup_id ),
		jQ_button_id = jQuery( '#translate_button_' + type + '-' + id ),
		buttonleft = Math.round( jQ_button_id.offset().left ),
		buttonbottom = Math.round( jQ_button_id.offset().top + jQ_button_id.outerHeight(true) ),
		rightedge_diff;
	if ( popup_id ) {
		jQuery.translate.languageCodeMap['pt'] = 'pt-PT'; // automatically convert 'pt' to 'pt-PT' in the jquery translate plugin
		if ( 'none' == popup_id.style.display || jQ_popup_id.position().top != buttonbottom ) { // check for hidden popup or incorrect placement
			popup_id.style.display = 'none';
			jQ_popup_id.css( 'left', buttonleft ).css( 'top', buttonbottom ); // move popup to correct position
			jQ_popup_id.slideDown( 'fast' );
			// move popup to the left if right edge is outside of window
			rightedge_diff = jQuery(window).width() + jQuery(window).scrollLeft() - jQ_popup_id.offset().left - jQ_popup_id.outerWidth(true);
			if ( rightedge_diff < 0 ) {
				jQ_popup_id.css( 'left', Math.max( 0, jQ_popup_id.offset().left + rightedge_diff ) );
			}
			jQuery( '#translate_popup .languagelink' ).each( function() { // bind click event onto all the anchors
				jQuery( this ).unbind( 'click' ).click( function () {
					google_translate( this.lang, type, id );
					return false;
				});
			});
			if ( 'en' != browser_lang && ( ! jQ_popup_id.data( 'localized' ) ) ) { // If the browser's preferred language isn't English and the popup hasn't already been localized
				localize_languages( browser_lang, popup_id );
			}
		} else {
			jQ_popup_id.slideUp( 'fast' );
		}
	}
}