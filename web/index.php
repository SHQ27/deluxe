<?php

$host = strtolower($_SERVER['HTTP_HOST']);

$esDeluxe = ( $host == 'www.deluxebuys.com');

if ( $esDeluxe): ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es-es" lang="es-es"
    dir="ltr">
<head>
    <title>DeluxeBuys</title>

    <style>

    @font-face {
      font-family: 'FuturaStd-Book';
      src:
      url('https://s3.amazonaws.com/deluxebuys-static/hotsale/FuturaStd-Book.eot?#iefix') format('embedded-opentype'),
      url('https://s3.amazonaws.com/deluxebuys-static/hotsale/FuturaStd-Book.otf') format('opentype'),
      url('https://s3.amazonaws.com/deluxebuys-static/hotsale/FuturaStd-Book.woff') format('woff'),
      url('https://s3.amazonaws.com/deluxebuys-static/hotsale/FuturaStd-Book.ttf')  format('truetype'),
      url('https://s3.amazonaws.com/deluxebuys-static/hotsale/FuturaStd-Book.svg#FuturaStd-Book') format('svg');
      font-weight: normal;
      font-style: normal;
    }

    ::-webkit-input-placeholder {
       color: #111;
    }

    :-moz-placeholder { /* Firefox 18- */
       color: #111;  
    }

    ::-moz-placeholder {  /* Firefox 19+ */
       color: #111;  
    }

    :-ms-input-placeholder {  
       color: #111;  
    }

    body {
        margin: 0;
        font-family: 'Verdana';
    }

    .header {
        margin: 30px 0 20px 0;
    }

    .titulo {
        color: #023f78;
        font-size: 25px;
        line-height: 80px;
        font-weight: bold;
        color: #000;
    }

    .texto {
        color: #023f78;
        font-size: 15px;
        letter-spacing: 2px;
        line-height: 30px;
        color: #333;
    }

    .texto a {
    	color: #fd7977;
    }

    </style>

</head>

<body style="text-align: center">


    <div class="titulo">
    	<br />
        DELUXEBUYS.COM
        <br /><br />
    </div>

    <div class="texto">
        Ante cualquier duda o consulta escribinos a<br /><a href="mailto:clientes@deluxebuys.com">clientes@deluxebuys.com</a>
    </div>
    

  


</body>
</html>

<?php exit; ?> 

<?php else: ?>
<?php


if ( date('Y-m-d') == '2017-10-29' && !isset( $_GET['cybermonday'] ) ) {

echo '<p style="text-align: center;"><img src="https://s3.amazonaws.com/deluxebuys-static/cybermonday/cybermonday.jpg"></p>';
exit;
}

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$host = strtolower($_SERVER['HTTP_HOST']);
$app = stripos($host, 'deluxebuys.' ) !== false ? 'frontend' : 'eshop';

$configuration = ProjectConfiguration::getApplicationConfiguration($app, 'prod', true);
sfContext::createInstance($configuration)->dispatch();


?> 

<?php endif; ?>
