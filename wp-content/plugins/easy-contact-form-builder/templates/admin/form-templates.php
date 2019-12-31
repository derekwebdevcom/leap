<?php
/**
 * Template for choosing a new form template
 */
global $wpdb;

$new_form_link = admin_url('admin.php?page=gdfrm&task=create_new_form');

$new_form_link = wp_nonce_url($new_form_link, 'gdfrm_create_new_form');

?>
<div class="wrap gdfrm_form_templates_container ">
    <div class="gdfrm_header">
        <i class="gdicon gdicon-logo"></i>
        <span><?php _e('Select Template',GDFRM_TEXT_DOMAIN);?></span>
        <ul>
            <li>
                <a href="http://grandwp.com/grandwp-forms-user-manual" target="_blank"><?php _e('Help',GDFRM_TEXT_DOMAIN);?></a>
            </li>
        </ul>
    </div>

    <div class="gdfrm_content">

        <?php for($i=0;$i<=9;$i++){ ?>
            <div class="grand_form_template">
                <img src="<?php echo GDFRM_IMAGES_URL.'templates/template'.$i.'.png';?>" class="grand_form_template_thumb">
                <a href="<?php echo $new_form_link.'&template='.$i;?>"><span><?php _e('Next',GDFRM_TEXT_DOMAIN);?></span></a>
            </div>
        <?php } ?>

    </div>

</div>