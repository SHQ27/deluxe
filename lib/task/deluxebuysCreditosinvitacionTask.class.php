<?php

class deluxebuysCreditosinvitacionTask extends deluxebuysBaseTask
{
    protected function configure()
    {
        parent::preConfigure();
        
        $this->namespace= 'deluxebuys';
        $this->name = 'creditos-invitacion';
        $this->briefDescription = 'Asigna los créditos por invitación';
        $this->detailedDescription = <<<EOF
        The [deluxebuys:creditos-invitacion|INFO] task does things.
        Call it with:
        
        [php symfony deluxebuys:creditos-invitacion|INFO]
EOF;
    }

    public function doExecute($arguments = array(), $options = array())
    {
        $this->log('--- Comienzo de ejecucion: "creditosInvitacion"');

        $invitaciones = invitacionTable::getInstance()->listPorProcesar();

        $conn = Doctrine_Manager::connection();

        if (!count($invitaciones)) {
            $this->log('No hay invitaciones');
            return;
        }
        
        $ok = $error = 0;
        foreach ($invitaciones as $invitacion) {
            try {
                    $conn->beginTransaction();
                    $this->crearBonificacion($invitacion->getIdUsuario());
                    $this->actualizarInvitacion($invitacion);
                    $conn->commit();
                    $ok++;
            } catch (Doctrine_Exception $e) {
                $this->log("Error al bonificar invitacion " . $invitacion->getIdInvitacion());
                $conn->rollback();
                $error++;
            }
        }        
        $this->log("Invitaciones creadas: $ok");
        $this->log("Invitaciones con error: $error");
	$this->log('--- Fin de ejecucion: "creditosInvitacion"');
    }
    
    protected function actualizarInvitacion(invitacion $invitacion)
    {                
        $invitacion->setBonificacion(true);
        $invitacion->save();
    }

    protected function crearBonificacion($idUsuario)
    {
        $bonificacion = new bonificacion();
        $bonificacion->setIdTipoDescuento(tipoDescuento::MONTOFIJO);
        $bonificacion->setIdTipoBonificacion(tipoBonificacion::INVITACION);
        $bonificacion->setIdUsuario($idUsuario);
        $bonificacion->setValor(configuracionTable::getValor(configuracion::MONTO_INVITACION));
        $configVencimiento = configuracionTable::getValor(configuracion::VENCIMIENTO_INVITACION);
        $bonificacion->setVencimiento(new Doctrine_Expression("ADDDATE(NOW(), {$configVencimiento})"));
        $bonificacion->save();        
    }
}
