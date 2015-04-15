            <div class="wrap">
            <h2>Better Pinterest Plugin</h2>

            <p>This plugin allows for the same options listed on the <a href="https://business.pinterest.com/en/widget-builder#do_pin_it_button" target="_Blank">Pinterest widget builder</a> page to be applied to all the images in your post unless otherwise specified.  We respect the <pre>nopin="nopin"</pre> attribute and will not show the button on an image smaller than 200px wide.</p>
            <p>Pinterest recommends that your images be a minimum of 600px wide</p>

            <form method="post" action="options.php">
                <?php
                    // this outputs the 
                    settings_fields( 'bpp-settings-group' );
                    // This could be moved to a constructor once the plugin is class based
                    do_settings_sections( 'bpp-settings-group' );
                ?>
                <table class="form-table">
                    <tr valign="top">
                    <th scope="row">Pin it Button Color</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="Red"><input type="radio" name="bpp_color" value="red"<?php checked( 'red' == get_option('bpp_color') ); ?>> <span>Red</span></label><br>
                            <label title="White"><input type="radio" name="bpp_color" value="white"<?php checked( 'white' == get_option('bpp_color') ); ?>> <span>White</span></label><br>
                            <label title="Gray"><input type="radio" name="bpp_color" value="gray"<?php checked( 'gray' == get_option('bpp_color') ); ?>> <span>Gray</span></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Size</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="Large"><input type="radio" name="bpp_size" value="28"<?php checked( '28' == get_option('bpp_size') ); ?>> <span>Large (28px)</span></label><br>
                            <label title="Small"><input type="radio" name="bpp_size" value="20"<?php checked( '20' == get_option('bpp_size') ); ?>> <span>Small (20px)</span></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Language</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="English"><input type="radio" name="bpp_lang" value="en"<?php checked( 'en' == get_option('bpp_lang') ); ?>> <span>English</span></label><br>
                            <label title="Japanese"><input type="radio" name="bpp_lang" value="ja"<?php checked( 'ja' == get_option('bpp_lang') ); ?>> <span>Japanese</span></label><br>
                        </fieldset>
                    </td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row">Pin it Button Corner</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="Northwest"><input type="radio" name="bpp_corner" value="northwest"<?php checked( 'northwest' == get_option('bpp_corner') ); ?>> <span>Northwest (top left)</span></label><br>
                            <label title="Northeast"><input type="radio" name="bpp_corner" value="northeast"<?php checked( 'northeast' == get_option('bpp_corner') ); ?>> <span>Northeast (top right)</span></label><br>
                            <label title="Southwest"><input type="radio" name="bpp_corner" value="southwest"<?php checked( 'southwest' == get_option('bpp_corner') ); ?>> <span>Southwest (bottom left)</span></label><br>
                            <label title="Southeast"><input type="radio" name="bpp_corner" value="southeast"<?php checked( 'southeast' == get_option('bpp_corner') ); ?>> <span>Southeast (bottom right)</span></label><br>
                        </fieldset>
                    </td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row">Pin it Button Count</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="Above the button"><input type="radio" name="bpp_count" value="above"<?php checked( 'above' == get_option('bpp_count') ); ?>> <span>Above the button</span></label><br>
                            <label title="Beside the button"><input type="radio" name="bpp_count" value="beside"<?php checked( 'beside' == get_option('bpp_count') ); ?>> <span>Beside the button (<em>If count is 0 no numbers show, this is a bug on the Pinterest side, not the plugin</em>)</span></label><br>
                            <label title="None"><input type="radio" name="bpp_count" value="none"<?php checked( 'none' == get_option('bpp_count') ); ?>> <span>None</span></label><br>
                        </fieldset>
                    </td>
                    </tr>
                    
                    <tr valign="top">
                    <th scope="row">Hover Settings</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Pin it Button Color</span></legend>
                            <label title="Show on Hover Only"><input type="radio" name="bpp_onhover" value="true"<?php checked( 'true' == get_option('bpp_onhover') ); ?>> <span>Only show Pin it button on hover/mouseover</span></label><br>
                            <label title="Always Show Pin"><input type="radio" name="bpp_onhover" value="false"<?php checked( 'false' == get_option('bpp_onhover') ); ?>> <span>Always show pin it button</span></label><br>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">What Pages Types Should this Apply To</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>What Pages Types Should this Apply To</span></legend>
                            <?php
                                // Needed only for serilialized array storage
                                $options = get_option('bpp_pagetype');
                                if(!is_array($options)) {
                                    $options = array();
                                }
                            ?>
                            <label title="Posts"><input type="checkbox" name="bpp_pagetype[]" value="posts"<?php checked( in_array('posts', $options) ); ?>> <span>Posts</span></label><br>
                            <label title="Pages"><input type="checkbox" name="bpp_pagetype[]" value="pages"<?php checked( in_array('pages', $options) ); ?>> <span>Pages</span></label><br>
                            <label title="Home"><input type="checkbox" name="bpp_pagetype[]" value="home"<?php checked( in_array('home', $options) ); ?>> <span>Home</span></label><br>
                            <label title="Archives"><input type="checkbox" name="bpp_pagetype[]" value="archives"<?php checked( in_array('archives', $options) ); ?>> <span>Archives</span></label><br>
                            <label title="Search"><input type="checkbox" name="bpp_pagetype[]" value="search"<?php checked( in_array('search', $options) ); ?>> <span>Search</span></label><br>
                        </fieldset>
                    </td>
                    </tr>
                    
                    <tr valign="top">
                    <th scope="row">Append to description</th>
                    <td>
                        <p>If you have a string you'd like to always append to a Pin's description</p>
                        <fieldset>
                            <legend class="screen-reader-text"><span>End description with</span></legend>
                            <label title="end of description"><input type="text" class="regular-text" name="bpp_description_append" value="<?php echo esc_attr(get_option('bpp_description_append')); ?>"></label>
                        </fieldset>
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Load pinit.js Asyncronously?</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span>Loading </span></legend>
                            <label title="Load Async"><input type="radio" name="bpp_load" value="async"<?php checked( 'async' == get_option('bpp_load') ); ?>> <span>Load pinit.js Asyncronously</span></label><br>
                            <label title="Do not load Async"><input type="radio" name="bpp_load" value="sync"<?php checked( 'sync' == get_option('bpp_load') ); ?>> <span>Load pinit.js Syncronously? (default)</span></label><br>
                            <label title="Do not load at all"><input type="radio" name="bpp_load" value="none"<?php checked( 'none' == get_option('bpp_load') ); ?>> <span>Do not load pinit.js (advanced setting; not recommended)</span></label><br>
                        </fieldset>
                    </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>

            </form>
            </div>