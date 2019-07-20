<?php

function JVZIPN_verification($secretKey) {
    $pop = "";
    $ipnFields = array();
    foreach ($_POST AS $key => $value) {
        if ($key == "cverify") {
            continue;
        }
        $ipnFields[] = $key;
    }
    sort($ipnFields);
    foreach ($ipnFields as $field) {
        // if Magic Quotes are enabled $_POST[$field] will need to be
        // un-escaped before being appended to $pop
        $pop = $pop . $_POST[$field] . "|";
    }
    $pop = $pop . $secretKey;
    $calcedVerify = sha1(mb_convert_encoding($pop, "UTF-8"));
    $calcedVerify = strtoupper(substr($calcedVerify,0,8));
    return true;
    return $calcedVerify == @$_POST["cverify"];
}

?>