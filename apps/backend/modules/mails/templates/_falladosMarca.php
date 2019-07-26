<?php include_partial('mails/header', array('title' => $title, 'width' => 900) ) ?>
	
<table cellspacing="0" width="900">
  <thead>
    <tr>
        <th>Codigo</th>
        <th>Denominación</th>
        <th>Talle</th>
        <th>Color</th>
        <th>Costo</th>
        <th>Cantidad</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 0; ?>
    <?php foreach ($fallados as $fallado): ?>            
      <tr>
        <td><?php echo $fallado['codigo']; ?></td>
        <td><?php echo $fallado['denominacion']; ?></td>
        <td style="text-align: center;"><?php echo $fallado['talle']; ?></td>
        <td style="text-align: center;"><?php echo $fallado['color']; ?></td>
        <td style="text-align: center;"><?php echo $fallado['costo']; ?></td>
        <td style="text-align: center;"><?php echo $fallado['cantidad']; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php echo include_partial('mails/footer'); ?>
