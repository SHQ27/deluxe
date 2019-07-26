<?php $source = $form->getObject() ?>
<?php if ($source): ?>

    <?php $resumen = sourceInversionTable::getInstance()->getResumen( $source->getIdSource() ); ?>
        
    <?php if (count($resumen)): ?>
    <table>
        <tr>
            <th>Mes</th>
            <th>eShop</th>
            <th>Inversión</th>
        </tr>
        <?php foreach ($resumen as $row): ?>
        <tr>
            <td><?php echo ucfirst( strftime("%B %Y", strtotime( $row['periodo'] . '-1' )) ); ?></td>
            <td><?php echo $row['eshop']; ?></td>
            <td>$<?php echo formatHelper::getInstance()->decimalNumber( $row['valor'] ); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php else: ?>
    <p>No hay datos cargados sobre inversiones para este source.</p>
    <?php endif; ?>
    
<?php endif; ?>