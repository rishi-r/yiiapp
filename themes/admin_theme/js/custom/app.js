
var left_side_width = 220; //Sidebar width in pixels

$(function() {
    "use strict";

    //Enable sidebar toggle
    $("[data-toggle='offcanvas']").click(function(e) {
        e.preventDefault();

        //If window is small enough, enable sidebar push menu
        if ($(window).width() <= 992) {
            $('.row-offcanvas').toggleClass('active');
            $('.left-side').removeClass("collapse-left");
            $(".right-side").removeClass("strech");
            $('.row-offcanvas').toggleClass("relative");
        } else {
            //Else, enable content streching
            $('.left-side').toggleClass("collapse-left");
            $(".right-side").toggleClass("strech");
        }
    });

    //Add hover support for touch devices
    $('.btn').bind('touchstart', function() {
        $(this).addClass('hover');
    }).bind('touchend', function() {
        $(this).removeClass('hover');
    });

    //Activate tooltips
    $("[data-toggle='tooltip']").tooltip();

    /*     
     * Add collapse and remove events to boxes
     */
    $("[data-widget='collapse']").click(function() {
        //Find the box parent        
        var box = $(this).parents(".box").first();
        //Find the body and the footer
        var bf = box.find(".box-body, .box-footer");
        if (!box.hasClass("collapsed-box")) {
            box.addClass("collapsed-box");
            bf.slideUp();
        } else {
            box.removeClass("collapsed-box");
            bf.slideDown();
        }
    });

    /*
     * ADD SLIMSCROLL TO THE TOP NAV DROPDOWNS
     * ---------------------------------------
     */
    $(".navbar .menu").slimscroll({
        height: "200px",
        alwaysVisible: false,
        size: "3px"
    }).css("width", "100%");

    /*
     * INITIALIZE BUTTON TOGGLE
     * ------------------------
     */
    $('.btn-group[data-toggle="btn-toggle"]').each(function() {
        var group = $(this);
        $(this).find(".btn").click(function(e) {
            group.find(".btn.active").removeClass("active");
            $(this).addClass("active");
            e.preventDefault();
        });

    });

    $("[data-widget='remove']").click(function() {
        //Find the box parent        
        var box = $(this).parents(".box").first();
        box.slideUp();
    });

    /* Sidebar tree view */
    $(".sidebar .treeview").tree();

    /* 
     * Make sure that the sidebar is streched full height
     * ---------------------------------------------
     * We are gonna assign a min-height value every time the
     * wrapper gets resized and upon page load. We will use
     * Ben Alman's method for detecting the resize event.
     * 
     **/
    function _fix() {
        //Get window height and the wrapper height
        var height = $(window).height() - $("body > .header").height();
        $(".wrapper").css("min-height", height + "px");
        var content = $(".wrapper").height();
        //If the wrapper height is greater than the window
        if (content > height)
            //then set sidebar height to the wrapper
            $(".left-side, html, body").css("min-height", content + "px");
        else {
            //Otherwise, set the sidebar to the height of the window
            $(".left-side, html, body").css("min-height", height + "px");
        }
    }
    //Fire upon load
    _fix();
    //Fire when wrapper is resized
    $(".wrapper").resize(function() {
        _fix();
        
    });

    
    /*
     * We are gonna initialize all checkbox and radio inputs to 
     * iCheck plugin in.
     * You can find the documentation at http://fronteed.com/iCheck/
     */
    $("input[type='checkbox'], input[type='radio']").iCheck({
        checkboxClass: 'icheckbox_minimal',
        radioClass: 'iradio_minimal'
    });

});


function Custombox()
{
    var _this = this;
    var varTime;
    this.init = function()
    {
        this.info_icon = '<i class="fa fa-info-sign"></i>';
        this.remove_icon = '<i class="fa fa-times"></i>';
    }
    this.alert =function(mess, error_success,time)
    {
        this.init();
        $("#cust_alert").removeClass("cust_alert_success").removeClass("cust_alert_error").html('').hide();
        if(typeof error_success === "undefined" || error_success == null)
        {
            error_success = 1;
        }
        if(typeof time === "undefined")
        {
            time = 0;
        }

        var class_set = 'cust_alert_success';
        if(error_success == 0)
        {
            class_set = 'cust_alert_error';
        }

        $("#cust_alert").addClass(class_set).html(this.info_icon+mess+this.remove_icon).slideDown(500);
        clearTimeout(varTime);
        if(time!=0)
        {
            varTime = setTimeout(function(){
                _this.removealert();
            },time)
        }
        $("#cust_alert .icon-remove-sign").bind("click",function(){
            $("#cust_alert").slideUp(500);
        });
        
    }
    this.defalert =function(mess)
    {
        $("#cust_loader_def").html(mess).slideDown(500);
    }
    
    this.removedefalert = function()
    {
        setTimeout(function(){
            $("#cust_loader_def").slideUp(1000);
        },1000);
    }
    this.removealert =function()
    {
        $("#cust_alert").removeClass("cust_alert_success").removeClass("cust_alert_success").html('').slideUp(500);
    }
}

