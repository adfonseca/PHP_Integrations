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
    $payment->description = "Teste item card";
    $payment->installments = ($_POST["installments"]);;
    $payment->payment_method_id = ($_POST["paymentMethodId"]);
   // $payment->capture=false;

    $payment->shipping_amount = 10;

    $payer = new MercadoPago\Payer();
    $payer->email = "test_user_22515001@testuser.com";
    $payer->name = "Nome";
    $payer->surname = "Sobrenome";
    $payer->date_created = "2018-06-02T12:58:41.425-04:00";
    $payer->phone = array(
    "area_code" => "11",
    "number" => "4444-4444"
    );

    $payer->identification = array(
    "type" => "CPF",
    "number" => "19119119100"
    );

    $payer->address = array(
    "street_name" => "Street",
    "street_number" => 123,
    "zip_code" => "06233200"
    );

    $payment->payer = $payer;
        $payment->payer = array(
        "email" => ($_POST["email"])
        );

//        echo '<pre>';
//        print_r($payment)
     if ($payment->save()){
      // Sucesso
      $responseArray = $payment->toArray();
      echo json_encode($responseArray);

    }else {
      //Falha
      $errorArray = (array) $payment->error;
      echo json_encode($errorArray);
    }
    
?>

