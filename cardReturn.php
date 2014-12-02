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
<div class="span-15 prepend-1">
<h3>Exemple de implementare</h3>

<p>Multumim!</p>
<p>Ai efectuat o plata pentru produsul cu identificatorul <?php echo $_GET['orderId']?></p>
<p>Ai primit in confirmURL rezultatul platii. Afiseaza aici un mesaj corespunzator cu starea comenzii <?php echo $_GET['orderId']?></p>
<!-- 
Aceasta pagina trebuie sa aiba un continut dinamic, generat in functie de starea platii.
Vom face un SELECT in BD, cautand starea comenzii cu identificatorul $_GET['orderId']
Daca starea este "confirmed/captured" vom afisa catre client un mesaj de tipul "succes".
Daca starea este "rejected" vom afisa catre client un mesaj de tipul "respingere"
Daca starea este "pending" vom afisa catre client un mesaj de tipul "in curs de procesare"
-->
</body>
</html>
