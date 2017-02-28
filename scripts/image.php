<?php //
    header('Content-type: image/jpeg');
    list($width,$height)=  getimagesize('../drawable/'.$_GET['src']);
    $newwidth=$_GET['w'];
    $newheight=$height*$newwidth/$width;
    $image_p = imagecreatetruecolor($newwidth,$newheight);
    $image = imagecreatefromjpeg('../drawable/'.$_GET['src']);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0,$newwidth,$newheight,$width,$height);
    echo imagejpeg($image_p,null,$_GET['q']);

?>