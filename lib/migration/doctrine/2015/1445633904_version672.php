<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version672 extends Doctrine_Migration_Base
{
    public function up()
    {
    	$eshopRie = eshopTable::getInstance()->getById(2);

    	$eshopRie->setTagsCompra('<!-- Facebook Conversion Code for Re ventas -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement(\'script\');
    fbds.async = true;
    fbds.src = \'//connect.facebook.net/en_US/fbds.js\';
    var s = document.getElementsByTagName(\'script\')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push([\'track\', \'6019419971965\', {\'value\':\'|%VALUE%|\',\'currency\':\'ARS\'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6019419971965&amp;cd[value]=|%VALUE%|&amp;cd[currency]=ARS&amp;noscript=1" /></noscript>');
    	$eshopRie->save();
		
		


    	$eshopFelix = eshopTable::getInstance()->getById(9);
    	$eshopFelix->setTagsCompra('<!-- Google Code for Felix - Compra E-commerce Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 941057759;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "dGPJCPHE3mAQ383dwAM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/941057759/?label=dGPJCPHE3mAQ383dwAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

<!-- Facebook Conversion Code for Felix - Compras E-commerce -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement(\'script\');
    fbds.async = true;
    fbds.src = \'//connect.facebook.net/en_US/fbds.js\';
    var s = document.getElementsByTagName(\'script\')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push([\'track\', \'6038632278755\', {\'value\':\'|%VALUE%|\',\'currency\':\'ARS\'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6038632278755&amp;cd[value]=|%VALUE%|&amp;cd[currency]=ARS&amp;noscript=1" /></noscript>');


		$eshopFelix->setTagsRemarketing('<!-- Google Remarketing Adwords -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 941057759;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/941057759/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<!-- End Google Remarketing Adwords -->

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
n.push=n;n.loaded=!0;n.version=\'2.0\';n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
document,\'script\',\'//connect.facebook.net/en_US/fbevents.js\');
fbq(\'init\', \'921841744567682\');
fbq(\'track\', "PageView");</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=921841744567682&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->');
		$eshopFelix->save();
    }

    public function down()
    {
    }
}