<?php

my_centrico_send_options();

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

    if ($cr == 'on') {
        $crselected_on = 'checked';
    } else {
        $crselected_on = '';
    }
    
    if ($nv == 'on') {
        $nvselected_on = 'checked';
    } else {
        $nvselected_on = '';
    }

    if ($cv == 'on') {
        $cvselected_on = 'checked';
    } else {
        $cvselected_on = '';
    }

    if ($mv == 'on') {
        $mvselected_on = 'checked';
    } else {
        $mvselected_on = '';
    }
}


echo '<div class="wrap">';
echo '<img src="' . plugin_dir_url(__FILE__) . 'images/logo.png" style="  
  width: 20%;
  margin-top: 20px;
  margin-bottom: 20px;">';
// echo '<h2>Centrico Subscription Form</h2>';

echo '<form action="" method="post">';
echo '<h3>Enter the list ID:</h3>';
echo '<input type="text" name="id_lista" value="' . $lid . '">';

echo '<h3>Enter the group id (separated by commas):</h3>';
echo '<input type="text" name="id_gruppi" value="' . $gids . '">';
echo '<br>';
echo '<br>';

//echo '<h3>Visibilità del campo nome:</h3>';
//echo '<select name="nv">';
//echo '<option value="on" name="nv" ' . $nvselected_on . '>On</option>';
//echo '<option value="off" name="nv" ' . $nvselected_off . '>Off</option>';
//echo '</select>';

echo '<input type="checkbox" name="nv" value="on" ' . $nvselected_on . '/> Show the name field';
echo '<br>';


// echo '<h3>Visibilità del campo e-mail:</h3>';
// echo '<select name="mv">';
// echo '<option value="on" name="mv" '.$mvselected_on.'>On</option>';
// echo '<option value="off" name="mv" '.$mvselected_off.'>Off</option>';
// echo '</select>';

//echo '<h3>Visibilità del campo cellulare:</h3>';
//echo '<select name="cv">';
//echo '<option value="on" name="cv" ' . $cvselected_on . '>On</option>';
//echo '<option value="off" name="cv" ' . $cvselected_off . '>Off</option>';
//echo '</select>';

echo '<input type="checkbox" name="cv" value="on" ' . $cvselected_on . '/> Show the mobile phone field';
echo '<br>';

//echo '<h3>Visibilità del campo cellulare:</h3>';

echo '<input type="checkbox" name="cr" value="on" ' . $crselected_on . '/> '. __( 'Show Centrico Credits', 'wp-centrico' );
echo '<br>';

echo '<p>';
echo '<input type="hidden" name="hidden-submission" value="1" />';
echo '<br>';
echo '<input type="submit">';
echo '</p>';

echo '</form>';

echo '</div>';

echo 'You can insert the form of Centrico in any page using the shortcode [centrico] or using the appropriate widget';

function my_centrico_send_options() {

    if (isset($_POST['hidden-submission']) && '1' == $_POST['hidden-submission']) {

        global $wpdb;

        $centrico_db_name_options = $wpdb->prefix . 'centrico';


        $svuota = "TRUNCATE TABLE $centrico_db_name_options";
        $wpdb->query($svuota);

        $sql = "INSERT INTO `$centrico_db_name_options`
          (`id`,`nome_visibilita`,`mail_visibilita`,`cell_visibilita`,`credits_visibilita`, `gids`, `lid`) 
   values ('1', '$_POST[nv]', 'on', '$_POST[cv]', '$_POST[cr]', '$_POST[id_gruppi]', '$_POST[id_lista]')";
        $wpdb->query($sql);
    } // end if
}

// end function



      