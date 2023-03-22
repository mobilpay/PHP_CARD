<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="author" content="NETOPIA" />
<meta http-equiv="copyright" content="(c)NETOPIA" />
<meta http-equiv="rating" content="general" />
<meta http-equiv="distribution" content="general" />
<link href="http://www.mobilpay.ro/assets/themes/public/css/screen.css" media="screen, projection" rel="stylesheet" type="text/css" />
<link href="http://www.mobilpay.ro/assets/common/img/favicon.ico" rel="shortcut icon" />
<link href="http://www.mobilpay.ro/assets/themes/public/css/print.css" media="print" rel="stylesheet" type="text/css" />
<link href="http://www.mobilpay.ro/assets/themes/public/css/mp.css" media="screen" rel="stylesheet" type="text/css" />
<link href="http://www.mobilpay.ro/assets/themes/public/css/ui.css" media="screen" rel="stylesheet" type="text/css" />
<!--[if IE]> <link href="http://www.mobilpay.ro/assets/themes/public/css/ie.css" media="screen, projection" rel="stylesheet" type="text/css" /><![endif]-->
</head>
<body >
<div class="wrapper">
	<div class="page">
		<div class="pagetop clearfix">		
			<div class="container clearfix">
					<div class="header">   
						<div class="logo">
						  <h1 class="top bottom">
							<a href="/"><span>MobilPay</span></a>
						  </h1>
						</div>
						<div class="menu">
							<a href="#" id="m-1"><span>Cum functioneaza</span></a>      
							<a href="#" id="m-2"><span>Cat costa</span></a>      
							<a href="#" id="m-3"><span>Demo</span></a>      
							<a href="#" id="m-4"><span>Inregistrare</span></a>      
							<a href="#" id="m-5"><span>FAQ</span></a>      
							<a href="#" id="m-6"><span>Presa</span></a>
							<a href="#" id="m-7"><span>Contact</span></a>
						</div>
					</div>
			
				<!-- content begin -->
				<div class="span-4">
	<img src="http://www.mobilpay.ro/assets/themes/public/img/demo.png"/>
</div>
<?php
require_once 'Mobilpay/Payment/Request/Abstract.php';
require_once 'Mobilpay/Payment/Request/Card.php';
require_once 'Mobilpay/Payment/Invoice.php';
require_once 'Mobilpay/Payment/Address.php';

