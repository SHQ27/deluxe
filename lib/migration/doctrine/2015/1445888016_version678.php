<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version678 extends Doctrine_Migration_Base
{
    public function up()
    {


    	$eshopFelix = eshopTable::getInstance()->getById(9);
    	$eshopFelix->setTagsSuscripcion('<!-- Google Code for Felix - Suscripci&oacute;n Newsletter Conversion Page -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 941057759;
var google_conversion_language = "en";
var google_conversion_format = "3";
var google_conversion_color = "ffffff";
var google_conversion_label = "7XyZCLKG82AQ383dwAM";
var google_remarketing_only = false;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//www.googleadservices.com/pagead/conversion/941057759/?label=7XyZCLKG82AQ383dwAM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>


<!-- Facebook Conversion Code for Felix - Suscripción Newsletter -->
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
window._fbq.push([\'track\', \'6038905133555\', {\'value\':\'0.00\',\'currency\':\'ARS\'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6038905133555&amp;cd[value]=0.00&amp;cd[currency]=ARS&amp;noscript=1" /></noscript>');
		$eshopFelix->save();
    }

    public function down()
    {
    }
}