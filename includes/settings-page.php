            <div class="wrap">
            <h2>Better Pinterest Plugin</h2>

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
                        <input type="radio" name="bpp_color" value="red"<?php checked( 'red' == get_option('bpp_color') ); ?> /> Red<br />
                        <input type="radio" name="bpp_color" value="white"<?php checked( 'white' == get_option('bpp_color') ); ?> /> White<br />
                        <input type="radio" name="bpp_color" value="gray"<?php checked( 'gray' == get_option('bpp_color') ); ?> /> Gray<br />
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Size</th>
                    <td>
                        <input type="radio" name="bpp_size" value="28"<?php checked( '28' == get_option('bpp_size') ); ?> /> Large (28px)<br />
                        <input type="radio" name="bpp_size" value="20"<?php checked( '20' == get_option('bpp_size') ); ?> /> Small (20px)<br />
                    </td>
                    </tr>

                    <tr valign="top">
                    <th scope="row">Pin it Button Language</th>
                    <td>
                        <input type="radio" name="bpp_lang" value="en"<?php checked( 'en' == get_option('bpp_lang') ); ?> /> English<br />
                        <input type="radio" name="bpp_lang" value="ja"<?php checked( 'ja' == get_option('bpp_lang') ); ?> /> Japanese<br />
                    </td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row">Pin it Button Corner</th>
                    <td>
                        <input type="radio" name="bpp_corner" value="northwest"<?php checked( 'northwest' == get_option('bpp_corner') ); ?> /> Northwest (top left)<br />
                        <input type="radio" name="bpp_corner" value="northeast"<?php checked( 'northeast' == get_option('bpp_corner') ); ?> /> Northeast (top right)<br />
                        <input type="radio" name="bpp_corner" value="southwest"<?php checked( 'southwest' == get_option('bpp_corner') ); ?> /> Southwest (bottom left)<br />
                        <input type="radio" name="bpp_corner" value="southeast"<?php checked( 'southeast' == get_option('bpp_corner') ); ?> /> Southeast (bottom right)<br />
                    </td>
                    </tr>
                     
                    <tr valign="top">
                    <th scope="row">Pin it Button Count</th>
                    <td>
                        <input type="radio" name="bpp_count" value="above"<?php checked( 'above' == get_option('bpp_count') ); ?> /> Above the button<br />
                        <input type="radio" name="bpp_count" value="beside"<?php checked( 'beside' == get_option('bpp_count') ); ?> /> Beside the button (<em>If count is 0 no numbers show, this is a bug on the Pinterest side, not the plugin</em>)<br />
                        <input type="radio" name="bpp_count" value="none"<?php checked( 'none' == get_option('bpp_count') ); ?> /> None<br />
                    </td>
                    </tr>
                    
                    <tr valign="top">
                    <th scope="row">Hover Settings</th>
                    <td>
                        <input type="radio" name="bpp_onhover" value="true"<?php checked( 'true' == get_option('bpp_onhover') ); ?> /> Only show Pin it button on hover/mouseover<br />
                        <input type="radio" name="bpp_onhover" value="false"<?php checked( 'false' == get_option('bpp_onhover') ); ?> /> Always show pin it button<br />
                    </td>
                    </tr>
                </table>
                
                <?php submit_button(); ?>

            </form>
            </div>