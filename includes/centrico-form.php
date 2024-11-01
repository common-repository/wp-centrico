<?php

// Costruisco un semplicissimo form da utilizzare nel front-end  
function html_form_code() {

    global $wpdb;
    $nv_query = 'nome_visibilita';
    $mv_query = 'mail_visibilita';
    $cv_query = 'cell_visibilita';
    $cr_query = 'credits_visibilita';
    $lid_query = 'lid';
    $gids_query = 'gids';
    $table_name = $wpdb->prefix . "centrico";
    $retrieve_data = $wpdb->get_results("SELECT * FROM $table_name");
    foreach ($retrieve_data as $retrieved_data) {
        $nv = $retrieved_data->$nv_query;
        $cv = $retrieved_data->$cv_query;
        $mv = $retrieved_data->$mv_query;
        $cr = $retrieved_data->$cr_query;
        $lid = $retrieved_data->$lid_query;
        $gids = $retrieved_data->$gids_query;
    }



    echo '<form id="frm" name="frm" action="https://console.centrico.it/trk" method="post" target="_blank" >';
    echo '<p>';
    echo '<input id="t" type="hidden" value="s" name="t" />';
    echo '<input id="t" type="hidden" value="1" name="v" />';
    echo '<input id="t" type="hidden" value="' . $lid . '" name="lid" />';
    echo '<input type="hidden" value=“0" name="' . $gids . '" />';
    if ($nv == 'on') {
        echo 'Il tuo nome (richiesto) <br />';
        echo '<input type="text" name="AmContact_name" pattern="[a-zA-Z0-9 ]+" value="' . ( isset($_POST["cf-name"]) ? esc_attr($_POST["cf-name"]) : '' ) . '" size="40"  required />';
    }
    echo '</p>';
    echo '<p>';

    if ($mv == 'on') {
        echo 'Il tuo indirizzo e-mail (richiesto) <br />';
        echo '<input type="email" id="AmContact_email" value="" name="AmContact_email"' . ( isset($_POST["cf-email"]) ? esc_attr($_POST["cf-email"]) : '' ) . '" size="40" required />';
    }

    echo '</p>';
    echo '<p>';

    if ($cv == 'on') {
        echo 'Numero di telefono (richiesto) <br />';
        echo '<input type="text" name="AmContact_telephone" pattern="[a-zA-Z0-9 ]+" value="' . ( isset($_POST["cf-subject"]) ? esc_attr($_POST["cf-subject"]) : '' ) . '" size="40" required />';
    }

    echo '</p>';
    echo '<p><input id="disabledInput" type="submit" name="cf-submitted" value="Iscriviti"/></p>';
    echo '</form>';

    if ($cr == 'on') {
        echo '<div style="color:#000">';
        echo __('Proudly powered by');
        echo '<a href="https://www.centrico.it" target="_blank" alt="invio newsletter email marketing ed sms marketing"> Centrico</a>';
        echo '</div>';
    }
}

// Genero lo shortcode per mostrare  il form
function centrico_shortcode() {
    ob_start();
    html_form_code();

    return ob_get_clean();
}

add_shortcode('centrico', 'centrico_shortcode');
