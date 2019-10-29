<?php
class Common {

    static public function imageResize($file, $width, $height)
    {
        $imageInfo = getimagesize($file);
        $imageWidth = $imageInfo[0];
        $imageHeight = $imageInfo[1];
        $imageType = $imageInfo[2];

        if ($imageType == IMAGETYPE_JPEG) {
            $image = imagecreatefromjpeg($file);
        } else if ($imageType == IMAGETYPE_GIF) {
            $image = imagecreatefromgif($file);
        } else if ($imageType == IMAGETYPE_PNG) {
            $image = imagecreatefrompng($file);
        } else {
            return FALSE;
        }

        if ((! is_null($width) && $imageWidth <= $width) || (is_null($height) && $imageHeight <= $height)) {
            return FALSE;
        } 
        
        if (! is_null($width) && $imageWidth >= $imageHeight) {
            $ratio = $width / $imageWidth;
        } else if (! is_null($height) && $imageWidth <= $imageHeight) {
            $ratio = $height / $imageHeight;
        } else {
            return FALSE;
        }

        $newWidth = round($imageWidth * $ratio);
        $newHeight = round($imageHeight * $ratio);

        $newImage = imagecreatetruecolor($newWidth, $newHeight);

        if ($imageType == IMAGETYPE_GIF || $imageType == IMAGETYPE_PNG) {
            imagesavealpha($newImage, true);
            $color = imagecolorallocatealpha($newImage, 0, 0, 0, 127);
            imagefill($newImage, 0, 0, $color);
        }

        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

        if($imageType == IMAGETYPE_JPEG) {
            imagejpeg($newImage, $file, 100);
        } elseif($imageType == IMAGETYPE_GIF) {
            imagegif($newImage, $file);         
        } elseif($imageType == IMAGETYPE_PNG) {
            imagepng($newImage, $file);
        }

        return TRUE;
    }

}
