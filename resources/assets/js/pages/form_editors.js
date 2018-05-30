'use strict';
$(document).ready(function() {
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();

    $(".wysihtml5-toolbar li:nth-child(3) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar li:nth-child(4) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar li:nth-child(5) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar li:nth-child(6) a").addClass("btn-outline-primary");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:first-child").addClass("fa fa-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(2)").addClass("fa fa-th-list");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(3)").addClass("hidden");
    $(".wysihtml5-toolbar .btn-group:eq(1) a:nth-child(4)").addClass("hidden");
    $(".wysihtml5-toolbar .btn-group:eq(3) a:first-child").addClass("fa fa-list");
    $(".wysihtml5-toolbar .btn-group:eq(3) a:nth-child(2)").addClass("fa fa-th-list");
    $(".wysihtml5-toolbar .btn-group:eq(3) a:nth-child(3)").addClass("hidden");
    $(".wysihtml5-toolbar .btn-group:eq(3) a:nth-child(4)").addClass("hidden");
    $(".note-editor .note-editing-area").addClass('note-editing-area1');
    $(".wysihtml5-toolbar li:nth-child(5) span").addClass("fa fa-share");
    $(".wysihtml5-toolbar li:nth-child(6) span").addClass("fa fa-picture-o");
    $("[data-wysihtml5-command='formatBlock'] span").css("position","relative").css("top","-5px").css("left","-5px");
    $(".note-toolbar button").removeClass('btn-default').addClass('btn-light');
    $(".wysihtml5-toolbar li:nth-child(2) a").removeClass('btn-default').addClass('btn-light');
    $(".note-btn .note-icon-arrows-alt").click(function () {
        $(".note-editing-area").removeClass('note-editing-area1');
    })
});
