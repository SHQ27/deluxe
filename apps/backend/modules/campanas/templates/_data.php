<?php $campanaMarcas = $form->getObject()->getCampanaMarca(); ?>
<?php $data = array(); ?>
<?php foreach ( $campanaMarcas as $campanaMarca ) { $data[] = $campanaMarca->getData(); }?>
<script>var campanaMarcaData = <?php echo json_encode($data); ?>;</script>