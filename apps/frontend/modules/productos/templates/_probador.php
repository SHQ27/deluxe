<div id="probadorOnline" class="<?php echo $idProductoGenero?> hide">

	<script>
	    var talleSetJson = <?php echo html_entity_decode($talleSetJson); ?>;
	    var zonasJson = <?php echo html_entity_decode($zonasJson); ?>;
	    var medidasUsuarioJson = <?php echo html_entity_decode($medidasUsuarioJson); ?>;        	    
	</script>

    <div class="title">
        <span class="sprite ico-probador"></span>
        <h2>Probador online</h2>
    </div>
    
        <p class="topText">
            Estas dentro de nuestra sección <strong>probador online</strong>. Ingresá tus<br />medidas para conocer tu talle.
        </p>
            	
        <div class="paso-1">
            
            <div class="boxLeft">
                <div class="sprite2 silueta">
                    <div class="indicador"></div>
                </div>
            </div>
            <div class="boxRight">
            
                <p class="selecciona">Ingresá tus medidas:</p>
            
                <?php foreach($talleZonas as $talleZona): ?>
                <div class="zona" rel="<?php echo $talleZona->getIdTalleZona(); ?>">
                    <label for="spinner_<?php echo $talleZona->getIdTalleZona(); ?>"><?php echo $talleZona->getDenominacion(); ?>:</label>
                    <input id="spinner_<?php echo $talleZona->getIdTalleZona(); ?>" disabled="disabled" />
                </div>
                <?php endforeach; ?>
                
                <a class="sprite button"></a>
                
                <div class="detalleProbador">
                    <?php $first = true; ?>
                    <?php foreach($talleZonas as $talleZona): ?>
                    <p class="itemDetalleProbador detalleProbador_<?php echo $talleZona->getIdTalleZona(); ?> <?php echo ($first)? 'show' : 'hide'; ?> ">
                        <?php echo $talleZona->getDescripcion(ESC_RAW); ?>
                    </p>
                    <?php $first = false; ?>
                    <?php endforeach; ?>
                </div>
                
            </div>
        
        </div>
        
        <div class="paso-2 hide">
            
            <div class="boxLeft">
                <div class="sprite2 silueta">
                </div>
            </div>
            
            <div class="boxRight">
                
                    <p class="talleEs">
                        Tu talle sugerido es
                    </p>
                    
                    <p class="talle"></p>
                    
                    <p class="aclaracion">
                        <span class="sprite icon-estrella"></span>
                        El talle sugerido se calcula en base a las medidas que vos proporcionaste y la guia de talles correspondiente a cada marca
                    </p>
            </div>            
        </div>
    </div>
</div>