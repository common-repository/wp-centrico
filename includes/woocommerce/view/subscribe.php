<!-- WooCommerce subscribe checkbox -->

<?php

$centrico_woocommerce_checkbox = get_option('centrico_woocommerce_checkbox');
$centrico_woocommerce_checkboxautocheck = get_option('centrico_woocommerce_checkboxautocheck');
$centrico_woocommerce_checkboxlabel = get_option('centrico_woocommerce_checkboxlabel');
$centrico_woocommerce_list_id = get_option('centrico_woocommerce_list_id');
$centrico_woocommerce_groups_id = get_option('centrico_woocommerce_groups_id');


//if (empty($centrico_woocommerce_liststype_user_selection) || $centrico_woocommerce_liststype_user_selection == "multiple") {
//    $type = 'checkbox';
//} else {
//    $type = 'radio';
//}

$checkbox = '';
$checkbox .= '<p class="form-row form-row-wide newsletters-woocommerce">';

    $checkbox .= '<label for="centrico_woocommerce" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">';
    $checkbox .= '<input ' . ((!empty($centrico_woocommerce_checkboxautocheck) || !empty($_POST['centrico_woocommerce'])) ? 'checked="checked"' : '') . ' class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="centrico_woocommerce" type="checkbox" name="centrico_woocommerce" value="1" />';
    $checkbox .= '<span>' . __($centrico_woocommerce_checkboxlabel) . '</span>';
    $checkbox .= '</label>';
    
    
//if (!empty($centrico_woocommerce_liststype) && $centrico_woocommerce_liststype == "admin") {
//    $checkbox .= '<label for="centrico_woocommerce" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">';
//    $checkbox .= '<input ' . ((!empty($centrico_woocommerce_checkboxautocheck) || !empty($_POST['centrico_woocommerce'])) ? 'checked="checked"' : '') . ' class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="centrico_woocommerce" type="checkbox" name="centrico_woocommerce" value="1" />';
//    $checkbox .= '<span>' . __($centrico_woocommerce_checkboxlabel) . '</span>';
//    $checkbox .= '</label>';
//} else {
//    if ($mailinglists = wpml_get_mailinglists()) {
//        $checkbox .= __($centrico_woocommerce_checkboxlabel);
//
//        if (!empty($centrico_woocommerce_liststype_user_selection) && $centrico_woocommerce_liststype_user_selection == "single") {
//            foreach ($mailinglists as $mailinglist) {
//                $checkbox .= '<label for="centrico_woocommerce_' . $mailinglist->id . '" class="woocommerce-form__label woocommerce-form__label-for-radio radio">';
//                $checkbox .= '<input ' . ((!empty($_POST['centrico_woocommerce']) && in_array($mailinglist->id, $_POST['centrico_woocommerce'])) ? 'checked="checked"' : '') . ' class="woocommerce-form__input woocommerce-form__input-radio input-radio" id="centrico_woocommerce_' . $mailinglist->id . '" type="radio" name="centrico_woocommerce[]" value="' . $mailinglist->id . '" />';
//                $checkbox .= '<span>' . __($mailinglist->title) . '</span>';
//                $checkbox .= '</label>';
//            }
//        } else {
//            foreach ($mailinglists as $mailinglist) {
//                $checkbox .= '<label for="centrico_woocommerce_' . $mailinglist->id . '" class="woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">';
//                $checkbox .= '<input ' . ((!empty($_POST['centrico_woocommerce']) && in_array($mailinglist->id, $_POST['centrico_woocommerce'])) ? 'checked="checked"' : '') . ' class="woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" id="centrico_woocommerce_' . $mailinglist->id . '" type="checkbox" name="centrico_woocommerce[]" value="' . $mailinglist->id . '" />';
//                $checkbox .= '<span>' . __($mailinglist->title) . '</span>';
//                $checkbox .= '</label>';
//            }
//        }
//    }
//}

$checkbox .= '</p>';
$checkbox .= '<div class="clear"></div>';
echo stripslashes($checkbox);
?>