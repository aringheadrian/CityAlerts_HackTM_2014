<?php 

namespace TreeWeb\libraries;

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

/**
 * Upload class
 */
class Upload
{
    /**
	 * Config
	 *
	 * @access private
	 */
    private static $config;

    /**
	 * Error
	 *
	 * @access private
	 */
    private $error;

    /**
	 * Constructor
	 *
	 * @access public
	 */
    public function __construct()
    {
        self::$config = config_load('upload');

        $this->error = new Error();

    }

    /**
	 * Upload image
	 *
	 * @access public
	 */
    public function uploadImage($file, $rename, $width, $height, $crop = false, $transparency=true)
    {
        if (is_array($file)) {

            $ext = substr(strrchr($file['name'], '.'), 1);

            if ($file['size'] > self::$config['max_filesize'])
                $this->error->setError('The file you attempted to upload is too large.');

        } else {

            $ext = substr(strrchr($_FILES[$file]['name'], '.'), 1);

            if ($_FILES[$file]['size'] > self::$config['max_filesize'])
                $this->error->setError('The file you attempted to upload is too large.');

        }

        if (!in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF')))
            $this->error->setError('The file you attempted to upload is not allowed.');

        if (!is_writable(self::$config['upload_path'] . 'images/'))
            $this->error->setError('The folder ' . self::$config['upload_path'] . ' images/ is not writeable.');

        if (!$this->error->hasErrors()) {

            $file_name =  $rename . '.' . $ext;

            if (is_array($file))
                copy($file['tmp_name'], self::$config['upload_path'] . 'images/' . $file_name);
            else
                copy($_FILES[$file]['tmp_name'], self::$config['upload_path'] . 'images/' . $file_name);

            if (in_array($ext, array('jpg', 'jpeg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'))) {

                if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'JPG' || $ext == 'JPEG')
                    $image = imagecreatefromjpeg(self::$config['upload_path'] . 'images/' . $file_name);
                elseif($ext == 'png' || $ext == 'PNG')
                    $image = imagecreatefrompng(self::$config['upload_path'] . 'images/' . $file_name);
                elseif($ext == 'gif' || $ext == 'GIF')
                    $image = imagecreatefromgif(self::$config['upload_path'] . 'images/' . $file_name);

                $old_width = imagesx($image);
                $old_height = imagesy($image);

                if ($crop) {

                    $scale = max($width / $old_width, $height / $old_height);
                    $new_width = ceil($scale * $old_width);
                    $new_height = ceil($scale * $old_height);

                    $tmp_img = imagecreatetruecolor($new_width, $new_height);
                    if ($transparency) {
                    if ($ext=="png") {
                       imagealphablending($tmp_img, false);
                       $colorTransparent = imagecolorallocatealpha($tmp_img, 0, 0, 0, 127);
                       imagefill($tmp_img, 0, 0, $colorTransparent);
                       imagesavealpha($tmp_img, true);
                     } elseif ($ext=="gif") {
                       $trnprt_indx = imagecolortransparent($image);
                       if ($trnprt_indx >= 0) {
                       //its transparent
                       $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
                       $trnprt_indx = imagecolorallocate($tmp_img, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                       imagefill($tmp_img, 0, 0, $trnprt_indx);
                       imagecolortransparent($tmp_img, $trnprt_indx);
                       }
                     }
                    } else {
                    Imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
                    }
                    imagecopyresampled($tmp_img, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

                    if ($new_width == $width) {

                        $src_x = 0;
                        $src_y = ($new_height / 2) - ($height / 2);

                    } elseif ($new_height == $height) {

                        $src_x = ($new_width / 2) - ($width / 2);
                        $src_y = 0;

                    }

                    $new_image = imagecreatetruecolor($width, $height);
                    if ($transparency) {
                    if ($ext=="png") {
                       imagealphablending($new_image, false);
                       $colorTransparent = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                       imagefill($new_image, 0, 0, $colorTransparent);
                       imagesavealpha($new_image, true);
                     } elseif ($ext=="gif") {
                       $trnprt_indx = imagecolortransparent($image);
                       if ($trnprt_indx >= 0) {
                       //its transparent
                       $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
                       $trnprt_indx = imagecolorallocate($new_image, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                       imagefill($new_image, 0, 0, $trnprt_indx);
                       imagecolortransparent($new_image, $trnprt_indx);
                       }
                     }
                    } else {
                    Imagefill($new_image, 0, 0, imagecolorallocate($new_image, 255, 255, 255));
                    }

                    imagecopyresampled($new_image, $tmp_img, 0, 0, $src_x, $src_y, $width, $height, $width, $height);
                    imagedestroy($tmp_img);

                } else {

                    $scale = min($width / $old_width, $height / $old_height);
                    $new_width = ceil($scale * $old_width);
                    $new_height = ceil($scale * $old_height);

                    $new_image = imagecreatetruecolor($new_width, $new_height);
                    if ($transparency) {
                    if ($ext=="png") {
                       imagealphablending($new_image, false);
                       $colorTransparent = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
                       imagefill($new_image, 0, 0, $colorTransparent);
                       imagesavealpha($new_image, true);
                     } elseif ($ext=="gif") {
                       $trnprt_indx = imagecolortransparent($image);
                       if ($trnprt_indx >= 0) {
                       //its transparent
                       $trnprt_color = imagecolorsforindex($image, $trnprt_indx);
                       $trnprt_indx = imagecolorallocate($new_image, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
                       imagefill($new_image, 0, 0, $trnprt_indx);
                       imagecolortransparent($new_image, $trnprt_indx);
                       }
                     }
                    } else {
                    Imagefill($new_img, 0, 0, imagecolorallocate($new_img, 255, 255, 255));
                    }
                    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);

                }

                if ($ext == 'jpg' || $ext == 'jpeg' )
                    imagejpeg($new_image, self::$config['upload_path'] . 'images/' . $file_name, 75);
                elseif($ext == 'png')
                     imagepng($new_image, self::$config['upload_path'] . 'images/' . $file_name);
                elseif($ext == 'gif')
                    imagegif($new_image, self::$config['upload_path'] . 'images/' . $file_name);

                imagedestroy($image);
                imagedestroy($new_image);

            }

            return $file_name;

        }
    }

    /**
	 * Upload file
	 *
	 * @access public
	 */
    public function uploadFile($field_name)
    {
        $ext = pathinfo($_FILES[$field_name]['name']);

        if (!in_array($ext['extension'], self::$config['allowed_filetypes']))
            $this->error->setError('The file you attempted to upload is not allowed.');

        if ($_FILES[$field_name]['size'] > self::$config['max_filesize'])
            $this->error->setError('The file you attempted to upload is too large.');

        if (!is_writable(self::$config['upload_path'] . 'files/'))
            $this->error->setError('The folder ' . self::$config['upload_path'] . ' files/ is not writeable.');

        if (!$this->error->hasErrors()) {

            $file_name =  time() . '.' . $ext['extension'];

            copy($_FILES[$field_name]['tmp_name'], self::$config['upload_path'] . 'files/' . $file_name);

            return $file_name;

        }
    }

}
