
<?php

// SDK de Mercado Pago

     require __DIR__ . '/../config.php';

//Dados do pagamento

    $token = $_REQUEST["token"];
    $payment_method_id = $_REQUEST["payment_method_id"];
    $installments = $_REQUEST["installments"];
    $issuer_id = $_REQUEST["issuer_id"];

    $payment = new MercadoPago\Payment();
    $payment->transaction_amount = 100;
    $payment->token = $token;
    $payment->description = "Heavy Duty Copper Hat";
    $payment->installments = $installments;
    $payment->payment_method_id = $payment_method_id;
    $payment->issuer_id = $issuer_id;
    $payment->payer = array(
      "email" => "test_user_27183576@testuser.com"
    );

// Imprime os dados do pagamento
    
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