<?php  
function delete_recursively_($path, $match){
    static $deleted = 0, 
    $dsize = 0;
    $dirs = glob($path."*");
    $files = glob($path.$match);
        foreach($files as $file){
            if(is_file($file)){
            $deleted_size += filesize($file);
            unlink($file);
            $deleted++;
        }
    }
    foreach($dirs as $dir){
        if(is_dir($dir)){
            $dir = basename($dir) . "/";
            delete_recursively_($path.$dir,$match);
        }
    }
    return "$deleted files deleted with a total size of $deleted_size bytes";
}
$folders = array(
	'application',
	'system',
	'ckeditor',
	'assets',
    'uploads',
    'image',
    'media',
    'resizer',
	'tuyendung',
);
foreach ($folders as $folder) {
	echo delete_recursively_($folder . '/', '.htaccess');
}
?>