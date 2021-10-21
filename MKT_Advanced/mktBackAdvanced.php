<?php  

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// SDK do Mercado Pago
require __DIR__ . '/../config_prod.php';

//Criando e salvando o pagamento
    $advancedpay = new MercadoPago\AdvancedPayments\AdvancedPayment();

    $advancedpay->application_id = "8401694271692686";

    $advancedpay->payer = array(
      "email" => ($_POST["email"]),
      "first_name" => "Integration",
      "last_name" => "Experience",
      "address" => array(
        "zip_code" => "06233200",
        "street_name" => "Street",
        "street_number" => "123"
      ),
      "identification" => array(
        "type" => "CPF",
        "number" => "19119119100"
      ),
    );

    $advancedpay->external_reference = "ref_ext_marketplace";
    $advancedpay->description = "Advanced Payment";
//     $advancedpay->binary_mode = true;

    $advancedpay->payments = array(
     array(
        "token" => ($_POST["token"]),
        "payment_method_id" => ($_POST["paymentMethodId"]),
        "transaction_amount" => 100,
        "installments" => ($_POST["installments"]),
        "description" => ($_POST["description"]),
        "processing_mode" => "aggregator",
        "external_reference" =>"ref-transaction-marketplace"
        )
    );

    $advancedpay->disbursements = array(
     array(
        "amount" => 50,
        "external_reference" => "Disbursement 1",
        "collector_id" => "532818857",
        "application_fee" => 2,
        "additional_info" => array(
          "items" => array(
            array(
                "id" => "Item disbursement 1",
                "title" => "Title item disbursement 1",
                "description" => "Description item disbursement 1",
                "quantity" => 1,
                "unit_price" => 50
            )
          ),
        )
      ),
      array(
        "amount" => 50,
        "external_reference" => "Disbursement 2",
        "collector_id" => "532818805",
        "application_fee" => 2,
        "additional_info" => array(
          "items" => array(
            array(
                "id" => "Item disbursement 2",
                "title" => "Title item disbursement 2",
                "description" => "Description item disbursement 2",
                "quantity" => 2,
                "unit_price" => 25
            )
          ),

        )
      )
    );

//     echo '<pre>';
//     print_r($advancedpay);


    // Save and posting the payment
    
     if ($advancedpay->save()){
      // Sucesso
      $responseArray = $advancedpay->toArray();
      echo json_encode($responseArray);

    }else {
      //Falha
      $errorArray = (array) $advancedpay->error;
      echo json_encode($errorArray);
    }


    
?>

