<?php function Genpath()
{ ?>
<div class="d-flex flex-row-reverse">
    <div>
        <button class="btn btn-primary" id="add-btn">
            <i class="fa fa-plus"></i>
        </button>
    </div>
    
    <div id="ass">
        <div class="input-group" id="add-dir" style="display: none;">
            <input type="text" class="form-control" placeholder="文件夹名" id="dir-name">
            <div class="input-group-append">
                <button class="btn btn-primary" id="add-dir-btn">
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="container">
        <ol class="breadcrumb">
            <?php
            $path = isset($_GET['path']) ? $_GET['path'] : '/';
            $p = explode('/', $path);
            $len = count($p) - 2; ?>
        <li class="breadcrumb-item"><a data-pjax href="?path=/" <?php if($path == '/') echo 'id="cur-link"';?>><i class="fa fa-home"></i></a></li>
<?php
            $cur = '/';
            for ($i = 1; $i <= $len; $i++) {
                $cur .= $p[$i] . '/';
                echo '<li class="breadcrumb-item"><a data-pjax href="?path=' . $cur . '" '.($i == $len ? 'id="cur-link"' : '').'>' . $p[$i] . '</a></li>';
            }
            ?>
        </ol>
    </div>
</div>
    <div id="tbl">
    <table class="table table-striped table-hover" data-path="<?php echo $path;?>">
        <thead>
            <tr>
                <th>文件名</th>
                <!-- <th>日期</th> -->
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $dir = 'pool' . $path;
            $f = $d = array();
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if ($file != '..' && $file != '.') {
                            if (is_file($dir . $file)) array_push($f, $file);
                            else array_push($d, $file);
                        }
                    }
                    closedir($dh);
                }

                foreach ($d as $dirname) {
                    echo '<tr>';
                    
                    echo '<th><i class="fa fa-folder"></i>
                            <a data-pjax href="?path=' . $path . $dirname . '/">' . $dirname . '</a>
                        </th>';

                    // echo '<th>' . date("Y-m-d H:i:s", filectime($dir . $dirname)) . '</th>';

                       ?><th>
                           <a href="javascript:void(0)" class="delete" del="dir">
                               <i class="fa fa-trash"></i>
                            </a>
                        </th><?php

                    echo '</tr>';
                }

                foreach ($f as $filename) {
                    echo '<tr>';

                    echo '<th><i class="fa fa-file-text"></i>
                            <a href="./v.php?filename=' . $path . $filename . '" target="view_window">' . $filename . '</a>
                        </th>';

                    // echo '<th>' . date("Y-m-d H:i:s", filectime($dir . $dirname)) . '</th>';

                    ?>  <th>
                            <a href="javascript:void(0)" class="delete">
                                <i class="fa fa-trash"></i>
                            </a>
                            <a href="javascript:void(0);" class="edit">
                                <i class="fa fa-edit"></i>
                            </a>
                        </th> <?php

                    echo '</tr>';
                }
            }
            else echo 'No Such Path';
            ?>
        </tbody>
    </table>
        </div>
<?php } ?>
<?php
if (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX']) {
    Genpath();
    exit();
}
?>
<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>CodeBox</title>
    <link rel="shortcut icon" href="icon/logo.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="200x200" href="icon/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery.pjax/2.0.1/jquery.pjax.js"></script>   
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/codemirror.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ace.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.7/ext-language_tools.js"></script>
    <script src="js/bs4.pop.js"></script>
    <link rel="stylesheet" href="css/bs4.pop.css">
    <script src="js/index.js"></script>
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6" id="path-view"><?php GenPath();?></div>
            <div class="col-md-6">
                <div class="row">
                    <div class="input-group mb-3" id="edit-name">
                        <input type="text" class="form-control" placeholder="文件名" id="save-name">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary" id="save-btn">
                                <i class="fa fa-save"></i>
                            </button>
                            <button class="btn btn-warning" onclick="$('#save-name').val(''); ed.setValue('');">
                                <i class="fa fa-undo"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="editor"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>