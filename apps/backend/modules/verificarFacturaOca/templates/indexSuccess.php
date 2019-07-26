<div id="sf_admin_container" class="verificarFacturaOca">
    <h1>Verificar Factura OCA</h1>
    
    <form enctype="multipart/form-data" method="post">
    
        <br/>
    
        <p>
        	<?php echo $verificarFacturaOcaForm['_csrf_token']; ?>
        	<?php echo $verificarFacturaOcaForm['csv']->renderLabel(); ?>
    		<?php echo $verificarFacturaOcaForm['csv']; ?>
		</p>
        
        <p>
            <input type="submit" value="Verificar" />
        </p> 
    </form>
        
    <?php if ( sfContext::getInstance()->getUser()->hasFlash('result_verificarFacturaOcaForm') ): ?>
    
        <?php $data = sfContext::getInstance()->getUser()->getFlash('result_verificarFacturaOcaForm'); ?>
        <?php sfContext::getInstance()->getUser()->setFlash('result_verificarFacturaOcaForm', null); ?>
        
        <?php if ( !$data['error'] ): ?>
        <table>
            <tr>
            <?php foreach ($data['headers'] as $header): ?>
                <th><?php echo $header; ?></th>
            <?php endforeach; ?>
            </tr>
            
            <?php foreach ($data['data'] as $data ): ?>
                <tr class="<?php echo ($data['exists']) ? 'exists' : 'no-exists'; ?>">
                <?php foreach ($data['row'] as $row ): ?>
                    <td><?php echo $row; ?></td>
                <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            
            
        </table>
        <?php else: ?>
        <p class="error"><?php echo $data['error']; ?></p>
        <?php endif; ?>
    
    <?php endif; ?>
</div>