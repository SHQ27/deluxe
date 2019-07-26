    			<div class="titulo MS-23"><?php echo $eshop->getTextoCarroDeCompras(); ?></div>
    			
                <div class="pasos MS-13 color6 ">
        			<div id="paso1" class="paso <?php echo ( $paso == 1 ) ? 'color8 ' : ''; ?> inline">
        				<span class="MS-39 color7">1</span>
        				<?php echo strtoupper( $eshop->getMiCarroTitulo() ); ?>
        			</div><div id="paso2" class="paso <?php echo ( $paso == 2 ) ? 'color8 ' : ''; ?> inline">
        				<span class="MS-39 color7">2</span>
        				<div class="">ENVIO</div>
        			</div><div id="paso3" class="paso <?php echo ( $paso == 3 ) ? 'color8 ' : ''; ?> inline">
        				<span class="MS-39 color7">3</span>
        				PAGO
        			</div>
        		</div>