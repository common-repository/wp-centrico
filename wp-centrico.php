<?php

/*
  Plugin Name: WP Centrico 1.1.1
  Plugin URI: https://www.centrico.it
  Description: Simple Centrico subscription form
  Version: 1.1.1
  Author: Ado2k.com snc
  Author URI: https://www.ado2k.com
 */

function centrico_activate() {

    global $wpdb;
    global $centrico_db_name;
    $centrico_db_name = $wpdb->prefix . 'centrico';


    // Create the table on first activation
    if ($wpdb->get_var("SHOW TABLES LIKE '$centrico_db_name'") != $centrico_db_name) {
        // creo la tabella vuota
        $sql = "CREATE TABLE " . $centrico_db_name . " (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`nome_visibilita` varchar(255),
		`cell_visibilita` varchar(255),
		`mail_visibilita` varchar(255),
		`credits_visibilita` varchar(255),
		`lid` varchar(255),
		`gids` varchar(255),
		`control` varchar(255),
                PRIMARY KEY (id)
		); ";

        $wpdb->query($sql);

        // require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        // 		dbDelta($sql);
        // riempio la tabella con delle impostazioni standard
        global $wpdb;
        $centrico_db_name = $wpdb->prefix . 'centrico';

        $sqlpopulate = "INSERT INTO " . $centrico_db_name . "
          (`id`,`nome_visibilita`,`mail_visibilita`,`cell_visibilita`,`credits_visibilita`, `gids`, `lid`, `control` ) 
   values ('1', 'on', 'on', 'on', 'on', '0', '0', '1')";

        $wpdb->query($sqlpopulate);
    } else {
//        // se la tabella esiste già la svuoto
//        $sql = "TRUNCATE TABLE $centrico_db_name";
//        $wpdb->query($sql);
    }
}

function centrico_deinstall() {
    global $wpdb;
    global $centrico_db_name;
    $centrico_db_name = $wpdb->prefix . 'centrico';

    // Remove the table
    $sql = "DROP TABLE IF EXISTS $centrico_db_name";
    $wpdb->query($sql);
}

register_activation_hook(__FILE__, 'centrico_activate');

if (function_exists('register_uninstall_hook')) {
    register_uninstall_hook(__FILE__, 'centrico_deinstall');
}

require plugin_dir_path(__FILE__) . 'includes/centrico-form.php';
require plugin_dir_path(__FILE__) . 'includes/centrico-settings.php';
require plugin_dir_path(__FILE__) . 'includes/centrico-widget.php';
require plugin_dir_path(__FILE__) . 'includes/class_centrico_api.php';

add_action('woocommerce_after_checkout_billing_form', 'apply_newsletters_checkbox');
add_action('woocommerce_checkout_order_processed', 'woo_checkout_order_processed', 10, 2); 
add_action('woocommerce_thankyou', 'add_to_subscriber_list', 10, 1);


function apply_newsletters_checkbox() {

    $centrico_woocommerce_checkbox = get_option('centrico_woocommerce_checkbox');
    if (!empty($centrico_woocommerce_checkbox)) {
        require plugin_dir_path(__FILE__) . 'includes/woocommerce/view/subscribe.php';

        //$this->render('views' . DS . 'subscribe', array('errors' => $errors), true, false, 'centrico_woocommerce');
    }
}

function woo_checkout_order_processed($order_id = null, $posted = null) {
    global $woocommerce, $Subscriber;

    $order = new WC_Order($order_id);
    $items = $order->get_items();
    $user_id = $order->get_user_id();

    if (!empty($_POST['centrico_woocommerce'])) {
        update_post_meta($order_id, 'centrico_centrico_woocommerce', $_POST['centrico_woocommerce']);
    }
}

function add_to_subscriber_list($order_id) {

    global $woocommerce, $Subscriber;

    $centrico_api = new centrico_api();
    
    $order = new WC_Order($order_id);
    $items = $order->get_items();
    $user_id = $order->get_user_id();
    $is_subscribed = get_post_meta($order_id, 'centrico_centrico_woocommerce', true);

    $centrico_woocommerce_list_id = get_option('centrico_woocommerce_list_id');
    $centrico_woocommerce_groups_id = get_option('centrico_woocommerce_groups_id');
    $centrico_woocommerce_fields = get_option('centrico_woocommerce_fields');
    
    if (!empty($is_subscribed)) {

        $data = array(
            'AmContact_email' => $order->get_billing_email()                   
        );

        
        if (!empty($centrico_woocommerce_fields)) {
            foreach ($centrico_woocommerce_fields as $field_slug => $wc_field) {
                if (!empty($wc_field)) {
                    if ($wc_value = get_user_meta($user_id, $wc_field, true)) {
                        $data[$field_slug] = $wc_value;
                    }
                }
            }
        }
        
        $centrico_woocommerce_errors = $centrico_api->manageSubscriptionNL($data,$centrico_woocommerce_list_id, $centrico_woocommerce_groups_id);

        if (!empty($centrico_woocommerce_errors)) {
            foreach ($centrico_woocommerce_errors as $error) {
                wc_add_notice($error, 'error');
            }
        } else {
//            $subscriber_id = $Subscriber->data->id;
//            $this->SubscriberMeta()->save(array('subscriber_id' => $subscriber_id, 'meta_key' => "_woocommerce_order_id", 'meta_value' => $order_id));
//
//            if (class_exists('WC_Subscriptions_Manager')) {
//                $subscription_key = WC_Subscriptions_Manager::get_subscription_key($order_id);
//                $this->SubscriberMeta()->save(array('subscriber_id' => $subscriber_id, 'meta_key' => "_woocommerce_subscription_key", 'meta_value' => $subscription_key));
//            }
        }
    }
}
