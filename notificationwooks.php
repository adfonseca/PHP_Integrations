<?php

// SDK do Mercado Pago
require __DIR__ . '/../config.php';

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
    }
?>