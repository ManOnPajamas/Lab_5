<?php
require_once 'producto.entidad.php';
require_once 'producto.model.php';

// Logica
$alm = new Producto();
$model = new ProductoModel();

if(isset($_REQUEST['action']))
{

	switch($_REQUEST['action'])
	{
		case 'actualizar':
			$alm->__SET('id',              $_REQUEST['id']);
			$alm->__SET('descripcion',          $_REQUEST['descripcion']);
			$alm->__SET('precio',        $_REQUEST['precio']);
			$alm->__SET('stock',        $_REQUEST['stock']);
			$alm->__SET('imagen',        $_REQUEST['imagen']);

			$model->Actualizar($alm);
			header('Location: producto.php');
			break;

		case 'registrar':
			$alm->__SET('id',              $_REQUEST['codigo']);
			$alm->__SET('descripcion',          $_REQUEST['descripcion']);
			$alm->__SET('precio',        $_REQUEST['precio']);
			$alm->__SET('stock',        $_REQUEST['stock']);
			$alm->__SET('imagen',        $_REQUEST['imagen']);

			$model->Registrar($alm);
			header('Location: producto.php');
			break;

		case 'eliminar':
			$model->Eliminar($_REQUEST['id']);
			header('Location: producto.php');
			break;

		case 'editar':
			$alm = $model->Obtener($_REQUEST['codigo']);
			break;
	}
}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Producto</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
	</head>
    <body style="padding:15px;">

        <div class="pure-g">
            <div class="pure-u-1-12">
                
                <form action="?action=<?php echo $alm->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" class="pure-form pure-form-stacked" style="margin-bottom:30px;">
                    <input type="hidden" name="id" value="<?php echo $alm->__GET('id'); ?>" />
                    
                    <table style="width:500px;">
                    	<tr>
                            <th style="text-align:left;">Id</th>
                            <td><input type="text" name="id" value="<?php echo $alm->__GET('id'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Descripcion</th>
                            <td><input type="text" name="descripcion" value="<?php echo $alm->__GET('descripcion'); ?>" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <th style="text-align:left;">Precio</th>
                            <td><input type="text" name="precio" value="<?php echo $alm->__GET('precio'); ?>" style="width:100%;" /></td>
                        </tr>
						<tr>
                            <th style="text-align:left;">Stock</th>
                            <td><input type="text" name="stock" value="<?php echo $alm->__GET('stock'); ?>" style="width:100%;" /></td>
                        </tr>
						<tr>
                            <th style="text-align:left;">Imagen</th>
                            <td><input type="text" name="imagen" value="<?php echo $alm->__GET('imagen'); ?>" style="width:100%;" /></td>
                        </tr>
                        
                    
                        <tr>
                            <td colspan="2">
                                <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                            </td>
                        </tr>
                    </table>
                </form>

                <table class="pure-table pure-table-horizontal">
                    <thead>
                        <tr>
                            <th style="text-align:left;">Id</th>
                            <th style="text-align:left;">Descripcion</th>
                            <th style="text-align:left;">Precio</th>
							<th style="text-align:left;">Stock</th>
							<th style="text-align:left;">Imagen</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <?php foreach($model->Listar() as $r): ?>
                        <tr>
                            <td><?php echo $r->__GET('id'); ?></td>
                            <td><?php echo $r->__GET('descripcion'); ?></td>
                            <td><?php echo $r->__GET('precio'); ?></td>
							<td><?php echo $r->__GET('stock'); ?></td>
							<td><?php echo $r->__GET('imagen'); ?></td>
                            <td>
                                <a href="?action=editar&codigo=<?php echo $r->id; ?>">Editar</a>
                            </td>
                            <td>
                                <a href="?action=eliminar&codigo=<?php echo $r->id; ?>">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>     
              
            </div>
        </div>

    </body>
</html>