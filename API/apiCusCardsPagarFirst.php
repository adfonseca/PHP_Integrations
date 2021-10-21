<?php  

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

// SDK do Mercado Pago
require __DIR__ . '/../config.php';

//Filtrando o e-mail digitado no formulário e armazenando o resultado (objeto customer)

    $filter = array(
        "email" => ($_POST["email"])
    );

    $customer_filter = MercadoPago\Customer::search($filter);
 
    //Pegando o customer (do array) com base no filtro
        foreach ($customer_filter as $customer) {
             if(!empty($customer)){
                  $idCustomer = $customer->id; 
             }
        } 

    
    // Se não exister o customer referente ao e-mail, então o customer é criado e o cartão armazenado
    if (empty($customer)){
        $customer = new MercadoPago\Customer();
        $customer->email = ($_POST["email"]);
        $customer->save();
        echo ("Customer salvo!");
        echo ("  ");

        $card = new MercadoPago\Card();
        $card->token = $_POST["token"];
        $card->customer_id = $customer->id;
        $card->save();
        echo ("Cartão salvo!");

    //...
    } else { //Se o customer existir, então é verificado se o cartão já existe caso contrário o cartão é salvo

        foreach ($customer->cards as $cards) {
            $last_four_digits = $cards->last_four_digits; //será usado como parametro de comparação
             if ($last_four_digits==($_POST["lastDigits"])){
                echo ("Cartão já existe e já vinculado ao customer (usar pagamento com customers e cards)!");
                return;
            };   
        }

        $card = new MercadoPago\Card();
        $card->token = $_POST["token"];
        $card->customer_id = $idCustomer;
        $card->save();
        echo ("Cartão salvo com sucesso!");
    }


    //Criando e salvando o pagamento
        $payment = new MercadoPago\Payment();
        $payment->transaction_amount = ($_POST["amount"]);
        $payment->token = ($_POST["token"]);
        $payment->description = "Teste pago";
        $payment->installments = ($_POST["installments"]);
        $payment->payment_method_id = ($_POST["paymentMethodId"]);
//         $payment->application_fee = 2.5;
        $payment->payer = array(
        "email" => ($_POST["email"])
        );

    // Save and posting the payment

    //     echo '<pre>';
    //     print_r($payment)


       $payment->save();

        // Print the payment status

        echo ("  ");
        echo $payment->status;

    
?>

