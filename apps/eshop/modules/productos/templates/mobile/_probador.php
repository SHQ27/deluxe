 <div id="probadorOnline" class="<?php echo $idProductoGenero?> hide">

    <script>
	    var talleSetJson = <?php echo html_entity_decode($talleSetJson); ?>;
	    var zonasJson = <?php echo html_entity_decode($zonasJson); ?>;
	    var medidasUsuarioJson = <?php echo html_entity_decode($medidasUsuarioJson); ?>;        	    
	</script>

	<div class="titulo MS-24 alignC">PROBADOR ONLINE</div>
	<div class="linea"><div class="triangulos"></div></div>
    
	<div class="detalle">
		
		<div class="texto OS-11 bold color8 alignC lh18">
			Estas dentro de nuestra sección de probador online. Ingresa tus<br /> medidas para conocer tu talle.
		</div>
    
    
        <div class="paso-1">
            
            
			<div class="izquierda inline">
				<div class="cuerpo alignC">
				    <?php if ( $idProductoGenero == productoGenero::HOMBRE ): ?>
				    <div id="i_pecho" class="indice MS-9 bold color7">PECHO</div>
				    <?php else: ?>
				    <div id="i_busto" class="indice MS-9 bold color7">BUSTO</div>
				    <?php endif; ?>
					
					<div id="i_cintura" class="indice MS-9 bold color7">CINTURA</div>
					<div id="i_cadera" class="indice MS-9 bold color7">CADERA</div>
				</div>
			</div>
			
			<div class="derecha inline">
				<div class="MS-13 color4 lh16">
				    INGRESÁ
				    <br />
					TUS MEDIDAS.
				</div>
				<div class="medidas">
				    <?php foreach($talleZonas as $talleZona): ?>
					<div class="zona campo MS-13 color4" rel="<?php echo $talleZona->getIdTalleZona(); ?>">
					    <?php echo $talleZona->getDenominacion(); ?>
						<input id="spinner_<?php echo $talleZona->getIdTalleZona(); ?>" disabled="disabled" />
					</div>
					<?php endforeach; ?>
				</div>
				
				<div class="btOscuro MS-15 bold color7 button">CALCULAR</div>
				
				<div class="info OS-11 color4 lh16 detalleProbador">
					<span class="raya"></span>
                    <?php $first = true; ?>
                    <?php foreach($talleZonas as $talleZona): ?>
                    <div class="itemDetalleProbador detalleProbador_<?php echo $talleZona->getIdTalleZona(); ?> <?php echo ($first)? 'show' : 'hide'; ?> ">
                        <?php echo $talleZona->getDescripcion(ESC_RAW); ?>
                    </div>
                    <?php $first = false; ?>
                    <?php endforeach; ?>
				</div>
			</div>

        
        </div>
        
        <div class="paso-2 hide">
            
			<div class="izquierda inline">
				<div class="cuerpo alignC">
				</div>
			</div>

			<div class="derecha inline">
				<div class="MS-13 color4 lh16" style="margin-top: 60px;">
				    TU TALLE
				    <br />
					SUGERIDO ES
				</div>
				<div class="talle MS-39 color4"></div>
				
				<div class="info OS-11 color4 lh16">
					<span class="raya"></span>
					El talle sugerido se calcula en<br />base a las medidas que vos<br />proporcionaste.
				</div>
			</div>
                
        </div>
                
	</div>
</div>