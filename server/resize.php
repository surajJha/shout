<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 13/1/15
 * Time: 1:25 PM
 */
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
class ScaleImage
{
    // ATTRIBUTES
    var $image;
    var $imageData = array();
    var $lastError;
    var $debugLevel;  // 0 = no user_error, 1 = warning, 2 = error

    // METHODS

    /*
       void ScaleImage([int debug_level])
       constructor
    */
    function ScaleImage($image, $maxWidth, $maxHeight, $debugLevel = 0)
    {
        $this->debugLevel = $debugLevel;
        if($this->setImageData($image))
        {
            if($this->calcRatio($maxWidth, $maxHeight))
            {
                $this->displayImage();
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
                $this->error("ScaleImage::setImageData(): not a valid image file");
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
            $this->error("ScaleImage::setImageData() - file not found");
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
                $this->error("setMaxWidth(): max width or max height is < 1");
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
                    $this->error("ScaleImage::calcRatio() - invalid source image size");
                    $result = FALSE;
                }
            }
        }
        else
        {
            $this->error("setMaxWidth(): max width or height is not numeric");
            $result = FALSE;
        }
        return($result);
    }  // end calcRatio()

    /*
       bool displayImage();
    */
    function displayImage()
    {
        $result = TRUE;
        $width = (INT) round($this->ratio * $this->imageData[0]);
        $height = (INT) round($this->ratio * $this->imageData[1]);
        if($width < 1 or $height < 1)
        {
            $this->error("ScaleImage::displayImage() - new width or height < 1");
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
                    $this->error("invalid mime type");
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
                            ob_start();
                             imagejpeg($newImage,'', 100);
                            echo "data:image/jpeg;base64,".base64_encode(ob_get_clean());
                            ob_flush();


                            break;
                        case "image/png":
                            ob_start();
                            imagejpeg($newImage,'', 100);
                            echo "data:image/jpeg;base64,".base64_encode(ob_get_clean());
                            ob_flush();
                            break;
                        case "image/gif":
                            ob_start();
                            imagejpeg($newImage,'', 100);
                            echo "data:image/jpeg;base64,".base64_encode(ob_get_clean());
                            ob_flush();
                            break;
                        default:
                            $this->error("ScaleImage::calcRatio() - invalid mime type");
                            $result = FALSE;
                    }
                }
                else
                {
                    $this->error("ScaleImage::calcRatio() - copy failed");
                    $result = FALSE;
                }
            }
            else
            {
                $this->error("ScaleImage::calcRatio() - create new image failed");
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

}  // end class ScaleImage

// SAMPLE USAGE:

$imageFile = $_GET['imgpath'];
$image = new ScaleImage($imageFile, 200, 200, 1);
