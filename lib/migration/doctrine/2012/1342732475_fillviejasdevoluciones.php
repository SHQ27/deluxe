<?php

class Fillviejasdevoluciones extends Doctrine_Migration_Base
{
  public function up()
  {
  	$csv = "1,22042,1,41370,'2012-05-24 15:51:13',12600&16,19957,1,38295,'2012-05-28 15:09:41',12765&17,22046,1,41072,'2012-05-28 15:15:15',12766&18,22091,1,41072,'2012-05-28 15:15:16',12766&22,22535,1,42745,'2012-05-29 14:42:13',12831&23,21884,1,40436,'2012-05-29 14:44:05',12833&24,21786,1,40436,'2012-05-29 14:44:05',12833&26,22049,1,40933,'2012-05-29 15:08:50',12840&27,20277,1,39224,'2012-05-29 15:12:35',12841&28,18330,1,41011,'2012-05-29 16:00:43',12843&29,21623,1,40024,'2012-05-30 13:00:17',12878&30,10402,1,40390,'2012-05-30 15:11:59',12896&31,21927,1,40390,'2012-05-30 15:12:00',12896&32,20716,1,39057,'2012-05-30 16:08:59',12906&33,8984,1,42234,'2012-05-31 10:52:50',12960&34,1587,1,41527,'2012-05-31 11:44:56',12962&35,6816,1,42770,'2012-05-31 11:58:35',12963&36,21886,1,40618,'2012-05-31 14:21:34',12987&37,21813,1,40074,'2012-06-01 11:27:03',13063&38,11531,1,41212,'2012-06-01 11:28:10',13064&39,22358,1,42099,'2012-06-01 11:33:00',13065&40,8957,1,42099,'2012-06-01 11:33:00',13065&41,8949,1,42099,'2012-06-01 11:33:00',13065&42,8967,1,41962,'2012-06-01 11:35:09',13066&43,9017,1,41962,'2012-06-01 11:35:10',13066&44,22295,1,42489,'2012-06-01 11:41:34',13068&45,9078,1,41923,'2012-06-01 12:18:00',13069&46,9190,1,41923,'2012-06-01 12:18:00',13069&47,21691,1,40454,'2012-06-01 12:24:22',13070&49,10316,1,40064,'2012-06-01 12:27:49',13072&50,10297,1,40064,'2012-06-01 12:27:49',13072&51,21823,1,40064,'2012-06-01 12:27:49',13072&52,13642,1,42591,'2012-06-01 12:28:58',13073&53,16839,1,43570,'2012-06-01 14:56:25',13083&54,19941,1,38394,'2012-06-01 15:16:51',13085&55,19720,1,37758,'2012-06-04 10:57:24',13201&56,21743,1,41437,'2012-06-04 11:57:05',13210&57,13751,1,42289,'2012-06-04 13:01:08',13215&58,21924,1,42289,'2012-06-04 13:01:08',13215&59,19389,1,42979,'2012-06-04 15:35:30',13223&60,22703,1,42979,'2012-06-04 15:35:30',13223&61,9189,1,42141,'2012-06-05 14:47:22',13266&62,8949,1,42721,'2012-06-05 14:50:59',13267&63,8957,1,42721,'2012-06-05 14:50:59',13267&64,8985,1,42721,'2012-06-05 14:50:59',13267&65,8951,1,42660,'2012-06-05 15:12:16',13269&66,9151,1,42577,'2012-06-05 15:42:44',13271&67,9192,1,42577,'2012-06-05 15:42:44',13271&68,604,1,44718,'2012-06-06 10:00:57',13311&69,23152,1,43381,'2012-06-06 11:51:34',13327&70,23133,1,43381,'2012-06-06 11:51:34',13327&71,23440,1,44083,'2012-06-06 11:54:13',13329&72,19926,1,44083,'2012-06-06 11:54:13',13329&73,20179,1,39302,'2012-06-06 12:22:10',13331&74,21691,1,41075,'2012-06-07 11:47:45',13403&75,22975,1,43826,'2012-06-07 15:11:15',13449&76,23163,1,44053,'2012-06-08 11:39:19',13510&78,9136,1,42734,'2012-06-08 12:22:06',13513&79,22314,1,42734,'2012-06-08 12:22:06',13513&80,22380,1,42734,'2012-06-08 12:22:06',13513&81,22377,1,42734,'2012-06-08 12:22:06',13513&82,21913,1,41207,'2012-06-08 12:43:35',13516&83,21924,1,42645,'2012-06-08 12:44:22',13517&84,9135,1,42210,'2012-06-11 09:56:49',13575&85,9154,1,42210,'2012-06-11 09:56:49',13575&86,21828,1,41380,'2012-06-11 10:41:54',13578&87,13775,1,41380,'2012-06-11 10:41:54',13578&88,10405,1,41380,'2012-06-11 10:41:54',13578&89,21865,1,40289,'2012-06-11 16:47:35',13595&90,23444,1,44207,'2012-06-11 17:37:38',13598&91,23138,1,44355,'2012-06-12 12:52:40',13628&92,20139,1,43953,'2012-06-12 14:47:22',13634&93,21912,1,42840,'2012-06-12 16:55:20',13647&94,9090,1,42105,'2012-06-12 16:57:37',13648&95,9171,1,42105,'2012-06-12 16:57:37',13648&96,9175,1,42105,'2012-06-12 16:57:37',13648&97,22730,1,43983,'2012-06-13 10:34:01',13667&98,9880,1,43983,'2012-06-13 10:34:01',13667&99,22726,1,43983,'2012-06-13 10:34:01',13667&100,24211,1,45256,'2012-06-14 09:48:30',13706&101,21691,1,40285,'2012-06-14 12:34:12',13717&102,24114,1,45361,'2012-06-14 15:02:09',13720&103,24120,2,45361,'2012-06-14 15:02:09',13720&104,24089,1,45361,'2012-06-14 15:02:09',13720&105,23798,1,45779,'2012-06-15 12:19:25',13747&106,23205,1,43805,'2012-06-15 15:04:04',13754&107,23184,1,43805,'2012-06-15 15:04:04',13754&108,20782,1,46879,'2012-06-15 15:09:33',13755&109,19942,1,38493,'2012-06-15 15:37:50',13756&110,16619,1,38493,'2012-06-15 15:37:50',13756&111,13775,1,35598,'2012-06-15 15:41:03',13757&112,18138,1,35598,'2012-06-15 15:41:03',13757&113,10354,1,35598,'2012-06-15 15:41:03',13757&114,13640,1,44233,'2012-06-15 15:44:34',13758&115,23441,1,43999,'2012-06-15 15:47:39',13759&116,19934,1,43757,'2012-06-15 15:52:18',13760&117,6460,1,37941,'2012-06-15 16:03:11',13762&118,22057,1,41124,'2012-06-15 16:09:19',13763&119,22073,1,41124,'2012-06-15 16:09:19',13763&120,19956,1,38684,'2012-06-15 16:12:05',13764&121,23781,1,45246,'2012-06-19 09:56:19',13862&122,24146,1,46170,'2012-06-19 09:59:12',13863&123,18836,1,42264,'2012-06-21 16:32:27',13975&124,24492,1,47453,'2012-06-22 09:53:29',14015&125,22964,1,43326,'2012-06-25 11:44:51',14120&126,22975,1,43326,'2012-06-25 11:44:51',14120&127,23242,1,43886,'2012-06-25 15:32:18',14130&128,24841,1,46750,'2012-06-26 11:59:02',14182&129,17982,1,44222,'2012-06-26 12:20:28',14184&130,23094,1,44222,'2012-06-26 12:20:28',14184&131,24369,1,46104,'2012-06-26 15:14:31',14189&132,20256,1,46084,'2012-06-26 15:38:27',14191&133,24810,1,47868,'2012-06-26 16:13:32',14196&134,24442,1,47786,'2012-06-26 16:19:29',14197&135,24704,1,46628,'2012-06-26 16:29:47',14202&136,10316,1,40824,'2012-06-27 16:30:47',14327&137,21777,1,40824,'2012-06-27 16:30:47',14327&138,23310,1,43669,'2012-06-27 17:01:07',14339&139,24088,1,45347,'2012-06-27 17:03:15',14340&140,10276,1,48162,'2012-06-27 17:06:36',14342&141,25341,1,48288,'2012-06-28 14:53:43',14463&142,24442,1,46068,'2012-06-29 11:30:50',14541&143,24538,1,46068,'2012-06-29 11:30:50',14541&144,25316,1,47557,'2012-06-29 11:32:00',14542&145,23170,1,43502,'2012-06-29 12:12:50',14551&146,8049,1,38802,'2012-06-29 12:18:42',14552&147,13647,1,40659,'2012-06-29 12:21:27',14553&148,24166,1,45417,'2012-06-29 12:29:04',14555&149,25327,1,47584,'2012-06-29 15:59:08',14568&150,21064,1,47584,'2012-06-29 15:59:08',14568&153,21855,1,44083,'2012-06-29 16:01:44',14569&154,22253,1,44083,'2012-06-29 16:01:44',14569&155,23892,1,46348,'2012-07-02 16:33:00',14682&156,18723,1,42894,'2012-07-02 17:12:08',14685&157,22194,1,42894,'2012-07-02 17:12:08',14685&158,9211,1,42894,'2012-07-02 17:12:08',14685&159,9229,1,42894,'2012-07-02 17:12:08',14685&160,20106,1,42894,'2012-07-02 17:12:08',14685&161,22495,1,42894,'2012-07-02 17:12:08',14685&162,25836,1,48823,'2012-07-03 09:52:45',14725&163,25833,1,48823,'2012-07-03 09:52:45',14725&164,25781,1,48823,'2012-07-03 09:52:45',14725&165,23889,1,45466,'2012-07-03 09:56:16',14726&166,23872,1,45200,'2012-07-03 10:01:20',14727&167,20081,1,48820,'2012-07-03 10:03:12',14728&168,23675,1,44895,'2012-07-04 10:05:41',14769&169,24688,1,47120,'2012-07-04 11:38:27',14774&171,5781,1,38129,'2012-07-04 15:13:37',14794&172,19045,1,38129,'2012-07-04 15:13:37',14794&173,19040,1,38129,'2012-07-04 15:13:37',14794&175,19041,1,38086,'2012-07-04 15:15:52',14796&176,23782,1,45184,'2012-07-04 16:31:54',14802&177,23875,1,45184,'2012-07-04 16:31:55',14802&178,24322,1,46571,'2012-07-04 17:15:33',14803&179,24980,1,47412,'2012-07-04 17:18:50',14804&180,26507,1,49233,'2012-07-04 17:23:06',14808&181,23949,1,45229,'2012-07-05 10:09:43',14838&182,11448,1,44238,'2012-07-05 11:36:43',14850&183,23651,1,45009,'2012-07-05 15:57:45',14862&184,21912,1,44382,'2012-07-10 15:13:31',15059&185,24442,1,47785,'2012-07-11 10:15:15',15107&186,26570,1,49050,'2012-07-12 12:00:07',15200&187,25409,1,48350,'2012-07-13 09:46:51',15292&188,20718,1,48709,'2012-07-13 11:07:41',15299&189,20781,1,48709,'2012-07-13 11:07:41',15299&190,20233,1,46209,'2012-07-13 11:50:10',15304&191,26417,1,49960,'2012-07-13 12:35:20',15308&192,19956,1,38225,'2012-07-13 15:56:59',15328&193,25320,1,47875,'2012-07-16 12:23:02',15436&194,25337,1,47875,'2012-07-16 12:23:02',15436&195,25286,1,47875,'2012-07-16 12:23:02',15436&196,26817,1,51240,'2012-07-16 16:01:01',15463&197,20178,1,46865,'2012-07-17 17:03:15',15567&198,19408,1,41800,'2012-07-17 17:04:10',15568&199,20248,1,47552,'2012-07-18 10:47:12',15626&200,22667,1,49561,'2012-07-18 11:08:22',15630&201,24400,1,46185,'2012-07-18 11:28:32',15636&202,25631,1,48722,'2012-07-18 11:38:52',15639&203,26643,1,50248,'2012-07-18 11:51:23',15642&204,25462,1,47942,'2012-07-18 12:00:03',15647&205,24974,1,47265,'2012-07-18 12:08:24',15649&206,26117,1,48547,'2012-07-18 14:54:08',15668&207,27397,1,51440,'2012-07-19 15:27:43',15757&208,25367,1,47843,'2012-07-19 15:42:55',15759&209,23168,1,50547,'2012-07-19 16:26:34',15762);";
  	$rows = explode('&', $csv);
  	
  	foreach ($rows as $row)
  	{
  		$fields = explode(',', $row);
  		
  		$idDevolucion	= trim($fields[0]);
  		$idProductoItem	= trim($fields[1]);
  		$cantidad		= trim($fields[2]);
  		$idPedido		= trim($fields[3]);
  		$fecha			= trim($fields[4]);
  		$idBonificacion	= trim($fields[5]);
  		
  		$pedidoProductoItem = pedidoProductoItemTable::getInstance()->getByCompoundKey($idPedido, $idProductoItem);
  		$pedido = pedidoTable::getInstance()->getByIdPedido($idPedido);
  		
  		$devolucion = new devolucion();
		$devolucion->setFecha( new Doctrine_Expression('now()') );
		$devolucion->setIdBonificacion( $idBonificacion );
		$devolucion->setIdUsuario( $pedido->getIdUsuario() );
		$devolucion->setTipoEnvio( devolucion::envio_deluxe );
		$devolucion->setTipoCredito( devolucion::credito_deluxe );
		$devolucion->setFechaRecibido( new Doctrine_Expression('now()') );
		$devolucion->setFechaCierre( new Doctrine_Expression('now()') );
		$devolucion->save();
		
		$devolucionProductoItem = new devolucionProductoItem();
		$devolucionProductoItem->setIdDevolucion( $devolucion->getIdDevolucion() );
		$devolucionProductoItem->setIdPedidoProductoItem( $pedidoProductoItem->getIdPedidoProductoItem() );
		$devolucionProductoItem->setCantidad( $cantidad );
		$devolucionProductoItem->save();
  	}
  	
  	
  }

  public function down()
  {
  }
}