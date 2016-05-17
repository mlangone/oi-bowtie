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
    <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

    <form method="post" name="cleanup_options" action="options.php">
    
<!-- This file should primarily consist of HTML with a little bit of PHP. -->
 
     <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // Cleanup
        $seo = $options['seo'];
        $headerSnippets = $options['headerSnippets'];
        $footerSnippets = $options['footerSnippets'];

        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>
    
        <!-- Use OI SEO in head section <head> -->
        <fieldset>
            <legend class="screen-reader-text"><span>Use OI SEO</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-seo">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-seo" name="<?php echo $this->plugin_name; ?> [seo]" value="1"/>
                <span><?php esc_attr_e('Use OI SEO', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <!-- inject scripts to before closing head tag <head>-->
        <fieldset>
            <legend class="screen-reader-text"><span>Add code before closing head tag</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-headerSnippets">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-headerSnippets" name="<?php echo $this->plugin_name; ?>[headerSnippets]" value="1"/>
                <span><?php esc_attr_e('Add code before closing head tag', $this->plugin_name); ?></span>
            </label>
        </fieldset>

        <!-- remove injected CSS from gallery -->
        <fieldset>
            <legend class="screen-reader-text"><span>Add code before the closing body tab</span></legend>
            <label for="<?php echo $this->plugin_name; ?>-footerSnippets">
                <input type="checkbox" id="<?php echo $this->plugin_name; ?>-footerSnippets" name="<?php echo $this->plugin_name; ?>[footerSnippets]" value="1" />
                <span><?php esc_attr_e('Add code before the closing body tab', $this->plugin_name); ?></span>
            </label>
        </fieldset>


        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>