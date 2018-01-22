<?php
$valid_formats = array("jpg", "jpeg", "png", "gif", "bmp");
$max_file_size = 1024 * 1024 * 5; // 1024KB * 1024KB * 5 -> 1MB * 5
$server_root = $_SERVER['DOCUMENT_ROOT'];// ścieżka głównego folderu
$path = $server_root.'test/photos/'; // ścieżka do folderu ze zdjęciami
$count = 0; //licznik przesłanych zdjęć

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
    // pętla z $_FILES do wgrania wszystkich zdjęć na serwer
    foreach ($_FILES['files']['name'] as $f => $name) {     
        if ($_FILES['files']['error'][$f] == 4) {
            continue; // Pominięcie dalszych instrukcji w pętli po napotkaniu błędu
                      //UPLOAD_ERR_NO_FILE -> (No file was uploaded)
        }          
        if ($_FILES['files']['error'][$f] == 0)//UPLOAD_ERR_OK -> (the file uploaded with success) 
        {
            if ($_FILES['files']['size'][$f] > $max_file_size) {
                $message[] = "$name is too large!.";
                continue; // Pominięcie za dużych zdjęć 
            }
            elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
                $message[] = "$name is not a valid format";
                continue; // Pominięcie plików, które nie są zdjęciami
            }
            else{ // zdjęcie spełnia wszystkie warunki, przeniesienie z TMP do wybranego folderu 
                if(move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path.$name))
                resizeThumb($name, $path);
                $count++; // zwiekszenie licznika przesłanych zdjęć po każdym obiegu pętli(po każdym pomyśnie dodanym zdjęciu) 
            }
        }
    }
    header('Location: index.php'); //Przejście do folderu ze zdjęciami(odświeżenie strony)
}
// File and new size
function resizeThumb($fname, $path){
	$filename = $fname;
	$path_photo = $path;
	$path_thumb = $_SERVER['DOCUMENT_ROOT'].'/photos/thumbs/';
	$thumb_width = 125.867; // optymalny rozmiar miniatury
	$thumb_height = 94.4;
	list($width, $height) = getimagesize($path.$filename);
	if($height/$width == 0.75)
	{
		$newwidth = $thumb_width;
		$newheight = $thumb_height;

	}else if($height/$width > 0.75)
	{
		$newheight = $thumb_height;
		$newwidth = $width / ($height / $newheight);
	}
	else
	{
		$newwidth = $thumb_width;
		$newheight = $height / ($width / $newwidth);
	}

	// Load
	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	$gray = imagecolorallocate($thumb, 192,192,192);
	imagefilledrectangle($thumb,0,0,$thumb_width,$thumb_height,$gray);
	$source = imagecreatefromjpeg($path_photo.$filename);

	// Resize
	//bool imagecopyresized ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresampled($thumb, $source, ($thumb_width - $newwidth)/2, ($thumb_height - $newheight)/2, 0, 0, $newwidth, $newheight, $width, $height);

	// Output
	imagejpeg($thumb, $path_thumb.$filename);
	imagedestroy($thumb);
}
?>