var custombox = new Custombox();

/*
 * 
 * common functions library file
 * 
 */

window.commonfn = window.commonfn || (function init($, undefined) {
    "use strict";
    var exports = {loaded:[]};
    exports.callAjax = function (url,dataString)
    {
        return $.ajax({     
                    type: "POST",
                    url: url,
                    cache: false,
                    data: dataString,
                    dataType: "json"
            });
    }

    exports.doAjax = function(options)
    {
        var s = {message:"wait..",load:false};
        s = $.extend({}, {
            ajaxSuccess:function(){}
        }, options);
        exports.disableButton(s.elem, s.message);
        if(s.load)
        {
            exports.block_body();
        }
        var ajax = $.ajax({     
                    type: "POST",
                    url: s.url,
                    cache: false,
                    data: s.dataString,
                    dataType: "json"
        });

        ajax.complete(function(){
            if(s.load)
                exports.unblock_body();
            exports.enableButton(s.elem);
        });
        ajax.success(function(data){
            if(data.error == 'logged_out')
            {
                exports.left_col();
                exports.h_user_settings();
                exports.openloginalert();
            }
            else
            if(data.success == 'logout')
            {
                s.url = HTTP_PATH+'login';
                exports.doAjax(s);
                exports.left_col();
                exports.h_user_settings();
            }
            else
            if(data.success == 'logged_in')
            {
                exports.left_col();
                exports.h_user_settings();
                s.url = HTTP_PATH;
                exports.doAjax(s);
            }
            else
            if(data.success == 1)
            {
                if(typeof s.container != 'undefined' && s.container != false)
                {
                    $(s.container).html(data.html);
                    if(typeof data.script != "undefined")
                    //if(typeof data.script != "undefined" && typeof data.script_name!= "undefined" && !exports.inArray(data.script_name,exports.loaded))
                    {
                        data.script = $(data.script);
                        $("body").append(data.script);
                        exports.loaded.push(data.script_name);
                    }
                }
                if(typeof s.load != 'undefined' && s.load != false)
                {
                    $(".sidebar-menu li").removeClass("active");
                    $('.sidebar-menu a[href^="'+s.url+'"]').closest("li").addClass("active");
                    document.title = data.pageTitle+" | "+SITE_NAME;
                    window.history.pushState({"html":data.html,"pageTitle":data.pageTitle+" | "+SITE_NAME},"", s.url);
                    app_init();
                }
            }
            if($.isFunction(s.ajaxSuccess))
                s.ajaxSuccess.call(this,data);
        });
    }

    exports.openloginalert = function(msg,path)
    {
        if(typeof path =="undefined")
            path = HTTP_PATH;
        bootbox.alert("Your are logged out",function(){
                window.location = path;
                return false;
        });
    }

    exports.timeConverter = function(UNIX_timestamp , h_i_s){
        if(h_i_s == undefined)
            h_i_s = false;
        var a = new Date(UNIX_timestamp*1000);
        var months = ['January','Feburary','March','April','May','June','July','August','September','October','November','December'];
        var year = a.getFullYear();
        var month = months[a.getMonth()];
        var date = a.getDate();

        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = month+' '+date+', '+year ;
        if(h_i_s)
        {
            time += ' '+hour+':'+min+':'+sec;
        }
        return time;
    }


    exports.disableButton = function(elem,message)
    {
        if(typeof message == "undefined")
            message = "Please wait...";
        var id = $(elem).attr("id");
        var class_es = $(elem).attr("class");
        var thistag = $(elem).clone();
        $(elem).addClass("displaynonehard");
        if ($(elem).is( "input")) 
        {
            var button = $("<button></button>");
            $(button).attr("class",class_es).attr("disabled","disabled").attr("id",id+"_dummybtn").html('<img src="'+ICONS_PATH+'ajax-loader.gif" width=20 /> '+message);
            
            $(elem).after(button);
        }
        else
        {
            $(thistag).removeAttr("id").attr("disabled","disabled").attr("id",id+"_dummybtn").html('<img src="'+ICONS_PATH+'ajax-loader.gif" width=20 /> '+message);
            $(elem).after(thistag);
        }
        var date =  new Date();
        exports.elem = date.getTime();

    }

    exports.enableButton = function (elem)
    {
        var date =  new Date();
        var elem_now = date.getTime();
        var timeDiff = elem_now - exports.elem;
        if(timeDiff < 100)
        {
            timeDiff = 1000;
        }
        else
            timeDiff = 0;
        
        var id = $(elem).attr("id");
        $(elem).fadeIn("slow",function(){
            $(this).removeAttr("disabled").removeClass("displaynonehard");
            $("#"+id+"_dummybtn").remove();
        });
            
        
        
        
    }
    exports.check_all_handle = function()
    {
        $("#checkallitem, input.actionsid").iCheck({
            checkboxClass: 'icheckbox_square-blue'
        }).attr("autocomplete",'off');
        
        $("#checkallitem").on('ifChecked',function(e) {
            $("input.actionsid").each(function() {
                    $(this).iCheck('check');
            });
            check_sel_opt();
        });
        $("#checkallitem").on('ifUnchecked',function(e) {
            $("input.actionsid").each(function() {
                    $(this).iCheck('uncheck');
            });
            check_sel_opt();
        });
        
        $("input.actionsid").on('ifChecked',function(e) {
            check_sel_opt();
        });
        $("input.actionsid").on('ifUnchecked',function(e) {
            $("input.actionsid").each(function() {
                if(!(this.checked))
                {
                    $("#checkallitem").removeAttr("checked");
                }
            });
            check_sel_opt();
        });
     }
     
     exports.delete_rows = function()
     {
         $("body").on("click","#delete_rows",function(e){
                e.preventDefault();
                var checkval = [];
                $('.actionsid:checkbox:checked').each(function(i){
                    checkval[i] = $(this).val();
                });
                if(checkval.length==0)
                {
                    return false;
                }
                var _this = this;
                bootbox.confirm("Are you sure to delete the selected data?",function(result){
                        if (result == true)
                        {
                            var tab_d = $(_this).attr('tab_d');

                            var url = HTTP_PATH+"commonclass/deleterows/";
                            var dataString="tab_d="+tab_d+"&checkval="+checkval;
                            exports.doAjax({'url':url,'dataString':dataString,'elem':"#delete_rows",
                            ajaxSuccess:function(data){
                                $('.actionsid:checkbox:checked').each(function(i){
                                    $(this).closest('tr').remove();
                                });
                                $("#checkallitem").iCheck('uncheck');
                                exports.doAjax({'url':window.location,'dataString':'',load:true,'container':'.right-side'});
                            }});
                            
                        }
                });
                
        });
     }
     
     exports.menu_loads = function()
     {
         $("body").on("click",".left-side .sidebar-menu a, .add_btn_ajax, .dataTables_paginate a",function(e){
             e.preventDefault();
             var path = $(this).attr('href');
             if(path == "#")
                 return false;
             exports.doAjax({'url':path,dataString:'',container:'.right-side',load:true,
                ajaxSuccess:function(data){
                    if($(document).width() < 1000)
                    {
                        $(".row-offcanvas-left").removeClass("active relative");
                    }
            }});
         });
         
         exports.doAjax({url:HTTP_PATH+THIS_CONTENT,dataString:"",container:".right-side",load:true});
     }
     exports.left_col = function()
     {
        exports.doAjax({'url':HTTP_PATH+'commonclass/left_col',dataString:'',container:'.left-side',
            ajaxSuccess:function(data){

            }
        });
     }
     exports.h_user_settings = function()
     {
        exports.doAjax({'url':HTTP_PATH+'commonclass/h_user_settings',dataString:'',container:'.h-navbar-dis',
            ajaxSuccess:function(data){

            }
        });
     }
     
     exports.block_body= function()
     {
         var h = $(window).height();
         $("body").addClass("body_relative").css("height",h);
         
         $(".body_loader").fadeIn().css("height",h);
     }
     exports.unblock_body= function()
     {
         $("body").removeClass("body_relative").css("height","auto");
         $(".body_loader").fadeOut();
     }
     
     exports.inArray = function(e,t)
     {
         var n=t.length;
         for(var c=0;c<n;c++)
         {
             if(e == t[c])
             {
                 return 1
             }
         }
         return 0;
     }
    exports.init = function(_$) {
        window.commonfn = init(_$ || $);
    };

    return exports;
        
   
}(window.jQuery));


