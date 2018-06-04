<?php
namespace libraries\ImageResizeLib;

class ImageResizeLib
{
    private $image;
    private $image_type;

    public function load($filename) {
        list(, , $this->image_type) = getimagesize($filename);
        switch ($this->image_type)
        {
            case IMAGETYPE_JPEG:
                $this->image = imagecreatefromjpeg($filename);
                break;
            case IMAGETYPE_GIF:
                $this->image = imagecreatefromgif($filename);
                break;
            case IMAGETYPE_PNG:
                $this->image = imagecreatefrompng($filename);
                break;
        }
    }

    public function save($filename, $compression=75) {
        switch ($this->image_type)
        {
            case IMAGETYPE_JPEG:
                imagejpeg($this->image,$filename,$compression);
                break;
            case IMAGETYPE_GIF:
                imagegif($this->image,$filename);
                break;
            case IMAGETYPE_PNG:
                imagepng($this->image,$filename);
                break;
        }
    }

    public function getWidth() {
        return imagesx($this->image);
    }

    public function getHeight() {
        return imagesy($this->image);
    }

    public function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getheight() * $ratio;
        $this->resize($width,$height);
    }

    public function resize($width,$height) {
        $new_image = imagecreatetruecolor($width, $height);
        imagecopyresampled($new_image, $this->image, 0, 0, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());
        $this->image = $new_image;
    }
}