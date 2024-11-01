<!-- WooCommerce Subscribers Settings -->

<?php
save_options();


$centrico_woocommerce_checkbox = get_option('centrico_woocommerce_checkbox');
$centrico_woocommerce_checkboxautocheck = get_option('centrico_woocommerce_checkboxautocheck');
$centrico_woocommerce_checkboxlabel = get_option('centrico_woocommerce_checkboxlabel');
$centrico_woocommerce_fields = get_option('centrico_woocommerce_fields');
$centrico_woocommerce_list_id = get_option('centrico_woocommerce_list_id');
$centrico_woocommerce_groups_id = get_option('centrico_woocommerce_groups_id');


//$centrico_woocommerce_liststype = get_option('centrico_woocommerce_liststype');
//$centrico_woocommerce_liststype_user_selection = get_option('centrico_woocommerce_liststype_user_selection');
//$centrico_woocommerce_mailinglists = get_option('centrico_woocommerce_mailinglists');
//$centrico_woocommerce_removeold = get_option('centrico_woocommerce_removeold');
//$centrico_woocommerce_checkbox_action = get_option('centrico_woocommerce_checkbox_action');

//$users = get_users(array('fields' => array('ID')));
//foreach ($users as $user) {
//    print_r(get_user_meta($user->ID));
//}

//print_r($centrico_woocommerce_fields);

WC()->session = new WC_Session_Handler;
WC()->customer = new WC_Customer;

$centrico_api = new centrico_api();

?>


<h1>Woo Commerce configuration for Centrico</h1>

