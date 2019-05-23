<!doctype>
<html?
	<head>
		<title>asdfasdf</title>
		<style>
			.upload-wrapper {
				width: 300px;
				margin-left:auto;
				margin-right:auto;
				background: #FFE4EF;
				height: 50px;
				border:2px dashed #FF69A5;
				boder-radius:10px;
				overflow:hidden:
				margin-top:10px;
				
			}
			.upload-wrapper .upload-click {
				text-align: center;
				margin-top:15px;
			}
			.upload-wrapper #input-file-upload {
				display:none;
			}			
			.upload-wrapper .upload-image {
				text-align: center;
				padding:5px;
				margin-top:15px;
				display:none;
			}
			h1{
				text-align:center;
				color:#CECECE;
			}
			#server-response {
				text-align:center;
				margin-top:10px
			}
			.error {
				color:#F0O;
			}
		</style>
		<script type="text/javascript" src="js/jquery-1.11.1min.js"></script>
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
	<body>
		<h1>asdfasdf</h1>
		<div class="upload-wrapper">
			<div class="upload-click">Click para subir foto</div>
			<div class="upload-image" style="display:none;">
				<img src="images/ajax-loader.gif" style="width:16px; height:16px;">
			</div>
			<input type="file" id="input-file-upload" style="display:none;">
		</div>
		<div id="server-response"></div
	</body>
</html>