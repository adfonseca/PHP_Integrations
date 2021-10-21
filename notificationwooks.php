<?php

// ini_set('display_errors',1);
// ini_set('display_startup_erros',1);
// error_reporting(E_ALL);

// SDK do Mercado Pago
require __DIR__ . '/vendor/autoload.php';

//Credenciais do Mercado Pago
MercadoPago\SDK::setAccessToken("APP_USR-8401694271692686-050614-591d4bcd58a81a7d4809badfed6bee6d-532818857");

  switch($_GET["type"]) {
        case "payment":
             $payment = null;
             $payment = MercadoPago\Payment::find_by_id($_GET["data_id"]);
      
             if ($payment->status == "approved"){
              echo "Pagamento aprovado: ".$payment->id;
             };

             if ($payment->status == "refunded"){
                echo "Pagamento devolvido: ".$payment->id;
             };

             if ($payment->status == "cancelled"){
              echo "Pagamento cancelado: ".$payment->id;
             };
            break;
      
//         case "subscription":
//             $preapproval = null;
//             $preapproval = MercadoPago\subscription::find_by_id($_GET["data_id"]);
      
//            if ($preapproval->status == "pending"){
//             echo "Assinatura pendente: ".$preapproval->id;
//            }; 
       
//            if ($preapproval->status == "authorized"){
//               echo "Assinatura autorizada: ".$preapproval->id;
//            };

//            if ($preapproval->status == "cancelled"){
//               echo "Assinatura cancelada: ".$preapproval->id;
//            };
//            break;
    }




   

//echo "https://IXexamplesPHP-dx979308.codeanyapp.com/notificationwooks.php?data.id=13852152933&type=payment"
//echo $_GET

//$pagamento = $_POST["pagamento"];
//$_GET = "https://loja-dx979308.codeanyapp.com/notificationwooks.php?data.id=$pagamento&type=payment";

?>