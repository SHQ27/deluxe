<?php

class Confguiadetalles extends Doctrine_Migration_Base
{
  public function up()
  {
  	$this->changeColumn('configuracion', 'valor', 'clob', '65535', array(
  	));
  	
  	$config = new configuracion();
	$config->setIdConfiguracion( configuracion::GUIA_DE_TALLE );
	$config->setDenominacion( 'Texto por default para las guías de talles' );
	$config->setValor( '<p><span style="font-size: x-small;"><strong>MUJER</strong></span> </p>
<table style="width: 576px;" cellspacing="0" cellpadding="0"><colgroup><col width="114" /> <col width="115" /> <col width="115" /> <col width="115" /> <col width="114" /> </colgroup>
<tbody>
<tr valign="TOP">
<td style="border: 1pt solid #00000a; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>TALLES</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>XS/36</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>S/38</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>M/40</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>L/42</strong></span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Talle</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">36</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">38</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">40</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">42</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Busto</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">82</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">86</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">90</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">94</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Cintura Anat&oacute;mica</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">60</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">64</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">68</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">72</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Cintura Baja<br /></span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">68</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">72</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">76</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">80</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Cadera</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">88</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">92</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="115">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">96</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="114">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">100</span></span></p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp; </p>
<table style="width: 773px;" cellspacing="0" cellpadding="0"><colgroup><col width="110" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> <col width="66" /> </colgroup>
<tbody>
<tr valign="TOP">
<td style="border: 1pt solid #00000a; padding: 0cm;" width="110">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>PANTALONES</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>23-30</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>24-32</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>25-34</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>26-36</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>27-38</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>28-40</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>29-42</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>30-44</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>31-46</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>32-4</strong></span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="110">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Cintura Anat&oacute;mica<br /></span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">58,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">61</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">63,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">66</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">68,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">71</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">73,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">76</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">78,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">81</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="110">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Cadera</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">87</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">89,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">92</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">94,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">97</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">99,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">102</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">104,5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">107</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">109,5</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="110">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Entrepierna Interna</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="66">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">83</span></span></p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><span style="font-size: x-small;"><strong>HOMBRE</strong></span> </p>
<table style="width: 629px;" cellspacing="0" cellpadding="0"><colgroup><col width="148" /> <col width="96" /> <col width="96" /> <col width="96" /> <col width="96" /> <col width="95" /> </colgroup>
<tbody>
<tr valign="TOP">
<td style="border: 1pt solid #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>TALLES SUPERIORES</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>S</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>M</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>L</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>XL</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>XXL</strong></span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Contorno de pecho</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">92</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">96</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">100</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">104</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">108</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Contorno de cintura</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">80</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">84</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">88</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">92</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">96</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Contorno de cadera</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">96</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">100</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">104</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">108</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">112</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Largo de brazos</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">65</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">66</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">67</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">69</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">69</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Ancho de hombros</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">42</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">43</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">44</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">45</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">4</span></span></p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<table style="width: 629px;" cellspacing="0" cellpadding="0"><colgroup><col width="148" /> <col width="96" /> <col width="96" /> <col width="96" /> <col width="96" /> <col width="95" /> </colgroup>
<tbody>
<tr valign="TOP">
<td style="border: 1pt solid #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>TALLES INFERIORES</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>30</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>32</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>34</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>36</strong></span></span></p>
</td>
<td style="border-width: 1pt 1pt 1pt medium; border-style: solid solid solid none; border-color: #00000a #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;"><strong>38</strong></span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Contorno de cintura</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">80</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">84</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">88</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">92</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">96</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Contorno de cadera</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">96</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">100</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">104</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">108</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">112</span></span></p>
</td>
</tr>
<tr valign="TOP">
<td style="border-width: medium 1pt 1pt; border-style: none solid solid; border-color: -moz-use-text-color #00000a #00000a; padding: 0cm;" width="148">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">Largo entrepierna</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">79.5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">80</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">80.5</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="96">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">81</span></span></p>
</td>
<td style="border-width: medium 1pt 1pt medium; border-style: none solid solid none; border-color: -moz-use-text-color #00000a #00000a -moz-use-text-color; padding: 0cm;" width="95">
<p style="margin-left: 0.21cm; margin-right: 0.21cm; margin-top: 0.05cm;"><span style="color: #000000;"><span style="font-size: x-small;">81.5</span></span></p>
</td>
</tr>
</tbody>
</table>' );
	$config->save();
	
	$q = Doctrine_Manager::getInstance()->getCurrentConnection();
	$q->execute("update marca set guia_talles = NULL");
	
  }

  public function down()
  {
  }
}
