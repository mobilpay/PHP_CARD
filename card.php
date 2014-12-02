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
	<img src="assets/themes/public/img/demo.png"/>
</div>
<div class="span-15 prepend-1">
<h3>Exemplu de implementare plata prin card bancar</h3>
<!-- 	In this page, before submitting the data, you'll need to inform the user on what he's going to buy and how much he'll be paying for what he chose. Make sure the VAT information is provided (VAT included or VAT free) 
	and that the description of the product is accurate. mobilpay and VISA/Mastercard logos are mandatory
 -->
<p>
	<strong>Ai ales sa testezi <i>Exemplu de implementare prin card bancar</i></strong>
	<br/>
	<strong>Cost 1.00 RON</strong>
	<br/>
	<strong>Plata va fi realizata prin portalul de plati securizat mobilpay.ro</strong>
	<br/>
	<form action="cardRedirect.php" method="post" name="frmPaymentRedirect">
<!-- 	If you want the values in the payment page to be prefilled, you need to request them from the customer and POST them to the payment gateway. If not, the customer will have to fill them in the secure page on mobilpay.ro -->
	<fieldset>
		<legend>Completeaza datele pentru facturare</legend>
		<label>Tip cumparator:</label><select name="billing_type" style="width: 200px;">
			<option value="person" selected>Persoana Fizica</option>
			<option value="company">Persoana juridica</option>
		</select><br/>
		<label id="labelFirstName">Prenume:</label><input type="text" name="billing_first_name" id="idFirstName" style="width: 200px;"/><br/>
		<label id="labelLastName">Nume:</label><input type="text" name="billing_last_name" id="idLastName" style="width: 200px;"/><br/>
		<label id="labelFiscalNumber">CNP:</label><input type="text" name="billing_fiscal_number" id="idFiscalNumber" style="width: 200px;"/><br/>
		<label id="labelIdentityNumber">CI:</label><input type="text" name="billing_identity_number" id="idIdentityNumber" style="width: 200px;"/><br/>
		<label>Tara:</label><input type="text" name="billing_country" style="width: 200px;"/><br/>
		<label>Judet/Sector:</label><input type="text" name="billing_county" style="width: 200px;"/><br/>
		<label>Localitate:</label><input type="text" name="billing_city" style="width: 200px;"/><br/>
		<label>Cod postal:</label><input type="text" name="billing_zip_code" style="width: 200px;"/><br/>
		<label>Adresa:</label><textarea type="text" name="billing_address" style="width: 200px; height: 150px;"></textarea><br/>
		<label>E-mail:</label><input type="text" name="billing_email" style="width: 200px;"/><br/>
		<label>Telefon mobil:</label><input type="text" name="billing_mobile_phone" style="width: 200px;"/><br/>
		<label>Banca:</label><input type="text" name="billing_bank" style="width: 200px;"/><br/>
		<label>IBAN:</label><input type="text" name="billing_iban" style="width: 200px;"/><br/>
	</fieldset>
	<fieldset>
		<legend>Completeaza datele pentru livrare</legend>
		<label>Tip cumparator:</label><select name="shipping_type" style="width: 200px;">
			<option value="person" selected>Persoana Fizica</option>
			<option value="company">Persoana juridica</option>
		</select><br/>
		<label id="labelFirstName">Prenume:</label><input type="text" name="shipping_first_name" id="idFirstName" style="width: 200px;"/><br/>
		<label id="labelLastName">Nume:</label><input type="text" name="shipping_last_name" id="idLastName" style="width: 200px;"/><br/>
		<label id="labelFiscalNumber">CNP:</label><input type="text" name="shipping_fiscal_number" id="idFiscalNumber" style="width: 200px;"/><br/>
		<label id="labelIdentityNumber">CI:</label><input type="text" name="shipping_identity_number" id="idIdentityNumber" style="width: 200px;"/><br/>
		<label>Tara:</label><input type="text" name="shipping_country" style="width: 200px;"/><br/>
		<label>Judet/Sector:</label><input type="text" name="shipping_county" style="width: 200px;"/><br/>
		<label>Localitate:</label><input type="text" name="shipping_city" style="width: 200px;"/><br/>
		<label>Cod postal:</label><input type="text" name="shipping_zip_code" style="width: 200px;"/><br/>
		<label>Adresa:</label><textarea type="text" name="shipping_address" style="width: 200px; height: 150px;"></textarea><br/>
		<label>E-mail:</label><input type="text" name="shipping_email" style="width: 200px;"/><br/>
		<label>Telefon mobil:</label><input type="text" name="shipping_mobile_phone" style="width: 200px;"/><br/>
		<label>Banca:</label><input type="text" name="shipping_bank" style="width: 200px;"/><br/>
		<label>IBAN:</label><input type="text" name="shipping_iban" style="width: 200px;"/><br/>
	</fieldset>
	<input type="submit" value="Plateste">
	</form>
	<br/>
</p>
<br/>
<br/>
</body>
</html>