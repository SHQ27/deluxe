<div class="waitList">
	
	<?php if ($isWaiting): ?>
	<a class="done sprite"></a>
	<?php else: ?>
	<a class="open sprite"></a>
	<a class="done sprite hide"></a>
		
	<div class="form">
		
		<form action="<?php echo url_for('producto_addWaitList')?>" method="POST">
		                		
			<?php echo $form['id_producto'] ?>
		                	
			<div class="row">
				<label>Elegí un Talle:</label>
				<div class="field greySelect"><?php echo $form['talle'] ?></div>
			</div>
			
			<div class="row">
				<label>Elegí un Color:</label>
				<div class="field greySelect"><?php echo $form['color'] ?></div>
			</div>
			
			<div class="row">
				<label>Cantidad:</label>
				<div class="field greySelect"><?php echo $form['cantidad'] ?></div>
			</div>
			
			<div class="button">
				<input type="submit" value="" class="sprite"/>
			</div>
			
			<div class="no-gracias">
				<a>No, gracias</a>
			</div>
			
		</form>
	
	</div>		
	<?php endif; ?>
	
</div>


<div class="sprite agotado"></div>