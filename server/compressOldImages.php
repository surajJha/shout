<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 16/7/15
 * Time: 11:56 AM
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'resizeTemp.php';
class CompressOldImages{

    var $image;
    var $imageData = array();
    var $lastError;
    var $debugLevel;
    var $ratio;
    public function __construct(){

    }

    public function compress(){
        $path = 'client_images';
        $files = array_values(array_filter(scandir($path), function($file) {
            return !is_dir($file);
        }));

        foreach($files as $file){
            $destination = 'temp_images/'.$file;
            $file = 'client_images/'.$file;
//            echo $destination."<br>";
//            echo $file."<br>";
            $this->ScaleImage($file, $destination, 350, 280, 1);

        }

    }

    function ScaleImage($image, $destination, $maxWidth, $maxHeight, $debugLevel = 0)
    {
        $this->debugLevel = $debugLevel;
        if($this->setImageData($image))
        {
            if($this->calcRatio($maxWidth, $maxHeight))
            {
                $this->displayImage($destination);
            }
        }
    }  // end constructor

    /*
       bool setImageData(str image)
    */
    function setImageData($image)
    {
        $result = TRUE;
        if(is_readable($image))
        {
            $imageData = @getimagesize($image);
            if($imageData == FALSE)
            {
                echo "ScaleImage::setImageData(): not a valid image file";
                $result = FALSE;
            }
            else
            {
                $this->image = $image;
                $this->imageData = $imageData;
            }
        }
        else
        {
            echo "ScaleImage::setImageData() - file not found";
            $result = FALSE;
        }
        return($result);
    }  // end setImageData


    /*
       bool calcRatio(int pixel_width, int pixel_height)
    */
    function calcRatio($maxWidth, $maxHeight)
    {
        $result = TRUE;
        if(is_numeric($maxWidth) and is_numeric($maxHeight))
        {
            $maxWidth = (INT) round($maxWidth);
            $maxHeight = (INT) round($maxHeight);
            if($maxWidth < 1 or $maxHeight < 1)
            {
                echo "setMaxWidth(): max width or max height is < 1";
                $result = FALSE;
            }
            else
            {
                if(!empty($this->imageData[0]) and !empty($this->imageData[1]))
                {
                    $this->ratio = min($maxWidth / $this->imageData[0],
                        $maxHeight / $this->imageData[1],
                        1);
                }
                else
                {
                    echo "ScaleImage::calcRatio() - invalid source image size";
                    $result = FALSE;
                }
            }
        }
        else
        {
            echo "setMaxWidth(): max width or height is not numeric";
            $result = FALSE;
        }
        return($result);
    }  // end calcRatio()

    /*
       bool displayImage();
    */
    function displayImage($destination)
    {
        $result = TRUE;
        $width = (INT) round($this->ratio * $this->imageData[0]);
        $height = (INT) round($this->ratio * $this->imageData[1]);
        if($width < 1 or $height < 1)
        {
            echo "ScaleImage::displayImage() - new width or height < 1";
            $result = FALSE;
        }
        else
        {
            $newImage = imagecreatetruecolor($width, $height);
            switch($this->imageData['mime'])
            {
                case "image/jpeg":
                    $oldImage = @imagecreatefromjpeg($this->image);
                    break;
                case "image/png":
                    $oldImage = @imagecreatefrompng($this->image);
                    break;
                case "image/gif":
                    $oldImage = @imagecreatefromgif($this->image);
                    break;
                default:
                    echo "invalid mime type";
                    $result = FALSE;
            }
            if($oldImage != FALSE)
            {
                if(imagecopyresampled($newImage, $oldImage, 0, 0, 0, 0, $width, $height,
                    $this->imageData[0], $this->imageData[1]))
                {
                    header("Content-Type: " . $this->imageData['mime']);

                    switch($this->imageData['mime'])
                    {
                        case "image/jpeg":
                            //ob_start();
                            try{
                                echo "jpeg";
                                imagejpeg($newImage,$destination, 100);
                            }
                            catch(Exception $e){
                                echo $e;
                            }
                            //  echo "data:image/jpeg;base64,".base64_encode(ob_get_clean());
                            //  ob_flush();


                            break;
                        case "image/png":
//                            ob_start();
                            imagejpeg($newImage,$destination, 100);
//                            echo "data:image/jpeg;base64,".base64_encode(ob_get_clean());
//                            ob_flush();
                            break;
                        case "image/gif":
//                            ob_start();
                            imagejpeg($newImage,$destination, 100);
//                            echo "data:image/jpeg;base64,".base64_encode(ob_get_clean());
//                            ob_flush();
                            break;
                        default:
                            echo "ScaleImage::calcRatio() - invalid mime type";
                            $result = FALSE;
                    }
                }
                else
                {
                    echo "ScaleImage::calcRatio() - copy failed";
                    $result = FALSE;
                }
            }
            else
            {
                echo "ScaleImage::calcRatio() - create new image failed";
                $result = FALSE;
            }
        }
    }  // end displayImage()

    /*
       void error(str error_message)
    */
    function error($msg)
    {
        $this->lastError = $msg;
        if($this->debugLevel)
        {
            $level = ($this->debugLevel == 2) ? E_USER_ERROR : E_USER_WARNING;
            user_error($msg, $level);
        }
    }  // end error()
}


$com = new CompressOldImages();
$com->compress();