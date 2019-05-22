<?php
	
	$upload_dir = "/www/imagemagick/uploads/";
	$upload_dir_url = "http://localhost/imagemagick/uploads/";
	$image_height = 200;
	$image_width = 200;
	
	if (isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
	
		if (!isset($_FILES['image_data']) || !is_uploaded_file($_FILES['image_data']['tmp_name'])) {
		
			$response = json_encode(array(
				'type' => 'error',
				'msg' => 'No hay archivo'
			));
		}
		
		$image_size_info = getimagesize($_FILES['image_data']['tmp_name']);
		
		if ($image_size_info) {
			$image_type = $image_size_info['mime'];
		} else {
			$response = json_encode(array(
				'type' => 'error',
				'msg' => 'Archivo invalido'
			));
		}
		
		$image = new Imagick($_FILES['image_data']['tmp_name']);
		
		if ($image_type == "image/gif") {
			$image = $image->coalesceImages();
			foreach ($image as $frame) {
				$frame->resizeImage($image_height,$image_width, Imagick::FILTER_LANCZOS, 1,TRUE);
			}
		} else {
			$image->resizeImage($image_height,$image_width, Imagick::FILTER_LANCZOS, 1,TRUE);
		}
		
		$results = $image->writeImages($upload_dir . $_FILES['image_data']['name'], true);
		
		if ($results) {
			$response = json_encode(array(
				'type' => 'success',
				'msg => 'Imagen subida' <br> <img src="'. $upload_dir_url . $_FILES['image_data']['name'] . '">')
			));
			die($response);
		}
		
	}
?>