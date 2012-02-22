<div class="wrap">
	<h2><?php _e('Jquery Ajax Translation', $domain); ?></h2>
	<p> <?php _e('Version', $domain); ?> <?php echo $this->version; ?>
        | <a href="<?php echo $this -> authorUrl; ?>" target="_blank" title="<?php _e('Visit author homepage', $domain);?>">Homepage</a>
        | <a href="<?php echo $this -> pluginUrl; ?>" target="_blank" title="<?php _e('Visit plugin homepage', $domain); ?>">Plugin Homepage</a>
    </p>

    <form method="post" action="options.php">
		<table class="form-table"> 
			<tr valign="top">
				<th scope="row"><?php _e('API key', $domain); ?></th>
                <td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('API key', $domain); ?></span></legend>
						<input name="<?php echo $p; ?>options[apiKey]" size="60" type="text" value="<?php echo $this->options['apiKey']; ?>" />
						<br />
						<span class="description"><?php _e('API key for use with either Google translate or Microsoft Bing translate <a href="#api-info">More information</a>', $domain); ?></span>
					</fieldset>
				</td>
			</tr>
            <tr valign="top">
				<th scope="row"><?php _e('Link style', $domain); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Link style', $domain); ?></span></legend>
						<label><input name="<?php echo $p; ?>options[linkStyle]" type="radio" value="text" <?php echo ( ( 'text' == $this->options['linkStyle'] )? 'checked="checked" ' : '' ); ?>/> <span><?php _e('Language Text', $domain); ?></span></label><br />
						<label><input name="<?php echo $p; ?>options[linkStyle]" type="radio" value="image" <?php echo ( ( 'image' == $this->options['linkStyle'] )? 'checked="checked" ' : '' ); ?>/> <span><?php _e('Flag Icon', $domain); ?></span></label><br />
						<label><input name="<?php echo $p; ?>options[linkStyle]" type="radio" value="imageandtext" <?php echo ( ( 'imageandtext' == $this -> options['linkStyle'] )? 'checked="checked" ' : '' ); ?>/> <span><?php _e('Flag Icon and Text', $domain); ?></span></label>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Translate button position', $domain); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Translate button position', $domain); ?></span></legend>
						<label><input name="<?php echo $p; ?>options[linkPosition]" type="radio" value="top" <?php echo ( ( 'top' == $this -> options['linkPosition'] ) ? 'checked="checked" ' : '' ); ?>/> <span><?php _e('Top of posts and pages', $domain); ?></span></label><br />
						<label><input name="<?php echo $p; ?>options[linkPosition]" type="radio" value="bottom" <?php echo ( ( 'bottom' == $this->options['linkPosition'] )? 'checked="checked" ' : '' ); ?>/> <span><?php _e('Bottom of posts and pages', $domain); ?></span></label><br />
						<label><input name="<?php echo $p; ?>options[linkPosition]" type="radio" value="none" <?php echo ( ( 'none' == $this->options['linkPosition'] )? 'checked="checked" ' : '' ); ?>/> <span><?php _e('none', $domain); ?></span></label><br />
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Horizontal line', $domain); ?></th>
				<td>
					<label>
						<input name="<?php echo $p; ?>options[hlineEnable]" type="checkbox" <?php echo ( ( $this->options['hlineEnable'] )? 'checked="checked" ' : '' ); ?>/>
						<span><?php _e('Show line above or below Translate button', $domain); ?></span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Background color', $domain); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Background color', $domain); ?></span></legend>
						<label>
							<input name="<?php echo $p; ?>options[copyBodyBackgroundColor]" type="checkbox" <?php echo ( ( $this->options['copyBodyBackgroundColor'] )? 'checked="checked" ' : '' ); ?>/>
							<span><?php _e('Copy background color from page body', $domain); ?></span>
						</label><br />
						<input name="<?php echo $p; ?>options[backgroundColor]" type="text" value="<?php echo $this->options['backgroundColor'];?>" <?php echo ( !( $this->options['copyBodyBackgroundColor'] )? '' : 'disabled="disabled"' ); ?> />
						<span class="description"><?php _e('Background color in the format #5AF or #55AAFF', $domain); ?></span>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Posts', $domain); ?></th>
				<td>
					<label>
						<input name="<?php echo $p; ?>options[postEnable]" type="checkbox" <?php echo ( ( $this -> options['postEnable'] )? 'checked="checked" ' : '' ); ?>/>
						<span><?php _e('Enable post translation', $domain); ?></span>
					</label>
					<br />
					<label>
						<input name="<?php echo $p; ?>options[excludeHome]" type="checkbox" ' <?php echo ( ( $this -> options['excludeHome'] )? 'checked="checked" ' : '' )?> <?php echo ( ( $this -> options['postEnable'] )? '' : 'disabled="disabled"' ); ?>/>
						<span><?php _e('Exclude home page', $domain); ?></span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Pages', $domain); ?></th>
				<td>
					<label>
						<input name="<?php echo $p; ?>options[pageEnable]" type="checkbox" <?php echo ( ( $this -> options['pageEnable'] )? 'checked="checked" ' : '' ); ?>/>
						<span><?php _e('Enable page translation', $domain); ?></span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Exclude posts and pages', $domain); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Exclude posts and pages', $domain); ?></span></legend>
						<input name="<?php echo $p; ?>options[excludePages]" size="60" type="text" value="<?php echo $excludePages_str; ?>" />
						<br />
						<span class="description"><?php _e('A comma separated list of post and page ID&apos;s', $domain); ?></span>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Comments', $domain); ?></th>
				<td>
					<label>
						<input name="<?php echo $p; ?>options[commentEnable]" type="checkbox" <?php echo ( ( $this -> options['commentEnable'] )? 'checked="checked" ' : '' ); ?>/>
						<span><?php _e('Enable comment translation', $domain); ?></span>
					</label>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Do not translate', $domain); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Do not translate', $domain); ?></span></legend>
						<input name="<?php echo $p; ?>options[doNotTranslateSelector]" type="text" value="<?php echo htmlspecialchars( $this -> options['doNotTranslateSelector'] ); ?>" />
						<span class="description"><?php _e('Selector in jQuery format (See the FAQ)', $domain); ?></span>
					</fieldset>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><?php _e('Languages', $domain); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Languages', $domain); ?></span></legend>
						<table class="translate_links"><tr><td valign="top">
						<?php
						$numberof_languages = count( $this -> languages );
						$index = 0;
						foreach ( $this -> languages as $lg => $v ):
                        ?>
                            <label title="<?php echo $this->display_name[$lg]; ?>"><input type="checkbox" name="<?php echo $p ;?>options[languages][]" value="<?php echo $lg; ?>" <?php echo ( in_array( $lg, (array) $this -> options['languages'] ) )? 'checked="checked"' : ''; ?>/> <img class="translate_flag <?php echo $lg ;?>" src="<?php echo $this->pluginRoot; ?>transparent.gif" alt="<?php echo $this->display_name[$lg]; ?>" width="16" height="11" /> <span><?php echo  $v ;?></span></label><br />
                        <?php 
							if ( ( 0 == ++$index % 13) && ( $index < $numberof_languages ) ): // columns should be 13 tall
                        ?>
                        </td><td valign="top">
                        <?php
							endif;
						endforeach;
                        ?>
				</td>
            </tr>
        </table>
        <p>
            <input type="button" class="button" id="languages_all" value="<?php _e('All', $domain); ?>" />
            <input type="button" class="button" id="languages_none" value="<?php _e('None', $domain); ?>" />
        </p>
    </fieldset>
