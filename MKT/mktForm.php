
<!DOCTYPE html>

<html>

<head>
   <title>Pagamento cartão Marketplace API</title>
</head>

<body>

<!--Formulário de dados do cartão-->
<form action="mktBack.php" method="post" id="paymentForm">
   <h3>Detalhe do comprador</h3>
     <div>
       <div>
         <label for="email">E-mail</label>
         <input id="email" name="email" type="text" value="test_user_70028570@testuser.com"></select>
       </div>
       <div>
         <label for="docType">Tipo de documento</label>
         <select id="docType" name="docType" data-checkout="docType" type="text"></select>
       </div>
       <div>
         <label for="docNumber">Número do documento</label>
         <input id="docNumber" name="docNumber" data-checkout="docNumber" type="text" value="19119119100" />
       </div>
     </div>
   <h3>Detalhes do cartão</h3>
     <div>
       <div>
         <label for="cardholderName">Titular do cartão</label>
         <input id="cardholderName" data-checkout="cardholderName" type="text" value="APRO">
       </div>
       <div>
         <label for="">Data de vencimento</label>
         <div>
           <input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" value="11" />
           <span class="date-separator">/</span>
           <input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" value="25" />
         </div>
       </div>
       <div>
         <label for="cardNumber">Número do cartão</label>
         <input type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4235 6477 2802 5682" />
       </div>
       <div>
         <label for="securityCode">Código de segurança</label>
         <input id="securityCode" data-checkout="securityCode" type="text" value="123" />
       </div>
       <div id="issuerInput">
         <label for="issuer">Banco emissor</label>
         <select id="issuer" name="issuer" data-checkout="issuer"></select>
       </div>
       <div>
         <label for="installments">Parcelas</label>
         <select type="text" id="installments" name="installments"></select>
       </div>
       <div>
         <input type="hidden" name="transactionAmount" id="transactionAmount" value="100" />
         <input type="hidden" name="paymentMethodId" id="paymentMethodId" />
         <input type="hidden" name="description" id="description" />
         <br>
         <button type="submit">Pagar</button>
         <br>
       </div>
   </div>
 </form>


<!--importação da biblioteca js do Mercado Pago para que os dados do cartão do cliente não cheguem ao servidor da aplicação--> 
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script type="text/javascript">

window.Mercadopago.setPublishableKey("TEST-38a55736-cbe1-4b72-b2f2-61e4da37a96e");

window.Mercadopago.getIdentificationTypes(); //Obtenha o tipo de documento

document.getElementById('cardNumber').addEventListener('change', guessPaymentMethod);

function guessPaymentMethod(event) {
   let cardnumber = document.getElementById("cardNumber").value;
   if (cardnumber.length >= 6) {
       let bin = cardnumber.substring(0,6);
       window.Mercadopago.getPaymentMethod({
           "bin": bin
       }, setPaymentMethod);
   }
};

function setPaymentMethod(status, response) {
   if (status == 200) {
       let paymentMethod = response[0];
       document.getElementById('paymentMethodId').value = paymentMethod.id;

       if(paymentMethod.additional_info_needed.includes("issuer_id")){
           getIssuers(paymentMethod.id);
       } else {
           getInstallments(
               paymentMethod.id,
               document.getElementById('transactionAmount').value
           );
       }
   } else {
       alert(`payment method info error: ${response}`);
   }
}

function getIssuers(paymentMethodId) {
   window.Mercadopago.getIssuers(
       paymentMethodId,
       setIssuers
   );
}

function setIssuers(status, response) {
   if (status == 200) {
       let issuerSelect = document.getElementById('issuer');
       response.forEach( issuer => {
           let opt = document.createElement('option');
           opt.text = issuer.name;
           opt.value = issuer.id;
           issuerSelect.appendChild(opt);
       });

       getInstallments(
           document.getElementById('paymentMethodId').value,
           document.getElementById('transactionAmount').value,
           issuerSelect.value
       );
   } else {
       alert(`issuers method info error: ${response}`);
   }
}

function getInstallments(paymentMethodId, transactionAmount, issuerId){
   window.Mercadopago.getInstallments({
       "payment_method_id": paymentMethodId,
       "amount": parseFloat(transactionAmount),
       "issuer_id": issuerId ? parseInt(issuerId) : undefined
   }, setInstallments);
}

function setInstallments(status, response){
   if (status == 200) {
       document.getElementById('installments').options.length = 0;
       response[0].payer_costs.forEach( payerCost => {
           let opt = document.createElement('option');
           opt.text = payerCost.recommended_message;
           opt.value = payerCost.installments;
           document.getElementById('installments').appendChild(opt);
       });
   } else {
       alert(`installments method info error: ${response}`);
   }
}

doSubmit = false;
document.getElementById('paymentForm').addEventListener('submit', getCardToken);
function getCardToken(event){
   event.preventDefault();
   if(!doSubmit){
       let $form = document.getElementById('paymentForm');
       window.Mercadopago.createToken($form, setCardTokenAndPay);
       return false;
   }
};

function setCardTokenAndPay(status, response) {
   if (status == 200 || status == 201) {
       let form = document.getElementById('paymentForm');
       let card = document.createElement('input');
       card.setAttribute('name', 'token');
       card.setAttribute('type', 'hidden');
       card.setAttribute('value', response.id);
       form.appendChild(card);
       doSubmit=true;
       form.submit();
   } else {
       alert("Verify filled data!\n"+JSON.stringify(response, null, 4));
   }
};


</script>
  
    <br/>  
    <br/>
    <h3>
      Consultar pagamento:
    </h3>

  <div>
    <form action="../consultar.php" method="post" id="pagamento">
     <label for="pagamento">Pagamento</label>
      <input type="text" id="pagamento" name="pagamento"/>
      <input type="submit" value="Consultar!" />
    </form>
  </div>
  
      <br/>  
    <br/>
    <h3>
      Capturar pagamento:
    </h3>

  <div>
    <form action="captura.php" method="post" id="pagamento">
     <label for="pagamento">Pagamento</label>
      <input type="text" id="pagamento" name="pagamento"/>
       <input type="submit" value="Capturar!" />
    </form>
  </div>


</body>
</html>

