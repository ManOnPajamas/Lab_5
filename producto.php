<?php
require_once 'producto.entidad.php';
require_once 'producto.model.php';

 $db = mysqli_connect("localhost", "root", "", "image_upload");
 $msg="";

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
if (isset($_POST['upload'])) {
  	// Get image name
  	$image = $_FILES['image']['name'];
  	// Get text
  	$image_text = mysqli_real_escape_string($db, $_POST['image_text']);

  	// image file directory
  	$target = "images/".basename($image);

  	$sql = "INSERT INTO images (image, image_text) VALUES ('$image', '$image_text')";
  	// execute query
  	mysqli_query($db, $sql);

  	if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  		$msg = "Image uploaded successfully";
  	}else{
  		$msg = "Failed to upload image";
  	}
  }
  $result = mysqli_query($db, "SELECT * FROM images");

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Producto</title>
		<style type="text/css">
			   #content{
				width: 50%;
				margin: 20px auto;
				border: 1px solid #cbcbcb;
			   }
			   form{
				width: 50%;
				margin: 20px auto;
			   }
			   form div{
				margin-top: 5px;
			   }
			   #img_div{
				width: 80%;
				padding: 5px;
				margin: 15px auto;
				border: 1px solid #cbcbcb;
			   }
			   #img_div:after{
				content: "";
				display: block;
				clear: both;
			   }
			   img{
				float: left;
				margin: 5px;
				width: 300px;
				height: 140px;
			   }
</style>
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
		
		<div id="content">
		  <?php
			while ($row = mysqli_fetch_array($result)) {
			  echo "<div id='img_div'>";
				echo "<img src='images/".$row['image']."' >";
				echo "<p>".$row['image_text']."</p>";
			  echo "</div>";
			}
		  ?>
		  <form method="POST" action="index.php" enctype="multipart/form-data">
			<input type="hidden" name="size" value="1000000">
			<div>
			  <input type="file" name="image">
			</div>
			<div>
			  <textarea 
				id="text" 
				cols="40" 
				rows="4" 
				name="image_text" 
				placeholder="Say something about this image..."></textarea>
			</div>
			<div>
				<button type="submit" name="upload">POST</button>
			</div>
		  </form>
		</div>

    </body>
</html>