<?php
/*
Plugin Name: Jquery AJAX Translation
Plugin URI: http://wordpress.org/extend/plugins/jquery-ajax-translation/
Description: Add <a href="http://code.google.com/apis/ajaxlanguage/">Google AJAX Translation</a> to your blog. This plugin allows your blog readers to translate your blog posts or comments into other languages. <a href="options-general.php?page=jquerytranslation.php">[Settings]</a>
Author: Ross Tweedie, Libin Pan, Michael Klein, and Nick Marshall
Version: 0.6.1
Stable tag: 0.6.1
Author URI: https://github.com/digitales/Jquery-AJAX-Translation
	
TODO:
	put admin page functions into separate file

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, version 2.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*/

register_deactivation_hook( __FILE__, array('JqueryTranslation', 'deactivate') );
    
if (!class_exists('JqueryTranslation')) {

	class JqueryTranslation {

		var $optionPrefix = 'jquery_translation_';
		var $version      = '0.6.1';
		var $pluginUrl    = 'http://wordpress.org/extend/plugins/jquery-ajax-translation/';
		var $authorUrl    = 'https://github.com/digitales/Jquery-AJAX-Translation';
        var $javascriptConfig   = '<script type="text/javascript">jQuery.translate.load("%s");</script>';
        
		var $languages = array(
			'af' => 'Afrikaans', 'ar' => 'Arabic', 'be' => 'Belarusian', 'bg' => 'Bulgarian', 'ca' => 'Catalan',
			'cs' => 'Czech', 'cy' => 'Welsh', 'da' => 'Danish', 'de' => 'German', 'el' => 'Greek', 'en' => 'English',
            'es' => 'Spanish', 'et' => 'Estonian', 'fa' => 'Persian', 'fi' => 'Finnish', 'fr' => 'French', 'ga' => 'Irish',
            'gl' => 'Galician', 'he' => 'Hebrew', 'hi' => 'Hindi', 'hr' => 'Croatian', 'hu' => 'Hungarian', 'id' => 'Indonesian',
			'is' => 'Icelandic', 'it' => 'Italian', 'ja' => 'Japanese', 'ko' => 'Korean', 'lt' => 'Lithuanian', 'lv' => 'Latvian',
			'mk' => 'Macedonian', 'ms' => 'Malay', 'mt' => 'Maltese', 'nl' => 'Dutch', 'no' => 'Norwegian', 'pl' => 'Polish', 'pt' => 'Portuguese',
			'ro' => 'Romanian', 'ru' => 'Russian', 'sk' => 'Slovak', 'sl' => 'Slovenian', 'sq' => 'Albanian', 'sr' => 'Serbian',
			'sv' => 'Swedish', 'sw' => 'Swahili', 'th' => 'Thai', 'tl' => 'Filipino', 'tr' => 'Turkish', 'uk' => 'Ukrainian',
            'vi' => 'Vietnamese', 'yi' => 'Yiddish', 'zh-cn' => 'Chinese (Simplified)', 'zh-tw' => 'Chinese (Traditional)'
		);
		var $target_languages = array(
			'af', /*Afrikaans */ 'ar', /*Arabic */
			'be', /*Belarusian */ 'bg', /*Bulgarian */ 'ca', /*Catalan */ 'cs', /*Czech */ 'cy', /*Welsh */ 'da', /*Danish */
			'de', /*German */ 'el', /*Greek */ 'en', /*English */ 'es', /*Spanish */ 'et', /*Estonian */ 'fa', /*Persian */
			'fi', /*Finnish */ 'fr', /*French */ 'ga', /*Irish */ 'gl', /*Galician */ 'he', /*Hebrew */ 'hi', /*Hindi */
			'hr', /*Croatian */ 'hu', /*Hungarian */ 'id', /*Indonesian */ 'is', /*Icelandic */ 'it', /*Italian */
			'ja', /*Japanese */ 'ko', /*Korean */ 'lt', /*Lithuanian */ 'lv', /*Latvian */ 'mk', /*Macedonian */
			'ms', /*Malay */ 'mt', /*Maltese */ 'nl', /*Dutch */ 'no', /*Norwegian */ 'pl', /*Polish */ 'pt', /*Portuguese */
			'ro', /*Romanian */ 'ru', /*Russian */ 'sk', /*Slovak */ 'sl', /*Slovenian */ 'sq', /*Albanian */ 'sr', /*Serbian */
			'sv', /*Swedish */ 'sw', /*Swahili */ 'th', /*Thai */ 'tl', /*Filipino */ 'tr', /*Turkish */ 'uk', /*Ukrainian */
            'vi', /*Vietnamese */ 'yi', /*Yiddish */ 'zh-cn', /* Chinese (Simplified) */ 'zh-tw' /* Chinese (Traditional) */
		);
		var $display_name = array(
			'af' => 'Afrikaans', 'ar' => 'العربية', 'be' => 'Беларуская', 'bg' => 'български', 'ca' => 'català',
            'cs' => 'česky', 'cy' => 'Cymraeg', 'da' => 'dansk', 'de' => 'Deutsch', 'el' => 'ελληνική', 'en' => 'English',
            'es' => 'Español', 'et' => 'eesti', 'fa' => 'فارسی', 'fi' => 'suomi', 'fr' => 'français', 'ga' => 'Gaeilge',
			'gl' => 'galego', 'he' => 'עברית', 'hi' => 'हिन्दी', 'hr' => 'hrvatski', 'hu' => 'magyar', 'id' => 'bahasa Indonesia',
			'is' => 'íslenska', 'it' => 'italiano', 'ja' => '日本語', 'ko' => '한국어', 'lt' => 'lietuvių', 'lv' => 'latviešu',
			'mk' => 'македонски', 'ms' => 'bahasa Melayu', 'mt' => 'Malti', 'nl' => 'Nederlands', 'no' => 'norsk', 'pl' => 'polski',
			'pt' => 'português', 'ro' => 'română', 'ru' => 'русский', 'sk' => 'slovenčina', 'sl' => 'slovenščina', 'sq' => 'shqipe',
			'sr' => 'српски', 'sv' => 'svenska', 'sw' => 'Kiswahili', 'th' => 'ภาษาไทย', 'tl' => 'Filipino', 'tr' => 'Türkçe',
			'uk' => 'українська', 'vi' => 'tiếng Việt', 'yi' => 'ייִדיש', 'zh-cn' => '中文 (简体)', 'zh-tw' => '中文 (繁體)'
		);
		var $translate_message = array(
			'af' => 'Vertaal', 'ar' => 'ترجمة', 'be' => 'Перакладаць', 'bg' => 'Преводач', 'ca' => 'Traductor',
			'cs' => 'Překladač', 'cy' => 'Cyfieithu', 'da' => 'Oversæt', 'de' => 'Übersetzung', 'el' => 'Μετάφραση',
			'en' => 'Translate', 'es' => 'Traductor', 'et' => 'Tõlkima', 'fa' => 'ترجمه', 'fi' => 'Kääntäjä', 'fr' => 'Traduction',
			'ga' => 'Aistrigh', 'gl' => 'Traducir', 'he' => 'תרגם', 'hi' => 'अनुवाद करें', 'hr' => 'Prevoditelj', 'hu' => 'Fordítás',
            'id' => 'Menerjemahkan', 'is' => 'Þýða', 'it' => 'Traduttore', 'ja' => '翻訳', 'ko' => '번역', 'lt' => 'Versti',
			'lv' => 'Tulkotājs', 'mk' => 'Преведува', 'ms' => 'Menerjemahkan', 'mt' => 'Traduċi', 'nl' => 'Vertaal', 'no' => 'Oversetter',
			'pl' => 'Tłumacz', 'pt' => 'Tradutor', 'ro' => 'Traducere', 'ru' => 'Переводчик', 'sk' => 'Prekladač', 'sl' => 'Prevajalnik',
            'sq' => 'Përkthej', 'sr' => 'преводилац', 'sv' => 'Översätt', 'sw' => 'Tafsiri', 'th' => 'แปล', 'tl' => 'Pagsasalin',
			'tr' => 'Tercüme etmek', 'uk' => 'Перекладач', 'vi' => 'Dịch', 'yi' => 'זעץ', 'zh-cn' => '翻译', 'zh-tw' => '翻譯', );

		var $options = array(  // default values for options
            'apiKey' => null, // The API key to use.
			'linkStyle' => 'text', // is stored as 'text', 'image', or 'imageandtext'
			'linkPosition' => 'bottom', // is stored as 'top', 'bottom', or 'none'
			'hlineEnable' => true, // is stored as "1" and "0" in database or returns false if the option doesn't exist
			'copyBodyBackgroundColor' => false, // is stored as "1" and "0" in database or returns false if the option doesn't exist
			'backgroundColor' => NULL, // is stored as NULL or CSS color in the format #5AF or #55AAFF
			'postEnable' => true, // is stored as "1" and "0" in database or returns false if the option doesn't exist
			'excludeHome' => false, // is stored as "1" and "0" in database or returns false if the option doesn't exist
			'pageEnable' => true, // is stored as "1" and "0" in database or returns false if the option doesn't exist
			'excludePages' => array(), // array of post and page id's to exclude
			'commentEnable' => false, // is stored as "1" and "0" in database or returns false if the option doesn't exist
			'doNotTranslateSelector' => NULL, // is stored as "" or string in the style of a jQuery selector
			'languages' => array() // array of language codes to display in popup
		);

		var $textDomain = 'jquery-translate'; // not used currently
		var $languageFileLoaded = false; // not used currently
		var $pluginRoot = '';
		
		var $before_translate = '['; // text to display before and after "Translate" link
		var $after_translate = ']';
		var $browser_lang = 'en';

		/**
		 * php 4 Constructor
		 */
		function JqueryTranslation() {
			$this->pluginRoot = plugins_url( '/', __FILE__ );
            // $this->loadDefaultSettings();

			foreach ( $this->options as $k => $v ) { // delete old style options from database from before version 0.5.0
				delete_option( $this->optionPrefix . $k );
			}

			$current_options = get_option( $this->optionPrefix . 'options' );

			if ( $current_options ) {
				foreach ( $current_options as $k => $v ) {
					if ( isset( $current_options[$k] ) and false !== $current_options[$k] ) // Checks to skip false options (missing from database)
						$this->options[$k] = $current_options[$k];
				}
			}

			$browser_lg = $this->browser_lang = $this->preferred_language( $this->target_languages ); // find browser's preferred language
			$browser_lg_index = array_search ( $browser_lg  , $this->options['languages'] ); // find index of preferred language in options array
			if ( isset( $browser_lg_index ) and false !== $browser_lg_index ) { // if preferred language is in options array, move it to the first element
				array_splice( $this->options['languages']  , $browser_lg_index  , 1 );
				array_unshift( $this->options['languages']  , $browser_lg );
			}

			// Add action and filter hooks to WordPress
			wp_register_style( 'ajax-translation', $this->pluginRoot . 'ajax-translation.css', false, '20100412', 'screen' );
			//wp_register_script( 'jquery-translate', $this->pluginRoot . 'jquery.translate-1.4.1.min.js', array('jquery'), '1.4.1', true );
            wp_register_script( 'jquery-translate', $this->pluginRoot . 'jquery.translate-1.4.7.including-ajax.js', array('jquery'), '1.4.1', true );
            
			if ( is_admin() ) {
				add_action( 'admin_menu', array( &$this, 'addOptionsPage' ) );
				add_action( 'admin_init', array( &$this, 'register_translation_settings' ) );
			} else {
				wp_enqueue_style( 'ajax-translation' );
				wp_enqueue_script( 'jquery-translate' );
                
                // Ensure that the configuration is stored on the page.
                add_action('wp_footer', array(&$this, 'embedJavascript'), 99);
                
				//wp_enqueue_script( 'google-ajax-translation-unminified', $this->pluginRoot . 'google-ajax-translation.js', array('jquery-translate'), '20100415', true ); // Minified version is appended to jquery.translate-1.4.1.min.js (Leave this here for debugging.)
				if ( ( $this -> options['postEnable'] || $this -> options['pageEnable'] ) && ( 'none' != $this -> options['linkPosition'] ) ) {
					add_filter( 'the_content', array( &$this, 'processContent' ), 50 );
				}
				if ( $this -> options['commentEnable'] ) {
					add_filter( 'comment_text', array( &$this, 'processComment' ), 50 );
				}
				add_filter( 'wp_footer', array( &$this, 'getLanguagePopup' ), 5 );
				add_filter( 'wp_footer', array( &$this, 'getFooterJS' ), 5 );
			}
		}
        
        /**
         * Load the default settings from a file
         *
         * This function is not currently in use.
         *
         * @param void
         * @return void
         */
        private function loadDefaultSettings()
        {
            $data = file_get_contents( $this->pluginRoot . 'settings/default_data.json' );
            $data = json_decode( $data );
            foreach( $data AS $key => $value ){
                $this->{$key} = $value;
            }
        }
        
        /**
         * Display the plugin's javascript and css code in the site's header
         *
         * @param void
         * @return void
        */
        function embedJavascript() {

            echo '<!-- BEGIN AJAX translate for WordPress -->';
            echo sprintf($this->javascriptConfig, $this -> options['apiKey'] );
            echo '<!-- END AJAX translate for WordPress -->';

        }

		/**
		 * adds Google Translation to Options menu in Administration Panel and adds scripts and css to one page
		 */
		function addOptionsPage(){
			$plugin_page = add_options_page('Jquery Translation', 'Jquery Translation', 'manage_options', basename(__FILE__), array(&$this, 'outputOptionsPanel'));
			if ( 'jquerytranslation' == $_GET['page'] ) { // add only to one admin page
				add_action( 'admin_footer-'. $plugin_page, array( &$this, 'admin_js' ) );
				wp_enqueue_style( 'ajax-translation' );
				wp_enqueue_script( 'jquery-translate' );
			}
		}

		/**
		 * whitelist and sanitize options
		 */
		function register_translation_settings() {
			register_setting( 'jquery-ajax-translation', $this -> optionPrefix . 'options', array( $this, 'sanitize_options' ) );
        }

		/**
		 * sanitize options array
		 * @return array of sanitized options
		 * @param $value array of unsanitized options
		 */
		function sanitize_options($value) {
			$value['apiKey'] = $this -> sanitize_text( $value['apiKey'] );
            $value['linkStyle'] = $this -> sanitize_linkStyle( $value['linkStyle'] );
			$value['linkPosition'] = $this -> sanitize_linkPosition( $value['linkPosition'] );
			$value['hlineEnable'] = $this -> sanitize_checkbox( $value['hlineEnable'] );
			$value['copyBodyBackgroundColor'] = $this -> sanitize_checkbox( $value['copyBodyBackgroundColor'] );
			$value['backgroundColor'] = $this -> sanitize_backgroundColor( $value['backgroundColor'] );
			$value['postEnable'] = $this -> sanitize_checkbox( $value['postEnable'] );
			$value['excludeHome'] = $this -> sanitize_checkbox( $value['excludeHome'] );
			$value['pageEnable'] = $this -> sanitize_checkbox( $value['pageEnable'] );
			$value['excludePages'] = $this -> sanitize_excludePages( $value['excludePages'] );
			$value['commentEnable'] = $this -> sanitize_checkbox( $value['commentEnable'] );
			$value['doNotTranslateSelector'] = $this -> sanitize_selector( $value['doNotTranslateSelector'] );
			$value['languages'] = $this -> sanitize_languages( $value['languages'] );
        
			return $value;
		}

		function sanitize_linkStyle($value) { // sanitize linkStyle option value
			$possible_values = array( 'text', 'image', 'imageandtext' );
			return ( in_array( $value, $possible_values ) ) ? $value : NULL;
		}

		function sanitize_linkPosition($value) { // sanitize linkPosition option value
			$possible_values = array( 'top', 'bottom', 'none' );
			return ( in_array( $value, $possible_values ) ) ? $value : NULL;
		}

		function sanitize_checkbox($value) { // sanitize checkbox option values
			return ( $value ) ? 1 : 0;
		}
        
        function sanitize_text( $value )
        { // sanitize the text fields.
            return $value;
        }

		function sanitize_backgroundColor($value) { // sanitize backgroundColor string
			$value = strtoupper( $value );
			if ( preg_match( "/^#[\dA-F]{3}$|^#[\dA-F]{6}$/", $value ) ) // only allow strings in the format #5AF or #55AAFF
				return $value;
			else
				return null;
		}

		function sanitize_excludePages($value) { // sanitize excludePages string
			$value = explode( ",", $value );
			$index = 0;
			while ( $index < sizeof( $value ) ) {
				$page_id_int = absint( $value[$index] );
				if ( $page_id_int ) {
					$value[$index] = $page_id_int;
					$index++;
				} else {
					array_splice( $value, $index, 1 );
				}
			}
			return $value;
		}

		function sanitize_selector($value) { // sanitize jQuery selector
			$value = str_replace( array( "'", '"' ), "", $value ); // get rid of single and double quotes
			return $value;
		}

		function sanitize_languages($value) { // sanitize languages option array
			if ( is_array($value) ) {
				$index = 0;
				foreach ( $value as $lg ) {
					if ( ! in_array( $lg, $this -> target_languages ) ) {
						array_splice( $value, $index , 1 );
						$index--;
					}
					$index++;
				}
			} else {
				$value = array(); // no languages checked sends a null string so this sets it to an empty array
			}
			return $value;
		}

		/**
		 * Uninstall function called by uninstall.php
		 *
		 * @param void
		 * @return void
		 */
		function uninstall() {
			/*foreach ( $this -> options as $k => $v ) { // delete options from wp_options table
				delete_option( $this -> optionPrefix . $k );
			}*/
			delete_option( $this->optionPrefix . 'options' ); // delete options from wp_options table
		}
        
        /**
         * Deactivate the plugin
         *
         * @param void
         * @return void
         */
        function deactivate()
        {
          //  $JqueryTranslation->uninstall();
          //  delete_option( $this->optionPrefix . 'options' );   
        }
        
        
        /**
         * loadLanguageFiles
         * Load the language files. This not yet fully implemented.
         *
         * @todo load the language files.
         * @param void
         * @return void
         */
		function loadLanguageFile() { // loads language files according to locale (NOT WORKING YET)
			if(!$this->languageFileLoaded) {
				load_plugin_textdomain($this->textDomain, $this->pluginRoot . 'languages', 'jquery-ajax-translation/languages' );
				$this->languageFileLoaded = true;
			}
		}
        

		/**
		 * Attach jQuery click events to admin buttons
		 *
		 * @param void
		 * @return void
		 */
		function admin_js() {
			$browser_lg = $this -> browser_lang;
			?>
			<script type="text/javascript">
			//<![CDATA[
				jQuery(document).ready(function($) {
<?php
				if ( 'en' != $browser_lg ) :
?>
					$('#translate_button').click(function() { // translate panel into browser's preferred language
						$('.wrap').translate( 'en', '<?php echo $browser_lg ?>', {
							not: 'img, input, #translate_button',
							start: function() { $('#translate_loading_admin').show(); },
							complete: function() { $('#translate_loading_admin').hide(); },
							error: function() { $('#translate_loading_admin').hide(); }
						});
					});
<?php
				endif;
?>
					$('input[name="jquery_translation_options[postEnable]"]').click(function() { // disable and enable excludeHome checkbox
						if ( $(this).is(':checked') ) {
							$('input[name="jquery_translation_options[excludeHome]"]').removeAttr('disabled');
						} else {
							$('input[name="jquery_translation_options[excludeHome]"]').attr('disabled', 'disabled');
						}
					});
					$('input[name="jquery_translation_options[copyBodyBackgroundColor]"]').click(function() { // disable and enable backgroundColor text field
						if ( $(this).is(':checked') ) {
							$('input[name="jquery_translation_options[backgroundColor]"]').attr('disabled', 'disabled');
						} else {
							$('input[name="jquery_translation_options[backgroundColor]"]').removeAttr('disabled');
						}
					});
					$('#languages_all').click(function() { // check all languages
						$('.translate_links input').attr('checked', 'checked');
					});
					$('#languages_none').click(function() { // uncheck all languages
						$('.translate_links input').removeAttr('checked');
					});
				});
			//]]>
			</script>
			<?php
		}

		function outputOptionsPanel() {
			$domain = $this -> textDomain;
			$p = $this -> optionPrefix;
			$excludePages_str = implode( ", ", (array) $this -> options['excludePages'] );
			
            require_once( 'views/options-panel.php' );
		}

		/**
		 * Filter to add Translate button to posts and pages
		 * @return $content string
		 * @param $content string
		 */
		function processContent($content = '') {
			$backtrace = debug_backtrace();
			if ( !is_feed() && // ignore feeds
			( "the_excerpt" != $backtrace[7]["function"] ) && // ignore excerpts
			( ( !is_page() && $this -> options['postEnable'] ) || ( is_page() && $this -> options['pageEnable'] ) ) && // apply to posts or pages
			! ( in_array( get_the_ID(), $this -> options['excludePages'] ) ) && // exclude certain pages and posts
			! ( $this -> options['excludeHome'] && is_home() ) ) { // if option is set exclude home page
				$translate_block = $this -> generate_translate_block('post');
				$translate_hr = ( $this -> options['hlineEnable'] ) ? ( '<hr class="translate_hr" />' . "\n" ) : "";
				$id = get_the_ID();
				$content = '<div id="content_div-' . $id . '">' . "\n" . $content . "</div>\n";
				//$content = $content . "\n<br />\nis_page: " . is_page() . "\n<br />\nis_attachment: " . is_attachment() . "\n<br />\nis_single: " . is_single() . "\n<br />\nis_home: " . is_home() . "\n<br />\nget_the_ID: " . get_the_ID() . "\n<br />";
				switch ( $this -> options['linkPosition'] ) {
					case 'top':
						$content = '<div class="translate_block" style="display: none;">' . "\n" .
							$translate_block . 
							$translate_hr . 
							"</div>\n" .
							$content;
					break;
					case 'bottom':
						$content = $content . 
							'<div class="translate_block" style="display: none;">' . "\n" .
							$translate_hr . 
							$translate_block . 
							"</div>\n";
					break;
				}
			}
			return $content;
		}

		/**
		 * Filter to add Translate button to comments
		 * @return $content string
		 * @param $content string
		 */
		function processComment($content = '') {
			if ( !is_feed() ) { // ignore feeds
				$translate_block = $this -> generate_translate_block('comment');
				$translate_hr = ( $this -> options['hlineEnable'] ) ? ( '<hr class="translate_hr" />' . "\n" ) : "";
				$content = $content .
					'<div class="translate_block" style="display: none;">' . "\n" .
					$translate_hr .
					$translate_block .
					"</div>\n";
			}
			return $content;
		}

		/**
		 * get a translate button that can be used anywhere in a post or page as needed by a custom theme. This should be in the WordPress loop.
		 */
		function get_jquery_ajax_translate_button($browser_lg = NULL) {
			$backtrace = debug_backtrace();
			if ( !is_feed() && // ignore feeds
			( "the_excerpt" != $backtrace[7]["function"] ) && // ignore excerpts
			( ( !is_page() && $this -> options['postEnable'] ) || ( is_page() && $this -> options['pageEnable'] ) ) && // apply to posts or pages
			! ( in_array( get_the_ID(), $this -> options['excludePages'] ) ) && // exclude certain pages and posts
			! ( $this -> options['excludeHome'] && is_home() ) ) { // if option is set exclude home page
				$translate_block = $this -> generate_translate_block('post',$browser_lg);
				return '<div class="translate_block" style="display: none;">' . "\n" .
					$translate_block .
					"</div>\n";
			}
		}

		/**
		 * echo a translate button for current post. This should be in the WordPress loop.
		 */
		function jquery_ajax_translate_button($browser_lg = NULL) {
			echo $this->get_jquery_ajax_translate_button($browser_lg );
		}

		/**
		 * generate translate_block 
		 * @return $translate_block string
		 * @param $type string a 'post or 'comment'
		 */
		function generate_translate_block($type = 'post', $browser_lg = NULL) {
			if ( 'post' == $type ) {
				$id = get_the_ID();
			} elseif ( 'comment' == $type ) {
				global $comment;
				$id = $comment -> comment_ID;
			} else {
				return NULL;
			}
			$browser_lg = ($browser_lg)?$browser_lg:$this -> browser_lang;
			$translate_block = '<a class="translate_translate" id="translate_button_' . $type . '-' . $id . '" lang="' . $browser_lg . '" xml:lang="' . $browser_lg . '" href="javascript:show_translate_popup(\'' . $browser_lg . '\', \'' . $type . '\', ' . $id . ');">' . ($this -> before_translate) . ($this -> translate_message[$browser_lg]) . ($this -> after_translate) . '</a><img src="' . $this -> pluginRoot . 'transparent.gif" id="translate_loading_' . $type . '-' . $id . '" class="translate_loading" style="display: none;" width="16" height="16" alt="" />' . "\n";
			return $translate_block;
		}

		/**
		 * echoes the language popup in the wp_footer
		 */
		function getLanguagePopup() {
			$numberof_languages = count( $this -> options['languages'] );
			$languages_per_column = ceil( ( $numberof_languages + 2 ) / 3 );
			$index = 0;
			$output = '<div id="translate_popup" style="display: none;' .
				( $this -> options['backgroundColor'] ? ( ' background-color: ' . $this -> options['backgroundColor'] ) : "" ) .
				'">' . "\n\t" .
				'<table class="translate_links"><tr><td valign="top">' . "\n";
			switch ( $this->options['linkStyle'] ) {
				case 'text':
					foreach( $this -> options['languages'] as $lg ) {
						$output .= "\t\t" . '<a class="languagelink" lang="' . $lg . '" xml:lang="' . $lg . '" href="#" title="' .
							$this -> languages[$lg] . '">' . $this -> display_name[$lg] . '</a>' . "\n";
						if ( 0 == ++$index % $languages_per_column) {
							$output .= "\t" . '</td><td valign="top">' . "\n";
						}
					}
					break;
				case 'image':
					foreach( $this -> options['languages'] as $lg ) {
						$output .= "\t\t" . '<a class="languagelink" lang="' . $lg . '" xml:lang="' . $lg . '" href="#" title="' . 
							$this -> languages[$lg] . '"><img class="translate_flag ' . $lg . '" src="' . 
							$this -> pluginRoot . 'transparent.gif" alt="' . 
							$this -> display_name[$lg] . '" width="16" height="11" /></a>' . "\n";
						if ( 0 == ++$index % $languages_per_column ) {
							$output .= "\t" . '</td><td valign="top">' . "\n";
						}
					}
					break;
				case 'imageandtext':
					foreach( $this -> options['languages'] as $lg ) {
						$output .= "\t\t" . '<a class="languagelink" lang="' . $lg . '" xml:lang="' . $lg . '" href="#" title="' . 
							$this -> languages[$lg] . '"><img class="translate_flag ' . $lg . '" src="' . 
							$this -> pluginRoot . 'transparent.gif" alt="' . 
							$this -> display_name[$lg] . '" width="16" height="11" /> ' . 
							$this -> display_name[$lg] . '</a>' . "\n";
						if ( 0 == ++$index % $languages_per_column ) {
							$output .= "\t" . '</td><td valign="top">' . "\n";
						}
					}
					break;
			}
			$output .= "\t\t" . '<a class="google_branding" rel="nofollow" href="http://translate.google.com/translate?sl=auto&amp;tl=' .
				$this -> browser_lang . '&amp;u=' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '" title="translate page">' .
				__('powered by', $this -> textDomain ) .
				'<img src="http://www.google.com/uds/css/small-logo.png" alt="Google" title="" width="51" height="15" /></a>' . 
				"\n\t</td></tr></table>\n</div>\n";
			echo $output;
		}

		/**
		 * echoes one or two JavaScripts in wp_footer
		 */
		function getFooterJS() {
			if ( $this -> options['copyBodyBackgroundColor'] ) { // Copy css background-color to popup if option is set
?>
				<script type="text/javascript">
					jQuery( function($) {
						$('#translate_popup').css('background-color', $('body').css('background-color'));
					});
				</script>
<?php
			}
			if ( $this -> options['doNotTranslateSelector'] ) {
?>
				<script type="text/javascript">
					//<![CDATA[
					var ga_translation_options = {
						do_not_translate_selector: '<?php echo $this -> options['doNotTranslateSelector'] ?>'
						};
					//]]>
				</script>
<?php
			}
		}

		/**
		 * function from: http://us.php.net/manual/en/function.http-negotiate-language.php
		 * determine which language out of an available set the user prefers most
		 * @param array $available_languages An array with language-tag-strings (must be lowercase) that are available
		 * @param string $http_accept_language An HTTP_ACCEPT_LANGUAGE string (read from $_SERVER['HTTP_ACCEPT_LANGUAGE'] if left out)
		 * @return string Best language chosen from $available_languages
		 */
		function preferred_language($available_languages, $http_accept_language="auto") {
			// if $http_accept_language was left out, read it from the HTTP-Header
			if ($http_accept_language == "auto")
				$http_accept_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

			// standard  for HTTP_ACCEPT_LANGUAGE is defined under
			// http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
			// pattern to find is therefore something like this:
			//    1#( language-range [ ";" "q" "=" qvalue ] )
			// where:
			//    language-range  = ( ( 1*8ALPHA *( "-" 1*8ALPHA ) ) | "*" )
			//    qvalue         = ( "0" [ "." 0*3DIGIT ] )
			//            | ( "1" [ "." 0*3("0") ] )
			preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" . "(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/i",
				$http_accept_language, $hits, PREG_SET_ORDER);

			// default language (in case of no hits) is 'en'
			$bestlang = 'en';
			$bestqval = 0;

			foreach ($hits as $arr) {
				// read data from the array of this hit
				$langprefix = strtolower ($arr[1]);
				if (!empty($arr[3])) {
					$langrange = strtolower ($arr[3]);
					$language = $langprefix . "-" . $langrange;
				}
				else $language = $langprefix;
				$qvalue = 1.0;
				if (!empty($arr[5]))
					$qvalue = floatval($arr[5]);

				// find q-maximal language 
				if (in_array($language,$available_languages) && ($qvalue > $bestqval)) {
					$bestlang = $language;
					$bestqval = $qvalue;
				}
				// if no direct hit, try the prefix only but decrease q-value by 10% (as http_negotiate_language does)
				else if (in_array($langprefix,$available_languages) && (($qvalue * 0.9) > $bestqval)) {
					$bestlang = $langprefix;
					$bestqval = $qvalue * 0.9;
				}
			}
			return $bestlang;
		}
	}
}

if ( class_exists( 'JqueryTranslation' ) ) { // instantiate the class
	$JqueryTranslation = new JqueryTranslation();
}
?>