/* 
 * BOX REFRESH BUTTON 
 * ------------------
 * This is a custom plugin to use with the compenet BOX. It allows you to add
 * a refresh button to the box. It converts the box's state to a loading state.
 * 
 * USAGE:
 *  $("#box-widget").boxRefresh( options );
 * */
(function($) {
    "use strict";

    $.fn.boxRefresh = function(options) {

        // Render options
        var settings = $.extend({
            //Refressh button selector
            trigger: ".refresh-btn",
            //File source to be loaded (e.g: ajax/src.php)
            source: "",
            //Callbacks
            onLoadStart: function(box) {
            }, //Right after the button has been clicked
            onLoadDone: function(box) {
            } //When the source has been loaded

        }, options);

        //The overlay
        var overlay = $('<div class="overlay"></div><div class="loading-img"></div>');

        return this.each(function() {
            //if a source is specified
            if (settings.source === "") {
                if (console) {
                    console.log("Please specify a source first - boxRefresh()");
                }
                return;
            }
            //the box
            var box = $(this);
            //the button
            var rBtn = box.find(settings.trigger).first();

            //On trigger click
            rBtn.click(function(e) {
                e.preventDefault();
                //Add loading overlay
                start(box);

                //Perform ajax call
                box.find(".box-body").load(settings.source, function() {
                    done(box);
                });


            });

        });

        function start(box) {
            //Add overlay and loading img
            box.append(overlay);

            settings.onLoadStart.call(box);
        }

        function done(box) {
            //Remove overlay and loading img
            box.find(overlay).remove();

            settings.onLoadDone.call(box);
        }

    };

})(jQuery);

