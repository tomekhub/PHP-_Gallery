<?php
require 'GalleryContent.php';
$gallery = new GalleryContent();
$gallery->setPath('photos', 'photos/thumbs');
$photos = $gallery->getPhotos(); 
$link = 'photo.php?obraz=';
?>
<!DOCTYPE HTML> 
<html lang='pl'> 
<head>
	<meta charset='utf-8'>
	<title>Galeria</title>
	<link rel='stylesheet' href='gallery.css'>
	<link href="https://fonts.googleapis.com/css?family=Anton|Ubuntu" rel="stylesheet"> 
</head>
<body>

		<div class="gallery_container">
			<form action="PhotoUpload.php" method="post" enctype="multipart/form-data">
			<p>Prześlij Zdjęcia</p>
		    <input type="file" id="file" name="files[]" multiple="multiple"  />
		  	<input type="submit" value="Prześlij!" />
			</form>
				<?php if($photos): ?>
					<div class="gallery">
						<?php foreach($photos as $photo): ?>
							<div class="gallery_item">						
								<a href="<?php echo $link . $photo['photo']?>"><img src="<?php echo $gallery->thumb_path ."/". $photo['photo']?>"></a>
								<p class="photo_title">Tytuł: <?php
								$str = $photo['photo'];
								if (strlen($str) > 10)
   									$str = substr($str, 0, 7) . '...';
   								echo $str;?></p>
								<p class="photo_date"> </p>
								
							</div>
						<?php endforeach; ?>
					</div>
				<?php else: ?>
					<p>Brak zdjęć</p>
				<?php endif; ?>
		</div>

</body>
</html>
