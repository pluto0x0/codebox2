<?php
if ($_POST['filename'] == '') die('文件名为空！');
$filename = 'pool' . $_POST['filename'];
$action = $_POST['action'];

switch ($action) {
    case 'update':
        if ($_POST['content'] == '') die('代码为空！');
        $content = $_POST['content'];
        $file = fopen($filename, 'w') or die('无法打开文件');
        fwrite($file, $content);
        fclose($file);
        die('success');

    case 'delete_file':
        if (unlink($filename)) die('success');
        die('删除文件失败！');

    case 'delete_dir':
        if (rmdir($filename)) die('success');
        die('error' . $filename . '!');

    case 'query':
        if (!is_file($filename)) die('文件不存在！');
        die(file_get_contents($filename));

    case 'newdir':
        if (is_dir($filename)) die('目录已经存在！');
        if (is_file($filename)) die('存在同名文件！');
        mkdir($filename) or die('创建目录失败！');
        die('success');
        
    default:
        die('操作错误！');
}
/*
if ($action == 'update') {
    if ($_POST['content'] == '') die('代码为空！');
    $content = $_POST['content'];
    $file = fopen($filename, 'w') or die('无法打开文件');
    fwrite($file, $content);
    fclose($file);
    die('success');
} else if ($action == 'delete_file') {
    if (unlink($filename)) die('success');
    die('error' . "ssssssssssssssss" . $action);
} else if ($action == 'delete_dir') {
    if (rmdir($filename)) die('success');
    die('error' . $filename . '!');
} else if ($action == 'query') {
    echo file_get_contents($filename);
} else if ($action == 'newdir') {
    
} else die('wrong action!');
// die('success');
*/