/*
 * SIDEBAR MENU
 * ------------
 * This is a custom plugin for the sidebar menu. It provides a tree view.
 * 
 * Usage:
 * $(".sidebar).tree();
 * 
 * Note: This plugin does not accept any options. Instead, it only requires a class
 *       added to the element that contains a sub-menu.
 *       
 * When used with the sidebar, for example, it would look something like this:
 * <ul class='sidebar-menu'>
 *      <li class="treeview active">
 *          <a href="#>Menu</a>
 *          <ul class='treeview-menu'>
 *              <li class='active'><a href=#>Level 1</a></li>
 *          </ul>
 *      </li>
 * </ul>
 * 
 * Add .active class to <li> elements if you want the menu to be open automatically
 * on page load. See above for an example.
 */
(function($) {
    "use strict";

    $.fn.tree = function() {

        return this.each(function() {
            var btn = $(this).children("a").first();
            var menu = $(this).children(".treeview-menu").first();
            var isActive = $(this).hasClass('active');

            //initialize already active menus
            if (isActive) {
                menu.show();
                btn.children(".fa-angle-left").first().removeClass("fa-angle-left").addClass("fa-angle-down");
            }
            //Slide open or close the menu on link click
            btn.click(function(e) {
                e.preventDefault();
                if (isActive) {
                    //Slide up to close menu
                    menu.slideUp();
                    isActive = false;
                    btn.children(".fa-angle-down").first().removeClass("fa-angle-down").addClass("fa-angle-left");
                    btn.parent("li").removeClass("active");
                } else {
                    //Slide down to open menu
                    menu.slideDown();
                    isActive = true;
                    btn.children(".fa-angle-left").first().removeClass("fa-angle-left").addClass("fa-angle-down");
                    btn.parent("li").addClass("active");
                }
            });

            /* Add margins to submenu elements to give it a tree look */
            menu.find("li > a").each(function() {
                var pad = parseInt($(this).css("margin-left")) + 10;

                $(this).css({"margin-left": pad + "px"});
            });

        });

    };


}(jQuery));



/* CENTER ELEMENTS */
(function($) {
    "use strict";
    jQuery.fn.center = function(parent) {
        if (parent) {
            parent = this.parent();
        } else {
            parent = window;
        }
        this.css({
            "position": "absolute",
            "top": ((($(parent).height() - this.outerHeight()) / 2) + $(parent).scrollTop() + "px"),
            "left": ((($(parent).width() - this.outerWidth()) / 2) + $(parent).scrollLeft() + "px")
        });
        return this;
    }
}(jQuery));

