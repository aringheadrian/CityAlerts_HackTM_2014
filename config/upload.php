<?php if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) exit('No direct access allowed.');

$config['upload_path'] = '__DIR_APPLICATION__uploads/';

$config['allowed_filetypes'] = array('png', 'jpg', 'jpeg', 'gif', 'pdf', 'zip', 'rar', 'PNG', 'JPG', 'JPEG', 'GIF', 'PDF', 'ZIP', 'RAR');

$config['max_filesize'] = 1048576;

$config['max_width_thumbnail'] = 500;

$config['max_height_thumbnail'] = 500;

$config['max_width'] = 2000;

$config['max_height'] = 2000;

$config['crop_thumbnail'] = true;

?>
