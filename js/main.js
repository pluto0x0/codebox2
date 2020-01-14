$(document).ready(function(){
    var coo = $.cookie("FontSize");
    if(coo == undefined) $("pre").css("font-size", "20px");
    else{
        $("pre").css("font-size", coo + "px");
        $('input[type="range"]').val(coo);
    }

    $("a.code-select").click(function(){
        $.cookie("Theme", $(this).parent().index(), { expires: 30 });
        
        var name = $(this).text();
        name = name.toLowerCase().replace(/ /g,"-");
        $("#hl-font").attr("href","//cdn.jsdelivr.net/gh/highlightjs/cdn-release@9.15.10/build/styles/" + name + ".min.css");
        $("code").bind("style",function(){
            $("div.card").css("background-color", $("code").css("background-color"));
        });
    });

    $("a.font-select").click(function(){
        $.cookie("Font", $(this).parent().index(), { expires: 30 });

        var font = $(this).text();
        $("code").css("font-family", font);
    });

    coo = $.cookie("Theme");
    if(coo != undefined) $("#theme-grp").children().eq(parseInt(coo)).children(0).click();

    coo = $.cookie("Font");
    if(coo != undefined) $("#font-grp").children().eq(parseInt(coo)).children(0).click();
});
function SetFontSize() {
    var size = $('input[type="range"]').val();
    $("pre").css("font-size", size + "px");
    $.cookie("FontSize", size, { expires: 30 });
}