/*
 * jQuery resize event - v1.1 - 3/14/2010
 * http://benalman.com/projects/jquery-resize-plugin/
 * 
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
(function($, h, c) {
    var a = $([]), e = $.resize = $.extend($.resize, {}), i, k = "setTimeout", j = "resize", d = j + "-special-event", b = "delay", f = "throttleWindow";
    e[b] = 250;
    e[f] = true;
    $.event.special[j] = {setup: function() {
            if (!e[f] && this[k]) {
                return false;
            }
            var l = $(this);
            a = a.add(l);
            $.data(this, d, {w: l.width(), h: l.height()});
            if (a.length === 1) {
                g();
            }
        }, teardown: function() {
            if (!e[f] && this[k]) {
                return false
            }
            var l = $(this);
            a = a.not(l);
            l.removeData(d);
            if (!a.length) {
                clearTimeout(i);
            }
        }, add: function(l) {
            if (!e[f] && this[k]) {
                return false
            }
            var n;
            function m(s, o, p) {
                var q = $(this), r = $.data(this, d);
                r.w = o !== c ? o : q.width();
                r.h = p !== c ? p : q.height();
                n.apply(this, arguments)
            }
            if ($.isFunction(l)) {
                n = l;
                return m
            } else {
                n = l.handler;
                l.handler = m
            }
        }};
    function g() {
        i = h[k](function() {
            a.each(function() {
                var n = $(this), m = n.width(), l = n.height(), o = $.data(this, d);
                if (m !== o.w || l !== o.h) {
                    n.trigger(j, [o.w = m, o.h = l])
                }
            });
            g()
        }, e[b])
    }}
)(jQuery, this);

/*!
 * SlimScroll https://github.com/rochal/jQuery-slimScroll
 * =======================================================
 * 
 * Copyright (c) 2011 Piotr Rochala (http://rocha.la) Dual licensed under the MIT 
 */
