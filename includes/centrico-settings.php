<?php

add_action('admin_menu', 'centrico_setup_menu');
 
function centrico_setup_menu(){
        add_menu_page( 'Centrico Plug-in', 'Centrico', 'manage_options', 'wp-centrico', 'centrico_init' );
        add_submenu_page('wp-centrico', 'Config', 'Settings', 'manage_options', 'wp-centrico', 'centrico_init' );
        add_submenu_page('wp-centrico', 'Woocommerce', 'Woocommerce', 'manage_options', 'wp-centrico-woocommerce', 'centrico_woocommerce_init' );
}
 
function centrico_init(){
        require ABSPATH . 'wp-content/plugins/wp-centrico/includes/options-gui.php';       
}

function centrico_woocommerce_init(){
        require ABSPATH . 'wp-content/plugins/wp-centrico/includes/woocommerce/view/settings.php';
}

?>