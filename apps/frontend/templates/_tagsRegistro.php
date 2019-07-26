<script type="text/javascript">
	ga('send', 'pageview', '/usuario/registro-ok');
</script>

<?php $usuario = $sf_user->getCurrentUser();?>
<?php if ( $usuario ): ?>
<img src="http://my.pampanetwork.com/scripts/sale.php?AccountId=6c1caa45&TotalCost=0&OrderID=<?php echo $usuario->getIdUsuario(); ?>&ProductID=deluxe&ActionCode=lead" width="1" height="1" >
<?php endif; ?>