(function(f) {
    jQuery.fn.extend({slimScroll: function(h) {
            var a = f.extend({width: "auto", height: "250px", size: "7px", color: "#000", position: "right", distance: "1px", start: "top", opacity: 0.4, alwaysVisible: !1, disableFadeOut: !1, railVisible: !1, railColor: "#333", railOpacity: 0.2, railDraggable: !0, railClass: "slimScrollRail", barClass: "slimScrollBar", wrapperClass: "slimScrollDiv", allowPageScroll: !1, wheelStep: 20, touchScrollStep: 200, borderRadius: "0px", railBorderRadius: "0px"}, h);
            this.each(function() {
                function r(d) {
                    if (s) {
                        d = d ||
                                window.event;
                        var c = 0;
                        d.wheelDelta && (c = -d.wheelDelta / 120);
                        d.detail && (c = d.detail / 3);
                        f(d.target || d.srcTarget || d.srcElement).closest("." + a.wrapperClass).is(b.parent()) && m(c, !0);
                        d.preventDefault && !k && d.preventDefault();
                        k || (d.returnValue = !1)
                    }
                }
                function m(d, f, h) {
                    k = !1;
                    var e = d, g = b.outerHeight() - c.outerHeight();
                    f && (e = parseInt(c.css("top")) + d * parseInt(a.wheelStep) / 100 * c.outerHeight(), e = Math.min(Math.max(e, 0), g), e = 0 < d ? Math.ceil(e) : Math.floor(e), c.css({top: e + "px"}));
                    l = parseInt(c.css("top")) / (b.outerHeight() - c.outerHeight());
                    e = l * (b[0].scrollHeight - b.outerHeight());
                    h && (e = d, d = e / b[0].scrollHeight * b.outerHeight(), d = Math.min(Math.max(d, 0), g), c.css({top: d + "px"}));
                    b.scrollTop(e);
                    b.trigger("slimscrolling", ~~e);
                    v();
                    p()
                }
                function C() {
                    window.addEventListener ? (this.addEventListener("DOMMouseScroll", r, !1), this.addEventListener("mousewheel", r, !1), this.addEventListener("MozMousePixelScroll", r, !1)) : document.attachEvent("onmousewheel", r)
                }
                function w() {
                    u = Math.max(b.outerHeight() / b[0].scrollHeight * b.outerHeight(), D);
                    c.css({height: u + "px"});
                    var a = u == b.outerHeight() ? "none" : "block";
                    c.css({display: a})
                }
                function v() {
                    w();
                    clearTimeout(A);
                    l == ~~l ? (k = a.allowPageScroll, B != l && b.trigger("slimscroll", 0 == ~~l ? "top" : "bottom")) : k = !1;
                    B = l;
                    u >= b.outerHeight() ? k = !0 : (c.stop(!0, !0).fadeIn("fast"), a.railVisible && g.stop(!0, !0).fadeIn("fast"))
                }
                function p() {
                    a.alwaysVisible || (A = setTimeout(function() {
                        a.disableFadeOut && s || (x || y) || (c.fadeOut("slow"), g.fadeOut("slow"))
                    }, 1E3))
                }
                var s, x, y, A, z, u, l, B, D = 30, k = !1, b = f(this);
                if (b.parent().hasClass(a.wrapperClass)) {
                    var n = b.scrollTop(),
                            c = b.parent().find("." + a.barClass), g = b.parent().find("." + a.railClass);
                    w();
                    if (f.isPlainObject(h)) {
                        if ("height"in h && "auto" == h.height) {
                            b.parent().css("height", "auto");
                            b.css("height", "auto");
                            var q = b.parent().parent().height();
                            b.parent().css("height", q);
                            b.css("height", q)
                        }
                        if ("scrollTo"in h)
                            n = parseInt(a.scrollTo);
                        else if ("scrollBy"in h)
                            n += parseInt(a.scrollBy);
                        else if ("destroy"in h) {
                            c.remove();
                            g.remove();
                            b.unwrap();
                            return
                        }
                        m(n, !1, !0)
                    }
                } else {
                    a.height = "auto" == a.height ? b.parent().height() : a.height;
                    n = f("<div></div>").addClass(a.wrapperClass).css({position: "relative",
                        overflow: "hidden", width: a.width, height: a.height});
                    b.css({overflow: "hidden", width: a.width, height: a.height});
                    var g = f("<div></div>").addClass(a.railClass).css({width: a.size, height: "100%", position: "absolute", top: 0, display: a.alwaysVisible && a.railVisible ? "block" : "none", "border-radius": a.railBorderRadius, background: a.railColor, opacity: a.railOpacity, zIndex: 90}), c = f("<div></div>").addClass(a.barClass).css({background: a.color, width: a.size, position: "absolute", top: 0, opacity: a.opacity, display: a.alwaysVisible ?
                                "block" : "none", "border-radius": a.borderRadius, BorderRadius: a.borderRadius, MozBorderRadius: a.borderRadius, WebkitBorderRadius: a.borderRadius, zIndex: 99}), q = "right" == a.position ? {right: a.distance} : {left: a.distance};
                    g.css(q);
                    c.css(q);
                    b.wrap(n);
                    b.parent().append(c);
                    b.parent().append(g);
                    a.railDraggable && c.bind("mousedown", function(a) {
                        var b = f(document);
                        y = !0;
                        t = parseFloat(c.css("top"));
                        pageY = a.pageY;
                        b.bind("mousemove.slimscroll", function(a) {
                            currTop = t + a.pageY - pageY;
                            c.css("top", currTop);
                            m(0, c.position().top, !1)
                        });
                        b.bind("mouseup.slimscroll", function(a) {
                            y = !1;
                            p();
                            b.unbind(".slimscroll")
                        });
                        return!1
                    }).bind("selectstart.slimscroll", function(a) {
                        a.stopPropagation();
                        a.preventDefault();
                        return!1
                    });
                    g.hover(function() {
                        v()
                    }, function() {
                        p()
                    });
                    c.hover(function() {
                        x = !0
                    }, function() {
                        x = !1
                    });
                    b.hover(function() {
                        s = !0;
                        v();
                        p()
                    }, function() {
                        s = !1;
                        p()
                    });
                    b.bind("touchstart", function(a, b) {
                        a.originalEvent.touches.length && (z = a.originalEvent.touches[0].pageY)
                    });
                    b.bind("touchmove", function(b) {
                        k || b.originalEvent.preventDefault();
                        b.originalEvent.touches.length &&
                                (m((z - b.originalEvent.touches[0].pageY) / a.touchScrollStep, !0), z = b.originalEvent.touches[0].pageY)
                    });
                    w();
                    "bottom" === a.start ? (c.css({top: b.outerHeight() - c.outerHeight()}), m(0, !0)) : "top" !== a.start && (m(f(a.start).position().top, null, !0), a.alwaysVisible || c.hide());
                    C()
                }
            });
            return this
        }});
    jQuery.fn.extend({slimscroll: jQuery.fn.slimScroll})
})(jQuery);

