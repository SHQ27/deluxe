	<div class="filtro inline <?php echo $filterId ?>">
 
	        
        <div id="actual" class="actual">
    		<div class="titulo MS-13 bold lh16">FILTRAR&nbsp;<br />POR /</div>
            <div class="items"></div>
            <a id="btLimpiar" class="bt OS-11 color4 bold">Eliminar filtros</a>
        </div>
    	    		
    	<div class="acordion">
    
    	    <?php if ( $showFilter ): ?>  
    	    <?php foreach ($collector as $name => $columnList): ?>
    		<div class="titulo MS-13 bold lh16 titulo-<?php echo $name; ?>"><?php echo $name ?></div>
    		<div class="contenido <?php echo $name; ?>">
    			<div class="elementos">
    			
    				<?php foreach ($columnList as $col => $list): ?>
    				<?php foreach ($list as $item): ?>
    				<?php if (is_string($item)) :?>
    				<h2 class="MS"><?php echo $item ?></h2> 
    				<?php else: ?>
    				<div class="elemento OS-11 color4" data-name="<?php echo $name; ?>" data-value="<?php echo $item['id']; ?>" title="<?php echo $item['value'] ?>">
                        <?php if ($name == 'colores'): ?>
        				<img src="<?php echo $item['img']; ?>" title="<?php echo $item['value']; ?>">
                        <?php else: ?>
                        <?php echo truncate_text( $item['value'], 15 ); ?>
                        <?php endif; ?>
    			   </div>
    				<?php endif; ?>
    				<?php endforeach; ?>			
    				<?php endforeach; ?>
    			</div>
    		</div>
    		<?php endforeach; ?>
            <?php endif; ?>
    		
    		<?php  if ( $rangeMin != $rangeMax ): ?>
    		<div class="titulo MS-13 bold lh16 titulo-precio">PRECIO</div>
    		<div class="contenido precio">
    			<div id="slider-range"></div>
    			<p id="amount">
    				<span class="min OS-11 color4"></span>
    				<span class="max OS-11 color4"></span>
    			</p>						
    		</div>
            <?php endif; ?>			
    		
    	</div>
        
        
	</div>

    <script>

    $(document).ready(function() { new filtro( [ <?php echo $rangeMin ?> , <?php echo $rangeMax ?> , <?php echo $rangeSettedMin ?> , <?php echo $rangeSettedMax ?> ] ); });
    </script>
	