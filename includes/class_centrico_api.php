<?php

class centrico_api {

    function __construct() {
        
    }

    public function manageSubscriptionNL($datiNewsletter, $listId, $groupsId = null) {

        $in = "";

        $groupsToAdd = "";
        if ($groupsId <> null) {
            $groupsToAdd = $groupsId;
        } else {
            $groupsToAdd = "";
        }

        $page = "/trk?t=s&fsu=1&force_upd=1&v=1&no_em=0&no_ui=1&lid=" . $listId . "&gids=" . $groupsToAdd;

        foreach ($datiNewsletter as $fieldName => $fieldValue){

            $page .= "&" . $fieldName . "=" . urlencode($fieldValue);

        }

        $fp = fsockopen("console.centrico.it", 80, $errno, $errstr, 30);

        if (!$fp) {
            echo "$errstr ($errno)<br />\n";
        } else {
            $out = "GET {$page} HTTPS/1.1\r\n";
            $out .= "Host: console.centrico.it\r\n";
            $out .= "Connection: Close\r\n\r\n";

            fwrite($fp, $out);
            while (!feof($fp)) {
                $in .= fgets($fp, 128); //aggiungi echo qui per vedere la risposta
            }

            fclose($fp);

            if (strpos($in, 'has been registered to the list')) {
                return true;
            } else {
                return false;
            }
        }
    }

    function composeURL($fieldName, $dati) {

        if (isset($dati[$fieldName])) {
            if (is_array($dati[$fieldName])) {
                return "&" . $fieldName . "=" . urlencode(implode(";", $dati[$fieldName]));
            } else {
                return "&" . $fieldName . "=" . urlencode($dati[$fieldName]);
            }
        }
    }

    function get_fields() {

        $fields = array(
            'AmContact_name' => 'Person Name',
            'AmContact_surname' => 'Person Lastname',
            'AmContact_birthDate' => 'Birth Date',
            'AmContact_city' => 'Person city',
            'AmContact_province' => 'Person province',
            'AmContact_address' => 'Person address',
            'AmContact_zipcode' => 'Person zipcode',
            'AmContact_telephone' => 'Person telephone',
            'AmContact_mobilephone' => 'Person mobilephone',
            'AmContact_email' => 'Person email',
//            'AmContact_gender' => 'Person gender',
        );

        return $fields;
    }

}
?>