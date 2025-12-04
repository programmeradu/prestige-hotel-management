<?php
// Script to generate placeholder logo image
$width = 200;
$height = 50;
$image = imagecreatetruecolor($width, $height);
$bg = imagecolorallocate($image, 240, 240, 240);
$textcolor = imagecolorallocate($image, 100, 100, 100);
imagefill($image, 0, 0, $bg);
imagestring($image, 5, ($width/2)-50, ($height/2)-8, 'Payment Logo', $textcolor);
$filepath = __DIR__ . '/views/img/placeholder_logo.png';
if (!is_dir(dirname($filepath))) {
    mkdir(dirname($filepath), 0755, true);
}
imagepng($image, $filepath);
imagedestroy($image);
echo "Placeholder image created at: $filepath\n";
