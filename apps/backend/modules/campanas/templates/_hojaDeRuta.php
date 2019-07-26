<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  	<title>Hoja de Ruta</title>

	<style>

		body { margin: 0 20px 0 20px; }

		p, h1, h2 { font-family: arial; }

		h1 { margin: 20px 0 20px 0; }

		p { 
		    -webkit-column-count: 3;
		    -moz-column-count: 3;
		    column-count: 3;
		}

		.recepcionadas {
			text-decoration: line-through;
		}

	</style>
 
	</head>
	<body>

		<h1>Hoja de Ruta del día <?php echo date('d/m/Y'); ?></h1>

		<?php foreach ($data as $row): ?>
		<?php $dataCampana = $row['dataCampana']; ?>
		<h2>
			<?php echo $row['campana']; ?>
			<small>( Del <?php echo $row['desde']; ?> al <?php echo $row['hasta']; ?>)</small>
		</h2>
		<p>
		<?php foreach ($dataCampana['no-recepcionadas'] as $marca): ?>
			<strong><?php echo $marca; ?></strong><br />
		<?php endforeach; ?>
		<?php foreach ($dataCampana['recepcionadas'] as $marca): ?>
			<span class="recepcionadas"><?php echo $marca; ?></span><br />
		<?php endforeach; ?>
		</p>
		<?php endforeach; ?>

	</body>
</html>
