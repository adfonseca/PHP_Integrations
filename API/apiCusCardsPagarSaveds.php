<?php  

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// SDK do Mercado Pago
require __DIR__ . '/../config.php';

    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = ($_POST["amount"]);
    $payment->token = ($_POST["token"]);
    $payment->description = "Item teste mkt cards saveds";
    $payment->installments = 1;
    $payment->payment_method_id = ($_POST["paymentMethodId"]);
   // $payment->application_fee = 2.5;
    $payment->payer = array(
        "type" => "customer",
        "id" => ($_POST["id"])
    );

//     echo '<pre>';
//     print_r($payment);


    $payment->save();

    // Print the payment status
    echo $payment->status;
    //...

?>

