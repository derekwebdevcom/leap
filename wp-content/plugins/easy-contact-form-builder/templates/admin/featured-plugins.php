<?php
/**
 * Template for featured plugins page
 */

function activation_link_gdwp_forms( $plugin, $action = 'activate' ) {
    if ( strpos( $plugin, '/' ) ) {
        $plugin = str_replace( '\/', '%2F', $plugin );
    }
    $url = sprintf( admin_url( 'plugins.php?action=' . $action . '&plugin=%s&plugin_status=all&paged=1&s' ), $plugin );
    $_REQUEST['plugin'] = $plugin;
    $url = wp_nonce_url( $url, $action . '-plugin_' . $plugin );
    return $url;
}

?>

<div class="wrap gdfrm_featured_plugins_container">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('GrandWP Form Builder',GDFRM_TEXT_DOMAIN);?></span>
        <ul>
            <li>
                <a href="https://demo.grandwp.com/wordpress-contact-form-builder-contact-person-information/" target="_blank"><?php _e('Demo',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="https://wordpress.org/support/plugin/easy-contact-form-builder" target="_blank"><?php _e('Support',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="https://grandwp.com/wordpress-contact-form-builder" target="_blank"><?php _e('Go Pro',GDFRM_TEXT_DOMAIN);?></a>
            </li>
            <li>
                <a href="https://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help',GDFRM_TEXT_DOMAIN);?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_content">


        <div class="single-plugin">
            <div class="plugin-thumb">
                <img src="<?php echo GDFRM_IMAGES_URL.'/gwpcalendar.png';?>">
            </div>
            <div class="plugin-info">
                <div class="plugin-name">GrandWP Calendar</div>
                <div class="plugin-desc">
                    Calendar  - Advanced and user-friendly Calendar for WordPress gives a variety of
                    options and powerful event management tools for WordPress users. It’s intuitive
                    user interface makes it super easy to use. You can easily add events, sort them into
                    categories / tags and choose from calendar displays. You can also display your event
                    venues using Google Maps right along the event details. The powerful configuration
                    options give you full control on the display of your calendar and events. Add colorful
                    widgets and more.
                </div>
                <div class="plugin-buttons">

                    <?php

                    $slug = 'simple-event-calendar';
                    $install_url = esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $slug), 'install-plugin_' . $slug));
                    $activation_url = activation_link_gdwp_forms($slug.'/index.php', 'activate');
                    $go_to_plugin_url = 'gd_events';

                    $plugin_dir = ABSPATH . 'wp-content/plugins/simple-event-calendar/';
                    if ( is_dir($plugin_dir) && !is_plugin_active( 'simple-event-calendar/index.php' ) ) {
                        ?>
                        <a class="gwp_plugin_activate " id="activate_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Activation</a>
                        <a class="gwp_goto_plugin hidden" id="go_to_calendar" href="edit.php?post_type=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Calendar</a>
                        <?php
                    }
                    else if( ! is_dir($plugin_dir) ) {
                        ?>
                        <a class="gwp_plugin_install" id="install_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Install</a>
                        <a class="gwp_plugin_activate hidden" id="activate_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Activation</a>
                        <a class="gwp_goto_plugin hidden" id="go_to_calendar" href="edit.php?post_type=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Calendar</a>
                        <?php
                    }

                    if ( is_plugin_active( 'simple-event-calendar/index.php' ) ) {
                    ?>
                    <a class="gwp_goto_plugin" id="go_to_calendar" href="edit.php?post_type=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Calendar</a>
                    <?php } ?>
                    <a href="https://demo.grandwp.com/wordpress-event-calendar-demo/" target="_blank">
                        <?php _e('Demo',GDFRM_TEXT_DOMAIN);?>
                    </a>
                </div>
            </div>
        </div>

        <div class="single-plugin">
            <div class="plugin-thumb">
                <img src="<?php echo GDFRM_IMAGES_URL.'/gwplightbox.png';?>" alt="Plugin Icon" />
            </div>
            <div class="plugin-info">
                <div class="plugin-name">GrandWP Lightbox</div>
                <div class="plugin-desc">
                    Lightbox - Grand LIghtbox is offering a quick and simple lightbox for your pages
                    and posts. It comes with friendly appearance and wide range of settings as the
                    aforementioned plugins, but if you’re looking for a minimalist way of opening
                    your images in a lightbox style, you’ll love this one. GrandLightbox allows you
                    to add beautiful features. You can display an image separately or in a slideshow,
                    and youcan also set the transitions, animations, slideshows’ speed, overlay opacity, etc.
                </div>
                <div class="plugin-buttons">
                    <?php

                    $slug = 'responsive-lightbox-popup';
                    $install_url = esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $slug), 'install-plugin_' . $slug));
                    $activation_url = activation_link_gdwp_forms($slug.'/index.php', 'activate');
                    $go_to_plugin_url = 'gd_lightbox';

                    $plugin_dir = ABSPATH . 'wp-content/plugins/responsive-lightbox-popup/';
                    if ( is_dir($plugin_dir) && !is_plugin_active( 'responsive-lightbox-popup/index.php' ) ) {
                        ?>
                        <a class="gwp_plugin_activate " id="activate_lightbox_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Activation</a>
                        <a class="gwp_goto_plugin hidden" id="go_to_lightbox" href="admin.php?page=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Lightbox</a>
                        <?php
                    }
                    else if( ! is_dir($plugin_dir) ) {
                        ?>
                        <a class="gwp_plugin_install" id="install_lightbox_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Install</a>
                        <a class="gwp_plugin_activate hidden" id="activate_lightbox_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Activation</a>
                        <a class="gwp_goto_plugin hidden" id="go_to_lightbox" href="admin.php?page=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Lightbox</a>
                        <?php
                    }

                    if ( is_plugin_active( 'responsive-lightbox-popup/index.php' ) ) {
                        ?>
                         <a class="gwp_goto_plugin" id="go_to_lightbox" href="admin.php?page=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Lightbox</a>
                    <?php } ?>
                         <a href="https://demo.grandwp.com/wordpress-responsive-lightbox-demo/" target="_blank"> <?php _e('Demo',GDFRM_TEXT_DOMAIN);?> </a>
                </div>
            </div>

        </div>

        <div class="single-plugin">
            <div class="plugin-thumb">
                <img src="<?php echo GDFRM_IMAGES_URL.'/gwpgallery.png';?>" alt="Plugin Icon" />
            </div>
            <div class="plugin-info">
                <div class="plugin-name">GrandWP Gallery</div>
                <div class="plugin-desc">
                    Gallery - Various adjustable options to make galleries even more personalized. GrandWP Gallery plugin stands for intuitive and modern design combined with high functionality. We have gathered all essential options in one tool to meet all kind of requirements..
                </div>
                <div class="plugin-buttons">
                    <?php

                    $slug = 'photo-gallery-image';
                    $install_url = esc_url(wp_nonce_url(self_admin_url('update.php?action=install-plugin&plugin=' . $slug), 'install-plugin_' . $slug));
                    $activation_url = activation_link_gdwp_forms($slug.'/index.php', 'activate');
                    $go_to_plugin_url = 'gdgallery';

                    $plugin_dir = ABSPATH . 'wp-content/plugins/photo-gallery-image/';
                    if ( is_dir($plugin_dir) && !is_plugin_active( 'photo-gallery-image/index.php' ) ) {
                        ?>
                        <a class="gwp_plugin_activate " id="activate_gallery_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Activation</a>
                        <a class="gwp_goto_plugin hidden" id="go_to_gallery" href="admin.php?page=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Gallery</a>
                        <?php
                    }
                    else if( ! is_dir($plugin_dir) ) {
                        ?>
                        <a class="gwp_plugin_install" id="install_gallery_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Install</a>
                        <a class="gwp_plugin_activate hidden" id="activate_gallery_now" data-install-url="<?php echo $install_url; ?>" data-activate-url="<?php echo $activation_url; ?>">Activation</a>
                        <a class="gwp_goto_plugin hidden" id="go_to_gallery" href="admin.php?page=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Gallery</a>
                        <?php
                    }

                    if ( is_plugin_active( 'photo-gallery-image/index.php' ) ) {
                        ?>
                        <a class="gwp_goto_plugin" id="go_to_gallery" href="admin.php?page=<?php echo $go_to_plugin_url; ?>" target="_blank">Go to Gallery</a>
                    <?php } ?>

                    <a href="https://demo.grandwp.com/wordpress-photo-gallery-justified/" target="_blank">
                        <?php _e('Demo',GDFRM_TEXT_DOMAIN);?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function install_grandwp_plugin(strThis,installUrl,activateUrl) {
        strThis.parents('.single-plugin').addClass('strloading');
        jQuery(this).prop('disable',true);
        jQuery.ajax({
            method: "POST",
            url: installUrl,
        }).done(function() {
            jQuery.ajax({
                type: 'POST',
                url: jQuery("#verifyUrl").attr('data-url'),
                error: function()
                {
                    jQuery(".error_install").show();
                },
                success: function(response)
                {
                    activate_grandwp_plugin(strThis,activateUrl);

                    strThis.parents('.plugin-buttons').find('.gwp_plugin_install').addClass('hidden');
                    strThis.parents('.plugin-buttons').find('.gwp_plugin_activate').removeClass('hidden');
                }
            });
        })
    }

    function activate_grandwp_plugin(strThis,activate_url) {
        strThis.parents('.single-plugin').addClass('strloading');
        jQuery.ajax({
            method: "POST",
            url: activate_url,
        }).done(function() {

            jQuery.ajax({
                type: 'POST',
                url: jQuery("#verifyUrl").attr('data-url'),
                error: function()
                {
                    jQuery(".error_activate").removeClass('hidden');
                },
                success: function(response)
                {
                    strThis.parents('.single-plugin').removeClass('strloading');
                    strThis.parents('.plugin-buttons').find('.gwp_plugin_install').addClass('hidden');
                    strThis.parents('.plugin-buttons').find('.gwp_plugin_activate').addClass('hidden');
                    strThis.parents('.plugin-buttons').find('.gwp_goto_plugin').removeClass('hidden');
                }
            });
        })
    }

    jQuery(".gwp_plugin_install").on("click",function(){
        install_grandwp_plugin(jQuery(this),jQuery(this).attr("data-install-url"),jQuery(this).attr("data-activate-url"));
    });
    jQuery(".gwp_plugin_activate").on("click",function(){
        activate_grandwp_plugin(jQuery(this),jQuery(this).attr("data-activate-url"))
    });
</script>