<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Mantenimientos</title>
        <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
		<script type="text/javascript">

			$(function() {
			
				$('.upload-click').click(function() {
					$('#input-file-upload').trigger('click');
				});
				
				$('#input-file-upload).change(function() {
				
					if (!window.File || !window.FileReader || !window.Blob) {
						window.alert("No se puede subir la imagen.");
						return;
					}
					
					var fileReader = new FileReader();
					
					
					var filter = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
					
					if (this.files.length == 0) {
						window.alert("Selecciona una imagen";
						return;
					}
					
					var file = this.files[0];
					var size = file.size;
					var type = file.type;
					
					if (!filter.test(type)) {
						window.alert("Tipo de archivo invalido");
						return;
					}
					
					var max = 2000000;
					
					if (size>max) {
						window.alert("Archivo muy pesado, maximo es 2Mb");
						return;
					}
					
					$('.upload-image').show();
					
					$('.upload-click').hide();
					
					var formData = new FormData();
					formData.append('image_data',file);
					
					$.ajax({
						type:'POST',
						precessData: false,
						contentType: false,
						url: 'upload_resize.php',
						data: formData,
						dataType: 'json',
						success: function(response) {
							$('.upload-image').hide();
							
							$('.upload-click').show();
							
							if (response.type == 'success') {
								$("#server-response").html('<div class="success">' + response.msg + '</div>');
							} else {
								$("#server-response").html('<div class="error">' + response.msg + '</div>');
							}
						}		
							
					});	
								
				});
			});
</script>
	</head>
    <body style="padding:15px;">

<div>
    <a href="alumno.php">Alumnos</a>
</div>

<div>
<a href="usuario.php">usuarios</a>
</div>

<div>
<a href="curso.php">curso</a>
</div>
              
<div>
<a href="usuario.php">USER</a>
</div>
<div class="upload-box">
	<label for="image-file">Upload file</label>
	<input type="file" name="image-file" id="image-file" accept="image/*" />
	<div id="server-results"></div>
</div>
<div class="upload-wrapper">
	<div class="upload-click">Click para subir foto</div>
	<div class="upload-image" style="display:none;">
		<img src="images/ajax-loader.gif" style="width:16px; height:16px;">
	</div>
	<input type="file" id="input-file-upload" style="display:none;">
</div>
<div id="server-response"></div>

    </body>
</html>



