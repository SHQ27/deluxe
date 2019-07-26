<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version632 extends Doctrine_Migration_Base
{
    public function up()
    {
        $data     = array();
        $data[8]  = 'PREND';
        $data[14] = 'PREND';
        $data[13] = 'ACCES';
        $data[16] = 'ACCES';
        $data[75] = 'ACCES';
        $data[61] = 'ACCES';
        $data[64] = 'ACCES';
        $data[66] = 'ACCES';
        $data[32] = 'ACCES';
        $data[34] = 'ACCES';
        $data[29] = 'ACCES';
        $data[48] = 'ACCES';
        $data[49] = 'ACCES';
        $data[35] = 'ACCES';
        $data[46] = 'PREND';
        $data[24] = 'PREND';
        $data[53] = 'ACCES';
        $data[69] = 'ACCES';
        $data[42] = 'PREND';
        $data[89] = 'PREND';
        $data[82] = 'PREND';
        $data[71] = 'ACCES';
        $data[23] = 'PREND';
        $data[65] = 'PREND';
        $data[67] = 'PREND';
        $data[6]  = 'PREND';
        $data[17] = 'PREND';
        $data[57] = 'PREND';
        $data[84] = 'PREND';
        $data[47] = 'PREND';
        $data[25] = 'ACCES';
        $data[20] = 'PREND';
        $data[62] = 'PREND';
        $data[55] = 'ACCES';
        $data[81] = 'ACCES';
        $data[85] = 'PREND';
        $data[63] = 'ACCES';
        $data[88] = 'PREND';
        $data[54] = 'ACCES';
        $data[10] = 'PREND';
        $data[87] = 'PREND';
        $data[83] = 'PREND';
        $data[5]  = 'PREND';
        $data[44] = 'ACCES';
        $data[22] = 'PREND';
        $data[38] = 'PREND';
        $data[27] = 'PREND';
        $data[68] = 'PREND';
        $data[51] = 'ACCES';
        $data[74] = 'PREND';
        $data[73] = 'PREND';
        $data[92] = 'PREND';
        $data[91] = 'PREND';
        $data[43] = 'ACCES';
        $data[9]  = 'PREND';
        $data[15] = 'PREND';
        $data[58] = 'ACCES';
        $data[30] = 'ACCES';
        $data[52] = 'ACCES';
        $data[33] = 'ACCES';
        $data[50] = 'ACCES';
        $data[79] = 'ACCES';
        $data[80] = 'ACCES';
        $data[1]  = 'PREND';
        $data[3]  = 'PREND';
        $data[76] = 'PREND';
        $data[77] = 'PREND';
        $data[60] = 'ACCES';
        $data[59] = 'PREND';
        $data[19] = 'PREND';
        $data[70] = 'ACCES';
        $data[72] = 'ACCES';
        $data[26] = 'ACCES';
        $data[36] = 'PREND';
        $data[37] = 'PREND';
        $data[12] = 'PREND';
        $data[39] = 'PREND';
        $data[45] = 'ACCES';
        $data[90] = 'PREND';
        $data[18] = 'PREND';
        $data[86] = 'PREND';
        $data[56] = 'PREND';
        $data[11] = 'PREND';
        $data[21] = 'PREND';
        $data[7]  = 'PREND';
        $data[2]  = 'PREND';
        $data[28] = 'PREND';

        foreach ($data as $idProductoCategoria => $tipoPrenda) {
            $productoCategoria = productoCategoriaTable::getInstance()->getById( $idProductoCategoria );
            $productoCategoria->setTipoPrenda( $tipoPrenda );
            $productoCategoria->save();
        }

    }

    public function down()
    {
    }
}