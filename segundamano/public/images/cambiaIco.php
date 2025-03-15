<?php

$src_img = new Imagick("src_img.png");
$icon = new Imagick();
$icon->setFormat("ico");

$geo=$src_img->getImageGeometry();

$size_w=$geo['width'];
$size_h=$geo['height'];

if (128/$size_w*$size_h>128) {
	$src_img->scaleImage(128,0);
} else {
	$src_img->scaleImage(0,128);
}

$src_img->cropImage(128, 128, 0, 0);

$clone = $src_img->clone();
$clone->scaleImage(16,0);
$icon->addImage($clone);

$clone = $src_img->clone();
$clone->scaleImage(32,0);
$icon->addImage($clone);

$clone = $src_img->clone();
$clone->scaleImage(64,0);
$icon->addImage($clone);

$clone = $src_img->clone();
$clone->scaleImage(128,0);
$icon->addImage($clone);

$icon->writeImages("favicon.ico", true);

$src_img->destroy();
$icon->destroy();
$clone->destroy();

?>