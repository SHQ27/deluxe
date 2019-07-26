<div id="sf_admin_container" class="reportes">
    
    <h1>Reporte Cronológico</h1>
	
	<h2>Consulta Manual</h2>
		
    <form method="post">
    	<?php echo $reporteCronologicoForm['_csrf_token']; ?>
    	
    	<?php echo $reporteCronologicoForm['id_eshop']->renderLabel(); ?>
		<?php echo $reporteCronologicoForm['id_eshop']; ?>
		
		<br/><br/>    	
    	
    	<?php echo $reporteCronologicoForm['periodo']->renderLabel(); ?>
		<?php echo $reporteCronologicoForm['periodo']; ?>
        <input type="submit" value="Descargar" class="button" />        
    </form>
    
    <h2>Reporte Semanal Histórico del eShop "Deluxe Buys"</h2>
    <table>
        <tr>
            <th>Semana</th>
            <th>Año</th>
            <th>Rango</th>
            <th>Descargar</th>
        </tr>
    <?php $year = null; ?>
    <?php foreach ($reportes as $reporte): ?>
        <?php if ( $year != $reporte['year']): ?>
        <?php $year = $reporte['year']; ?>
        <tr><td colspan="4" class="center"><strong><?php echo $year; ?></strong></td></tr>
        <?php endif; ?>
        <tr>
            <td><?php echo $reporte['week']; ?></td>
            <td><?php echo $reporte['year']; ?></td>
            <td><?php echo $reporte['rango']; ?></td>
            <td>
                <a href="<?php echo url_for('reportes_cronologico_descargar', array('filename' => base64_encode($reporte['filename']))); ?>">
                    <img width="16" height="16" src="/backend/images/icons/small/backup.png" alt="Descargar">
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </table>
    
    
</div>