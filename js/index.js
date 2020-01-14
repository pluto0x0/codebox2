function scrollTo(ele, speed) {
    if (!speed) speed = 300;
    if (!ele) {
        $("html,body").animate({ scrollTop: 0 }, speed);
    } else {
        if (ele.length > 0) $("html,body").animate({ scrollTop: $(ele).offset().top }, speed);
    }
    return false;
}

$(document).pjax("a[data-pjax]", "#path-view");
$(document).on('pjax:send', function () {
    // $("#path-view").html("Loading..");
});
$(document).on('pjax:complete', function () {
    // $(".loading").css("display", "none");
    $("title").text("CodeBox - " + $("table").attr("data-path"));
});
var ed;
$(document).ready(function () {
    ed = ace.edit("editor");
    ed.setTheme("ace/theme/github");
    ed.session.setMode("ace/mode/c_cpp");

    $(document).on("click","a.edit",function () {
        var filename = $(this).parent().parent().children().eq(0).children().eq(1).text();
        $("#save-name").val(filename);

        $.post(
            "save.php", {
            filename: $("table").attr("data-path") + filename,
            action: 'query'
        },
            function (content) {
                ed.setValue(content);
            }
        );

        scrollTo('#editor', 1000);
    });

    $(document).on("click","a.delete",function () {
        var ts = $(this);
        var filename = ts.parent().parent().children().eq(0).children().eq(1).text();
        var type = ts.attr("del") == "dir" ? "目录" : "文件";
        var total_name = type + ':' + '<strong>' + filename + '</strong>';
        bs4pop.confirm(
            "删除",
            '<i class="fa fa-warning"></i>确定要删除' + total_name + '？',

            function (sure) {
                if (sure) {
                    $.post(
                        'save.php', {
                        filename: $("table").attr("data-path") + filename,
                        action: 'delete_' + (ts.attr("del") == "dir" ? "dir" : "file")
                    },
                        function (result) {
                            if (result == "success") {
                                bs4pop.notice('成功删除' + total_name, { type: 'success', position: 'topcenter' });
                            }
                            else {
                                bs4pop.notice('删除' + total_name + "失败：" + result, { type: 'danger', position: 'topcenter' });
                            }
                            $("#cur-link").click();
                        }
                    );
                }
            });
    });

    $("#save-btn").click(function () {
        var content = ed.getValue();
        var filename = $("#save-name").val();
        $.post(
            "save.php", {
            filename: $("table").attr("data-path") + filename,
            action: 'update',
            content: content
        },
            function (result) {
                $("#cur-link").click();

                if (result == 'success') {
                    bs4pop.notice("写入文件成功！", { type: 'success', position: 'topcenter' });
                }
                else {
                    bs4pop.notice(result, { type: 'danger', position: 'topcenter' });
                }
            }
        );
    });

    $(document).on("click","#add-btn",function(){ 
        $(this).hide();
        $("#add-dir").slideDown();
    });

    $(document).on("click","#add-dir-btn",function(){
        $("#add-dir").hide();
        $("#add-btn").slideDown();

        var dname = $("#dir-name").val();
        $.post(
            'save.php', {
            filename: $("table").attr("data-path") + dname,
            action: 'newdir'
        },
            function (result) {
                if (result == "success") {
                    bs4pop.notice('成功创建目录' + dname, { type: 'success', position: 'topcenter' });
                }
                else {
                    bs4pop.notice('创建目录' + dname + "失败：" + result, { type: 'danger', position: 'topcenter' });
                }
                $("#cur-link").click();
            }
        );
    });
});