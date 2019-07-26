<?php

class Idexternosucursalesoca extends Doctrine_Migration_Base
{
  public function up()
  {
  	$q = Doctrine_Manager::getInstance()->getCurrentConnection();

  	$q->execute("update sucursal_oca set id_externo = 39 where codigo = 'AGR'");
  	$q->execute("update sucursal_oca set id_externo = 133 where codigo = 'BNO'");
  	$q->execute("update sucursal_oca set id_externo = 3 where codigo = 'AVE'");
  	$q->execute("update sucursal_oca set id_externo = 27 where codigo = 'AZL'");
  	$q->execute("update sucursal_oca set id_externo = 28 where codigo = 'BHI'");
  	$q->execute("update sucursal_oca set id_externo = 70 where codigo = 'BCE'");
  	$q->execute("update sucursal_oca set id_externo = 29 where codigo = 'BRC'");
  	$q->execute("update sucursal_oca set id_externo = 107 where codigo = 'BVL'");
  	$q->execute("update sucursal_oca set id_externo = 125 where codigo = 'BRA'");
  	$q->execute("update sucursal_oca set id_externo = 130 where codigo = 'FTE'");
  	$q->execute("update sucursal_oca set id_externo = 128 where codigo = 'CVI'");
  	$q->execute("update sucursal_oca set id_externo = 34 where codigo = 'CMP'");
  	$q->execute("update sucursal_oca set id_externo = 49 where codigo = 'CTC'");
  	$q->execute("update sucursal_oca set id_externo = 127 where codigo = 'CHB'");
  	$q->execute("update sucursal_oca set id_externo = 31 where codigo = 'CHA'");
  	$q->execute("update sucursal_oca set id_externo = 140 where codigo = 'ITO'");
  	$q->execute("update sucursal_oca set id_externo = 61 where codigo = 'COY'");
  	$q->execute("update sucursal_oca set id_externo = 32 where codigo = 'CHO'");
  	$q->execute("update sucursal_oca set id_externo = 141 where codigo = 'FL1'");
  	$q->execute("update sucursal_oca set id_externo = 139 where codigo = 'CI5'");
  	$q->execute("update sucursal_oca set id_externo = 142 where codigo = 'PR1'");
  	$q->execute("update sucursal_oca set id_externo = 52 where codigo = 'ETI'");
  	$q->execute("update sucursal_oca set id_externo = 47 where codigo = 'CRD'");
  	$q->execute("update sucursal_oca set id_externo = 114 where codigo = 'CDU'");
  	$q->execute("update sucursal_oca set id_externo = 46 where codigo = 'COC'");
  	$q->execute("update sucursal_oca set id_externo = 40 where codigo = 'COA'");
  	$q->execute("update sucursal_oca set id_externo = 41 where codigo = 'COR'");
  	$q->execute("update sucursal_oca set id_externo = 48 where codigo = 'CSU'");
  	$q->execute("update sucursal_oca set id_externo = 35 where codigo = 'CNQ'");
  	$q->execute("update sucursal_oca set id_externo = 36 where codigo = 'CQ1'");
  	$q->execute("update sucursal_oca set id_externo = 42 where codigo = 'EJE'");
  	$q->execute("update sucursal_oca set id_externo = 30 where codigo = 'CCO'");
  	$q->execute("update sucursal_oca set id_externo = 138 where codigo = 'DVT'");
  	$q->execute("update sucursal_oca set id_externo = 7 where codigo = 'CI1'");
  	$q->execute("update sucursal_oca set id_externo = 67 where codigo = 'LOR'");
  	$q->execute("update sucursal_oca set id_externo = 50 where codigo = 'ELO'");
  	$q->execute("update sucursal_oca set id_externo = 51 where codigo = 'EQS'");
  	$q->execute("update sucursal_oca set id_externo = 131 where codigo = 'FLV'");
  	$q->execute("update sucursal_oca set id_externo = 55 where codigo = 'FMA'");
  	$q->execute("update sucursal_oca set id_externo = 137 where codigo = 'FM1'");
  	$q->execute("update sucursal_oca set id_externo = 58 where codigo = 'GPO'");
  	$q->execute("update sucursal_oca set id_externo = 57 where codigo = 'GNR'");
  	$q->execute("update sucursal_oca set id_externo = 79 where codigo = 'OYA'");
  	$q->execute("update sucursal_oca set id_externo = 56 where codigo = 'GHU'");
  	$q->execute("update sucursal_oca set id_externo = 43 where codigo = 'JMA'");
  	$q->execute("update sucursal_oca set id_externo = 66 where codigo = 'JUJ'");
  	$q->execute("update sucursal_oca set id_externo = 64 where codigo = 'JNI'");
  	$q->execute("update sucursal_oca set id_externo = 88 where codigo = 'LCA'");
  	$q->execute("update sucursal_oca set id_externo = 115 where codigo = 'LPG'");
  	$q->execute("update sucursal_oca set id_externo = 60 where codigo = 'IRJ'");
  	$q->execute("update sucursal_oca set id_externo = 89 where codigo = 'LYE'");
  	$q->execute("update sucursal_oca set id_externo = 116 where codigo = 'LVS'");
  	$q->execute("update sucursal_oca set id_externo = 73 where codigo = 'SMT'");
  	$q->execute("update sucursal_oca set id_externo = 14 where codigo = 'LIR'");
  	$q->execute("update sucursal_oca set id_externo = 136 where codigo = 'LBO'");
  	$q->execute("update sucursal_oca set id_externo = 15 where codigo = 'LZM'");
  	$q->execute("update sucursal_oca set id_externo = 2 where codigo = 'ADG'");
  	$q->execute("update sucursal_oca set id_externo = 68 where codigo = 'LUJ'");
  	$q->execute("update sucursal_oca set id_externo = 71 where codigo = 'MDQ'");
  	$q->execute("update sucursal_oca set id_externo = 126 where codigo = 'MD1'");
  	$q->execute("update sucursal_oca set id_externo = 108 where codigo = 'MJU'");
  	$q->execute("update sucursal_oca set id_externo = 117 where codigo = 'MDZ'");
  	$q->execute("update sucursal_oca set id_externo = 144 where codigo = 'MZ2'");
  	$q->execute("update sucursal_oca set id_externo = 118 where codigo = 'DES'");
  	$q->execute("update sucursal_oca set id_externo = 113 where codigo = 'C12'");
  	$q->execute("update sucursal_oca set id_externo = 16 where codigo = 'MRO'");
  	$q->execute("update sucursal_oca set id_externo = 72 where codigo = 'NEC'");
  	$q->execute("update sucursal_oca set id_externo = 76 where codigo = 'NQN'");
  	$q->execute("update sucursal_oca set id_externo = 63 where codigo = 'JIO'");
  	$q->execute("update sucursal_oca set id_externo = 12 where codigo = 'CI7'");
  	$q->execute("update sucursal_oca set id_externo = 77 where codigo = 'OBR'");
  	$q->execute("update sucursal_oca set id_externo = 78 where codigo = 'OLV'");
  	$q->execute("update sucursal_oca set id_externo = 99 where codigo = 'ORA'");
  	$q->execute("update sucursal_oca set id_externo = 143 where codigo = 'PCH'");
  	$q->execute("update sucursal_oca set id_externo = 18 where codigo = 'PLO'");
  	$q->execute("update sucursal_oca set id_externo = 123 where codigo = 'MSP'");
  	$q->execute("update sucursal_oca set id_externo = 81 where codigo = 'PRA'");
  	$q->execute("update sucursal_oca set id_externo = 13 where codigo = 'FLS'");
  	$q->execute("update sucursal_oca set id_externo = 25 where codigo = 'AOL'");
  	$q->execute("update sucursal_oca set id_externo = 82 where codigo = 'PRS'");
  	$q->execute("update sucursal_oca set id_externo = 62 where codigo = 'INO'");
  	$q->execute("update sucursal_oca set id_externo = 132 where codigo = 'PNM'");
  	$q->execute("update sucursal_oca set id_externo = 83 where codigo = 'PSS'");
  	$q->execute("update sucursal_oca set id_externo = 59 where codigo = 'IGR'");
  	$q->execute("update sucursal_oca set id_externo = 111 where codigo = 'PMY'");
  	$q->execute("update sucursal_oca set id_externo = 135 where codigo = 'PUN'");
  	$q->execute("update sucursal_oca set id_externo = 19 where codigo = 'QMS'");
  	$q->execute("update sucursal_oca set id_externo = 85 where codigo = 'RAF'");
  	$q->execute("update sucursal_oca set id_externo = 87 where codigo = 'RCQ'");
  	$q->execute("update sucursal_oca set id_externo = 91 where codigo = 'RES'");
  	$q->execute("update sucursal_oca set id_externo = 119 where codigo = 'RCU'");
  	$q->execute("update sucursal_oca set id_externo = 92 where codigo = 'RGL'");
  	$q->execute("update sucursal_oca set id_externo = 4 where codigo = 'RGA'");
  	$q->execute("update sucursal_oca set id_externo = 44 where codigo = 'TER'");
  	$q->execute("update sucursal_oca set id_externo = 94 where codigo = 'ROS'");
  	$q->execute("update sucursal_oca set id_externo = 93 where codigo = 'RO1'");
  	$q->execute("update sucursal_oca set id_externo = 100 where codigo = 'SLA'");
  	$q->execute("update sucursal_oca set id_externo = 53 where codigo = 'FCO'");
  	$q->execute("update sucursal_oca set id_externo = 20 where codigo = 'SID'");
  	$q->execute("update sucursal_oca set id_externo = 8 where codigo = 'CI3'");
  	$q->execute("update sucursal_oca set id_externo = 120 where codigo = 'UAQ'");
  	$q->execute("update sucursal_oca set id_externo = 21 where codigo = 'SJU'");
  	$q->execute("update sucursal_oca set id_externo = 145 where codigo = 'LZO'");
  	$q->execute("update sucursal_oca set id_externo = 69 where codigo = 'LUQ'");
  	$q->execute("update sucursal_oca set id_externo = 23 where codigo = 'SMN'");
  	$q->execute("update sucursal_oca set id_externo = 102 where codigo = 'SMA'");
  	$q->execute("update sucursal_oca set id_externo = 22 where codigo = 'SMG'");
  	$q->execute("update sucursal_oca set id_externo = 75 where codigo = 'NIC'");
  	$q->execute("update sucursal_oca set id_externo = 129 where codigo = 'SPD'");
  	$q->execute("update sucursal_oca set id_externo = 24 where codigo = 'AFA'");
  	$q->execute("update sucursal_oca set id_externo = 17 where codigo = 'MST'");
  	$q->execute("update sucursal_oca set id_externo = 98 where codigo = 'SFN'");
  	$q->execute("update sucursal_oca set id_externo = 96 where codigo = 'RSA'");
  	$q->execute("update sucursal_oca set id_externo = 134 where codigo = 'RS1'");
  	$q->execute("update sucursal_oca set id_externo = 97 where codigo = 'SDE'");
  	$q->execute("update sucursal_oca set id_externo = 86 where codigo = 'SUN'");
  	$q->execute("update sucursal_oca set id_externo = 103 where codigo = 'TDL'");
  	$q->execute("update sucursal_oca set id_externo = 101 where codigo = 'TTG'");
  	$q->execute("update sucursal_oca set id_externo = 90 where codigo = 'REL'");
  	$q->execute("update sucursal_oca set id_externo = 65 where codigo = 'TQL'");
  	$q->execute("update sucursal_oca set id_externo = 80 where codigo = 'OYO'");
  	$q->execute("update sucursal_oca set id_externo = 104 where codigo = 'TUC'");
  	$q->execute("update sucursal_oca set id_externo = 74 where codigo = 'YAN'");
  	$q->execute("update sucursal_oca set id_externo = 11 where codigo = 'USH'");
  	$q->execute("update sucursal_oca set id_externo = 122 where codigo = 'VSF'");
  	$q->execute("update sucursal_oca set id_externo = 110 where codigo = 'VTO'");
  	$q->execute("update sucursal_oca set id_externo = 9 where codigo = 'CI4'");
  	$q->execute("update sucursal_oca set id_externo = 105 where codigo = 'VDM'");
  	$q->execute("update sucursal_oca set id_externo = 45 where codigo = 'VCP'");
  	$q->execute("update sucursal_oca set id_externo = 112 where codigo = 'VDR'");
  	$q->execute("update sucursal_oca set id_externo = 106 where codigo = 'VLG'");
  	$q->execute("update sucursal_oca set id_externo = 109 where codigo = 'VMA'");
  	$q->execute("update sucursal_oca set id_externo = 121 where codigo = 'VME'");
  	$q->execute("update sucursal_oca set id_externo = 26 where codigo = 'APZ'");
  	
  	$q->execute("update sucursal_oca set activa = false where id_externo IS NULL");
  	
  }

  public function down()
  {
  }
}
