<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://onlineimage.com
 * @since      1.0.0
 *
 * @package    Oi_Bowtie
 * @subpackage Oi_Bowtie/admin/partials
 */
?>

<div class="wrap">


    <h2 class="nav-tab-wrapper">Clean up</h2>

    <form method="post" name="cleanup_options" action="options.php">

    <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $oi_seo = $options['oi_seo'];
        $header_snippets = $options['header_snippets'];
        $footer_snippets = $options['footer_snippets'];
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>

    <!-- oi seo <head> -->
    <fieldset>
        <legend class="screen-reader-text">
            <span>OI Seo</span>
        </legend>
        <label for="<?php echo $this->plugin_name; ?>-seo">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-oi_seo" name="<?php echo $this->plugin_name; ?>[oi_seo]" value="1" <?php checked($oi_seo, 1); ?> />
            <span><?php esc_attr_e('OI Seo - (should not be used with other SEO plugins will cause duplicate title and meta information)', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- header snippets -->
    <fieldset>
        <legend class="screen-reader-text"><span>Header Snippets</span></legend>
        <label for="<?php echo $this->plugin_name; ?>-header_snippets">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-header_snippets" name="<?php echo $this->plugin_name; ?>[header_snippets]" value="1" <?php checked($header_snippets, 1); ?> />
            <span><?php esc_attr_e('Inject snippets to the head section before the closing </head> tag ', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <!-- foote snippets -->
    <fieldset>
        <legend class="screen-reader-text"><span>Footer Snippets</span></legend>
        <label for="<?php echo $this->plugin_name; ?>-footer_snippets">
            <input type="checkbox" id="<?php echo $this->plugin_name; ?>-footer_snippets" name="<?php echo $this->plugin_name; ?>[footer_snippets]" value="1" <?php checked( $footer_snippets, 1 ); ?>  />
            <span><?php esc_attr_e('Inject snippets to the footer area before the closing </body> tag', $this->plugin_name); ?></span>
        </label>
    </fieldset>

    <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>