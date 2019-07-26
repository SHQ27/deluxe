<?php


class usuarioTalleZonaTable extends Doctrine_Table
{
    /**
     * Retorna una instancia de usuarioTalleZonaTable;
     *
     * @return usuarioTalleZonaTable
     */    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('usuarioTalleZona');
    }
    
    /**
     * Inserta o edita un nuevo usuarioTalleZona
     *
     */
    public function save($idUsuario, $idTalleZona, $medida)
    {
        $usuarioTalleZona =  $this->createQuery('utz')
                                  ->addWhere('utz.id_usuario = ?', $idUsuario)
                                  ->addWhere('utz.id_talle_zona = ?', $idTalleZona)
                                  ->fetchOne();
    
    
        if (!$usuarioTalleZona)
        {
            $usuarioTalleZona = new usuarioTalleZona();
            $usuarioTalleZona->setIdUsuario( $idUsuario );
            $usuarioTalleZona->setIdTalleZona( $idTalleZona );
        }
    
        $usuarioTalleZona->setMedida( $medida );
        $usuarioTalleZona->save();
    }
    
    /**
     * Devuelve un array clave valor con las medidas del usuario
     *
     */
    public function getMedidas($idUsuario)
    {
        return $this->createQuery('utz')
                     ->select('utz.id_talle_zona, utz.medida')
                     ->addWhere('utz.id_usuario = ?', $idUsuario)
                     ->execute( array(), 'HYDRATE_KEY_VALUE_PAIR' );
    }
    
    
}