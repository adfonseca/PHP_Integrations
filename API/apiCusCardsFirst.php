<!DOCTYPE html>

<html>

<head>
   <title>Pagar e armazenar cartão</title>
</head>

<body>

  
<!--Formulário de dados do cartão-->
<form action="apiCusCardsPagarFirst.php" method="post" id="pay" name="pay" >
    <fieldset>
        <ul>
           <li>
                <label for="amount">Valor:</label>
                <input type="text" name="amount"  id="amount" value=""/>
            </li>
            <li>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="test_user_70028570@testuser.com"/>
            </li>
            <li>
                <label for="cardNumber">Credit card number:</label>
                <input type="text" id="cardNumber" data-checkout="cardNumber" value=""/>
            </li>
            <li>
                <label for="securityCode">Security code:</label>
                <input type="text" id="securityCode" data-checkout="securityCode" value="123"/>
            </li>
            <li>
                <label for="cardExpirationMonth">Expiration month:</label>
                <input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" value="11"/>
            </li>
            <li>
                <label for="cardExpirationYear">Expiration year:</label>
                <input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" value="2025"/>
            </li>
            <li>
                <label for="cardholderName">Card holder name:</label>
                <input type="text" id="cardholderName" data-checkout="cardholderName" value="APRO"/>
            </li>
            <li>
                <label for="docType">Document type:</label>
                 <select id="docType" data-checkout="docType">  </select>            
            </li>
            <li>
                <label for="docNumber">Document number:</label>
                <input type="text" id="docNumber" data-checkout="docNumber"  value="19119119100"/>
            </li>
            <li>
               <label for="installments">Installments:</label>
               <select id="installments" class="form-control" name="installments"></select>
           </li>
        </ul>
        <input type="hidden" name="paymentMethodId" />
        <input type="text" name="lastDigits" id="lastDigits"/>
        <input type="submit" value="Pay!" />
    </fieldset>
</form>

<!--banners-->

<img src="https://imgmp.mlstatic.com/org-img/MLB/MP/BANNERS/tipo2_735X40.jpg?v=1" 
alt="Mercado Pago - Meios de pagamento" title="Mercado Pago - Meios de pagamento" 
width="735" height="40"/>

<!--importação da biblioteca js do Mercado Pago para que os dados do cartão do cliente não cheguem ao servidor da aplicação--> 
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script type="text/javascript">

//Chave publica
window.Mercadopago.setPublishableKey("TEST-38a55736-cbe1-4b72-b2f2-61e4da37a96e");

//Obtenha o tipo de documento
window.Mercadopago.getIdentificationTypes(); 

//Função que captura os eventos de alteração no form
function addEvent(to, type, fn){ 
        if(document.addEventListener){
            to.addEventListener(type, fn, false);
        } else if(document.attachEvent){
            to.attachEvent('on'+type, fn);
        } else {
            to['on'+type] = fn;
        }  
    };


//Eventos para pegar o método de pagamento
addEvent(document.querySelector('#cardNumber'), 'keyup', guessingPaymentMethod);
addEvent(document.querySelector('#cardNumber'), 'change', guessingPaymentMethod);
addEvent(document.querySelector('#cardNumber'), 'keyup', getLastDigits);
addEvent(document.querySelector('#cardNumber'), 'change', getLastDigits);

//Função para pegar os últimos dígitos do cartão
function getLastDigits() {
  const cardnumber = document.getElementById("cardNumber");
  if (cardnumber.value.length >= 15){
    document.getElementById("lastDigits").value = cardnumber.value.substring(cardnumber.value.length-4,cardnumber.value.length);
  }
}


//Função que captura o número do cartão
function getBin() {
  const cardnumber = document.getElementById("cardNumber");
  return cardnumber.value.replace(/[ .-]/g, '').slice(0, 6);
}

//Função que captura o método de pagamento com base no número do cartão.

function guessingPaymentMethod(event) {

    var bin = getBin();

    if (event.type == "keyup") {
        if (bin.length >= 6) {
            window.Mercadopago.getPaymentMethod({
                "bin": bin
            }, setPaymentMethodInfo);
        }
    } else {
        setTimeout(function() {
            if (bin.length >= 6) {
                window.Mercadopago.getPaymentMethod({
                    "bin": bin
                }, setPaymentMethodInfo);
            }
        }, 100);
    }
};


function setPaymentMethodInfo(status, response) {
    if (status == 200) {
        const paymentMethodElement = document.querySelector('input[name=paymentMethodId]');

        if (paymentMethodElement) {
            paymentMethodElement.value = response[0].id;
        } else {
            const input = document.createElement('input');
            input.setAttribute('name', 'paymentMethodId');
            input.setAttribute('type', 'hidden');
            input.setAttribute('value', response[0].id);     

            form.appendChild(input);
        }

        Mercadopago.getInstallments({
        "bin": getBin(),
        "amount": parseFloat(document.querySelector('#amount').value),
        }, setInstallmentInfo);

    } else {
        alert(`payment method info error: ${response}`);  
    }
};


//Função que captura as parcelas do cartão com base no método de pagamento
function setInstallmentInfo(status, response) {
            var selectorInstallments = document.querySelector("#installments"),
            fragment = document.createDocumentFragment();
            selectorInstallments.options.length = 0;

            if (response.length > 0) {
                var option = new Option("Escolha...", '-1'),
                payerCosts = response[0].payer_costs;
                fragment.appendChild(option);
                
                for (var i = 0; i < payerCosts.length; i++) {
                    fragment.appendChild(new Option(payerCosts[i].recommended_message, payerCosts[i].installments));
                }
                
                selectorInstallments.appendChild(fragment);
                selectorInstallments.removeAttribute('disabled');
            }
        };

//Capture os dados do cartão para gerar o token

doSubmit = false;
addEvent(document.querySelector('#pay'), 'submit', doPay);
function doPay(event){
    event.preventDefault();
    if(!doSubmit){
        var $form = document.querySelector('#pay');

        window.Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below

        return false;
    }
};

function sdkResponseHandler(status, response) {
    if (status != 200 && status != 201) {
        alert("verify filled data");
    }else{
        var form = document.querySelector('#pay');
        var card = document.createElement('input');
        card.setAttribute('name', 'token');
        card.setAttribute('type', 'text');
        card.setAttribute('value', response.id);
        form.appendChild(card);
        doSubmit=true;
        form.submit();
    }
};
    
</script>

</body>
</html>