#for testing purposes, all payment requests will be sent to the sandbox server. Once your account will be active you must switch back to the live server https://secure.mobilpay.ro
#in order to display the payment form in a different language, simply add the language identifier to the end of the paymentUrl, i.e https://secure.mobilpay.ro/en for English
$paymentUrl = 'https://sandboxsecure.mobilpay.ro';
//$paymentUrl = 'https://secure.mobilpay.ro';
// this is the path on your server to the public certificate. You may download this from Admin -> Conturi de comerciant -> Detalii -> Setari securitate
$x509FilePath 	= 'i.e: /home/certificates/public.cer';
try
{
	srand((int) microtime() * 1000000);
	$objPmReqCard 						= new Mobilpay_Payment_Request_Card();
	#merchant account signature - generated by mobilpay.ro for every merchant account
	#semnatura contului de comerciant - mergi pe www.mobilpay.ro Admin -> Conturi de comerciant -> Detalii -> Setari securitate
	$objPmReqCard->signature 			= 'XXXX-XXXX-XXXX-XXXX-XXXX';
	#you should assign here the transaction ID registered by your application for this commercial operation
	#order_id should be unique for a merchant account
	$objPmReqCard->orderId 				= md5(uniqid(rand()));
	#below is where mobilPay will send the payment result. This URL will always be called first; mandatory
	$objPmReqCard->confirmUrl 			= 'http://your.confirm.url'; 
	#below is where mobilPay redirects the client once the payment process is finished. Not to be mistaken for a "successURL" nor "cancelURL"; mandatory
	$objPmReqCard->returnUrl 			= 'http://your.return.url'; 
	
	#detalii cu privire la plata: moneda, suma, descrierea
	#payment details: currency, amount, description
	$objPmReqCard->invoice = new Mobilpay_Payment_Invoice();
	#payment currency in ISO Code format; permitted values are RON, EUR, USD, MDL; please note that unless you have mobilPay permission to 
	#process a currency different from RON, a currency exchange will occur from your currency to RON, using the official BNR exchange rate from that moment
	#and the customer will be presented with the payment amount in a dual currency in the payment page, i.e N.NN RON (e.ee EUR)
	$objPmReqCard->invoice->currency	= 'RON';
	$objPmReqCard->invoice->amount		= '1.00';
	#available installments number; if this parameter is present, only its value(s) will be available
	//$objPmReqCard->invoice->installments= '2,3';
	#selected installments number; its value should be within the available installments defined above
	//$objPmReqCard->invoice->selectedInstallments= '3';
        //platile ulterioare vor contine in request si informatiile despre token. Prima plata nu va contine linia de mai jos.
        $objPmReqCard->invoice->tokenId = 'token_id';
	$objPmReqCard->invoice->details		= 'Plata online cu cardul';
	
	#detalii cu privire la adresa posesorului cardului
	#details on the cardholder address (optional)
	$billingAddress 				= new Mobilpay_Payment_Address();
	$billingAddress->type			= $_POST['billing_type']; //should be "person"
	$billingAddress->firstName		= $_POST['billing_first_name'];
	$billingAddress->lastName		= $_POST['billing_last_name'];
	$billingAddress->address		= $_POST['billing_address'];
	$billingAddress->email			= $_POST['billing_email'];
	$billingAddress->mobilePhone		= $_POST['billing_mobile_phone'];
	$objPmReqCard->invoice->setBillingAddress($billingAddress);
	
	#detalii cu privire la adresa de livrare
	#details on the shipping address
	$shippingAddress 				= new Mobilpay_Payment_Address();
	$shippingAddress->type			= $_POST['shipping_type'];
	$shippingAddress->firstName		= $_POST['shipping_first_name'];
	$shippingAddress->lastName		= $_POST['shipping_last_name'];
	$shippingAddress->address		= $_POST['shipping_address'];
	$shippingAddress->email			= $_POST['shipping_email'];
	$shippingAddress->mobilePhone		= $_POST['shipping_mobile_phone'];
	$objPmReqCard->invoice->setShippingAddress($shippingAddress);

	#uncomment the line below in order to see the content of the request
	//echo "<pre>";print_r($objPmReqCard);echo "</pre>";
	$objPmReqCard->encrypt($x509FilePath);
}
catch(Exception $e)
{
}
?>
<div class="span-15 prepend-1">
<h3>Exemplu de implementare plata prin card</h3>
<?php if(!($e instanceof Exception)):?>
<p>
	<form name="frmPaymentRedirect" method="post" action="<?php echo $paymentUrl;?>">
	<input type="hidden" name="env_key" value="<?php echo $objPmReqCard->getEnvKey();?>"/>
	<input type="hidden" name="data" value="<?php echo $objPmReqCard->getEncData();?>"/>
	<input type="hidden" name="cipher" value="<?php echo $objPmReqCard->getCipher();?>" /> 
	<input type="hidden" name="iv" value="<?php echo $objPmReqCard->getIv();?>" /> 
	<p>
		Vei redirectat catre pagina de plati securizata a mobilpay.ro
	</p>
	<p>
		Pentru a continua apasa <input type="image" src="images/mobilpay.gif" />
	</p>
	</form>
</p>
<!--
<script type="text/javascript" language="javascript">
	window.setTimeout(document.frmPaymentRedirect.submit(), 5000);
</script> -->
<?php else:?>
<p><strong><?php echo $e->getMessage();?></strong></p>
<?php endif;?>
<br/>
<br/>
</body>
</html>
