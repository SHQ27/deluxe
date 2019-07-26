<div id="sf_admin_container">
    <h1>Borrar Cache</h1>
    
    <h2>Listados</h2>
    
    <p>
        <?php if ($borrar && $type == 'listados'): ?>
        La cache se ha borrado exitosamente, podes verificar el resultado ingresando<br/>
        en <a href="http://www.deluxebuys.com">http://www.deluxebuys.com</a>
        <?php else: ?>
        Esta cache se elimina automaticamente en el minuto 0 (cero) de cada hora y cuando empieza o finaliza una campaña.
        <br/><br/>
        No es conveniente abusar del borrado de la misma, ya que eso sobrexige la carga en los servidores.
        <br/><br/>
        Recordá los momentos de borrado automatico para evitar borrar cache 5 min antes de un borrado automatico.
        <br/><br/>
        <a href="/backend/cache?type=listados&borrar=true">Hace click aqui si aún queres borrar esta cache</a>
        <?php endif; ?>
    </p>

</div>