<form action="" method="post">
    <table class="form-table">
        <tbody>
            <tr>
                <th><label for="centrico_woocommerce_checkbox"><?php _e('Enable?', 'centrico-woocommerce'); ?></label></th>
                <td>
                    <label><input onclick="if (jQuery(this).is(':checked')) {
                                jQuery('#centrico_woocommerce_div').show();
                            } else {
                                jQuery('#centrico_woocommerce_div').hide();
                            }" <?php echo (!empty($centrico_woocommerce_checkbox)) ? 'checked="checked"' : ''; ?> type="checkbox" name="centrico_woocommerce_checkbox" value="1" id="centrico_woocommerce_checkbox" /> <?php _e('Yes, enable the subscribe checkbox on the WooCommerce checkout', 'centrico-woocommerce'); ?></label>
                    <span class="howto"><?php _e('Tick/check this to enable the integration', 'centrico-woocommerce'); ?></span>
                </td>
            </tr>
        </tbody>
    </table>

    <div id="centrico_woocommerce_div" style="display:<?php echo (!empty($centrico_woocommerce_checkbox)) ? 'block' : 'none'; ?>;">
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="centrico_woocommerce_checkboxautocheck"><?php _e('Auto Check?', 'centrico-woocommerce'); ?></label></th>
                    <td>
                        <label><input <?php echo (!empty($centrico_woocommerce_checkboxautocheck)) ? 'checked="checked"' : ''; ?> type="checkbox" name="centrico_woocommerce_checkboxautocheck" value="1" id="centrico_woocommerce_checkboxautocheck" /> <?php _e('Yes, auto check the checkbox', 'centrico-woocommerce'); ?></label>
                        <span class="howto"><?php _e('By ticking/checking this, the subscribe checkbox will be automatically pre-checked for customers.', 'centrico-woocommerce'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th><label for="centrico_woocommerce_checkboxlabel"><?php _e('Checkbox Label', 'centrico-woocommerce'); ?></label></th>
                    <td>
                        <?php if (1 == 0) : ?>
                            <div id="centrico-woocommerce-checkboxlabel-tabs">
                                <ul>
                                    <?php foreach ($languages as $language) : ?>
                                        <li><a href="#centrico-woocommerce-checkboxlabel-tabs-<?php echo $language; ?>"><?php echo language_flag($language); ?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php foreach ($languages as $language) : ?>
                                    <div id="centrico-woocommerce-checkboxlabel-tabs-<?php echo $language; ?>">
                                        <input type="text" class="widefat" name="centrico_woocommerce_checkboxlabel[<?php echo $language; ?>]" value="<?php echo esc_attr(stripslashes(language_use($language, $centrico_woocommerce_checkboxlabel))); ?>" id="centrico_woocommerce_checkboxlabel_<?php echo $language; ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <script type="text/javascript">
                                jQuery(document).ready(function () {
                                    if (jQuery.isFunction(jQuery.fn.tabs)) {
                                        jQuery('#centrico-woocommerce-checkboxlabel-tabs').tabs();
                                    }
                                });
                            </script>
                        <?php else : ?>
                            <input type="text" class="widefat" name="centrico_woocommerce_checkboxlabel" value="<?php echo esc_attr(stripslashes($centrico_woocommerce_checkboxlabel)); ?>" id="centrico_woocommerce_checkboxlabel" />
                        <?php endif; ?>
                        <span class="howto"><?php _e('Specify the caption/label to show next to the checkbox.', 'centrico-woocommerce'); ?></span>
                    </td>
                </tr>

                <tr>
                    <th><label for=""><?php _e('Custom Fields', 'newsletters-woocommerce'); ?></label></th>
                    <td>
                        <p class="howto"><?php _e('Assign WooCommerce checkout fields to save to the Centrico plugin custom fields as the customer is subscribed.', 'centrico-woocommerce'); ?></p>

                        <?php if ($wc_fields = WC()->checkout->get_checkout_fields()) : ?>


                            <?php if ($fields = $centrico_api->get_fields()) : ?>
                                <table class="form-table">
                                    <?php foreach ($fields as $key=>$value) : ?>
                                        <?php if ($key != "email") : ?>
                                            <tr>
                                                <th>
                                                    <?php _e($value); ?>: 
                                                </th>
                                                <td>
                                                    <select name="centrico_woocommerce_fields[<?php echo $key; ?>]">
                                                        <option value=""><?php _e('- Select -', 'centrico-woocommerce'); ?></option>
                                                        <?php foreach ($wc_fields as $wc_section => $wc_section_fields) : ?>
                                                            <?php foreach ($wc_section_fields as $wc_section_field_key => $wc_section_field) : ?>
                                                                <?php if(stripos($wc_section_field_key, "billing") > -1){ ?>
                                                                <option <?php echo (!empty($centrico_woocommerce_fields[$key]) && $centrico_woocommerce_fields[$key] == $wc_section_field_key) ? 'selected="selected"' : ''; ?> value="<?php echo $wc_section_field_key; ?>"><?php echo __($wc_section_field['label']); ?></option>
                                                                <?php } ?>
                                                            <?php endforeach; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        <?php else : ?>
                            <p class="newsletters_error"><?php _e('No checkout fields were found', 'newsletters-woocommerce'); ?></p>
                        <?php endif; ?>
                    </td>
                </tr>

                <tr>
                    <th><label for="centrico_woocommerce_list_id"><?php _e('List ID', 'centrico-woocommerce'); ?></label></th>
                    <td>

                        <input type="text" class="widefat" name="centrico_woocommerce_list_id" value="<?php echo esc_attr(stripslashes($centrico_woocommerce_list_id)); ?>" id="centrico_woocommerce_list_id" />
                        <span class="howto"><?php _e('Specify the list ID.', 'centrico-woocommerce'); ?></span>
                    </td>
                </tr>

                <tr>
                    <th><label for="centrico_woocommerce_groups_id"><?php _e('Groups ID', 'centrico-woocommerce'); ?></label></th>
                    <td>

                        <input type="text" class="widefat" name="centrico_woocommerce_groups_id" value="<?php echo esc_attr(stripslashes($centrico_woocommerce_groups_id)); ?>" id="centrico_woocommerce_groups_id" />
                        <span class="howto"><?php _e('Specify the Groups ID separated by a comma.', 'centrico-woocommerce'); ?></span>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

    <input type="hidden" name="hidden-submit" value="1" />

    <input name="Submit" type="submit" class="button button-primary" value="<?php esc_attr_e('Save Changes'); ?>" />


</form>

<?php

function save_options() {

    if (isset($_POST['hidden-submit']) && '1' == $_POST['hidden-submit']) {


        if (isset($_POST['centrico_woocommerce_checkbox'])) {
            update_option('centrico_woocommerce_checkbox', $_POST['centrico_woocommerce_checkbox']);
        } else {
            update_option('centrico_woocommerce_checkbox', "");
            update_option('centrico_woocommerce_checkboxautocheck', "");
            update_option('centrico_woocommerce_checkboxlabel', "");
            update_option('centrico_woocommerce_list_id', "");
            update_option('centrico_woocommerce_groups_id', "");

            return;
        }

        if (isset($_POST['centrico_woocommerce_checkboxautocheck'])) {
            update_option('centrico_woocommerce_checkboxautocheck', $_POST['centrico_woocommerce_checkboxautocheck']);
        } else {
            update_option('centrico_woocommerce_checkboxautocheck', "");
        }

        if (isset($_POST['centrico_woocommerce_checkboxlabel'])) {
            update_option('centrico_woocommerce_checkboxlabel', $_POST['centrico_woocommerce_checkboxlabel']);
        } else {
            update_option('centrico_woocommerce_checkboxlabel', "");
        }

        if (isset($_POST['centrico_woocommerce_fields'])) {
            update_option('centrico_woocommerce_fields', $_POST['centrico_woocommerce_fields']);
        } else {
            update_option('centrico_woocommerce_fields', "");
        }
        
        if (isset($_POST['centrico_woocommerce_list_id'])) {
            update_option('centrico_woocommerce_list_id', $_POST['centrico_woocommerce_list_id']);
        } else {
            update_option('centrico_woocommerce_list_id', "");
        }

        if (isset($_POST['centrico_woocommerce_groups_id'])) {
            update_option('centrico_woocommerce_groups_id', $_POST['centrico_woocommerce_groups_id']);
        } else {
            update_option('centrico_woocommerce_groups_id', "");
        }
    }
}
?>