</td>
            </tr>
			</table>
        <?php
			if ( 'en' != $this -> browser_lang ) {
				echo '<input type="button" class="button" id="translate_button" value="' . $this -> translate_message[$this -> browser_lang] . '" /> <img src="' . $this -> pluginRoot . 'transparent.gif" id="translate_loading_admin" class="translate_loading" style="display: none;" width="16" height="16" alt="" />
			';
			}
        ?>
        <p class="submit"><?php echo settings_fields('jquery-ajax-translation'); ?>
            <input type="submit" name="submit" class="button-primary" value="<?php _e('Save Changes', $domain); ?>" />
			</p>
        </form>
        
        
        <h3 name="api-info" id="api-info"><?php _e('API information', $domain); ?></h3>
        <h4>Google Translate</h4>
        <p>Since 1st of December Google has switched off the free version of it's translation software. The costs can be viewed on the Google Language page: <a href="http://code.google.com/apis/language/translate/v2/pricing.html">Google translate pricing</a></p>
        
        <p>If you to the aforementioned page, click on the link to go to the Google API console ( <i>https://code.google.com/apis/console/#project:xxxxx</i> ). After this click on the 'Billing' option on the left hand side, and then complete the billing details.</p>
        
        <p>Once the billing details are setup, click on the option called API Access: <i>https://code.google.com/apis/console/#project:xxxxx:access</i></p>
        <p>Click on the option to '<i>Create new Server key...</i>'. Since the API key will be embedded on the website, it is a good idea to provide some IP addresses so that people don't abuse the translation tools by copying your API key. So provide your server IP address.</p>
        
        <p>Please could you email over the newly created API key, it should look something like: <i>AIasSnDNcjIhNhBk6xu9kI69dJ68atRFqZFir8U</i></p>
        
        <h4>Microsoft Bing Translation</h4>
        <p>More information to follow.</p>

        
    </div>
    
    
    