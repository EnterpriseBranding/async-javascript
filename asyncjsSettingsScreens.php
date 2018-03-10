<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

$site_url = trailingslashit( get_site_url() );
$aj_gtmetrix_username = get_option( 'aj_gtmetrix_username', '' );
$aj_gtmetrix_api_key = get_option( 'aj_gtmetrix_api_key', '' );
$aj_gtmetrix_server = get_option( 'aj_gtmetrix_server', '' );
$aj_enabled = get_option( 'aj_enabled', 0 );
$aj_enabled_checked = ( $aj_enabled == 1 ) ? ' checked="checked"' : '';
$aj_method = get_option( 'aj_method', 'async' );
$aj_method_async = ( $aj_method == 'async' ) ? ' checked="checked"' : '';
$aj_method_defer = ( $aj_method == 'defer' ) ? ' checked="checked"' : '';
$aj_jquery = get_option( 'aj_jquery', 'async' );
$aj_jquery = ( $aj_jquery == 'same ' ) ? $aj_method : $aj_jquery;
$aj_jquery_async = ( $aj_jquery == 'async' ) ? ' checked="checked"' : '';
$aj_jquery_defer = ( $aj_jquery == 'defer' ) ? ' checked="checked"' : '';
$aj_jquery_exclude = ( $aj_jquery == 'exclude' ) ? ' checked="checked"' : '';
$aj_async = get_option( 'aj_async', '' );
$aj_defer = get_option( 'aj_defer', '' );
$aj_exclusions = get_option( 'aj_exclusions', '' );
$aj_plugin_exclusions = ( is_array( get_option( 'aj_plugin_exclusions', array() ) ) && !is_null( get_option( 'aj_plugin_exclusions', array() ) ) ? get_option( 'aj_plugin_exclusions', array() ) : explode( ',', get_option( 'aj_plugin_exclusions', '' ) ) );
$aj_theme_exclusions = ( is_array( get_option( 'aj_theme_exclusions', array() ) ) && !is_null( get_option( 'aj_theme_exclusions', array() ) ) ? get_option( 'aj_theme_exclusions', array() ) : explode( ',', get_option( 'aj_theme_exclusions', '' ) ) );
$aj_autoptimize_enabled = get_option( 'aj_autoptimize_enabled', 0 );
$aj_autoptimize_enabled_checked = ( $aj_autoptimize_enabled == 1 ) ? ' checked="checked"' : '';
$aj_autoptimize_method = get_option( 'aj_autoptimize_method', 'async' );
$aj_autoptimize_async = ( $aj_autoptimize_method == 'async' ) ? ' checked="checked"' : '';
$aj_autoptimize_defer = ( $aj_autoptimize_method == 'defer' ) ? ' checked="checked"' : '';
?>
<table class="form-table" width="100%" cellpadding="10">
    <tr id="aj_intro">
            <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/finger_point_out_punch_hole_400_clr_17860.png" title="<?php echo AJ_TITLE; ?>" alt="<?php echo AJ_TITLE; ?>"  class="aj_step_img"></td>
            <td scope="row" align="left" style="vertical-align: top !important;">
                    <h3><?php echo AJ_TITLE; ?></h3>
                    <?php echo $this->about_aj(); ?>
            </td>
    </tr>
    <tr id="aj_quick_settings">
            <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/clock_fast_times_text_10762.gif" title="Quick Settings" alt="Quick Settings"  class="aj_step_img"></td>
            <td scope="row" align="left" style="vertical-align: top !important;">
                    <h3>Quick Settings</h3>
                    <p>Use the buttons below to apply common settings.</p>
                    <p><strong>Note: </strong>Using the buttons below will erase any current settings within <?php echo AJ_TITLE; ?>.</p>
                    <p>
                            <button data-id="aj_step2b_apply" class="aj_steps_button">Apply Async</button>
                            <button data-id="aj_step2c_apply" class="aj_steps_button">Apply Defer</button>
                            <button data-id="aj_step2d_apply" class="aj_steps_button">Apply Async (jQuery excluded)</button>
                            <button data-id="aj_step2e_apply" class="aj_steps_button">Apply Defer (jQuery excluded)</button>
                    </p>
            </td>
    </tr>
    <tr id="aj_settings_enable">
        <td scope="row" align="center" style="vertical-align: top !important;"><img src="<?php echo AJ_PLUGIN_URL; ?>images/finger_point_out_punch_hole_400_clr_17860.png" title="Enable <?php echo AJ_TITLE; ?>" alt="Enable <?php echo AJ_TITLE; ?>"  class="aj_step_img"></td>
        <td scope="row" align="left" style="vertical-align: top !important;">
            <h3>Enable <?php echo AJ_TITLE; ?></h3>
            <p><label>Enable <?php echo AJ_TITLE; ?>? </label><input type="checkbox" id="aj_enabled" id="aj_enabled" value="1" <?php echo $aj_enabled_checked; ?> /></p>
            <hr />
            <h3><?php echo AJ_TITLE; ?> Method</h3>
            <p>Please select the method (<strong>async</strong> or <strong>defer</strong>) that you wish to enable:</p>
            <p><label>Method: </label><input type="radio" name="aj_method" value="async" <?php echo $aj_method_async; ?> /> Async <input type="radio" name="aj_method" value="defer" <?php echo $aj_method_defer; ?> /> Defer</p>
            <hr />
            <h3>jQuery</h3>
            <p>Often if jQuery is loaded with <strong>async</strong> or <strong>defer</strong> it can break some jQuery functions, specifically inline scripts which require jQuery to be loaded before the scripts are run.  <strong><em>Sometimes</em></strong> choosing a different method (<strong>async</strong> or <strong>defer</strong>) will work, otherwise it may be necessary to exclude jQuery from having <strong>async</strong> or <strong>defer</strong> applied.</p>
            <p><label>jQuery Method: </label><input type="radio" name="aj_jquery" value="async" <?php echo $aj_jquery_async; ?> /> Async <input type="radio" name="aj_jquery" value="defer" <?php echo $aj_jquery_defer; ?> /> Defer <input type="radio" name="aj_jquery" value="exclude" <?php echo $aj_jquery_exclude; ?> /> Exclude</p>
            <hr />
            <h3>Scripts to Async</h3>
            <p>Please list any scripts which you would like to apply the 'async' attribute to. (comma seperated list eg: jquery.js,jquery-ui.js)</p>
            <p><label>Async Scripts: </label><textarea id="aj_async" style="width:95%;"><?php echo $aj_async; ?></textarea></p>
            <hr />
            <h3>Scripts to Defer</h3>
            <p>Please list any scripts which you would like to apply the 'defer' attribute to. (comma seperated list eg: jquery.js,jquery-ui.js)</p>
            <p><label>Defer Scripts: </label><textarea id="aj_defer" style="width:95%;"><?php echo $aj_defer; ?></textarea></p>
            <hr />
            <h3>Script Exclusion</h3>
            <p>Please list any scripts which you would like excluded from having <strong>async</strong> or <strong>defer</strong> applied during page load. (comma seperated list eg: jquery.js,jquery-ui.js)</p>
            <p><label>Exclusions: </label><textarea id="aj_exclusions" style="width:95%;"><?php echo $aj_exclusions; ?></textarea></p>
            <hr />
            <h3>Plugin Exclusions</h3>
            <p>Please select one or more plugins. Scripts contained within the plugin will not have async / defer applied.</p>
            <p><strong><em>Please Note:</em></strong> This will exclude any JavaScript files which are contained within the files of the selected Plugin(s). External JavaScripts loaded by the selected Plugin(s) are not affected.</p>
            <p>For Example: If a plugin is installed in path <strong>/wp-content/plugins/some-plugin/</strong> then and JavaScripts contained within this path will be excluded. If the plugin loads a JavaScript which is countained elsewhere then the Global Method will be used (ie async or defer)</p>
            <p><label>Exclusions: </label>
            <?php
            $plugins = get_plugins();
            $output = '';
            if ( !empty( $plugins ) ) {
                $output .= '<select id="aj_plugin_exclusions" class="aj_chosen" multiple="multiple" style="min-width:50%;" >';
                    foreach ( $plugins as $path=>$plugin ) {
                            $split = explode( '/', $path );
                                                                    $text_domain = $split[0];
                            if ( $text_domain != 'async-javascript' ) {
                                    //var_dump( $aj_plugin_exclusions );
                            $selected = ( in_array( $text_domain, $aj_plugin_exclusions ) ) ? ' selected="selected"' : '';
                            $output .= '<option value="' . $text_domain . '"' . $selected . '>' . $plugin['Name'] . '</option>';
                        }
                    }
                $output .= '</select>';
            } else {
                $output .= '<p>No plugins found.</p>';
            }
            echo $output;
            ?>
            </p>
            <hr />
            <h3>Theme Exclusions</h3>
            <p>Please select one or more themes. Scripts contained within the theme will not have async / defer applied.</p>
            <p><strong><em>Please Note:</em></strong> This will exclude any JavaScript files which are contained within the files of the selected Theme(s). External JavaScripts loaded by the selected Theme(s) are not affected.</p>
            <p>For Example: If a theme is installed in path <strong>/wp-content/themes/some-theme/</strong> then and JavaScripts contained within this path will be excluded. If the theme loads a JavaScript which is countained elsewhere then the Global Method will be used (ie async or defer)</p>
            <p>
                <label>Exclusions: </label>
                <?php
                $themes = wp_get_themes();
                $output = '';
                if ( !empty( $themes ) ) {
                    $output .= '<select id="aj_theme_exclusions" class="aj_chosen" multiple="multiple" style="min-width:50%;" >';
                        foreach ( $themes as $path=>$theme ) {
                                                                        $text_domain = $path;
                            $selected = ( in_array( $text_domain, $aj_theme_exclusions ) ) ? ' selected="selected"' : '';
                            $output .= '<option value="' . $text_domain . '"' . $selected . '>' . $theme->Name . '</option>';
                        }
                    $output .= '</select>';
                } else {
                    $output .= '<p>No themes found.</p>';
                }
                echo $output;
                ?>
            </p>
            <hr />
            <h3><?php echo AJ_TITLE; ?> For Plugins</h3>
            <p>Although not recommended, some themes / plugins can load JavaScript files without using the <strong><a href="https://codex.wordpress.org/Plugin_API/Action_Reference/wp_enqueue_scripts" target="_blank">wp_enqueue_script</a></strong> function.  In some cases this is necessary for the functionality of the theme / plugin.</p>
            <p>If these themes / plugins provide a hook that can be used to manipulate how the JavaScript file is loaded then <?php echo AJ_TITLE; ?> may be able to provide support for these themes / plugins.</p>
            <p>If you have any active themes / plugins that <?php echo AJ_TITLE; ?> supports then these will be listed below.</p>
            <p>If you think you have found a plugin that <?php echo AJ_TITLE; ?> may be able to provide support for please lodge a ticket at <a href="https://wordpress.org/support/plugin/async-javascript" target="_blank">https://wordpress.org/support/plugin/async-javascript</a></p>
            <?php
            if ( is_plugin_active( 'autoptimize/autoptimize.php' ) ) {
                    ?>
                    <div class="aj_plugin">
                            <h4>Plugin: Autoptimize</h4>
                            <p><a href="https://wordpress.org/plugins/autoptimize/" target="_blank">https://wordpress.org/plugins/autoptimize/</a></p>
                            <p><label>Enable Autoptimize Support: </label><input type="checkbox" id="aj_autoptimize_enabled" value="1" <?php echo $aj_autoptimize_enabled_checked; ?> /></p>
                            <p><label>jQuery Method: </label><input type="radio" name="aj_autoptimize_method" value="async" <?php echo $aj_autoptimize_async; ?> /> Async <input type="radio" name="aj_autoptimize_method" value="defer" <?php echo $aj_autoptimize_defer; ?> /> Defer</p>
                    </div>
                    <?php
            }
            ?>
            <p><button data-id="aj_save_settings" class="aj_steps_button">Save Settings</button></p>
        </td>
    </tr>
</table>
<?php