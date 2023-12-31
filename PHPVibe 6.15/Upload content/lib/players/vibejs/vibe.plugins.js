! function() {
    "use strict";
    var e = null;
    e = void 0 === window.videojs && "function" == typeof require ? require("video.js") : window.videojs,
        function(e, t) {
            var n, i = {
                    ui: !0
                },
                o = t.getComponent("MenuItem"),
                s = t.extend(o, {
                    constructor: function(e, n) {
                        n.selectable = !0, o.call(this, e, n), this.src = n.src, e.on("resolutionchange", t.bind(this, this.update))
                    }
                });
            s.prototype.handleClick = function(e) {
                o.prototype.handleClick.call(this, e), this.player_.currentResolution(this.options_.label)
            }, s.prototype.update = function() {
                var e = this.player_.currentResolution();
                this.selected(this.options_.label === e.label)
            }, o.registerComponent("ResolutionMenuItem", s);
            var r = t.getComponent("MenuButton"),
                a = t.extend(r, {
                    constructor: function(e, n) {
                        if (this.label = document.createElement("span"), n.label = "Quality", r.call(this, e, n), this.el().setAttribute("aria-label", "Quality"), this.controlText("Quality"), n.dynamicLabel) t.dom.addClass(this.label, "vjs-resolution-button-label"), this.el().appendChild(this.label);
                        else {
                            var i = document.createElement("span");
                            t.dom.addClass(i, "vjs-menu-icon"), this.el().appendChild(i)
                        }
                        e.on("updateSources", t.bind(this, this.update)), e.on("resolutionchange", t.bind(this, this.update))
                    }
                });
            a.prototype.createItems = function() {
                var e = [],
                    t = this.sources && this.sources.label || {};
                for (var n in t) t.hasOwnProperty(n) && e.push(new s(this.player_, {
                    label: n,
                    src: t[n],
                    selected: n === (!!this.currentSelection && this.currentSelection.label)
                }));
                return e
            }, a.prototype.update = function() {
                this.sources = this.player_.getGroupedSrc(), this.currentSelection = this.player_.currentResolution(), this.label.innerHTML = this.currentSelection ? this.currentSelection.label : "";
                var e = this.label.innerHTML;
                if (e) {
                    var t = e.toLowerCase().replace("p", "").replace("hd", "");
                    t = parseInt(t), this.label.innerHTML = t >= 700 ? t + 'p <span class="vjs-ishd">HD</span>' : t >= 1 ? t + 'p <span class="vjs-issd">SD</span>' : "auto"
                }
                return r.prototype.update.call(this)
            }, a.prototype.buildCSSClass = function() {
                return r.prototype.buildCSSClass.call(this) + " vjs-resolution-button"
            }, r.registerComponent("ResolutionMenuButton", a), n = function(e) {
                var n = t.mergeOptions(i, e),
                    o = this;

                function s(e, t) {
                    return e.res && t.res ? +t.res - +e.res : 0
                }

                function r(e) {
                    var t = {
                        label: {},
                        res: {},
                        type: {}
                    };
                    return e.map(function(e) {
                        d(t, "label", e), d(t, "res", e), d(t, "type", e), l(t, "label", e), l(t, "res", e), l(t, "type", e)
                    }), t
                }

                function d(e, t, n) {
                    null == e[t][n[t]] && (e[t][n[t]] = [])
                }

                function l(e, t, n) {
                    e[t][n[t]].push(n)
                }
                o.updateSrc = function(e) {
                    if (!e) return o.src();
                    e = e.filter(function(e) {
                        try {
                            return "" !== o.canPlayType(e.type)
                        } catch (e) {
                            return !0
                        }
                    }), this.currentSources = e.sort(s), this.groupedSrc = r(this.currentSources);
                    var t = function(e, t) {
                        var i = n.default,
                            o = "";
                        "high" === i ? (i = t[0].res, o = t[0].label) : "low" !== i && null != i && e.res[i] ? e.res[i] && (o = e.res[i][0].label) : (i = t[t.length - 1].res, o = t[t.length - 1].label);
                        return {
                            res: i,
                            label: o,
                            sources: e.res[i]
                        }
                    }(this.groupedSrc, this.currentSources);
                    return this.currentResolutionState = {
                        label: t.label,
                        sources: t.sources
                    }, o.trigger("updateSources"), o.setSourcesSanitized(t.sources, t.label), o.trigger("resolutionchange"), o
                }, o.currentResolution = function(e, t) {
                    if (null == e) return this.currentResolutionState;
                    if (this.groupedSrc && this.groupedSrc.label && this.groupedSrc.label[e]) {
                        var i = this.groupedSrc.label[e],
                            s = o.currentTime(),
                            r = o.paused();
                        !r && this.player_.options_.bigPlayButton && this.player_.bigPlayButton.hide();
                        var a = "loadeddata";
                        return "Youtube" !== this.player_.techName_ && "none" === this.player_.preload() && "Flash" !== this.player_.techName_ && (a = "timeupdate"), o.setSourcesSanitized(i, e, t || n.customSourcePicker).one(a, function() {
                            o.currentTime(s), o.handleTechSeeked_(), r || (o.play(), o.handleTechSeeked_()), o.trigger("resolutionchange")
                        }), o
                    }
                }, o.getGroupedSrc = function() {
                    return this.groupedSrc
                }, o.setSourcesSanitized = function(e, t, n) {
                    return this.currentResolutionState = {
                        label: t,
                        sources: e
                    }, "function" == typeof n ? n(o, e, t) : (o.src(e.map(function(e) {
                        return {
                            src: e.src,
                            type: e.type,
                            res: e.res
                        }
                    })), o)
                }, o.ready(function() {
                    if (n.ui) {
                        var e = new a(o, n);
                        o.controlBar.resolutionSwitcher = o.controlBar.el_.insertBefore(e.el_, o.controlBar.getChild("fullscreenToggle").el_), o.controlBar.resolutionSwitcher.dispose = function() {
                            this.parentNode.removeChild(this)
                        }
                    }
                    var t, i, s;
                    o.options_.sources.length > 1 && o.updateSrc(o.options_.sources), "Youtube" === o.techName_ && (t = o, i = {
                        highres: {
                            res: 1080,
                            label: "1080p",
                            yt: "highres"
                        },
                        hd1080: {
                            res: 1080,
                            label: "1080p",
                            yt: "hd1080"
                        },
                        hd720: {
                            res: 720,
                            label: "720p",
                            yt: "hd720"
                        },
                        large: {
                            res: 480,
                            label: "480p",
                            yt: "large"
                        },
                        medium: {
                            res: 360,
                            label: "360p",
                            yt: "medium"
                        },
                        small: {
                            res: 240,
                            label: "240p",
                            yt: "small"
                        },
                        tiny: {
                            res: 144,
                            label: "144p",
                            yt: "tiny"
                        },
                        auto: {
                            res: 0,
                            label: "Auto",
                            yt: "auto"
                        }
                    }, s = function(e, n, i) {
                        var o = t.tech_.ytPlayer.getPlayerState(),
                            s = t.tech_.ytPlayer.getCurrentTime();
                        return t.tech_.ytPlayer.setPlaybackQuality(n[0]._yt), t.tech_.ytPlayer.seekTo(s, !0), 1 == o && t.tech_.ytPlayer.playVideo(), t.trigger("updateSources"), t
                    }, n.customSourcePicker = s, t.tech_.ytPlayer.setPlaybackQuality("auto"), t.tech_.ytPlayer.addEventListener("onPlaybackQualityChange", function(e) {
                        for (var n in i)
                            if (n.yt === e.data) return void t.currentResolution(n.label, s)
                    }), t.one("play", function() {
                        var e = t.tech_.ytPlayer.getAvailableQualityLevels(),
                            n = (t.tech_.ytPlayer.getPlaybackQuality(), []);
                        e.map(function(e) {
                            n.push({
                                src: t.src().src,
                                type: t.src().type,
                                label: i[e].label,
                                res: i[e].res,
                                _yt: i[e].yt
                            })
                        }), t.groupedSrc = r(n);
                        var o = {
                            label: "auto",
                            res: 0,
                            sources: t.groupedSrc.label.auto
                        };
                        this.currentResolutionState = {
                            label: o.label,
                            sources: o.sources
                        }, t.trigger("updateSources"), t.setSourcesSanitized(o.sources, o.label, s)
                    }))
                })
            }, t.registerPlugin("videoJsResolutionSwitcher", n)
        }(window, e)
}(),
function(e) {
    "function" == typeof define && define.amd ? define(["./video"], function(t) {
        e(window, document, t)
    }) : "object" == typeof exports && "object" == typeof module ? e(window, document, require("video.js")) : e(window, document, videojs)
}(function(e, t, n) {
    var i = function(n) {
            return new RegExp("(?:^|;\\s*)" + e.escape(n).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=").test(t.cookie)
        },
        o = function() {
            try {
                return e.localStorage.setItem("persistVolume", "persistVolume"), e.localStorage.removeItem("persistVolume"), !0
            } catch (e) {
                return !1
            }
        },
        s = function(n) {
            return o() ? e.localStorage.getItem(n) : function(n) {
                if (!n || !i(n)) return null;
                var o = new RegExp("(?:^|.*;\\s*)" + e.escape(n).replace(/[\-\.\+\*]/g, "\\$&") + "\\s*\\=\\s*((?:[^;](?!;))*[^;]?).*");
                return e.unescape(t.cookie.replace(o, "$1"))
            }(n)
        },
        r = function(n, i) {
            return o() ? e.localStorage.setItem(n, i) : function(n, i, o, s, r, a) {
                if (n && !/^(?:expires|max\-age|path|domain|secure)$/i.test(n)) {
                    var d = "";
                    if (o) switch (o.constructor) {
                        case Number:
                            d = o === 1 / 0 ? "; expires=Tue, 19 Jan 2038 03:14:07 GMT" : "; max-age=" + o;
                            break;
                        case String:
                            d = "; expires=" + o;
                            break;
                        case Date:
                            d = "; expires=" + o.toGMTString()
                    }
                    t.cookie = e.escape(n) + "=" + e.escape(i) + d + (r ? "; domain=" + r : "") + (s ? "; path=" + s : "") + (a ? "; secure" : "")
                }
            }(n, i, 1 / 0, "/")
        },
        a = {
            namespace: ""
        };
    n.registerPlugin("persistvolume", function(e) {
        var t = this,
            n = function(e) {
                var t, n, i;
                for (n = 1; n < arguments.length; n++) {
                    t = arguments[n];
                    for (i in t) t.hasOwnProperty(i) && (e[i] = t[i])
                }
                return e
            }({}, a, e || {}),
            i = n.namespace + "-volume",
            o = n.namespace + "-mute";
        t.on("volumechange", function() {
            r(i, t.volume()), r(o, t.muted())
        });
        var d = s(i);
        null !== d && t.volume(d);
        var l = s(o);
        null !== l && t.muted("true" === l)
    })
}),
function(e) {
    if ("object" == typeof exports && "undefined" != typeof module) module.exports = e();
    else if ("function" == typeof define && define.amd) define([], e);
    else {
        ("undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this).videojsBrand = e()
    }
}(function() {
    return function e(t, n, i) {
        function o(r, a) {
            if (!n[r]) {
                if (!t[r]) {
                    var d = "function" == typeof require && require;
                    if (!a && d) return d(r, !0);
                    if (s) return s(r, !0);
                    var l = new Error("Cannot find module '" + r + "'");
                    throw l.code = "MODULE_NOT_FOUND", l
                }
                var u = n[r] = {
                    exports: {}
                };
                t[r][0].call(u.exports, function(e) {
                    var n = t[r][1][e];
                    return o(n || e)
                }, u, u.exports, e, t, n, i)
            }
            return n[r].exports
        }
        for (var s = "function" == typeof require && require, r = 0; r < i.length; r++) o(i[r]);
        return o
    }({
        1: [function(e, t, n) {
            (function(e) {
                "use strict";
                Object.defineProperty(n, "__esModule", {
                    value: !0
                });
                var i, o = "undefined" != typeof window ? window.videojs : void 0 !== e ? e.videojs : null,
                    s = (i = o) && i.__esModule ? i : {
                        default: i
                    },
                    r = {
                        image: "/logo-example.png",
                        title: "Logo Title",
                        destination: "http://www.google.com",
                        destinationTarget: "_blank"
                    },
                    a = function(e) {
                        var t = this;
                        this.ready(function() {
                            ! function(e, t) {
                                var n = document.createElement("div");
                                n.className = "vjs-brand-container";
                                var i = document.createElement("a");
                                i.className = "vjs-brand-container-link", i.setAttribute("href", t.destination || r.destination), i.setAttribute("title", t.title || r.title), i.setAttribute("target", t.destinationTarget || r.destinationTarget);
                                var o = document.createElement("img");
                                o.src = t.image || r.image, i.appendChild(o), n.appendChild(i), e.controlBar.el().insertBefore(n, e.controlBar.fullscreenToggle.el()), e.addClass("vjs-brand")
                            }(t, s.default.mergeOptions(r, e))
                        })
                    };
                s.default.registerPlugin("brand", a), a.VERSION = "0.0.4", n.default = a, t.exports = n.default
            }).call(this, "undefined" != typeof global ? global : "undefined" != typeof self ? self : "undefined" != typeof window ? window : {})
        }, {}]
    }, {}, [1])(1)
}),
function(e, t) {
    "function" == typeof define && define.amd ? define([], t.bind(this, e, e.videojs)) : "undefined" != typeof module && module.exports ? module.exports = t(e, e.videojs) : t(e, e.videojs)
}(window, function(e, t) {
    "use strict";
    e.videojs_hotkeys = {
        version: "0.2.19"
    }, t.registerPlugin("hotkeys", function(n) {
        var i = this,
            o = i.el(),
            s = document,
            r = t.mergeOptions || t.util.mergeOptions,
            a = (n = r({
                volumeStep: .1,
                seekStep: 5,
                enableMute: !0,
                enableVolumeScroll: !0,
                enableFullscreen: !0,
                enableNumbers: !0,
                enableJogStyle: !1,
                alwaysCaptureHotkeys: !1,
                enableModifiersForNumbers: !0,
                enableInactiveFocus: !0,
                skipInitialFocus: !1,
                playPauseKey: function(e) {
                    return 32 === e.which || 179 === e.which
                },
                rewindKey: function(e) {
                    return 37 === e.which || 177 === e.which
                },
                forwardKey: function(e) {
                    return 39 === e.which || 176 === e.which
                },
                volumeUpKey: function(e) {
                    return 38 === e.which
                },
                volumeDownKey: function(e) {
                    return 40 === e.which
                },
                muteKey: function(e) {
                    return 77 === e.which
                },
                fullscreenKey: function(e) {
                    return 70 === e.which
                },
                customKeys: {}
            }, n || {})).volumeStep,
            d = n.seekStep,
            l = n.enableMute,
            u = n.enableVolumeScroll,
            h = n.enableFullscreen,
            c = n.enableNumbers,
            p = n.enableJogStyle,
            y = n.alwaysCaptureHotkeys,
            g = n.enableModifiersForNumbers,
            f = n.enableInactiveFocus,
            m = n.skipInitialFocus;
        o.hasAttribute("tabIndex") || o.setAttribute("tabIndex", "-1"), o.style.outline = "none", !y && i.autoplay() || m || i.one("play", function() {
            o.focus()
        }), f && i.on("userinactive", function() {
            var e = function() {
                    clearTimeout(t)
                },
                t = setTimeout(function() {
                    i.off("useractive", e), s.activeElement.parentElement == o.querySelector(".vjs-control-bar") && o.focus()
                }, 10);
            i.one("useractive", e)
        }), i.on("play", function() {
            var e = o.querySelector(".iframeblocker");
            e && "" === e.style.display && (e.style.display = "block", e.style.bottom = "39px")
        });
        var v = function(t) {
            if (i.controls()) {
                var n = t.relatedTarget || t.toElement || s.activeElement;
                if ((y || n == o || n == o.querySelector(".vjs-tech") || n == o.querySelector(".iframeblocker") || n == o.querySelector(".vjs-control-bar")) && u) {
                    t = e.event || t;
                    var r = Math.max(-1, Math.min(1, t.wheelDelta || -t.detail));
                    t.preventDefault(), 1 == r ? i.volume(i.volume() + a) : -1 == r && i.volume(i.volume() - a)
                }
            }
        };
        return i.on("keydown", function(e) {
            var t, r, u, f, m = e.which,
                v = e.preventDefault,
                A = i.duration();
            if (i.controls()) {
                var P = s.activeElement;
                if (y || P == o || P == o.querySelector(".vjs-tech") || P == o.querySelector(".vjs-control-bar") || P == o.querySelector(".iframeblocker")) switch (u = e, f = i, n.playPauseKey(u, f) ? 1 : n.rewindKey(u, f) ? 2 : n.forwardKey(u, f) ? 3 : n.volumeUpKey(u, f) ? 4 : n.volumeDownKey(u, f) ? 5 : n.muteKey(u, f) ? 6 : n.fullscreenKey(u, f) ? 7 : void 0) {
                    case 1:
                        v(), y && e.stopPropagation(), i.paused() ? i.play() : i.pause();
                        break;
                    case 2:
                        t = !i.paused(), v(), t && i.pause(), r = i.currentTime() - d, i.currentTime() <= d && (r = 0), i.currentTime(r), t && i.play();
                        break;
                    case 3:
                        t = !i.paused(), v(), t && i.pause(), (r = i.currentTime() + d) >= A && (r = t ? A - .001 : A), i.currentTime(r), t && i.play();
                        break;
                    case 5:
                        v(), p ? (r = i.currentTime() - 1, i.currentTime() <= 1 && (r = 0), i.currentTime(r)) : i.volume(i.volume() - a);
                        break;
                    case 4:
                        v(), p ? ((r = i.currentTime() + 1) >= A && (r = A), i.currentTime(r)) : i.volume(i.volume() + a);
                        break;
                    case 6:
                        l && i.muted(!i.muted());
                        break;
                    case 7:
                        h && (i.isFullscreen() ? i.exitFullscreen() : i.requestFullscreen());
                        break;
                    default:
                        if ((m > 47 && m < 59 || m > 95 && m < 106) && (g || !(e.metaKey || e.ctrlKey || e.altKey)) && c) {
                            var b = 48;
                            m > 95 && (b = 96);
                            var C = m - b;
                            v(), i.currentTime(i.duration() * C * .1)
                        }
                        for (var k in n.customKeys) {
                            var S = n.customKeys[k];
                            S && S.key && S.handler && S.key(e) && (v(), S.handler(i, n, e))
                        }
                }
            }
        }), i.on("dblclick", function(e) {
            if (i.controls()) {
                var t = e.relatedTarget || e.toElement || s.activeElement;
                t != o && t != o.querySelector(".vjs-tech") && t != o.querySelector(".iframeblocker") || h && (i.isFullscreen() ? i.exitFullscreen() : i.requestFullscreen())
            }
        }), i.on("mousewheel", v), i.on("DOMMouseScroll", v), this
    })
}), $(document).ready(function() {
        if (void 0 === e) var e = document.domain;
        var t = "h+t+t+p+s:/+/w+w+w.p+h+p+v+i+b+e+.+c+o+m/p+l+a+y+e+r+s+-+v+i+d+e+o+-+c+m+s/".replace(/\+/g, "");
        contextMenu = '<div class="vjs-context-menu vjs-item-inactive"><ul><li class="head">Share on</li><li><a class="Facebook" href="https://www.facebook.com/sharer/sharer.php?u=' + e + '" target="_blank"><span>Facebook</span></a></li><li><a class="twitter" href="https://twitter.com/share?url=' + e + '" target="_blank"><span>Twitter</span></a></li><li><a class="google" href="https://plus.google.com/share?url=' + e + '" target="_blank"><span>Google+</span></a></li><li><a href="' + t + '" title="Player info" target="_blank" style="text-align:center;"></a></li></ul></div>', $(".video-js ").append(contextMenu), $(".video-js ").oncontextmenu = function() {
            return $(".vjs-context-menu").toggleClass("vjs-item-inactive"), !1
        }, $(".video-js ").bind("contextmenu", function(e) {
            return $(".vjs-context-menu").toggleClass("vjs-item-inactive"), !1
        }), $(document).mousedown(function() {
            $(".vjs-context-menu:hover") || $(".vjs-context-menu").hasClass("vjs-item-inactive") || $(".vjs-context-menu").toggleClass("vjs-item-inactive")
        })
    }),
    function(e, t) {
        "object" == typeof exports && "undefined" != typeof module ? module.exports = t(require("video.js")) : "function" == typeof define && define.amd ? define(["videojs"], function(n) {
            return e.Youtube = t(n)
        }) : e.Youtube = t(e.videojs)
    }(this, function(e) {
        "use strict";
        var t, n, i, o, s, r, a, d, l = e.browser.IS_IOS || e.browser.IS_ANDROID,
            u = e.getTech("Tech"),
            h = e.extend(u, {
                constructor: function(e, t) {
                    u.call(this, e, t), this.setPoster(e.poster), this.setSrc(this.options_.source, !0), this.setTimeout(function() {
                        this.el_ && (this.el_.parentNode.className += " vjs-youtube", l && (this.el_.parentNode.className += " vjs-youtube-mobile"), h.isApiReady ? this.initYTPlayer() : h.apiReadyQueue.push(this))
                    }.bind(this))
                },
                dispose: function() {
                    if (this.ytPlayer) this.ytPlayer.stopVideo && this.ytPlayer.stopVideo(), this.ytPlayer.destroy && this.ytPlayer.destroy();
                    else {
                        var e = h.apiReadyQueue.indexOf(this); - 1 !== e && h.apiReadyQueue.splice(e, 1)
                    }
                    this.ytPlayer = null, this.el_.parentNode.className = this.el_.parentNode.className.replace(" vjs-youtube", "").replace(" vjs-youtube-mobile", ""), this.el_.parentNode.removeChild(this.el_), u.prototype.dispose.call(this)
                },
                createEl: function() {
                    var e = document.createElement("div");
                    e.setAttribute("id", this.options_.techId), e.setAttribute("style", "width:100%;height:100%;top:0;left:0;position:absolute"), e.setAttribute("class", "vjs-tech");
                    var t = document.createElement("div");
                    if (t.appendChild(e), !l && !this.options_.ytControls) {
                        var n = document.createElement("div");
                        n.setAttribute("class", "vjs-iframe-blocker"), n.setAttribute("style", "position:absolute;top:0;left:0;width:100%;height:100%"), n.onclick = function() {
                            this.pause()
                        }.bind(this), t.appendChild(n)
                    }
                    return t
                },
                initYTPlayer: function() {
                    var e = {
                        controls: 0,
                        modestbranding: 1,
                        rel: 0,
                        showinfo: 0,
                        loop: this.options_.loop ? 1 : 0
                    };
                    if (void 0 !== this.options_.autohide && (e.autohide = this.options_.autohide), void 0 !== this.options_.cc_load_policy && (e.cc_load_policy = this.options_.cc_load_policy), void 0 !== this.options_.ytControls && (e.controls = this.options_.ytControls), void 0 !== this.options_.disablekb && (e.disablekb = this.options_.disablekb), void 0 !== this.options_.end && (e.end = this.options_.end), void 0 !== this.options_.color && (e.color = this.options_.color), e.controls ? void 0 !== this.options_.fs && (e.fs = this.options_.fs) : e.fs = 0, void 0 !== this.options_.end && (e.end = this.options_.end), void 0 !== this.options_.hl ? e.hl = this.options_.hl : void 0 !== this.options_.language && (e.hl = this.options_.language.substr(0, 2)), void 0 !== this.options_.iv_load_policy && (e.iv_load_policy = this.options_.iv_load_policy), void 0 !== this.options_.list ? e.list = this.options_.list : this.url && void 0 !== this.url.listId && (e.list = this.url.listId), void 0 !== this.options_.listType && (e.listType = this.options_.listType), void 0 !== this.options_.modestbranding && (e.modestbranding = this.options_.modestbranding), void 0 !== this.options_.playlist && (e.playlist = this.options_.playlist), void 0 !== this.options_.playsinline && (e.playsinline = this.options_.playsinline), void 0 !== this.options_.rel && (e.rel = this.options_.rel), void 0 !== this.options_.showinfo && (e.showinfo = this.options_.showinfo), void 0 !== this.options_.start && (e.start = this.options_.start), void 0 !== this.options_.theme && (e.theme = this.options_.theme), void 0 !== this.options_.customVars) {
                        var t = this.options_.customVars;
                        Object.keys(t).forEach(function(n) {
                            e[n] = t[n]
                        })
                    }
                    this.activeVideoId = this.url ? this.url.videoId : null, this.activeList = e.list, this.ytPlayer = new YT.Player(this.options_.techId, {
                        videoId: this.activeVideoId,
                        playerVars: e,
                        events: {
                            onReady: this.onPlayerReady.bind(this),
                            onPlaybackQualityChange: this.onPlayerPlaybackQualityChange.bind(this),
                            onPlaybackRateChange: this.onPlayerPlaybackRateChange.bind(this),
                            onStateChange: this.onPlayerStateChange.bind(this),
                            onVolumeChange: this.onPlayerVolumeChange.bind(this),
                            onError: this.onPlayerError.bind(this)
                        }
                    })
                },
                onPlayerReady: function() {
                    this.options_.muted && this.ytPlayer.mute(), this.ytPlayer.getAvailablePlaybackRates().length > 1 && (this.featuresPlaybackRate = !0), this.playerReady_ = !0, this.triggerReady(), this.playOnReady ? this.play() : this.cueOnReady && (this.cueVideoById_(this.url.videoId), this.activeVideoId = this.url.videoId)
                },
                onPlayerPlaybackQualityChange: function() {},
                onPlayerPlaybackRateChange: function() {
                    this.trigger("ratechange")
                },
                onPlayerStateChange: function(e) {
                    var t = e.data;
                    if (t !== this.lastState && !this.errorNumber) switch (this.lastState = t, t) {
                        case -1:
                            this.trigger("loadstart"), this.trigger("loadedmetadata"), this.trigger("durationchange"), this.trigger("ratechange");
                            break;
                        case YT.PlayerState.ENDED:
                            this.trigger("ended");
                            break;
                        case YT.PlayerState.PLAYING:
                            this.trigger("timeupdate"), this.trigger("durationchange"), this.trigger("playing"), this.trigger("play"), this.isSeeking && this.onSeeked();
                            break;
                        case YT.PlayerState.PAUSED:
                            this.trigger("canplay"), this.isSeeking ? this.onSeeked() : this.trigger("pause");
                            break;
                        case YT.PlayerState.BUFFERING:
                            this.player_.trigger("timeupdate"), this.player_.trigger("waiting")
                    }
                },
                onPlayerVolumeChange: function() {
                    this.trigger("volumechange")
                },
                onPlayerError: function(e) {
                    this.errorNumber = e.data, this.trigger("pause"), this.trigger("error")
                },
                error: function() {
                    var e = 1e3 + this.errorNumber;
                    switch (this.errorNumber) {
                        case 5:
                            return {
                                code: e,
                                message: "Error while trying to play the video"
                            };
                        case 2:
                        case 100:
                            return {
                                code: e,
                                message: "Unable to find the video"
                            };
                        case 101:
                        case 150:
                            return {
                                code: e,
                                message: "Playback on other Websites has been disabled by the video owner."
                            }
                    }
                    return {
                        code: e,
                        message: "YouTube unknown error (" + this.errorNumber + ")"
                    }
                },
                loadVideoById_: function(e) {
                    var t = {
                        videoId: e
                    };
                    this.options_.start && (t.startSeconds = this.options_.start), this.options_.end && (t.endEnd = this.options_.end), this.ytPlayer.loadVideoById(t)
                },
                cueVideoById_: function(e) {
                    var t = {
                        videoId: e
                    };
                    this.options_.start && (t.startSeconds = this.options_.start), this.options_.end && (t.endEnd = this.options_.end), this.ytPlayer.cueVideoById(t)
                },
                src: function(e) {
                    return e && this.setSrc({
                        src: e
                    }), this.source
                },
                poster: function() {
                    return l ? null : this.poster_
                },
                setPoster: function(e) {
                    this.poster_ = e
                },
                setSrc: function(e) {
                    e && e.src && (delete this.errorNumber, this.source = e, this.url = h.parseUrl(e.src), this.options_.poster || this.url.videoId && (this.poster_ = "https://img.youtube.com/vi/" + this.url.videoId + "/0.jpg", this.trigger("posterchange"), this.checkHighResPoster()), this.options_.autoplay && !l ? this.isReady_ ? this.play() : this.playOnReady = !0 : this.activeVideoId !== this.url.videoId && (this.isReady_ ? (this.cueVideoById_(this.url.videoId), this.activeVideoId = this.url.videoId) : this.cueOnReady = !0))
                },
                autoplay: function() {
                    return this.options_.autoplay
                },
                setAutoplay: function(e) {
                    this.options_.autoplay = e
                },
                loop: function() {
                    return this.options_.loop
                },
                setLoop: function(e) {
                    this.options_.loop = e
                },
                play: function() {
                    this.url && this.url.videoId && (this.wasPausedBeforeSeek = !1, this.isReady_ ? (this.url.listId && (this.activeList === this.url.listId ? this.ytPlayer.playVideo() : (this.ytPlayer.loadPlaylist(this.url.listId), this.activeList = this.url.listId)), this.activeVideoId === this.url.videoId ? this.ytPlayer.playVideo() : (this.loadVideoById_(this.url.videoId), this.activeVideoId = this.url.videoId)) : (this.trigger("waiting"), this.playOnReady = !0))
                },
                pause: function() {
                    this.ytPlayer && this.ytPlayer.pauseVideo()
                },
                paused: function() {
                    return !this.ytPlayer || this.lastState !== YT.PlayerState.PLAYING && this.lastState !== YT.PlayerState.BUFFERING
                },
                currentTime: function() {
                    return this.ytPlayer ? this.ytPlayer.getCurrentTime() : 0
                },
                setCurrentTime: function(e) {
                    this.lastState === YT.PlayerState.PAUSED && (this.timeBeforeSeek = this.currentTime()), this.isSeeking || (this.wasPausedBeforeSeek = this.paused()), this.ytPlayer.seekTo(e, !0), this.trigger("timeupdate"), this.trigger("seeking"), this.isSeeking = !0, this.lastState === YT.PlayerState.PAUSED && this.timeBeforeSeek !== e && (clearInterval(this.checkSeekedInPauseInterval), this.checkSeekedInPauseInterval = setInterval(function() {
                        this.lastState === YT.PlayerState.PAUSED && this.isSeeking ? this.currentTime() !== this.timeBeforeSeek && (this.trigger("timeupdate"), this.onSeeked()) : clearInterval(this.checkSeekedInPauseInterval)
                    }.bind(this), 250))
                },
                seeking: function() {
                    return this.isSeeking
                },
                seekable: function() {
                    return this.ytPlayer ? e.createTimeRange(0, this.ytPlayer.getDuration()) : e.createTimeRange()
                },
                onSeeked: function() {
                    clearInterval(this.checkSeekedInPauseInterval), this.isSeeking = !1, this.wasPausedBeforeSeek && this.pause(), this.trigger("seeked")
                },
                playbackRate: function() {
                    return this.ytPlayer ? this.ytPlayer.getPlaybackRate() : 1
                },
                setPlaybackRate: function(e) {
                    this.ytPlayer && this.ytPlayer.setPlaybackRate(e)
                },
                duration: function() {
                    return this.ytPlayer ? this.ytPlayer.getDuration() : 0
                },
                currentSrc: function() {
                    return this.source && this.source.src
                },
                ended: function() {
                    return !!this.ytPlayer && this.lastState === YT.PlayerState.ENDED
                },
                volume: function() {
                    return this.ytPlayer ? this.ytPlayer.getVolume() / 100 : 1
                },
                setVolume: function(e) {
                    this.ytPlayer && this.ytPlayer.setVolume(100 * e)
                },
                muted: function() {
                    return !!this.ytPlayer && this.ytPlayer.isMuted()
                },
                setMuted: function(e) {
                    this.ytPlayer && (this.muted(!0), e ? this.ytPlayer.mute() : this.ytPlayer.unMute(), this.setTimeout(function() {
                        this.trigger("volumechange")
                    }, 50))
                },
                buffered: function() {
                    if (!this.ytPlayer || !this.ytPlayer.getVideoLoadedFraction) return e.createTimeRange();
                    var t = this.ytPlayer.getVideoLoadedFraction() * this.ytPlayer.getDuration();
                    return e.createTimeRange(0, t)
                },
                preload: function() {},
                load: function() {},
                reset: function() {},
                supportsFullScreen: function() {
                    return !0
                },
                checkHighResPoster: function() {
                    var e = "https://img.youtube.com/vi/" + this.url.videoId + "/maxresdefault.jpg";
                    try {
                        var t = new Image;
                        t.onload = function() {
                            if ("naturalHeight" in t) {
                                if (t.naturalHeight <= 90 || t.naturalWidth <= 120) return
                            } else if (t.height <= 90 || t.width <= 120) return;
                            this.poster_ = e, this.trigger("posterchange")
                        }.bind(this), t.onerror = function() {}, t.src = e
                    } catch (e) {}
                }
            });
        h.isSupported = function() {
            return !0
        }, h.canPlaySource = function(e) {
            return h.canPlayType(e.type)
        }, h.canPlayType = function(e) {
            return "video/youtube" === e
        }, h.parseUrl = function(e) {
            var t = {
                    videoId: null
                },
                n = e.match(/^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/);
            n && 11 === n[2].length && (t.videoId = n[2]);
            return (n = e.match(/[?&]list=([^#\&\?]+)/)) && n[1] && (t.listId = n[1]), t
        }, h.apiReadyQueue = [], "undefined" != typeof document && (o = "https://www.youtube.com/iframe_api", s = function() {
            YT.ready(function() {
                h.isApiReady = !0;
                for (var e = 0; e < h.apiReadyQueue.length; ++e) h.apiReadyQueue[e].initYTPlayer()
            })
        }, r = !1, a = document.createElement("script"), (d = document.getElementsByTagName("script")[0]).parentNode.insertBefore(a, d), a.onload = function() {
            r || (r = !0, s())
        }, a.onreadystatechange = function() {
            r || "complete" !== this.readyState && "loaded" !== this.readyState || (r = !0, s())
        }, a.src = o, t = ".vjs-youtube .vjs-iframe-blocker { display: none; }.vjs-youtube.vjs-user-inactive .vjs-iframe-blocker { display: block; }.vjs-youtube .vjs-poster { background-size: cover; }.vjs-youtube-mobile .vjs-big-play-button { display: none; }", n = document.head || document.getElementsByTagName("head")[0], (i = document.createElement("style")).type = "text/css", i.styleSheet ? i.styleSheet.cssText = t : i.appendChild(document.createTextNode(t)), n.appendChild(i)), void 0 !== e.registerTech ? e.registerTech("Youtube", h) : e.registerComponent("Youtube", h)
    }),
    function(e, t) {
        "object" == typeof exports && "undefined" != typeof module ? module.exports = t(require("video.js")) : "function" == typeof define && define.amd ? define(["video.js"], t) : e.videojsContribAds = t(e.videojs)
    }(this, function(e) {
        "use strict";
        e = e && e.hasOwnProperty("default") ? e.default : e;
        var t = function(e, t) {
                t.isImmediatePropagationStopped = function() {
                    return !0
                }, t.cancelBubble = !0, t.isPropagationStopped = function() {
                    return !0
                }
            },
            n = function(e, n, i) {
                t(0, i), e.trigger({
                    type: n + i.type,
                    originalEvent: i
                })
            },
            i = function(e, t) {
                e.ads.isInAdMode() && (e.ads.isContentResuming() ? e.ads._contentEnding && n(e, "content", t) : n(e, "ad", t))
            },
            o = function(e, i) {
                e.ads.isInAdMode() ? e.ads.isContentResuming() ? (t(0, i), e.trigger("resumeended")) : n(e, "ad", i) : e.ads._contentHasEnded || (n(e, "content", i), e.trigger("readyforpostroll"))
            },
            s = function(e, t) {
                if (!("loadstart" === t.type && !e.ads._hasThereBeenALoadStartDuringPlayerLife || "loadeddata" === t.type && !e.ads._hasThereBeenALoadedData || "loadedmetadata" === t.type && !e.ads._hasThereBeenALoadedMetaData))
                    if (e.ads.inAdBreak()) n(e, "ad", t);
                    else {
                        if (e.currentSrc() !== e.ads.contentSrc) return;
                        n(e, "content", t)
                    }
            },
            r = function(e, t) {
                e.ads.inAdBreak() ? n(e, "ad", t) : e.ads.isContentResuming() && n(e, "content", t)
            };

        function a(e) {
            "playing" === e.type ? i(this, e) : "ended" === e.type ? o(this, e) : "loadstart" === e.type || "loadeddata" === e.type || "loadedmetadata" === e.type ? s(this, e) : "play" === e.type ? r(this, e) : this.ads.isInAdMode() && (this.ads.isContentResuming() ? n(this, "content", e) : n(this, "ad", e))
        }
        var d, l = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : {},
            u = "undefined" != typeof window ? window : void 0 !== l ? l : "undefined" != typeof self ? self : {},
            h = {},
            c = (Object.freeze || Object)({
                default: h
            }),
            p = c && h || c,
            y = void 0 !== l ? l : "undefined" != typeof window ? window : {};
        "undefined" != typeof document ? d = document : (d = y["__GLOBAL_DOCUMENT_CACHE@4"]) || (d = y["__GLOBAL_DOCUMENT_CACHE@4"] = p);
        var g = d,
            f = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function(e) {
                return typeof e
            } : function(e) {
                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
            },
            m = (function() {
                function e(e) {
                    var t, n;

                    function i(t, n) {
                        try {
                            var s = e[t](n),
                                r = s.value;
                            r instanceof
                            function(e) {
                                this.value = e
                            } ? Promise.resolve(r.value).then(function(e) {
                                i("next", e)
                            }, function(e) {
                                i("throw", e)
                            }): o(s.done ? "return" : "normal", s.value)
                        } catch (e) {
                            o("throw", e)
                        }
                    }

                    function o(e, o) {
                        switch (e) {
                            case "return":
                                t.resolve({
                                    value: o,
                                    done: !0
                                });
                                break;
                            case "throw":
                                t.reject(o);
                                break;
                            default:
                                t.resolve({
                                    value: o,
                                    done: !1
                                })
                        }(t = t.next) ? i(t.key, t.arg): n = null
                    }
                    this._invoke = function(e, o) {
                        return new Promise(function(s, r) {
                            var a = {
                                key: e,
                                arg: o,
                                resolve: s,
                                reject: r,
                                next: null
                            };
                            n ? n = n.next = a : (t = n = a, i(e, o))
                        })
                    }, "function" != typeof e.return && (this.return = void 0)
                }
                "function" == typeof Symbol && Symbol.asyncIterator && (e.prototype[Symbol.asyncIterator] = function() {
                    return this
                }), e.prototype.next = function(e) {
                    return this._invoke("next", e)
                }, e.prototype.throw = function(e) {
                    return this._invoke("throw", e)
                }, e.prototype.return = function(e) {
                    return this._invoke("return", e)
                }
            }(), function(e, t) {
                if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function")
            }),
            v = function(e, t) {
                if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function, not " + typeof t);
                e.prototype = Object.create(t && t.prototype, {
                    constructor: {
                        value: e,
                        enumerable: !1,
                        writable: !0,
                        configurable: !0
                    }
                }), t && (Object.setPrototypeOf ? Object.setPrototypeOf(e, t) : e.__proto__ = t)
            },
            A = function(e, t) {
                if (!e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
                return !t || "object" != typeof t && "function" != typeof t ? e : t
            },
            P = function(e, t) {
                return t ? encodeURIComponent(e) : e
            },
            b = function(e, t, n) {
                if (e && e[n])
                    for (var i = e[n], o = Object.keys(i), s = 0; s < o.length; s++) t["{mediainfo." + n + "." + o[s] + "}"] = i[o[s]]
            },
            C = {
                processMetadataTracks: function(e, t) {
                    for (var n = e.textTracks(), i = function(n) {
                            "metadata" === n.kind && (e.ads.cueTextTracks.setMetadataTrackMode(n), t(e, n))
                        }, o = 0; o < n.length; o++) i(n[o]);
                    n.addEventListener("addtrack", function(e) {
                        i(e.track)
                    })
                },
                setMetadataTrackMode: function(e) {},
                getSupportedAdCue: function(e, t) {
                    return t
                },
                isSupportedAdCue: function(e, t) {
                    return !0
                },
                getCueId: function(e, t) {
                    return t.id
                }
            };

        function k() {
            var e = this;
            !1 !== e.ads._shouldBlockPlay && (e.paused() || (e.ads.debug("Playback was canceled by cancelContentPlay"), e.pause()), e.ads._cancelledPlay = !0)
        }
        C.processAdTrack = function(t, n, i, o) {
            t.ads.includedCues = {};
            for (var s = 0; s < n.length; s++) {
                var r = n[s],
                    a = this.getSupportedAdCue(t, r);
                if (!this.isSupportedAdCue(t, r)) return void e.log.warn("Skipping as this is not a supported ad cue.", r);
                var d = this.getCueId(t, r),
                    l = r.startTime;
                if (void 0 !== (h = d) && t.ads.includedCues[h]) return void e.log("Skipping ad already seen with ID " + d);
                o && o(t, a, d, l), i(t, a, d, l), void 0 !== (u = d) && "" !== u && (t.ads.includedCues[u] = !0)
            }
            var u, h
        };
        var S = {},
            T = e;
        S.isMiddlewareMediatorSupported = function() {
            return !T.browser.IS_IOS && !T.browser.IS_ANDROID && !!(T.use && T.middleware && T.middleware.TERMINATOR)
        }, S.playMiddleware = function(e) {
            return {
                setSource: function(e, t) {
                    t(null, e)
                },
                callPlay: function() {
                    if (e.ads && !0 === e.ads._shouldBlockPlay) return e.ads.debug("Using playMiddleware to block content playback"), e.ads._playBlocked = !0, T.middleware.TERMINATOR
                },
                play: function(t, n) {
                    e.ads && e.ads._playBlocked && t && (e.ads.debug("Play call to Tech was terminated."), e.trigger("play"), e.addClass("vjs-has-started"), e.ads._playBlocked = !1)
                }
            }
        }, S.testHook = function(e) {
            T = e
        };
        var w = function() {
                function t(e) {
                    m(this, t), this.player = e
                }
                return t._getName = function() {
                    return "Anonymous State"
                }, t.prototype.transitionTo = function(e) {
                    var t = this.player;
                    this.cleanup(t);
                    var n = new e(t);
                    t.ads._state = n, t.ads.debug(this.constructor._getName() + " -> " + n.constructor._getName());
                    for (var i = arguments.length, o = Array(1 < i ? i - 1 : 0), s = 1; s < i; s++) o[s - 1] = arguments[s];
                    n.init.apply(n, [t].concat(o))
                }, t.prototype.init = function() {}, t.prototype.cleanup = function() {}, t.prototype.onPlay = function() {}, t.prototype.onPlaying = function() {}, t.prototype.onEnded = function() {}, t.prototype.onAdsReady = function() {
                    e.log.warn("Unexpected adsready event")
                }, t.prototype.onAdsError = function() {}, t.prototype.onAdsCanceled = function() {}, t.prototype.onAdTimeout = function() {}, t.prototype.onAdStarted = function() {}, t.prototype.onContentChanged = function() {}, t.prototype.onContentResumed = function() {}, t.prototype.onReadyForPostroll = function() {
                    e.log.warn("Unexpected readyforpostroll event")
                }, t.prototype.onNoPreroll = function() {}, t.prototype.onNoPostroll = function() {}, t.prototype.startLinearAdMode = function() {
                    e.log.warn("Unexpected startLinearAdMode invocation (State via " + this.constructor._getName() + ")")
                }, t.prototype.endLinearAdMode = function() {
                    e.log.warn("Unexpected endLinearAdMode invocation (State via " + this.constructor._getName() + ")")
                }, t.prototype.skipLinearAdMode = function() {
                    e.log.warn("Unexpected skipLinearAdMode invocation (State via " + this.constructor._getName() + ")")
                }, t.prototype.isAdState = function() {
                    throw new Error("isAdState unimplemented for " + this.constructor._getName())
                }, t.prototype.isWaitingForAdBreak = function() {
                    return !1
                }, t.prototype.isContentResuming = function() {
                    return !1
                }, t.prototype.inAdBreak = function() {
                    return !1
                }, t.prototype.handleEvent = function(e) {
                    var t = this.player;
                    "play" === e ? this.onPlay(t) : "adsready" === e ? this.onAdsReady(t) : "adserror" === e ? this.onAdsError(t) : "adscanceled" === e ? this.onAdsCanceled(t) : "adtimeout" === e ? this.onAdTimeout(t) : "ads-ad-started" === e ? this.onAdStarted(t) : "contentchanged" === e ? this.onContentChanged(t) : "contentresumed" === e ? this.onContentResumed(t) : "readyforpostroll" === e ? this.onReadyForPostroll(t) : "playing" === e ? this.onPlaying(t) : "ended" === e ? this.onEnded(t) : "nopreroll" === e ? this.onNoPreroll(t) : "nopostroll" === e && this.onNoPostroll(t)
                }, t
            }(),
            _ = function(e) {
                function t(n) {
                    m(this, t);
                    var i = A(this, e.call(this, n));
                    return i.contentResuming = !1, i.waitingForAdBreak = !1, i
                }
                return v(t, e), t.prototype.isAdState = function() {
                    return !0
                }, t.prototype.onPlaying = function() {
                    this.contentResuming && this.transitionTo(B)
                }, t.prototype.onContentResumed = function() {
                    this.contentResuming && this.transitionTo(B)
                }, t.prototype.isWaitingForAdBreak = function() {
                    return this.waitingForAdBreak
                }, t.prototype.isContentResuming = function() {
                    return this.contentResuming
                }, t.prototype.inAdBreak = function() {
                    return !0 === this.player.ads._inLinearAdMode
                }, t
            }(w),
            L = function(e) {
                function t() {
                    return m(this, t), A(this, e.apply(this, arguments))
                }
                return v(t, e), t.prototype.isAdState = function() {
                    return !1
                }, t.prototype.onContentChanged = function(e) {
                    e.ads.debug("Received contentchanged event (ContentState)"), e.paused() ? this.transitionTo(I) : (this.transitionTo(R, !1), e.pause(), e.ads._pausedOnContentupdate = !0)
                }, t
            }(w),
            E = function(t) {
                t.ads.debug("Starting ad break"), t.ads._inLinearAdMode = !0, t.trigger("adstart"), t.ads.shouldPlayContentBehindAd(t) || (t.ads.snapshot = function(t) {
                    var n;
                    n = e.browser.IS_IOS && t.ads.isLive(t) && 0 < t.seekable().length ? t.currentTime() - t.seekable().end(0) : t.currentTime();
                    var i = t.$(".vjs-tech"),
                        o = t.textTracks ? t.textTracks() : [],
                        s = [],
                        r = {
                            ended: t.ended(),
                            currentSrc: t.currentSrc(),
                            src: t.tech_.src(),
                            currentTime: n,
                            type: t.currentType()
                        };
                    i && (r.nativePoster = i.poster, r.style = i.getAttribute("style"));
                    for (var a = 0; a < o.length; a++) {
                        var d = o[a];
                        s.push({
                            track: d,
                            mode: d.mode
                        }), d.mode = "disabled"
                    }
                    return r.suppressedTracks = s, r
                }(t)), t.ads.shouldPlayContentBehindAd(t) && (t.ads.preAdVolume_ = t.volume(), t.volume(0)), t.addClass("vjs-ad-playing"), t.hasClass("vjs-live") && t.removeClass("vjs-live"), t.ads.removeNativePoster()
            },
            M = function(t, n) {
                t.ads.debug("Ending ad break"), void 0 === n && (n = function() {}), t.ads.adType = null, t.ads._inLinearAdMode = !1, t.trigger("adend"), t.removeClass("vjs-ad-playing"), t.ads.isLive(t) && t.addClass("vjs-live"), t.ads.shouldPlayContentBehindAd(t) ? (t.volume(t.ads.preAdVolume_), n()) : function(t, n, i) {
                    if (void 0 === i && (i = function() {}), !0 === t.ads.disableNextSnapshotRestore) return t.ads.disableNextSnapshotRestore = !1, i();
                    var o = t.$(".vjs-tech"),
                        s = 20,
                        r = n.suppressedTracks,
                        a = void 0,
                        d = function() {
                            for (var e = 0; e < r.length; e++)(a = r[e]).track.mode = a.mode
                        },
                        l = function() {
                            var i = void 0;
                            e.browser.IS_IOS && t.ads.isLive(t) ? n.currentTime < 0 && (i = 0 < t.seekable().length ? t.seekable().end(0) + n.currentTime : t.currentTime(), t.currentTime(i)) : n.ended ? t.currentTime(t.duration()) : (t.currentTime(n.currentTime), t.play()), t.ads.shouldRemoveAutoplay_ && (t.autoplay(!1), t.ads.shouldRemoveAutoplay_ = !1)
                        },
                        u = function n() {
                            if (t.off("contentcanplay", n), t.ads.tryToResumeTimeout_ && (t.clearTimeout(t.ads.tryToResumeTimeout_), t.ads.tryToResumeTimeout_ = null), 1 < (o = t.el().querySelector(".vjs-tech")).readyState) return l();
                            if (void 0 === o.seekable) return l();
                            if (0 < o.seekable.length) return l();
                            if (s--) t.setTimeout(n, 50);
                            else try {
                                l()
                            } catch (t) {
                                e.log.warn("Failed to resume the content after an advertisement", t)
                            }
                        };
                    n.nativePoster && (o.poster = n.nativePoster), "style" in n && o.setAttribute("style", n.style || ""), t.ads.videoElementRecycled() ? (t.one("resumeended", i), t.one("contentloadedmetadata", d), e.browser.IS_IOS && !t.autoplay() && (t.autoplay(!0), t.ads.shouldRemoveAutoplay_ = !0), t.src({
                        src: n.currentSrc,
                        type: n.type
                    }), t.one("contentcanplay", u), t.ads.tryToResumeTimeout_ = t.setTimeout(u, 2e3)) : (d(), t.ended() || t.play(), i())
                }(t, t.ads.snapshot, n)
            },
            R = function(t) {
                function n() {
                    return m(this, n), A(this, t.apply(this, arguments))
                }
                return v(n, t), n._getName = function() {
                    return "Preroll"
                }, n.prototype.init = function(e, t, n) {
                    if (this.waitingForAdBreak = !0, e.addClass("vjs-ad-loading"), n || e.ads.nopreroll_) return this.resumeAfterNoPreroll(e);
                    var i = e.ads.settings.timeout;
                    "number" == typeof e.ads.settings.prerollTimeout && (i = e.ads.settings.prerollTimeout), this._timeout = e.setTimeout(function() {
                        e.trigger("adtimeout")
                    }, i), t ? this.handleAdsReady() : this.adsReady = !1
                }, n.prototype.onAdsReady = function(t) {
                    t.ads.inAdBreak() ? e.log.warn("Unexpected adsready event (Preroll)") : (t.ads.debug("Received adsready event (Preroll)"), this.handleAdsReady())
                }, n.prototype.handleAdsReady = function() {
                    this.adsReady = !0, this.readyForPreroll()
                }, n.prototype.afterLoadStart = function(e) {
                    var t = this.player;
                    t.ads._hasThereBeenALoadStartDuringPlayerLife ? e() : (t.ads.debug("Waiting for loadstart..."), t.one("loadstart", function() {
                        t.ads.debug("Received loadstart event"), e()
                    }))
                }, n.prototype.noPreroll = function() {
                    var e = this;
                    this.afterLoadStart(function() {
                        e.player.ads.debug("Skipping prerolls due to nopreroll event (Preroll)"), e.resumeAfterNoPreroll(e.player)
                    })
                }, n.prototype.readyForPreroll = function() {
                    var e = this.player;
                    this.afterLoadStart(function() {
                        e.ads.debug("Triggered readyforpreroll event (Preroll)"), e.trigger("readyforpreroll")
                    })
                }, n.prototype.onAdsCanceled = function(e) {
                    var t = this;
                    e.ads.debug("adscanceled (Preroll)"), this.afterLoadStart(function() {
                        t.resumeAfterNoPreroll(e)
                    })
                }, n.prototype.onAdsError = function(t) {
                    var n = this;
                    e.log("adserror (Preroll)"), this.inAdBreak() ? t.ads.endLinearAdMode() : this.afterLoadStart(function() {
                        n.resumeAfterNoPreroll(t)
                    })
                }, n.prototype.startLinearAdMode = function() {
                    var t = this.player;
                    !this.adsReady || t.ads.inAdBreak() || this.isContentResuming() ? e.log.warn("Unexpected startLinearAdMode invocation (Preroll)") : (t.clearTimeout(this._timeout), t.ads.adType = "preroll", this.waitingForAdBreak = !1, E(t), t.ads._shouldBlockPlay = !1)
                }, n.prototype.onAdStarted = function(e) {
                    e.removeClass("vjs-ad-loading")
                }, n.prototype.endLinearAdMode = function() {
                    var e = this.player;
                    this.inAdBreak() && (e.removeClass("vjs-ad-loading"), e.addClass("vjs-ad-content-resuming"), M(e), this.contentResuming = !0)
                }, n.prototype.skipLinearAdMode = function() {
                    var t = this,
                        n = this.player;
                    n.ads.inAdBreak() || this.isContentResuming() ? e.log.warn("Unexpected skipLinearAdMode invocation") : this.afterLoadStart(function() {
                        n.trigger("adskip"), n.ads.debug("skipLinearAdMode (Preroll)"), t.resumeAfterNoPreroll(n)
                    })
                }, n.prototype.onAdTimeout = function(e) {
                    var t = this;
                    this.afterLoadStart(function() {
                        e.ads.debug("adtimeout (Preroll)"), t.resumeAfterNoPreroll(e)
                    })
                }, n.prototype.onNoPreroll = function(t) {
                    t.ads.inAdBreak() || this.isContentResuming() ? e.log.warn("Unexpected nopreroll event (Preroll)") : this.noPreroll()
                }, n.prototype.resumeAfterNoPreroll = function(e) {
                    this.contentResuming = !0, e.ads._shouldBlockPlay = !1, e.paused() && (e.ads._playRequested || e.ads._pausedOnContentupdate) && e.play()
                }, n.prototype.cleanup = function(t) {
                    t.ads._hasThereBeenALoadStartDuringPlayerLife || e.log.warn("Leaving Preroll state before loadstart event can cause issues."), t.removeClass("vjs-ad-loading"), t.removeClass("vjs-ad-content-resuming"), t.clearTimeout(this._timeout)
                }, n
            }(_),
            D = function(e) {
                function t() {
                    return m(this, t), A(this, e.apply(this, arguments))
                }
                return v(t, e), t._getName = function() {
                    return "Midroll"
                }, t.prototype.init = function(e) {
                    e.ads.adType = "midroll", E(e), e.addClass("vjs-ad-loading")
                }, t.prototype.onAdStarted = function(e) {
                    e.removeClass("vjs-ad-loading")
                }, t.prototype.endLinearAdMode = function() {
                    var e = this.player;
                    this.inAdBreak() && (this.contentResuming = !0, e.addClass("vjs-ad-content-resuming"), e.removeClass("vjs-ad-loading"), M(e))
                }, t.prototype.onAdsError = function(e) {
                    this.inAdBreak() && e.ads.endLinearAdMode()
                }, t.prototype.cleanup = function(e) {
                    e.removeClass("vjs-ad-loading"), e.removeClass("vjs-ad-content-resuming")
                }, t
            }(_),
            j = function(t) {
                function n() {
                    return m(this, n), A(this, t.apply(this, arguments))
                }
                return v(n, t), n._getName = function() {
                    return "Postroll"
                }, n.prototype.init = function(e) {
                    if (this.waitingForAdBreak = !0, e.ads._contentEnding = !0, e.ads.nopostroll_) this.resumeContent(e), this.transitionTo(N);
                    else {
                        e.addClass("vjs-ad-loading");
                        var t = e.ads.settings.timeout;
                        "number" == typeof e.ads.settings.postrollTimeout && (t = e.ads.settings.postrollTimeout), this._postrollTimeout = e.setTimeout(function() {
                            e.trigger("adtimeout")
                        }, t)
                    }
                }, n.prototype.startLinearAdMode = function() {
                    var t = this.player;
                    t.ads.inAdBreak() || this.isContentResuming() ? e.log.warn("Unexpected startLinearAdMode invocation (Postroll)") : (t.ads.adType = "postroll", t.clearTimeout(this._postrollTimeout), this.waitingForAdBreak = !1, E(t))
                }, n.prototype.onAdStarted = function(e) {
                    e.removeClass("vjs-ad-loading")
                }, n.prototype.endLinearAdMode = function() {
                    var e = this,
                        t = this.player;
                    this.inAdBreak() && (t.removeClass("vjs-ad-loading"), this.resumeContent(t), M(t, function() {
                        e.transitionTo(N)
                    }))
                }, n.prototype.skipLinearAdMode = function() {
                    var t = this.player;
                    t.ads.inAdBreak() || this.isContentResuming() ? e.log.warn("Unexpected skipLinearAdMode invocation") : (t.ads.debug("Postroll abort (skipLinearAdMode)"), t.trigger("adskip"), this.abort(t))
                }, n.prototype.onAdTimeout = function(e) {
                    e.ads.debug("Postroll abort (adtimeout)"), this.abort(e)
                }, n.prototype.onAdsError = function(e) {
                    e.ads.debug("Postroll abort (adserror)"), e.ads.inAdBreak() ? e.ads.endLinearAdMode() : this.abort(e)
                }, n.prototype.onContentChanged = function(e) {
                    this.isContentResuming() ? this.transitionTo(I) : this.inAdBreak() || this.transitionTo(R)
                }, n.prototype.onNoPostroll = function(t) {
                    this.isContentResuming() || this.inAdBreak() ? e.log.warn("Unexpected nopostroll event (Postroll)") : this.transitionTo(N)
                }, n.prototype.resumeContent = function(e) {
                    this.contentResuming = !0, e.addClass("vjs-ad-content-resuming")
                }, n.prototype.abort = function(e) {
                    this.resumeContent(e), e.removeClass("vjs-ad-loading"), this.transitionTo(N)
                }, n.prototype.cleanup = function(e) {
                    e.removeClass("vjs-ad-content-resuming"), e.clearTimeout(this._postrollTimeout), e.ads._contentEnding = !1
                }, n
            }(_),
            I = function(e) {
                function t() {
                    return m(this, t), A(this, e.apply(this, arguments))
                }
                return v(t, e), t._getName = function() {
                    return "BeforePreroll"
                }, t.prototype.init = function(e) {
                    this.adsReady = !1, this.shouldResumeToContent = !1, e.ads._shouldBlockPlay = !0
                }, t.prototype.onAdsReady = function(e) {
                    e.ads.debug("Received adsready event (BeforePreroll)"), this.adsReady = !0
                }, t.prototype.onPlay = function(e) {
                    e.ads.debug("Received play event (BeforePreroll)"), this.transitionTo(R, this.adsReady, this.shouldResumeToContent)
                }, t.prototype.onAdsCanceled = function(e) {
                    e.ads.debug("adscanceled (BeforePreroll)"), this.shouldResumeToContent = !0
                }, t.prototype.onAdsError = function() {
                    this.player.ads.debug("adserror (BeforePreroll)"), this.shouldResumeToContent = !0
                }, t.prototype.onNoPreroll = function() {
                    this.player.ads.debug("Skipping prerolls due to nopreroll event (BeforePreroll)"), this.shouldResumeToContent = !0
                }, t.prototype.skipLinearAdMode = function() {
                    var e = this.player;
                    e.trigger("adskip"), e.ads.debug("skipLinearAdMode (BeforePreroll)"), this.shouldResumeToContent = !0
                }, t.prototype.onContentChanged = function() {}, t
            }(L),
            B = function(e) {
                function t() {
                    return m(this, t), A(this, e.apply(this, arguments))
                }
                return v(t, e), t._getName = function() {
                    return "ContentPlayback"
                }, t.prototype.init = function(e) {
                    e.ads._shouldBlockPlay = !1
                }, t.prototype.onAdsReady = function(e) {
                    e.ads.debug("Received adsready event (ContentPlayback)"), e.ads.nopreroll_ || (e.ads.debug("Triggered readyforpreroll event (ContentPlayback)"), e.trigger("readyforpreroll"))
                }, t.prototype.onReadyForPostroll = function(e) {
                    e.ads.debug("Received readyforpostroll event"), this.transitionTo(j)
                }, t.prototype.startLinearAdMode = function() {
                    this.transitionTo(D)
                }, t
            }(L),
            N = function(t) {
                function n() {
                    return m(this, n), A(this, t.apply(this, arguments))
                }
                return v(n, t), n._getName = function() {
                    return "AdsDone"
                }, n.prototype.init = function(e) {
                    e.ads._contentHasEnded = !0, e.trigger("ended")
                }, n.prototype.startLinearAdMode = function() {
                    e.log.warn("Unexpected startLinearAdMode invocation (AdsDone)")
                }, n
            }(L),
            x = S.playMiddleware,
            F = S.isMiddlewareMediatorSupported,
            V = e.getTech("Html5").Events,
            U = {
                timeout: 5e3,
                prerollTimeout: void 0,
                postrollTimeout: void 0,
                debug: !1,
                stitchedAds: !1,
                contentIsLive: void 0
            },
            O = function(t) {
                var n, i, o, s = this,
                    r = e.mergeOptions(U, t),
                    d = V.concat(["firstplay", "loadedalldata", "playing"]);
                s.on(d, a), F() && r.debug ? e.log("ADS:", "Play middleware has been registered with videojs") : (n = s, r.debug && e.log("ADS:", "Using cancelContentPlay to block content playback"), n.on("play", k)), s.setTimeout(function() {
                    s.ads._hasThereBeenALoadStartDuringPlayerLife || "" === s.src() || e.log.error("videojs-contrib-ads has not seen a loadstart event 5 seconds after being initialized, but a source is present. This indicates that videojs-contrib-ads was initialized too late. It must be initialized immediately after video.js in the same tick. As a result, some ads will not play and some media events will be incorrect. For more information, see http://videojs.github.io/videojs-contrib-ads/integrator/getting-started.html")
                }, 5e3), s.on("ended", function() {
                    s.hasClass("vjs-has-started") || s.addClass("vjs-has-started")
                }), s.on("contenttimeupdate", function() {
                    s.removeClass("vjs-waiting")
                }), s.on(["addurationchange", "adcanplay"], function() {
                    s.ads.snapshot && s.currentSrc() === s.ads.snapshot.currentSrc || s.ads.inAdBreak() && s.play()
                }), s.on("nopreroll", function() {
                    s.ads.debug("Received nopreroll event"), s.ads.nopreroll_ = !0
                }), s.on("nopostroll", function() {
                    s.ads.debug("Received nopostroll event"), s.ads.nopostroll_ = !0
                }), s.on("playing", function() {
                    s.ads._cancelledPlay = !1, s.ads._pausedOnContentupdate = !1
                }), s.on("play", function() {
                    s.ads._playRequested = !0
                }), s.one("loadstart", function() {
                    s.ads._hasThereBeenALoadStartDuringPlayerLife = !0
                }), s.on("loadeddata", function() {
                    s.ads._hasThereBeenALoadedData = !0
                }), s.on("loadedmetadata", function() {
                    s.ads._hasThereBeenALoadedMetaData = !0
                }), s.ads = (i = s, {
                    disableNextSnapshotRestore: !1,
                    _contentEnding: !1,
                    _contentHasEnded: !1,
                    _hasThereBeenALoadStartDuringPlayerLife: !1,
                    _hasThereBeenALoadedData: !1,
                    _hasThereBeenALoadedMetaData: !1,
                    _inLinearAdMode: !1,
                    _shouldBlockPlay: !1,
                    _playBlocked: !1,
                    _playRequested: !1,
                    adType: null,
                    VERSION: "6.3.0",
                    reset: function() {
                        i.ads.disableNextSnapshotRestore = !1, i.ads._contentEnding = !1, i.ads._contentHasEnded = !1, i.ads.snapshot = null, i.ads.adType = null, i.ads._hasThereBeenALoadedData = !1, i.ads._hasThereBeenALoadedMetaData = !1, i.ads._cancelledPlay = !1, i.ads._shouldBlockPlay = !1, i.ads._playBlocked = !1, i.ads.nopreroll_ = !1, i.ads.nopostroll_ = !1, i.ads._playRequested = !1
                    },
                    startLinearAdMode: function() {
                        i.ads._state.startLinearAdMode()
                    },
                    endLinearAdMode: function() {
                        i.ads._state.endLinearAdMode()
                    },
                    skipLinearAdMode: function() {
                        i.ads._state.skipLinearAdMode()
                    },
                    stitchedAds: function(e) {
                        return void 0 !== e && (this._stitchedAds = !!e), this._stitchedAds
                    },
                    videoElementRecycled: function() {
                        if (i.ads.shouldPlayContentBehindAd(i)) return !1;
                        if (!this.snapshot) throw new Error("You cannot use videoElementRecycled while there is no snapshot.");
                        var e = i.tech_.src() !== this.snapshot.src,
                            t = i.currentSrc() !== this.snapshot.currentSrc;
                        return e || t
                    },
                    isLive: function(t) {
                        return "boolean" == typeof t.ads.settings.contentIsLive ? t.ads.settings.contentIsLive : t.duration() === 1 / 0 || "8" === e.browser.IOS_VERSION && 0 === t.duration()
                    },
                    shouldPlayContentBehindAd: function(t) {
                        return !e.browser.IS_IOS && !e.browser.IS_ANDROID && t.duration() === 1 / 0
                    },
                    isInAdMode: function() {
                        return this._state.isAdState()
                    },
                    isWaitingForAdBreak: function() {
                        return this._state.isWaitingForAdBreak()
                    },
                    isContentResuming: function() {
                        return this._state.isContentResuming()
                    },
                    isAdPlaying: function() {
                        return this._state.inAdBreak()
                    },
                    inAdBreak: function() {
                        return this._state.inAdBreak()
                    },
                    removeNativePoster: function() {
                        var e = i.$(".vjs-tech");
                        e && e.removeAttribute("poster")
                    },
                    debug: function() {
                        if (this.settings.debug) {
                            for (var t = arguments.length, n = Array(t), i = 0; i < t; i++) n[i] = arguments[i];
                            1 === n.length && "string" == typeof n[0] ? e.log("ADS: " + n[0]) : e.log.apply(e, ["ADS:"].concat(n))
                        }
                    }
                }), s.ads.settings = r, s.ads._state = new I(s), s.ads._state.init(s), s.ads.stitchedAds(r.stitchedAds), s.ads.cueTextTracks = C, s.ads.adMacroReplacement = function(t, n, i) {
                    void 0 === n && (n = !1);
                    var o = {};
                    for (var s in void 0 !== i && (o = i), o["{player.id}"] = this.options_["data-player"], o["{mediainfo.id}"] = this.mediainfo ? this.mediainfo.id : "", o["{mediainfo.name}"] = this.mediainfo ? this.mediainfo.name : "", o["{mediainfo.description}"] = this.mediainfo ? this.mediainfo.description : "", o["{mediainfo.tags}"] = this.mediainfo ? this.mediainfo.tags : "", o["{mediainfo.reference_id}"] = this.mediainfo ? this.mediainfo.reference_id : "", o["{mediainfo.duration}"] = this.mediainfo ? this.mediainfo.duration : "", o["{mediainfo.ad_keys}"] = this.mediainfo ? this.mediainfo.ad_keys : "", o["{player.duration}"] = this.duration(), o["{timestamp}"] = (new Date).getTime(), o["{document.referrer}"] = g.referrer, o["{window.location.href}"] = u.location.href, o["{random}"] = Math.floor(1e12 * Math.random()), b(this.mediainfo, o, "custom_fields"), b(this.mediainfo, o, "customFields"), o) t = t.split(s).join(P(o[s], n));
                    return t.replace(/{pageVariable\.([^}]+)}/g, function(t, i) {
                        for (var o = void 0, s = u, r = i.split("."), a = 0; a < r.length; a++) a === r.length - 1 ? o = s[r[a]] : s = s[r[a]];
                        var d = void 0 === o ? "undefined" : f(o);
                        return null === o ? "null" : void 0 === o ? (e.log.warn('Page variable "' + i + '" not found'), "") : "string" !== d && "number" !== d && "boolean" !== d ? (e.log.warn('Page variable "' + i + '" is not a supported type'), "") : P(String(o), n)
                    })
                }.bind(s), (o = s).ads.contentSrc = o.currentSrc(), o.ads._seenInitialLoadstart = !1, o.on("loadstart", function() {
                    if (!o.ads.inAdBreak()) {
                        var e = o.currentSrc();
                        e !== o.ads.contentSrc && (o.ads._seenInitialLoadstart && o.trigger({
                            type: "contentchanged"
                        }), o.trigger({
                            type: "contentupdate",
                            oldValue: o.ads.contentSrc,
                            newValue: e
                        }), o.ads.contentSrc = e), o.ads._seenInitialLoadstart = !0
                    }
                }), s.on("contentchanged", s.ads.reset);
                var l = function() {
                    var t = s.textTracks();
                    if (!s.ads.shouldPlayContentBehindAd(s) && s.ads.inAdBreak() && s.tech_.featuresNativeTextTracks && e.browser.IS_IOS && !Array.isArray(s.textTracks()))
                        for (var n = 0; n < t.length; n++) {
                            var i = t[n];
                            "showing" === i.mode && (i.mode = "disabled")
                        }
                };
                s.ready(function() {
                    s.textTracks().addEventListener("change", l)
                }), s.on(["play", "playing", "ended", "adsready", "adscanceled", "adskip", "adserror", "adtimeout", "ads-ad-started", "contentchanged", "contentresumed", "readyforpostroll", "nopreroll", "nopostroll"], function(e) {
                    s.ads._state.handleEvent(e.type)
                }), s.on("dispose", function() {
                    s.textTracks().removeEventListener("change", l)
                })
            };
        return (e.registerPlugin || e.plugin)("ads", O), F() && e.use("*", x), O
    }),
    function(e, t) {
        "object" == typeof exports && "undefined" != typeof module ? t(require("video.js")) : "function" == typeof define && define.amd ? define(["video.js"], t) : t(e.videojs)
    }(this, function(e) {
        "use strict";
        e = e && e.hasOwnProperty("default") ? e.default : e;
        var t = function(e, t, n) {
            this.vjsPlayer = e, this.controller = n, this.contentTrackingTimer = null, this.contentComplete = !1, this.updateTimeIntervalHandle = null, this.updateTimeInterval = 1e3, this.seekCheckIntervalHandle = null, this.seekCheckInterval = 1e3, this.resizeCheckIntervalHandle = null, this.resizeCheckInterval = 250, this.seekThreshold = 100, this.contentEndedListeners = [], this.contentSource = "", this.contentPlayheadTracker = {
                currentTime: 0,
                previousTime: 0,
                seeking: !1,
                duration: 0
            }, this.vjsPlayerDimensions = {
                width: this.getPlayerWidth(),
                height: this.getPlayerHeight()
            }, this.vjsControls = this.vjsPlayer.getChild("controlBar"), this.h5Player = null, this.vjsPlayer.one("play", this.setUpPlayerIntervals.bind(this)), this.boundContentEndedListener = this.localContentEndedListener.bind(this), this.vjsPlayer.on("contentended", this.boundContentEndedListener), this.vjsPlayer.on("dispose", this.playerDisposedListener.bind(this)), this.vjsPlayer.on("readyforpreroll", this.onReadyForPreroll.bind(this)), this.vjsPlayer.ready(this.onPlayerReady.bind(this)), this.vjsPlayer.ads(t)
        };
        t.prototype.setUpPlayerIntervals = function() {
            this.updateTimeIntervalHandle = setInterval(this.updateCurrentTime.bind(this), this.updateTimeInterval), this.seekCheckIntervalHandle = setInterval(this.checkForSeeking.bind(this), this.seekCheckInterval), this.resizeCheckIntervalHandle = setInterval(this.checkForResize.bind(this), this.resizeCheckInterval)
        }, t.prototype.updateCurrentTime = function() {
            this.contentPlayheadTracker.seeking || (this.contentPlayheadTracker.currentTime = this.vjsPlayer.currentTime())
        }, t.prototype.checkForSeeking = function() {
            var e = 1e3 * (this.vjsPlayer.currentTime() - this.contentPlayheadTracker.previousTime);
            Math.abs(e) > this.seekCheckInterval + this.seekThreshold ? this.contentPlayheadTracker.seeking = !0 : this.contentPlayheadTracker.seeking = !1, this.contentPlayheadTracker.previousTime = this.vjsPlayer.currentTime()
        }, t.prototype.checkForResize = function() {
            var e = this.getPlayerWidth(),
                t = this.getPlayerHeight();
            e == this.vjsPlayerDimensions.width && t == this.vjsPlayerDimensions.height || (this.vjsPlayerDimensions.width = e, this.vjsPlayerDimensions.height = t, this.controller.onPlayerResize(e, t))
        }, t.prototype.localContentEndedListener = function() {
            this.contentComplete || (this.contentComplete = !0, this.controller.onContentComplete());
            for (var e in this.contentEndedListeners) "function" == typeof this.contentEndedListeners[e] && this.contentEndedListeners[e]();
            clearInterval(this.updateTimeIntervalHandle), clearInterval(this.seekCheckIntervalHandle), clearInterval(this.resizeCheckIntervalHandle), this.vjsPlayer.el() && this.vjsPlayer.one("play", this.setUpPlayerIntervals.bind(this))
        }, t.prototype.onNoPostroll = function() {
            this.vjsPlayer.trigger("nopostroll")
        }, t.prototype.playerDisposedListener = function() {
            this.contentEndedListeners = [], this.controller.onPlayerDisposed(), this.contentComplete = !0, this.vjsPlayer.off("contentended", this.boundContentEndedListener), this.vjsPlayer.ads.adTimeoutTimeout && clearTimeout(this.vjsPlayer.ads.adTimeoutTimeout);
            var e = [this.updateTimeIntervalHandle, this.seekCheckIntervalHandle, this.resizeCheckIntervalHandle];
            for (var t in e) e[t] && clearInterval(e[t])
        }, t.prototype.onReadyForPreroll = function() {
            this.controller.onPlayerReadyForPreroll()
        }, t.prototype.onPlayerReady = function() {
            this.h5Player = document.getElementById(this.controller.getSettings().id).getElementsByClassName("vjs-tech")[0], this.h5Player.hasAttribute("autoplay") && this.controller.setSetting("adWillAutoPlay", !0), this.onVolumeChange(), this.vjsPlayer.on("fullscreenchange", this.onFullscreenChange.bind(this)), this.vjsPlayer.on("volumechange", this.onVolumeChange.bind(this))
        }, t.prototype.onFullscreenChange = function() {
            this.vjsPlayer.isFullscreen() ? this.controller.onPlayerEnterFullscreen() : this.controller.onPlayerExitFullscreen()
        }, t.prototype.onVolumeChange = function() {
            var e = this.vjsPlayer.muted() ? 0 : this.vjsPlayer.volume();
            this.controller.onPlayerVolumeChanged(e)
        }, t.prototype.injectAdContainerDiv = function(e) {
            this.vjsControls.el().parentNode.appendChild(e)
        }, t.prototype.getContentPlayer = function() {
            return this.h5Player
        }, t.prototype.getVolume = function() {
            return this.vjsPlayer.muted() ? 0 : this.vjsPlayer.volume()
        }, t.prototype.setVolume = function(e) {
            this.vjsPlayer.volume(e), 0 == e ? this.vjsPlayer.muted(!0) : this.vjsPlayer.muted(!1)
        }, t.prototype.unmute = function() {
            this.vjsPlayer.muted(!1)
        }, t.prototype.mute = function() {
            this.vjsPlayer.muted(!0)
        }, t.prototype.play = function() {
            this.vjsPlayer.play()
        }, t.prototype.getPlayerWidth = function() {
            var e = this.vjsPlayer.el().getBoundingClientRect() || {};
            return parseInt(e.width, 10) || this.vjsPlayer.width()
        }, t.prototype.getPlayerHeight = function() {
            var e = this.vjsPlayer.el().getBoundingClientRect() || {};
            return parseInt(e.height, 10) || this.vjsPlayer.height()
        }, t.prototype.getPlayerOptions = function() {
            return this.vjsPlayer.options_
        }, t.prototype.toggleFullscreen = function() {
            this.vjsPlayer.isFullscreen() ? this.vjsPlayer.exitFullscreen() : this.vjsPlayer.requestFullscreen()
        }, t.prototype.getContentPlayheadTracker = function() {
            return this.contentPlayheadTracker
        }, t.prototype.onAdError = function(e) {
            this.vjsControls.show();
            var t = void 0 !== e.getError ? e.getError() : e.stack;
            this.vjsPlayer.trigger({
                type: "adserror",
                data: {
                    AdError: t,
                    AdErrorEvent: e
                }
            })
        }, t.prototype.onAdBreakStart = function(e) {
            this.contentSource = this.vjsPlayer.currentSrc(), this.vjsPlayer.off("contentended", this.boundContentEndedListener), -1 != e.getAd().getAdPodInfo().getPodIndex() && this.vjsPlayer.ads.startLinearAdMode(), this.vjsControls.hide(), this.vjsPlayer.pause()
        }, t.prototype.onAdBreakEnd = function() {
            this.vjsPlayer.on("contentended", this.boundContentEndedListener), this.vjsPlayer.ads.inAdBreak() && this.vjsPlayer.ads.endLinearAdMode(), this.vjsControls.show()
        }, t.prototype.onAdStart = function() {
            this.vjsPlayer.trigger("ads-ad-started")
        }, t.prototype.onAllAdsCompleted = function() {
            1 == this.contentComplete && (this.h5Player.src != this.contentSource && this.vjsPlayer.src(this.contentSource), this.controller.onContentAndAdsCompleted())
        }, t.prototype.onAdsReady = function() {
            this.vjsPlayer.trigger("adsready")
        }, t.prototype.changeSource = function(e, t) {
            this.vjsPlayer.currentSrc() && (this.vjsPlayer.currentTime(0), this.vjsPlayer.pause()), e && this.vjsPlayer.src(e), t ? this.vjsPlayer.one("loadedmetadata", this.playContentFromZero.bind(this)) : this.vjsPlayer.one("loadedmetadata", this.seekContentToZero.bind(this))
        }, t.prototype.seekContentToZero = function() {
            this.vjsPlayer.currentTime(0)
        }, t.prototype.playContentFromZero = function() {
            this.vjsPlayer.currentTime(0), this.vjsPlayer.play()
        }, t.prototype.addContentEndedListener = function(e) {
            this.contentEndedListeners.push(e)
        }, t.prototype.reset = function() {
            this.vjsPlayer.on("contentended", this.boundContentEndedListener), this.vjsControls.show(), this.vjsPlayer.ads.inAdBreak() && this.vjsPlayer.ads.endLinearAdMode(), this.contentPlayheadTracker.currentTime = 0
        };
        var n = function(e) {
            this.controller = e, this.adContainerDiv = document.createElement("div"), this.controlsDiv = document.createElement("div"), this.countdownDiv = document.createElement("div"), this.seekBarDiv = document.createElement("div"), this.progressDiv = document.createElement("div"), this.playPauseDiv = document.createElement("div"), this.muteDiv = document.createElement("div"), this.sliderDiv = document.createElement("div"), this.sliderLevelDiv = document.createElement("div"), this.fullscreenDiv = document.createElement("div"), this.boundOnMouseUp = this.onMouseUp.bind(this), this.boundOnMouseMove = this.onMouseMove.bind(this), this.adPlayheadTracker = {
                currentTime: 0,
                duration: 0,
                isPod: !1,
                adPosition: 0,
                totalAds: 0
            }, this.controlPrefix = this.controller.getSettings().id ? this.controller.getSettings().id + "_" : "", this.showCountdown = !0, !1 === this.controller.getSettings().showCountdown && (this.showCountdown = !1), this.createAdContainer()
        };
        n.prototype.createAdContainer = function() {
            this.assignControlAttributes(this.adContainerDiv, "ima-ad-container"), this.adContainerDiv.style.position = "absolute", this.adContainerDiv.style.zIndex = 1111, this.adContainerDiv.addEventListener("mouseenter", this.showAdControls.bind(this), !1), this.adContainerDiv.addEventListener("mouseleave", this.hideAdControls.bind(this), !1), this.createControls(), this.controller.injectAdContainerDiv(this.adContainerDiv)
        }, n.prototype.createControls = function() {
            this.assignControlAttributes(this.controlsDiv, "ima-controls-div"), this.controlsDiv.style.width = "100%", this.assignControlAttributes(this.countdownDiv, "ima-countdown-div"), this.countdownDiv.innerHTML = this.controller.getSettings().adLabel, this.countdownDiv.style.display = this.showCountdown ? "block" : "none", this.assignControlAttributes(this.seekBarDiv, "ima-seek-bar-div"), this.seekBarDiv.style.width = "100%", this.assignControlAttributes(this.progressDiv, "ima-progress-div"), this.assignControlAttributes(this.playPauseDiv, "ima-play-pause-div"), this.addClass(this.playPauseDiv, "ima-playing"), this.playPauseDiv.addEventListener("click", this.onAdPlayPauseClick.bind(this), !1), this.assignControlAttributes(this.muteDiv, "ima-mute-div"), this.addClass(this.muteDiv, "ima-non-muted"), this.muteDiv.addEventListener("click", this.onAdMuteClick.bind(this), !1), this.assignControlAttributes(this.sliderDiv, "ima-slider-div"), this.sliderDiv.addEventListener("mousedown", this.onAdVolumeSliderMouseDown.bind(this), !1), this.assignControlAttributes(this.sliderLevelDiv, "ima-slider-level-div"), this.assignControlAttributes(this.fullscreenDiv, "ima-fullscreen-div"), this.addClass(this.fullscreenDiv, "ima-non-fullscreen"), this.fullscreenDiv.addEventListener("click", this.onAdFullscreenClick.bind(this), !1), this.adContainerDiv.appendChild(this.controlsDiv), this.controlsDiv.appendChild(this.countdownDiv), this.controlsDiv.appendChild(this.seekBarDiv), this.controlsDiv.appendChild(this.playPauseDiv), this.controlsDiv.appendChild(this.muteDiv), this.controlsDiv.appendChild(this.sliderDiv), this.controlsDiv.appendChild(this.fullscreenDiv), this.seekBarDiv.appendChild(this.progressDiv), this.sliderDiv.appendChild(this.sliderLevelDiv)
        }, n.prototype.onAdPlayPauseClick = function() {
            this.controller.onAdPlayPauseClick()
        }, n.prototype.onAdMuteClick = function() {
            this.controller.onAdMuteClick()
        }, n.prototype.onAdFullscreenClick = function() {
            this.controller.toggleFullscreen()
        }, n.prototype.onAdsPaused = function() {
            this.addClass(this.playPauseDiv, "ima-paused"), this.removeClass(this.playPauseDiv, "ima-playing"), this.showAdControls()
        }, n.prototype.onAdsResumed = function() {
            this.onAdsPlaying(), this.showAdControls()
        }, n.prototype.onAdsPlaying = function() {
            this.addClass(this.playPauseDiv, "ima-playing"), this.removeClass(this.playPauseDiv, "ima-paused")
        }, n.prototype.updateAdUi = function(e, t, n, i, o) {
            var s = Math.floor(t / 60),
                r = Math.floor(t % 60);
            r.toString().length < 2 && (r = "0" + r);
            var a = ": ";
            o > 1 && (a = " (" + i + " " + this.controller.getSettings().adLabelNofN + " " + o + "): "), this.countdownDiv.innerHTML = this.controller.getSettings().adLabel + a + s + ":" + r;
            var d = 100 * (e / n);
            this.progressDiv.style.width = d + "%"
        }, n.prototype.unmute = function() {
            this.addClass(this.muteDiv, "ima-non-muted"), this.removeClass(this.muteDiv, "ima-muted"), this.sliderLevelDiv.style.width = 100 * this.controller.getPlayerVolume() + "%"
        }, n.prototype.mute = function() {
            this.addClass(this.muteDiv, "ima-muted"), this.removeClass(this.muteDiv, "ima-non-muted"), this.sliderLevelDiv.style.width = "0%"
        }, n.prototype.onAdVolumeSliderMouseDown = function() {
            document.addEventListener("mouseup", this.boundOnMouseUp, !1), document.addEventListener("mousemove", this.boundOnMouseMove, !1)
        }, n.prototype.onMouseMove = function(e) {
            this.changeVolume(e)
        }, n.prototype.onMouseUp = function(e) {
            this.changeVolume(e), document.removeEventListener("mouseup", this.boundOnMouseUp), document.removeEventListener("mousemove", this.boundOnMouseMove)
        }, n.prototype.changeVolume = function(e) {
            var t = (e.clientX - this.sliderDiv.getBoundingClientRect().left) / this.sliderDiv.offsetWidth;
            t *= 100, t = Math.min(Math.max(t, 0), 100), this.sliderLevelDiv.style.width = t + "%", 0 == this.percent ? (this.addClass(this.muteDiv, "ima-muted"), this.removeClass(this.muteDiv, "ima-non-muted")) : (this.addClass(this.muteDiv, "ima-non-muted"), this.removeClass(this.muteDiv, "ima-muted")), this.controller.setVolume(t / 100)
        }, n.prototype.showAdContainer = function() {
            this.adContainerDiv.style.display = "block"
        }, n.prototype.onAdError = function() {
            this.adContainerDiv.style.display = "none"
        }, n.prototype.onAdBreakStart = function(e) {
            this.adContainerDiv.style.display = "block", "application/javascript" !== e.getAd().getContentType() || this.controller.getSettings().showControlsForJSAds ? this.controlsDiv.style.display = "block" : this.controlsDiv.style.display = "none", this.onAdsPlaying(), this.hideAdControls()
        }, n.prototype.onAdBreakEnd = function() {
            var e = this.controller.getCurrentAd();
            (null == e || e.isLinear()) && (this.adContainerDiv.style.display = "none"), this.controlsDiv.style.display = "none", this.countdownDiv.innerHTML = ""
        }, n.prototype.onAllAdsCompleted = function() {
            this.adContainerDiv.style.display = "none"
        }, n.prototype.onLinearAdStart = function() {
            this.removeClass(this.adContainerDiv, "bumpable-ima-ad-container")
        }, n.prototype.onNonLinearAdLoad = function() {
            this.adContainerDiv.style.display = "block", this.addClass(this.adContainerDiv, "bumpable-ima-ad-container")
        }, n.prototype.onPlayerEnterFullscreen = function() {
            this.addClass(this.fullscreenDiv, "ima-fullscreen"), this.removeClass(this.fullscreenDiv, "ima-non-fullscreen")
        }, n.prototype.onPlayerExitFullscreen = function() {
            this.addClass(this.fullscreenDiv, "ima-non-fullscreen"), this.removeClass(this.fullscreenDiv, "ima-fullscreen")
        }, n.prototype.onPlayerVolumeChanged = function(e) {
            0 == e ? (this.addClass(this.muteDiv, "ima-muted"), this.removeClass(this.muteDiv, "ima-non-muted"), this.sliderLevelDiv.style.width = "0%") : (this.addClass(this.muteDiv, "ima-non-muted"), this.removeClass(this.muteDiv, "ima-muted"), this.sliderLevelDiv.style.width = 100 * e + "%")
        }, n.prototype.showAdControls = function() {
            this.addClass(this.controlsDiv, "ima-controls-div-showing"), this.playPauseDiv.style.display = "block", this.muteDiv.style.display = "block", this.sliderDiv.style.display = "block", this.fullscreenDiv.style.display = "block"
        }, n.prototype.hideAdControls = function() {
            this.removeClass(this.controlsDiv, "ima-controls-div-showing"), this.playPauseDiv.style.display = "none", this.muteDiv.style.display = "none", this.sliderDiv.style.display = "none", this.fullscreenDiv.style.display = "none"
        }, n.prototype.assignControlAttributes = function(e, t) {
            e.id = this.controlPrefix + t, e.className = this.controlPrefix + t + " " + t
        }, n.prototype.getClassRegexp = function(e) {
            return new RegExp("(^|[^A-Za-z-])" + e + "((?![A-Za-z-])|$)", "gi")
        }, n.prototype.elementHasClass = function(e, t) {
            return this.getClassRegexp(t).test(e.className)
        }, n.prototype.addClass = function(e, t) {
            e.className = e.className.trim() + " " + t
        }, n.prototype.removeClass = function(e, t) {
            var n = this.getClassRegexp(t);
            e.className = e.className.trim().replace(n, "")
        }, n.prototype.getAdContainerDiv = function() {
            return this.adContainerDiv
        }, n.prototype.setShowCountdown = function(e) {
            this.showCountdown = e, this.countdownDiv.style.display = this.showCountdown ? "block" : "none"
        };
        var i = "1.4.0",
            o = function(e) {
                this.controller = e, this.adDisplayContainer = null, this.adDisplayContainerInitialized = !1, this.adsLoader = null, this.adsManager = null, this.adsRenderingSettings = null, this.adTagUrl = null, this.adsResponse = null, this.currentAd = null, this.adTrackingTimer = null, this.allAdsCompleted = !1, this.adsActive = !1, this.adPlaying = !1, this.adMuted = !1, this.adBreakReadyListener = void 0, this.contentCompleteCalled = !1, this.adsManagerDimensions = {
                    width: 0,
                    height: 0
                }, this.autoPlayAdBreaks = !0, !1 === this.controller.getSettings().autoPlayAdBreaks && (this.autoPlayAdBreaks = !1), this.controller.getSettings().locale && google.ima.settings.setLocale(this.controller.getSettings().locale), this.controller.getSettings().disableFlashAds && google.ima.settings.setDisableFlashAds(this.controller.getSettings().disableFlashAds), this.controller.getSettings().disableCustomPlaybackForIOS10Plus && google.ima.settings.setDisableCustomPlaybackForIOS10Plus(this.controller.getSettings().disableCustomPlaybackForIOS10Plus), this.initAdObjects(), (this.controller.getSettings().adTagUrl || this.controller.getSettings().adsResponse) && this.requestAds()
            };
        o.prototype.initAdObjects = function() {
            this.adDisplayContainer = new google.ima.AdDisplayContainer(this.controller.getAdContainerDiv(), this.controller.getContentPlayer()), this.adsLoader = new google.ima.AdsLoader(this.adDisplayContainer), this.adsLoader.getSettings().setVpaidMode(google.ima.ImaSdkSettings.VpaidMode.ENABLED), 0 == this.controller.getSettings().vpaidAllowed && this.adsLoader.getSettings().setVpaidMode(google.ima.ImaSdkSettings.VpaidMode.DISABLED), this.controller.getSettings().vpaidMode && this.adsLoader.getSettings().setVpaidMode(this.controller.getSettings().vpaidMode), this.controller.getSettings().locale && this.adsLoader.getSettings().setLocale(this.controller.getSettings().locale), this.controller.getSettings().numRedirects && this.adsLoader.getSettings().setNumRedirects(this.controller.getSettings().numRedirects), this.adsLoader.getSettings().setPlayerType("videojs-ima"), this.adsLoader.getSettings().setPlayerVersion(i), this.adsLoader.getSettings().setAutoPlayAdBreaks(this.autoPlayAdBreaks), this.adsLoader.addEventListener(google.ima.AdsManagerLoadedEvent.Type.ADS_MANAGER_LOADED, this.onAdsManagerLoaded.bind(this), !1), this.adsLoader.addEventListener(google.ima.AdErrorEvent.Type.AD_ERROR, this.onAdsLoaderError.bind(this), !1)
        }, o.prototype.requestAds = function() {
            var e = new google.ima.AdsRequest;
            this.controller.getSettings().adTagUrl ? e.adTagUrl = this.controller.getSettings().adTagUrl : e.adsResponse = this.controller.getSettings().adsResponse, this.controller.getSettings().forceNonLinearFullSlot && (e.forceNonLinearFullSlot = !0), e.linearAdSlotWidth = this.controller.getPlayerWidth(), e.linearAdSlotHeight = this.controller.getPlayerHeight(), e.nonLinearAdSlotWidth = this.controller.getSettings().nonLinearWidth || this.controller.getPlayerWidth(), e.nonLinearAdSlotHeight = this.controller.getSettings().nonLinearHeight || this.controller.getPlayerHeight(), e.setAdWillAutoPlay(this.controller.adsWillAutoplay()), e.setAdWillPlayMuted(this.controller.adsWillPlayMuted()), this.adsLoader.requestAds(e)
        }, o.prototype.onAdsManagerLoaded = function(e) {
            this.createAdsRenderingSettings(), this.adsManager = e.getAdsManager(this.controller.getContentPlayheadTracker(), this.adsRenderingSettings), this.adsManager.addEventListener(google.ima.AdErrorEvent.Type.AD_ERROR, this.onAdError.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.AD_BREAK_READY, this.onAdBreakReady.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.CONTENT_PAUSE_REQUESTED, this.onContentPauseRequested.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.CONTENT_RESUME_REQUESTED, this.onContentResumeRequested.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.ALL_ADS_COMPLETED, this.onAllAdsCompleted.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.LOADED, this.onAdLoaded.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.STARTED, this.onAdStarted.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.CLICK, this.onAdPaused.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.COMPLETE, this.onAdComplete.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.SKIPPED, this.onAdComplete.bind(this)), this.controller.getIsMobile() && (this.adsManager.addEventListener(google.ima.AdEvent.Type.PAUSED, this.onAdPaused.bind(this)), this.adsManager.addEventListener(google.ima.AdEvent.Type.RESUMED, this.onAdResumed.bind(this))), this.autoPlayAdBreaks || this.initAdsManager(), this.controller.onAdsReady(), this.controller.getSettings().adsManagerLoadedCallback && this.controller.getSettings().adsManagerLoadedCallback()
        }, o.prototype.onAdsLoaderError = function(e) {
            window.console.warn("AdsLoader error: " + e.getError()), this.controller.onErrorLoadingAds(e), this.adsManager && this.adsManager.destroy()
        }, o.prototype.initAdsManager = function() {
            try {
                var e = this.controller.getPlayerWidth(),
                    t = this.controller.getPlayerHeight();
                this.adsManagerDimensions.width = e, this.adsManagerDimensions.height = t, this.adsManager.init(e, t, google.ima.ViewMode.NORMAL), this.adsManager.setVolume(this.controller.getPlayerVolume()), this.adDisplayContainerInitialized || (this.adDisplayContainer.initialize(), this.adDisplayContainer.initialized = !0)
            } catch (e) {
                this.onAdError(e)
            }
        }, o.prototype.createAdsRenderingSettings = function() {
            if (this.adsRenderingSettings = new google.ima.AdsRenderingSettings, this.adsRenderingSettings.restoreCustomPlaybackStateOnAdBreakComplete = !0, this.controller.getSettings().adsRenderingSettings)
                for (var e in this.controller.getSettings().adsRenderingSettings) "" !== e && (this.adsRenderingSettings[e] = this.controller.getSettings().adsRenderingSettings[e])
        }, o.prototype.onAdError = function(e) {
            var t = void 0 !== e.getError ? e.getError() : e.stack;
            window.console.warn("Ad error: " + t), this.adsManager.destroy(), this.controller.onAdError(e)
        }, o.prototype.onAdBreakReady = function(e) {
            this.adBreakReadyListener(e)
        }, o.prototype.onContentPauseRequested = function(e) {
            this.adsActive = !0, this.adPlaying = !0, this.controller.onAdBreakStart(e)
        }, o.prototype.onContentResumeRequested = function(e) {
            this.adsActive = !1, this.adPlaying = !1, this.controller.onAdBreakEnd()
        }, o.prototype.onAllAdsCompleted = function(e) {
            this.allAdsCompleted = !0, this.controller.onAllAdsCompleted()
        }, o.prototype.onAdLoaded = function(e) {
            e.getAd().isLinear() || (this.controller.onNonLinearAdLoad(), this.controller.playContent())
        }, o.prototype.onAdStarted = function(e) {
            this.currentAd = e.getAd(), this.currentAd.isLinear() ? (this.adTrackingTimer = setInterval(this.onAdPlayheadTrackerInterval.bind(this), 250), this.controller.onLinearAdStart()) : this.controller.onNonLinearAdStart()
        }, o.prototype.onAdPaused = function() {
            this.controller.onAdsPaused()
        }, o.prototype.onAdResumed = function(e) {
            this.controller.onAdsResumed()
        }, o.prototype.onAdComplete = function() {
            this.currentAd.isLinear() && clearInterval(this.adTrackingTimer)
        }, o.prototype.onAdPlayheadTrackerInterval = function() {
            var e = this.adsManager.getRemainingTime(),
                t = this.currentAd.getDuration(),
                n = t - e;
            n = n > 0 ? n : 0;
            var i = 0,
                o = void 0;
            this.currentAd.getAdPodInfo() && (o = this.currentAd.getAdPodInfo().getAdPosition(), i = this.currentAd.getAdPodInfo().getTotalAds()), this.controller.onAdPlayheadUpdated(n, e, t, o, i)
        }, o.prototype.onContentComplete = function() {
            this.adsLoader && (this.adsLoader.contentComplete(), this.contentCompleteCalled = !0), this.adsManager && this.adsManager.getCuePoints() && !this.adsManager.getCuePoints().includes(-1) && this.controller.onNoPostroll(), this.allAdsCompleted && this.controller.onContentAndAdsCompleted()
        }, o.prototype.onPlayerDisposed = function() {
            this.adTrackingTimer && clearInterval(this.adTrackingTimer), this.adsManager && (this.adsManager.destroy(), this.adsManager = null)
        }, o.prototype.onPlayerReadyForPreroll = function() {
            if (this.autoPlayAdBreaks) {
                this.initAdsManager();
                try {
                    this.controller.showAdContainer(), this.adsManager.setVolume(this.controller.getPlayerVolume()), this.adsManager.start()
                } catch (e) {
                    this.onAdError(e)
                }
            }
        }, o.prototype.onPlayerEnterFullscreen = function() {
            this.adsManager && this.adsManager.resize(window.screen.width, window.screen.height, google.ima.ViewMode.FULLSCREEN)
        }, o.prototype.onPlayerExitFullscreen = function() {
            this.adsManager && this.adsManager.resize(this.controller.getPlayerWidth(), this.controller.getPlayerHeight(), google.ima.ViewMode.NORMAL)
        }, o.prototype.onPlayerVolumeChanged = function(e) {
            this.adsManager && this.adsManager.setVolume(e), this.adMuted = 0 == e
        }, o.prototype.onPlayerResize = function(e, t) {
            this.adsManager && (this.adsManagerDimensions.width = e, this.adsManagerDimensions.height = t, this.adsManager.resize(e, t, google.ima.ViewMode.NORMAL))
        }, o.prototype.getCurrentAd = function() {
            return this.currentAd
        }, o.prototype.setAdBreakReadyListener = function(e) {
            this.adBreakReadyListener = e
        }, o.prototype.isAdPlaying = function() {
            return this.adPlaying
        }, o.prototype.isAdMuted = function() {
            return this.adMuted
        }, o.prototype.pauseAds = function() {
            this.adsManager.pause(), this.adPlaying = !1
        }, o.prototype.resumeAds = function() {
            this.adsManager.resume(), this.adPlaying = !0
        }, o.prototype.unmute = function() {
            this.adsManager.setVolume(1), this.adMuted = !1
        }, o.prototype.mute = function() {
            this.adsManager.setVolume(0), this.adMuted = !0
        }, o.prototype.setVolume = function(e) {
            this.adsManager.setVolume(e), this.adMuted = 0 == e
        }, o.prototype.initializeAdDisplayContainer = function() {
            this.adDisplayContainerInitialized = !0, this.adDisplayContainer.initialize()
        }, o.prototype.playAdBreak = function() {
            this.autoPlayAdBreaks || (this.controller.showAdContainer(), this.adsManager.setVolume(this.controller.getPlayerVolume()), this.adsManager.start())
        }, o.prototype.addEventListener = function(e, t) {
            this.adsManager && this.adsManager.addEventListener(e, t)
        }, o.prototype.getAdsManager = function() {
            return this.adsManager
        }, o.prototype.reset = function() {
            this.adsActive = !1, this.adPlaying = !1, this.adTrackingTimer && clearInterval(this.adTrackingTimer), this.adsManager && (this.adsManager.destroy(), this.adsManager = null), this.adsLoader && !this.contentCompleteCalled && this.adsLoader.contentComplete(), this.contentCompleteCalled = !1, this.allAdsCompleted = !1
        };
        var s = function(e, i) {
            this.settings = {}, this.contentAndAdsEndedListeners = [], this.isMobile = navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i) || navigator.userAgent.match(/Android/i), this.initWithSettings(i);
            var s = {
                    debug: this.settings.debug,
                    timeout: this.settings.timeout,
                    prerollTimeout: this.settings.prerollTimeout
                },
                r = this.extend({}, s, i.contribAdsSettings || {});
            this.playerWrapper = new t(e, r, this), this.adUi = new n(this), this.sdkImpl = new o(this)
        };
        s.IMA_DEFAULTS = {
            debug: !1,
            timeout: 5e3,
            prerollTimeout: 1e3,
            adLabel: "Advertisement",
            adLabelNofN: "of",
            showControlsForJSAds: !0
        }, s.prototype.initWithSettings = function(e) {
            this.settings = this.extend({}, s.IMA_DEFAULTS, e || {}), this.settings.id ? (this.warnAboutDeprecatedSettings(), this.showCountdown = !0, !1 === this.settings.showCountdown && (this.showCountdown = !1)) : window.console.error("Error: must provide id of video.js div")
        }, s.prototype.warnAboutDeprecatedSettings = function() {
            var e = this;
            ["adWillAutoplay", "adsWillAutoplay", "adWillPlayMuted", "adsWillPlayMuted"].forEach(function(t) {
                void 0 !== e.settings[t] && console.warn("WARNING: videojs.ima setting " + t + " is deprecated")
            })
        }, s.prototype.getSettings = function() {
            return this.settings
        }, s.prototype.getIsMobile = function() {
            return this.isMobile
        }, s.prototype.injectAdContainerDiv = function(e) {
            this.playerWrapper.injectAdContainerDiv(e)
        }, s.prototype.getAdContainerDiv = function() {
            return this.adUi.getAdContainerDiv()
        }, s.prototype.getContentPlayer = function() {
            return this.playerWrapper.getContentPlayer()
        }, s.prototype.getContentPlayheadTracker = function() {
            return this.playerWrapper.getContentPlayheadTracker()
        }, s.prototype.requestAds = function() {
            this.sdkImpl.requestAds()
        }, s.prototype.setSetting = function(e, t) {
            this.settings[e] = t
        }, s.prototype.onErrorLoadingAds = function(e) {
            this.adUi.onAdError(), this.playerWrapper.onAdError(e)
        }, s.prototype.onAdPlayPauseClick = function() {
            this.sdkImpl.isAdPlaying() ? (this.adUi.onAdsPaused(), this.sdkImpl.pauseAds()) : (this.adUi.onAdsPlaying(), this.sdkImpl.resumeAds())
        }, s.prototype.onAdMuteClick = function() {
            this.sdkImpl.isAdMuted() ? (this.playerWrapper.unmute(), this.adUi.unmute(), this.sdkImpl.unmute()) : (this.playerWrapper.mute(), this.adUi.mute(), this.sdkImpl.mute())
        }, s.prototype.setVolume = function(e) {
            this.playerWrapper.setVolume(e), this.sdkImpl.setVolume(e)
        }, s.prototype.getPlayerVolume = function() {
            return this.playerWrapper.getVolume()
        }, s.prototype.toggleFullscreen = function() {
            this.playerWrapper.toggleFullscreen()
        }, s.prototype.onAdError = function(e) {
            this.adUi.onAdError(), this.playerWrapper.onAdError(e)
        }, s.prototype.onAdBreakStart = function(e) {
            this.playerWrapper.onAdBreakStart(e), this.adUi.onAdBreakStart(e)
        }, s.prototype.showAdContainer = function() {
            this.adUi.showAdContainer()
        }, s.prototype.onAdBreakEnd = function() {
            this.playerWrapper.onAdBreakEnd(), this.adUi.onAdBreakEnd()
        }, s.prototype.onAllAdsCompleted = function() {
            this.adUi.onAllAdsCompleted(), this.playerWrapper.onAllAdsCompleted()
        }, s.prototype.onAdsPaused = function() {
            this.adUi.onAdsPaused()
        }, s.prototype.onAdsResumed = function() {
            this.adUi.onAdsResumed()
        }, s.prototype.onAdPlayheadUpdated = function(e, t, n, i, o) {
            this.adUi.updateAdUi(e, t, n, i, o)
        }, s.prototype.getCurrentAd = function() {
            return this.sdkImpl.getCurrentAd()
        }, s.prototype.playContent = function() {
            this.playerWrapper.play()
        }, s.prototype.onLinearAdStart = function() {
            this.adUi.onLinearAdStart(), this.playerWrapper.onAdStart()
        }, s.prototype.onNonLinearAdLoad = function() {
            this.adUi.onNonLinearAdLoad()
        }, s.prototype.onNonLinearAdStart = function() {
            this.adUi.onNonLinearAdLoad(), this.playerWrapper.onAdStart()
        }, s.prototype.getPlayerWidth = function() {
            return this.playerWrapper.getPlayerWidth()
        }, s.prototype.getPlayerHeight = function() {
            return this.playerWrapper.getPlayerHeight()
        }, s.prototype.onAdsReady = function() {
            this.playerWrapper.onAdsReady()
        }, s.prototype.onPlayerResize = function(e, t) {
            this.sdkImpl.onPlayerResize(e, t)
        }, s.prototype.onContentComplete = function() {
            this.sdkImpl.onContentComplete()
        }, s.prototype.onNoPostroll = function() {
            this.playerWrapper.onNoPostroll()
        }, s.prototype.onContentAndAdsCompleted = function() {
            for (var e in this.contentAndAdsEndedListeners) "function" == typeof this.contentAndAdsEndedListeners[e] && this.contentAndAdsEndedListeners[e]()
        }, s.prototype.onPlayerDisposed = function() {
            this.contentAndAdsEndedListeners = [], this.sdkImpl.onPlayerDisposed()
        }, s.prototype.onPlayerReadyForPreroll = function() {
            this.sdkImpl.onPlayerReadyForPreroll()
        }, s.prototype.onPlayerEnterFullscreen = function() {
            this.adUi.onPlayerEnterFullscreen(), this.sdkImpl.onPlayerEnterFullscreen()
        }, s.prototype.onPlayerExitFullscreen = function() {
            this.adUi.onPlayerExitFullscreen(), this.sdkImpl.onPlayerExitFullscreen()
        }, s.prototype.onPlayerVolumeChanged = function(e) {
            this.adUi.onPlayerVolumeChanged(e), this.sdkImpl.onPlayerVolumeChanged(e)
        }, s.prototype.setContentWithAdTag = function(e, t, n) {
            this.reset(), this.settings.adTagUrl = t || this.settings.adTagUrl, this.playerWrapper.changeSource(e, n)
        }, s.prototype.setContentWithAdsResponse = function(e, t, n) {
            this.reset(), this.settings.adsResponse = t || this.settings.adsResponse, this.playerWrapper.changeSource(e, n)
        }, s.prototype.reset = function() {
            this.sdkImpl.reset(), this.playerWrapper.reset()
        }, s.prototype.addContentEndedListener = function(e) {
            this.playerWrapper.addContentEndedListener(e)
        }, s.prototype.addContentAndAdsEndedListener = function(e) {
            this.contentAndAdsEndedListeners.push(e)
        }, s.prototype.setAdBreakReadyListener = function(e) {
            this.sdkImpl.setAdBreakReadyListener(e)
        }, s.prototype.setShowCountdown = function(e) {
            this.adUi.setShowCountdown(e), this.showCountdown = e, this.countdownDiv.style.display = this.showCountdown ? "block" : "none"
        }, s.prototype.initializeAdDisplayContainer = function() {
            this.sdkImpl.initializeAdDisplayContainer()
        }, s.prototype.playAdBreak = function() {
            this.sdkImpl.playAdBreak()
        }, s.prototype.addEventListener = function(e, t) {
            this.sdkImpl.addEventListener(e, t)
        }, s.prototype.getAdsManager = function() {
            return this.sdkImpl.getAdsManager()
        }, s.prototype.changeAdTag = function(e) {
            this.reset(), this.settings.adTagUrl = e
        }, s.prototype.pauseAd = function() {
            this.adUi.onAdsPaused(), this.sdkImpl.pauseAds()
        }, s.prototype.resumeAd = function() {
            this.adUi.onAdsPlaying(), this.sdkImpl.resumeAds()
        }, s.prototype.adsWillAutoplay = function() {
            return void 0 !== this.settings.adsWillAutoplay ? this.settings.adsWillAutoplay : void 0 !== this.settings.adWillAutoplay ? this.settings.adWillAutoplay : !!this.playerWrapper.getPlayerOptions().autoplay
        }, s.prototype.adsWillPlayMuted = function() {
            return void 0 !== this.settings.adsWillPlayMuted ? this.settings.adsWillPlayMuted : void 0 !== this.settings.adWillPlayMuted ? this.settings.adWillPlayMuted : void 0 !== this.playerWrapper.getPlayerOptions().muted ? this.playerWrapper.getPlayerOptions().muted : 0 == this.playerWrapper.getVolume()
        }, s.prototype.extend = function(e) {
            for (var t = void 0, n = void 0, i = void 0, o = arguments.length, s = Array(o > 1 ? o - 1 : 0), r = 1; r < o; r++) s[r - 1] = arguments[r];
            for (n = 0; n < s.length; n++) {
                t = s[n];
                for (i in t) t.hasOwnProperty(i) && (e[i] = t[i])
            }
            return e
        };
        (e.registerPlugin || e.plugin)("ima", function(e) {
            this.ima = new function(e, t) {
                this.controller = new s(e, t), this.addContentAndAdsEndedListener = function(e) {
                    this.controller.addContentAndAdsEndedListener(e)
                }.bind(this), this.addContentEndedListener = function(e) {
                    this.controller.addContentEndedListener(e)
                }.bind(this), this.addEventListener = function(e, t) {
                    this.controller.addEventListener(e, t)
                }.bind(this), this.changeAdTag = function(e) {
                    this.controller.changeAdTag(e)
                }.bind(this), this.getAdsManager = function() {
                    return this.controller.getAdsManager()
                }.bind(this), this.initializeAdDisplayContainer = function() {
                    this.controller.initializeAdDisplayContainer()
                }.bind(this), this.pauseAd = function() {
                    this.controller.pauseAd()
                }.bind(this), this.playAdBreak = function() {
                    this.controller.playAdBreak()
                }.bind(this), this.requestAds = function() {
                    this.controller.requestAds()
                }.bind(this), this.resumeAd = function() {
                    this.controller.resumeAd()
                }.bind(this), this.setAdBreakReadyListener = function(e) {
                    this.controller.setAdBreakReadyListener(e)
                }.bind(this), this.setContentWithAdTag = function(e, t, n) {
                    this.controller.setContentWithAdTag(e, t, n)
                }.bind(this), this.setContentWithAdsResponse = function(e, t, n) {
                    this.controller.setContentWithAdsResponse(e, t, n)
                }.bind(this), this.setShowCountdown = function(e) {
                    this.controller.setShowCountdown(e)
                }.bind(this)
            }(this, e)
        })
    });