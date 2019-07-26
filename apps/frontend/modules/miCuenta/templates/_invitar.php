                    <h2>INVITAR AMIGOS</h2>
                    
                    <p><span><strong>INVITANDO A TUS AMIGOS TENÉS BENEFICIOS.</strong></span></p>
                                        
                	<p>
                	    Por cada amigo que invites y realice su primera compra en Deluxebuys <span><strong>&nbsp;RECIBIRÁS $15&nbsp;</strong></span> para utilizar en tus próximas operaciones.
				    </p>
    			
                    <p>Escribí el mail de los amigos que querés invitar:</p>
                                            
					<form action="<?php echo url_for('mi_cuenta_invitar_amigos')?>" method="post">
					
					    <?php echo $invitacionRapidaForm['_csrf_token'] ?>
						
                        <?php  for ($i = 0 ; $i < InvitacionRapidaForm::TOTAL_INPUTS ; $i++ ): ?>
                        <div class="row">
                            <?php echo $invitacionRapidaForm['emails'][$i]; ?>
                            <div class="message error"><?php echo $invitacionRapidaForm['emails'][$i]->getError() ?></div>
                        </div>
                        <?php endfor; ?>
                        
                        <input type="submit" value="INVITAR" class="formInputButton">
                    </form>