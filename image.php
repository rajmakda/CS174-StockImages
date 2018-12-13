<?php
    // Written by Raj Makda SJSU ID: 010128222
  class Image {

    var $fileName;
    var $size;
    var $image;

    // Constructs a new object of the image class using the filename
    function __construct( $fileName ) {
        $this->fileName = $fileName;
        $this->image = $this->imagecreatefromfile($fileName);
        $this->size = getimagesize($fileName);
    }

    // Loads an image identifier for use with the php gd library based on the format of the image
    private function imagecreatefromfile( $fileName ) {
        if (!file_exists($fileName)) {
            throw new InvalidArgumentException('File "'.$fileName.'" not found.');
        }
        switch ( strtolower( pathinfo( $fileName, PATHINFO_EXTENSION ))) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($fileName);
            break;
            case 'png':
                return imagecreatefrompng($fileName);
            break;
            default:
                throw new InvalidArgumentException('File "'.$fileName.'" is not valid jpg or png image.');
            break;
        }
    }

    // Returns the gray color for pixel given a conversion method and rgb colors
    private function getGray($method, $r, $g, $b) {
        // Uses averaging 
        if ($method == 1) {
            return ($r + $g + $b)/3;
        // Uses lightness
        } else if ($method == 2) {
            return (max($r,$g,$b) + min($r,$b,$g))/2;
        // Uses luminous
        } else if ($method == 3){
            return 0.5*$r + 0.4*$g + 0.1*$b; 
        } else {
            return 0;
        }
    }

    // Converts an image to grayscale based on one of the methods. If $fileNameOut is not provided then it is self destructive.
    function grayscale( $method, $fileNameOut=null ) {
       if ($method > 3) return false;
        if (!$this->size) return false;
        $image = $this->image;
        if (!$image) return false;
        $im = imagecreatetruecolor($this->size[0],$this->size[1]);
        // Iterate through every pixel and set the gray color for the corresponding rgb color
        for ($i = 0; $i < $this->size[0];$i++) {
            for ($j = 0;$j < $this->size[1] ; $j++) {
                $rgb = imagecolorat($image, $i, $j);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;
                $gray = $this->getGray($method, $r, $g, $b);
                $color = imagecolorallocate($im, $gray, $gray, $gray);
                imagesetpixel($im, $i, $j, $color);
            }
        }
        if ($fileNameOut !== null) {
            $this->saveImage($fileNameOut,$im);
        } else {
            $this->image = $im;
            $this->saveImage(null,$im);
        }
        return true;
    }

    // Adds another image based on alpha composition to the image object. If $fileNameOut is not provided, it is self destructive.
    // If $under is false, an overlay takes place.
    function composite($foreground, $x, $y ,$fileNameOut=null,$under=true) {
        if ($under == true) {
            $foregroundSize = $foreground->size;
            $foregroundImage = $foreground->image;
            $backgroundImage = imagecreatetruecolor($this->size[0],$this->size[1]);
            imagecopy($backgroundImage, $this->image,0,0,0,0,$this->size[0],$this->size[1]);
        } else {
            $foregroundSize = $this->size;
            $foregroundImage = $this->image;
            $backgroundImage = imagecreatetruecolor($foreground->size[0],$foreground->size[1]);
            imagecopy($backgroundImage, $foreground->image,0,0,0,0,$foreground->size[0],$foreground->size[1]);
        }
        for ($i = 0; $i < $foregroundSize[0]; $i++) {
            for ($j = 0; $j < $foregroundSize[1]; $j++) {
                $rgba = imagecolorsforindex($foregroundImage, imagecolorat($foregroundImage, $i, $j));
                $alpha = $rgba["alpha"];
                $red = $rgba["red"];
                $green = $rgba["green"];
                $blue = $rgba["blue"];
                if ($alpha !== 0) {
                    $rgba1 = imagecolorsforindex($this->image, imagecolorat($this->image, $i, $j));
                    $alpha1 = $rgba["alpha"];
                    $red1 = $rgba["red"];
                    $green1 = $rgba["green"];
                    $blue1 = $rgba["blue"];
                    $red = ($red * $alpha) + ((1-$alpha)*$red1);
                    $green = ($green * $alpha) + ((1-$alpha)*$green1);
                    $blue = ($blue * $alpha) + ((1-$alpha)*$blue1);
                }
                $color = imagecolorallocatealpha($backgroundImage, $red, $green, $blue, $alpha);
                imagesetpixel($backgroundImage, $i+$x, $j+$y, $color);
            }
        }
        if ($fileNameOut !== null) {
            $this->saveImage($fileNameOut,$backgroundImage);
        } else {
            $this->image = $backgroundImage;
            $this->saveImage(null, $backgroundImage);
        }
        return true;
    }

    // Saves an image to the disk
    function saveImage($fileName=null, $image=null) {
        if ( $image !== null && $fileName !== null) {
            imagejpeg($image, $fileName);
        } else if ($image !== null && $fileName === null) {
            imagejpeg($image, $this->fileName);
        } else {
            imagejpeg($this->image, $this->fileName);
        }
    }

    // Displays an image to the browser
    function displayImage() {
        header('Content-type: image/jpeg');
        imagejpeg($this->image);
    }
}   
?>