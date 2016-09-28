<?php
/**
 * ==============================================
 * domain.php
 * @author: Tony_wang
 * @date: 2016-9-28
 * @version: v1.0.0
 */
date_default_timezone_set('PRC');

$dirlist = dir_list("./new");
$i =  0;

foreach ($dirlist as $v){
    $filename = basename($v);
    $basename = basename($v,".csv").'.txt';
    $myfile = fopen($v, "r") or die("Unable to open file!");
    
    $newfile = fopen("./list/".$basename,"a");

    while(!feof($myfile)) {
        $line =  fgets($myfile);
    
        if(preg_match("/^[\w\-]{2,4}\.com|^[\w\-]{2,3}\.[\w]{2,5}/",$line,$arr)){
    
            fwrite($newfile,$arr[0]."\n");
            $i++;
        }
    
    }
    fclose($myfile);
    fclose($newfile);
    rename($v, "./old/".$filename);
    
}



echo "增加共 $i 条<br>";


$nowdir = dir_list("./list");

foreach ($nowdir as $v){
    $name = basename($v,".txt");
    echo '<a href="'.$v.'">'.$name.'</a><br/>';
    
}


function dir_path($path) {
    $path = str_replace('\\', '/', $path);
    if (substr($path, -1) != '/') $path = $path . '/';
    return $path;
}
/**
 * 列出目录下的所有文件
 *
 * @param str $path 目录
 * @param str $exts 后缀
 * @param array $list 路径数组
 * @return array 返回路径数组
 */
function dir_list($path, $exts = '', $list = array()) {
    $path = dir_path($path);
    $files = glob($path . '*');
    foreach($files as $v) {
        if (!$exts || preg_match("/\.($exts)/i", $v)) {
            $list[] = $v;
            if (is_dir($v)) {
                $list = dir_list($v, $exts, $list);
            }
        }
    }
    return $list;
}
