<?php  

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// SDK do Mercado Pago
require __DIR__ . '/../config.php';

//Criando e salvando o pagamento
    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = ($_POST["transactionAmount"]);
    $payment->token = ($_POST["token"]);
    $payment->description = ($_POST["description"]);
    $payment->installments = ($_POST["installments"]);;
    $payment->payment_method_id = ($_POST["paymentMethodId"]);
    $payment->application_fee = 2.00;
   // $payment->capture=false;
    $payment->payer = array(
    "email" => ($_POST["email"])
    );

    // Save and posting the payment
    
    $payment->save();

    // Print the payment status
    echo ("  ");
    echo $payment->status;

    
?>

