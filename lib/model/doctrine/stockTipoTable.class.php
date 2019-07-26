<?php


class stockTipoTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de stockTipoTable;
     *
     * @return stockTipoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('stockTipo');
    }
    
    /**
     * Retorna  todos las opciones elegibles manualmente desde backend
     *
     * @return array
     */
    public function getManualOptions()
    {
        $choices = $this->createQuery('st')
                        ->select('st.id_stock_tipo, st.denominacion')
                        ->addWhere('st.es_de_sistema = ?', false)
                        ->orderBy('st.denominacion')
                        ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
        
        $otro = $choices[stockTipo::MANUAL_OTRO];
        unset($choices[stockTipo::MANUAL_OTRO]);

        $response = array(stockTipo::MANUAL_OTRO => $otro);
        foreach($choices as $k => $v) $response[$k] = $v;
        return $response;
    }
    
}