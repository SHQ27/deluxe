<div id="sf_admin_container" class="reporteCuponeras">
    
    <h1>Reporte de Cuponeras</h1>
		
    <form method="post">
    	<?php echo $reporteCuponerasForm['_csrf_token']; ?>
    	<br/><br/>
		<?php echo $reporteCuponerasForm['prefijo']->renderError(); ?>
    	<?php echo $reporteCuponerasForm['prefijo']->renderLabel(); ?>
		<?php echo $reporteCuponerasForm['prefijo']; ?>
		<br/><br/><br/>
		<?php echo $reporteCuponerasForm['vigencia_desde']->renderError(); ?>
    	<?php echo $reporteCuponerasForm['vigencia_desde']->renderLabel(); ?>
		<?php echo $reporteCuponerasForm['vigencia_desde']; ?>
		<br/><br/><br/>
		<?php echo $reporteCuponerasForm['vigencia_hasta']->renderError(); ?>
    	<?php echo $reporteCuponerasForm['vigencia_hasta']->renderLabel(); ?>
		<?php echo $reporteCuponerasForm['vigencia_hasta']; ?>
		<br/><br/><br/>
		<?php echo $reporteCuponerasForm['valor_pagado']->renderError(); ?>
    	<?php echo $reporteCuponerasForm['valor_pagado']->renderLabel(); ?>
		<?php echo $reporteCuponerasForm['valor_pagado']; ?>
		<br/><br/><br/>
		<?php echo $reporteCuponerasForm['comision_cuponera']->renderError(); ?>
    	<?php echo $reporteCuponerasForm['comision_cuponera']->renderLabel(); ?>
		<?php echo $reporteCuponerasForm['comision_cuponera']; ?>		
		<br/><br/><br/>
        <input type="submit" value="Generar" class="button" />
    </form>
    
    <br/><br/>
    
    <?php if ( isset( $data ) ): ?>
    
    <table>
        <tr>
            <td colspan="2"><strong>Datos Relevantes</strong></td>
        </tr>
        <tr>
            <td>Cupones Usados</td>
            <td><?php echo $data['utilizados']; ?></td>
        </tr>
        <tr>
            <td>Valor Real de cada Cupón</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['valor'] ); ?></td>
        </tr>
        <tr>
            <td>Valor Pagado por cada Cupón</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['valor_pagado'] ); ?></td>
        </tr>
        <tr>
            <td>Valor total de los cupones utilizados</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['monto_descuentos_utilizados'] ); ?></td>
        </tr>
        <tr>
            <td>Valor Real de los Productos</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['monto_productos'] ); ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Ingresos de Dinero</strong></td>
        </tr>   
        <tr>
            <td>Valor pagado por total de cupones utilizados</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['monto_cupones_utilizados'] ); ?></td>
        </tr>
        <tr>
            <td>Dinero Real Ingresado por venta</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['monto_total'] ); ?></td>
        </tr>
        <tr>
            <td>Total de Ingresos</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['total_ingresos'] ); ?></td>
        </tr>   
        <tr>
            <td colspan="2"><strong>Egresos de Dinero</strong></td>
        </tr>
        <tr>
            <td>Costo de Envío</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['monto_envio'] ); ?></td>
        </tr>
        <tr>
            <td>Costo de mercadería por compra</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['costo'] ); ?></td>
        </tr>
        <tr>
            <td>Comisión cuponera (<?php echo $data['comision_cuponera']; ?>%)</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['monto_comision_cuponera'] ); ?></td>
        </tr>
        <tr>
            <td>Total de Egresos</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['total_egresos'] ); ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Resultado de la Acción</strong></td>
        </tr>
        <tr>
            <td>Total de Ingresos - Total de Egresos</td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $data['resultado'] ); ?></td>
        </tr>
    </table>
    <?php endif; ?>
</div>