/*
 Name: autoComplete
 Authors:
 Andy Matthews: @commadelimited
 Raymond Camden: @cfjedimaster
 
 Website: http://andyMatthews.net
 Version: 1.5.2
 GA: Add data:{} and change data:{}, to data:l.data, so can pass in variables.
 : data-icon="none" >> data-icon="false" jqm 1.4
 */(function(e) {
    "use strict";
    var t = {method: "GET", icon: "arrow-r", cancelRequests: !1, target: e(), source: null, callback: null, link: null, data: {}, minLength: 0, transition: "fade", matchFromStart: !0, labelHTML: function(e) {
            return e
        }, onNoResults: function() {
            return
        }, onLoading: function() {
            return
        }, onLoadingFinished: function() {
            return
        }, termParam: "term", loadingHtml: '<li data-icon="false"><a href="#">Buscando...</a></li>', interval: 0, builder: null, dataHandler: null, klass: null, forceFirstChoiceOnEnterKey: !0}, n = {}, r = function(t, n, r) {
        var s, o = "";
        r.klass && (o = 'class="' + r.klass + '"');
        if (r.builder)
            s = r.builder.apply(t.eq(0), [n, r]);
        else {
            s = [];
            if (n) {
                r.dataHandler && (n = r.dataHandler(n));
                e.each(n, function(t, n) {
                    e.isPlainObject(n) ? s.push("<li " + o + " data-icon=" + r.icon + '><a href="javascript:pushItem(' + r.labelHTML(n.label) + ')">' + r.labelHTML(n.label) + "</a></li>") : s.push("<li " + o + " data-icon=" + r.icon + '>' + r.labelHTML(n) + "</li>");
                });
            }
        }
        e.isArray(s) && (s = s.join(""));
        e(r.target).html(s).listview("refresh");
        r.callback !== null && e.isFunction(r.callback) && i(r);
        if (s.length > 0)
            t.trigger("targetUpdated.autocomplete");
        else {
            t.trigger("targetCleared.autocomplete");
            r.onNoResults && r.onNoResults()
        }
    }, i = function(t) {
        e("li a", e(t.target)).bind("click.autocomplete", function(e) {
            e.stopPropagation();
            e.preventDefault();
            t.callback(e)
        })
    }, s = function(e, t) {
        t.html("").listview("refresh").closest("fieldset").removeClass("ui-search-active");
        e.trigger("targetCleared.autocomplete")
    }, o = function(t) {
        var i = e(this), u = i.attr("id"), a, f, l = i.jqmData("autocomplete"), c, h;
        Date.now || (Date.now = function() {
            return(new Date).valueOf()
        });
        t && (t.keyCode === 38 ? e(".ui-btn-active", e(l.target)).removeClass("ui-btn-active").prevAll("li.ui-btn:eq(0)").addClass("ui-btn-active").length || e(".ui-btn:last", e(l.target)).addClass("ui-btn-active") : t.keyCode === 40 ? e(".ui-btn-active", e(l.target)).removeClass("ui-btn-active").nextAll("li.ui-btn:eq(0)").addClass("ui-btn-active").length || e(".ui-btn:first", e(l.target)).addClass("ui-btn-active") : t.keyCode === 13 && l.forceFirstChoiceOnEnterKey && (e(".ui-btn-active a", e(l.target)).click().length || e(".ui-btn:first a", e(l.target)).click()));
        if (l) {
            a = i.val();
            if (l._lastText === a)
                return;
            l._lastText = a;
            if (l._retryTimeout) {
                window.clearTimeout(l._retryTimeout);
                l._retryTimeout = null
            }
            if (!(!t || t.keyCode !== 13 && t.keyCode !== 38 && t.keyCode !== 40))
                return;
            if (a.length < l.minLength)
                s(i, e(l.target));
            else {
                if (l.interval && Date.now() - l._lastRequest < l.interval) {
                    l._retryTimeout = window.setTimeout(e.proxy(o, this), l.interval - Date.now() + l._lastRequest);
                    return
                }
                l._lastRequest = Date.now();
                if (e.isArray(l.source)) {
                    var p = function(e) {
                        return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
                    };
                    f = l.source.sort().filter(function(t) {
                        l.matchFromStart ? (c, h = new RegExp("^" + p(a), "i")) : (c, h = new RegExp(p(a), "i"));
                        e.isPlainObject(t) ? c = t.label : c = t;
                        return h.test(c)
                    });
                    r(i, f, l)
                } else if (typeof l.source == "function")
                    l.source(a, function(e) {
                        r(i, e, l)
                    });
                else {
                    var d = {type: l.method, data: l.data, dataType: "json", beforeSend: function(t) {
                            if (l.cancelRequests) {
                                n[u] && n[u].abort();
                                n[u] = t
                            }
                            l.onLoading && l.onLoadingFinished && l.onLoading();
                            if (l.loadingHtml) {
                                e(l.target).html(l.loadingHtml).listview("refresh");
                                e(l.target).closest("fieldset").addClass("ui-search-active")
                            }
                        }, success: function(e) {
                            r(i, e, l)
                        }, complete: function() {
                            l.cancelRequests && (n[u] = null);
                            l.onLoadingFinished && l.onLoadingFinished()
                        }};
                    if (e.isPlainObject(l.source)) {
                        l.source.callback && l.source.callback(a, d);
                        for (var v in l.source)
                            v !== "callback" && (d[v] = l.source[v])
                    } else
                        d.url = l.source;
                    l.termParam && (d.data[l.termParam] = a);
                    e.ajax(d)
                }
            }
        }
    }, u = {init: function(n) {
            var r = this;
            r.jqmData("autocomplete", e.extend({}, t, n));
            var i = r.jqmData("autocomplete");
            return r.unbind("keyup.autocomplete").bind("keyup.autocomplete", o).next(".ui-input-clear").bind("click", function() {
                s(r, e(i.target))
            })
        }, update: function(t) {
            var n = this.jqmData("autocomplete");
            n && this.jqmData("autocomplete", e.extend(n, t));
            return this
        }, clear: function() {
            var t = this.jqmData("autocomplete");
            t && s(this, e(t.target));
            return this
        }, destroy: function() {
            var t = this.jqmData("autocomplete");
            if (t) {
                s(this, e(t.target));
                this.jqmRemoveData("autocomplete");
                this.unbind(".autocomplete")
            }
            return this
        }};
    e.fn.autocomplete = function(e) {
        if (u[e])
            return u[e].apply(this, Array.prototype.slice.call(arguments, 1));
        if (typeof e == "object" || !e)
            return u.init.apply(this, arguments)
    }
})(jQuery);