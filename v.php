<!DOCTYPE html>
<html>

<head>
    <title>查看文件 - <?php echo $_GET['filename']; ?></title>
    <link rel="shortcut icon" href="icon/logo.png" type="image/x-icon" />
    <link rel="apple-touch-icon" sizes="200x200" href="icon/logo.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="//cdn.staticfile.org/font-awesome/4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="css/main.css">
    <link id="hl-font" rel="stylesheet" href="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.10/build/styles/github.min.css" />
    <script src="//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.10/build/highlight.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/highlightjs-line-numbers.js@2.7.0/dist/highlightjs-line-numbers.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        hljs.configure({
            tabReplace: '    '
        });
        hljs.initHighlightingOnLoad();
        hljs.initLineNumbersOnLoad();
    </script>
    <script src="js/main.js"></script>
</head>

<body>
    <script>
        var clipboard = new ClipboardJS('.copy');
        clipboard.on('error', function(e) {
            alert("复制失败，请按 Ctrl-C !");
        });
    </script>
    <div class="container">
        <div class="card">

            <div class="card-header">
                <?php
                $name = 'pool' . $_GET['filename'];
                $ex = file_exists($name);
                if (!$ex) {
                    echo '<i class="fa fa-warning"></i> error';
                    $str = '<i><b><font color="red">错误：未找到文件！</font></b></i>';
                } else {
                    $str = file_get_contents($name);
                    $str = str_replace('<', '&lt;', $str);
                    $str = str_replace('>', '&gt;', $str);
                    echo '<i class="fa fa-info-circle"></i> 共' . strlen($str) . '个字符';
                }
                echo '&nbsp;&nbsp;<i class="fa fa-file-text"></i> 文件：' . $_GET['filename'];
                ?>
            </div>
            <div class="card-body hljs">
                <pre>
                        <code><?php echo $str; ?></code>
</pre>
            </div>
            <div class="card-footer">
                <?php
                if ($ex) {
                    echo '<i class="fa fa-calendar"></i> 创建时间： ' . date("Y-m-d H:i:s", filectime($name));
                    echo '  <i class="fa fa-calendar-plus-o"></i> 修改时间： ' . date("Y-m-d H:i:s", filemtime($name)) . '</span>';
                    echo '<a href="./"><i class="fa fa-home"></i></a>';
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container" id="ctrl-btn">
        <div class="col">
            <label><img src="icon/font-size.svg" />
                <input type="range" class="custom-range" min="10" max="30" step="5" onchange="SetFontSize()">
            </label>
        </div>
        <div class="col">

            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <img src="icon/theme.svg" />
                    <span class="caret"></span>
                    <span class="sr-only">切换下拉菜单</span>
                </button>
                <ul class="dropdown-menu" role="menu" id="theme-grp">
                    <li><a href="javascript:void(0);" class="code-select">Railscasts</a></li>
                    <li><a href="javascript:void(0);" class="code-select">Solarized Light</a></li>
                    <li><a href="javascript:void(0);" class="code-select">Tomorrow Night Eighties</a></li>
                    <li><a href="javascript:void(0);" class="code-select">VS</a></li>
                    <li><a href="javascript:void(0);" class="code-select">Far</a></li>
                    <li><a href="javascript:void(0);" class="code-select">Hybrid</a></li>
                    <li><a href="javascript:void(0);" class="code-select">Solarized Dark</a></li>
                    <li><a href="javascript:void(0);" class="code-select">Github</a></li>
                </ul>
            </div>
        </div>
        <div class="col">
            <button id="copy" class="btn btn-primary copy" data-clipboard-target="code">
                <img src="icon/copy.svg" />
            </button>
        </div>
        <div class="col">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <img src="icon/font.svg" />
                    <span class="caret"></span>
                    <span class="sr-only">切换下拉菜单</span>
                </button>
                <ul class="dropdown-menu" role="menu" style="width: 250px;" id="font-grp">
                    <li><a href="javascript:void(0);" class="font-select" style="font-family: Consolas;">Consolas</a></li>
                    <li><a href="javascript:void(0);" class="font-select" style="font-family: Courier New;">Courier New</a></li>
                    <li><a href="javascript:void(0);" class="font-select" style="font-family: Monaco;">Monaco</a></li>
                    <li><a href="javascript:void(0);" class="font-select" style="font-family: DejaVuSansMono;">DejaVuSansMono</a></li>
                    <li><a href="javascript:void(0);" class="font-select" style="font-family: Anonymous Pro;">Anonymous Pro</a></li>
                </ul>
            </div>
        </div>
        <div class="col">
            <div class="custom-controls-stacked d-block my-3">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" checked="checked">
                    <label class="custom-control-label" for="customSwitch1">行号</label>
                </div>
            </div>
        </div>
    </div>
</body>

</html>