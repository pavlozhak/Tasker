<?php
namespace libraries\FileUploadLib;

use libraries\ImageResizeLib as ImageResize;

class FileUploadLib
{
    private static $extensions = array("image/png", "image/jpg", "image/jpeg", "image/gif");

    public function __construct()
    {

    }

    public static function upload()
    {
        if(!empty($_FILES['file']))
        {
            if(in_array($_FILES['file']['type'], self::$extensions))
            {
                $source = $_FILES['file']['tmp_name'];
                $fileName = time().'_'.basename($_FILES["file"]["name"]);
                $targetPath = "images/".$fileName;
                move_uploaded_file($source, $targetPath);

                $imageResize = new ImageResize\ImageResizeLib();
                $imageResize->load($targetPath);
                $imageResize->resizeToWidth(320);
                $imageResize->save($targetPath);

                return "http://tasker.strangedev.pp.ua/".$targetPath;
            }
        }
    }
}