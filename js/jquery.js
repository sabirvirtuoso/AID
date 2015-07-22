/*
 * jQuery 1.2.1 - New Wave Javascript
 *
 * Copyright (c) 2007 John Resig (jquery.com)
 * Dual licensed under the MIT (MIT-LICENSE.txt)
 * and GPL (GPL-LICENSE.txt) licenses.
 *
 * $Date: 2007-09-16 23:42:06 -0400 (Sun, 16 Sep 2007) $
 * $Rev: 3353 $
 */
(function(){
    if(typeof jQuery!="undefined")var _jQuery=jQuery;
    var jQuery=window.jQuery=function(selector,context){
        return this instanceof jQuery?this.init(selector,context):new jQuery(selector,context);
    };

    if(typeof $!="undefined")var _$=$;
    window.$=jQuery;
    var quickExpr=/^[^<]*(<(.|\s)+>)[^>]*$|^#(\w+)$/;
    jQuery.fn=jQuery.prototype={
        init:function(selector,context){
            selector=selector||document;
            if(typeof selector=="string"){
                var m=quickExpr.exec(selector);
                if(m&&(m[1]||!context)){
                    if(m[1])selector=jQuery.clean([m[1]],context);
                    else{
                        var tmp=document.getElementById(m[3]);
                        if(tmp)if(tmp.id!=m[3])return jQuery().find(selector);
                        else{
                            this[0]=tmp;
                            this.length=1;
                            return this;
                        }else
                            selector=[];
                    }
                }else
                    return new jQuery(context).find(selector);
            }else if(jQuery.isFunction(selector))return new jQuery(document)[jQuery.fn.ready?"ready":"load"](selector);
            return this.setArray(selector.constructor==Array&&selector||(selector.jquery||selector.length&&selector!=window&&!selector.nodeType&&selector[0]!=undefined&&selector[0].nodeType)&&jQuery.makeArray(selector)||[selector]);
        },
        jquery:"1.2.1",
        size:function(){
            return this.length;
        },
        length:0,
        get:function(num){
            return num==undefined?jQuery.makeArray(this):this[num];
        },
        pushStack:function(a){
            var ret=jQuery(a);
            ret.prevObject=this;
            return ret;
        },
        setArray:function(a){
            this.length=0;
            Array.prototype.push.apply(this,a);
            return this;
        },
        each:function(fn,args){
            return jQuery.each(this,fn,args);
        },
        index:function(obj){
            var pos=-1;
            this.each(function(i){
                if(this==obj)pos=i;
            });
            return pos;
        },
        attr:function(key,value,type){
            var obj=key;
            if(key.constructor==String)if(value==undefined)return this.length&&jQuery[type||"attr"](this[0],key)||undefined;
            else{
                obj={};

                obj[key]=value;
            }
            return this.each(function(index){
                for(var prop in obj)jQuery.attr(type?this.style:this,prop,jQuery.prop(this,obj[prop],type,index,prop));
            });
        },
        css:function(key,value){
            return this.attr(key,value,"curCSS");
        },
        text:function(e){
            if(typeof e!="object"&&e!=null)return this.empty().append(document.createTextNode(e));
            var t="";
            jQuery.each(e||this,function(){
                jQuery.each(this.childNodes,function(){
                    if(this.nodeType!=8)t+=this.nodeType!=1?this.nodeValue:jQuery.fn.text([this]);
                });
            });
            return t;
        },
        wrapAll:function(html){
            if(this[0])jQuery(html,this[0].ownerDocument).clone().insertBefore(this[0]).map(function(){
                var elem=this;
                while(elem.firstChild)elem=elem.firstChild;
                return elem;
            }).append(this);
            return this;
        },
        wrapInner:function(html){
            return this.each(function(){
                jQuery(this).contents().wrapAll(html);
            });
        },
        wrap:function(html){
            return this.each(function(){
                jQuery(this).wrapAll(html);
            });
        },
        append:function(){
            return this.domManip(arguments,true,1,function(a){
                this.appendChild(a);
            });
        },
        prepend:function(){
            return this.domManip(arguments,true,-1,function(a){
                this.insertBefore(a,this.firstChild);
            });
        },
        before:function(){
            return this.domManip(arguments,false,1,function(a){
                this.parentNode.insertBefore(a,this);
            });
        },
        after:function(){
            return this.domManip(arguments,false,-1,function(a){
                this.parentNode.insertBefore(a,this.nextSibling);
            });
        },
        end:function(){
            return this.prevObject||jQuery([]);
        },
        find:function(t){
            var data=jQuery.map(this,function(a){
                return jQuery.find(t,a);
            });
            return this.pushStack(/[^+>] [^+>]/.test(t)||t.indexOf("..")>-1?jQuery.unique(data):data);
        },
        clone:function(events){
            var ret=this.map(function(){
                return this.outerHTML?jQuery(this.outerHTML)[0]:this.cloneNode(true);
            });
            var clone=ret.find("*").andSelf().each(function(){
                if(this[expando]!=undefined)this[expando]=null;
            });
            if(events===true)this.find("*").andSelf().each(function(i){
                var events=jQuery.data(this,"events");
                for(var type in events)for(var handler in events[type])jQuery.event.add(clone[i],type,events[type][handler],events[type][handler].data);
            });
            return ret;
        },
        filter:function(t){
            return this.pushStack(jQuery.isFunction(t)&&jQuery.grep(this,function(el,index){
                return t.apply(el,[index]);
            })||jQuery.multiFilter(t,this));
        },
        not:function(t){
            return this.pushStack(t.constructor==String&&jQuery.multiFilter(t,this,true)||jQuery.grep(this,function(a){
                return(t.constructor==Array||t.jquery)?jQuery.inArray(a,t)<0:a!=t;
            }));
        },
        add:function(t){
            return this.pushStack(jQuery.merge(this.get(),t.constructor==String?jQuery(t).get():t.length!=undefined&&(!t.nodeName||jQuery.nodeName(t,"form"))?t:[t]));
        },
        is:function(expr){
            return expr?jQuery.multiFilter(expr,this).length>0:false;
        },
        hasClass:function(expr){
            return this.is("."+expr);
        },
        val:function(val){
            if(val==undefined){
                if(this.length){
                    var elem=this[0];
                    if(jQuery.nodeName(elem,"select")){
                        var index=elem.selectedIndex,a=[],options=elem.options,one=elem.type=="select-one";
                        if(index<0)return null;
                        for(var i=one?index:0,max=one?index+1:options.length;i<max;i++){
                            var option=options[i];
                            if(option.selected){
                                var val=jQuery.browser.msie&&!option.attributes["value"].specified?option.text:option.value;
                                if(one)return val;
                                a.push(val);
                            }
                        }
                        return a;
                    }else
                        return this[0].value.replace(/\r/g,"");
                }
            }else
                return this.each(function(){
                    if(val.constructor==Array&&/radio|checkbox/.test(this.type))this.checked=(jQuery.inArray(this.value,val)>=0||jQuery.inArray(this.name,val)>=0);
                    else if(jQuery.nodeName(this,"select")){
                        var tmp=val.constructor==Array?val:[val];
                        jQuery("option",this).each(function(){
                            this.selected=(jQuery.inArray(this.value,tmp)>=0||jQuery.inArray(this.text,tmp)>=0);
                        });
                        if(!tmp.length)this.selectedIndex=-1;
                    }else
                    this.value=val;
            });
        },
        html:function(val){
            return val==undefined?(this.length?this[0].innerHTML:null):this.empty().append(val);
        },
        replaceWith:function(val){
            return this.after(val).remove();
        },
        eq:function(i){
            return this.slice(i,i+1);
        },
        slice:function(){
            return this.pushStack(Array.prototype.slice.apply(this,arguments));
        },
        map:function(fn){
            return this.pushStack(jQuery.map(this,function(elem,i){
                return fn.call(elem,i,elem);
            }));
        },
        andSelf:function(){
            return this.add(this.prevObject);
        },
        domManip:function(args,table,dir,fn){
            var clone=this.length>1,a;
            return this.each(function(){
                if(!a){
                    a=jQuery.clean(args,this.ownerDocument);
                    if(dir<0)a.reverse();
                }
                var obj=this;
                if(table&&jQuery.nodeName(this,"table")&&jQuery.nodeName(a[0],"tr"))obj=this.getElementsByTagName("tbody")[0]||this.appendChild(document.createElement("tbody"));
                jQuery.each(a,function(){
                    var elem=clone?this.cloneNode(true):this;
                    if(!evalScript(0,elem))fn.call(obj,elem);
                });
            });
        }
    };

    function evalScript(i,elem){
        var script=jQuery.nodeName(elem,"script");
        if(script){
            if(elem.src)jQuery.ajax({
                url:elem.src,
                async:false,
                dataType:"script"
            });else
                jQuery.globalEval(elem.text||elem.textContent||elem.innerHTML||"");
            if(elem.parentNode)elem.parentNode.removeChild(elem);
        }else if(elem.nodeType==1)jQuery("script",elem).each(evalScript);
        return script;
    }
    jQuery.extend=jQuery.fn.extend=function(){
        var target=arguments[0]||{},a=1,al=arguments.length,deep=false;
        if(target.constructor==Boolean){
            deep=target;
            target=arguments[1]||{};

        }
        if(al==1){
            target=this;
            a=0;
        }
        var prop;
        for(;a<al;a++)if((prop=arguments[a])!=null)for(var i in prop){
            if(target==prop[i])continue;
            if(deep&&typeof prop[i]=='object'&&target[i])jQuery.extend(target[i],prop[i]);
            else if(prop[i]!=undefined)target[i]=prop[i];
        }
        return target;
    };

    var expando="jQuery"+(new Date()).getTime(),uuid=0,win={};

    jQuery.extend({
        noConflict:function(deep){
            window.$=_$;
            if(deep)window.jQuery=_jQuery;
            return jQuery;
        },
        isFunction:function(fn){
            return!!fn&&typeof fn!="string"&&!fn.nodeName&&fn.constructor!=Array&&/function/i.test(fn+"");
        },
        isXMLDoc:function(elem){
            return elem.documentElement&&!elem.body||elem.tagName&&elem.ownerDocument&&!elem.ownerDocument.body;
        },
        globalEval:function(data){
            data=jQuery.trim(data);
            if(data){
                if(window.execScript)window.execScript(data);
                else if(jQuery.browser.safari)window.setTimeout(data,0);else
                    eval.call(window,data);
            }
        },
        nodeName:function(elem,name){
            return elem.nodeName&&elem.nodeName.toUpperCase()==name.toUpperCase();
        },
        cache:{},
        data:function(elem,name,data){
            elem=elem==window?win:elem;
            var id=elem[expando];
            if(!id)id=elem[expando]=++uuid;
            if(name&&!jQuery.cache[id])jQuery.cache[id]={};

            if(data!=undefined)jQuery.cache[id][name]=data;
            return name?jQuery.cache[id][name]:id;
        },
        removeData:function(elem,name){
            elem=elem==window?win:elem;
            var id=elem[expando];
            if(name){
                if(jQuery.cache[id]){
                    delete jQuery.cache[id][name];
                    name="";
                    for(name in jQuery.cache[id])break;if(!name)jQuery.removeData(elem);
                }
            }else{
                try{
                    delete elem[expando];
                }catch(e){
                    if(elem.removeAttribute)elem.removeAttribute(expando);
                }
                delete jQuery.cache[id];
            }
        },
        each:function(obj,fn,args){
            if(args){
                if(obj.length==undefined)for(var i in obj)fn.apply(obj[i],args);else
                    for(var i=0,ol=obj.length;i<ol;i++)if(fn.apply(obj[i],args)===false)break;
            }else{
                if(obj.length==undefined)for(var i in obj)fn.call(obj[i],i,obj[i]);else
                    for(var i=0,ol=obj.length,val=obj[0];i<ol&&fn.call(val,i,val)!==false;val=obj[++i]){}
            }
            return obj;
        },
        prop:function(elem,value,type,index,prop){
            if(jQuery.isFunction(value))value=value.call(elem,[index]);
            var exclude=/z-?index|font-?weight|opacity|zoom|line-?height/i;
            return value&&value.constructor==Number&&type=="curCSS"&&!exclude.test(prop)?value+"px":value;
        },
        className:{
            add:function(elem,c){
                jQuery.each((c||"").split(/\s+/),function(i,cur){
                    if(!jQuery.className.has(elem.className,cur))elem.className+=(elem.className?" ":"")+cur;
                });
            },
            remove:function(elem,c){
                elem.className=c!=undefined?jQuery.grep(elem.className.split(/\s+/),function(cur){
                    return!jQuery.className.has(c,cur);
                }).join(" "):"";
            },
            has:function(t,c){
                return jQuery.inArray(c,(t.className||t).toString().split(/\s+/))>-1;
            }
        },
        swap:function(e,o,f){
            for(var i in o){
                e.style["old"+i]=e.style[i];
                e.style[i]=o[i];
            }
            f.apply(e,[]);
            for(var i in o)e.style[i]=e.style["old"+i];
        },
        css:function(e,p){
            if(p=="height"||p=="width"){
                var old={},oHeight,oWidth,d=["Top","Bottom","Right","Left"];
                jQuery.each(d,function(){
                    old["padding"+this]=0;
                    old["border"+this+"Width"]=0;
                });
                jQuery.swap(e,old,function(){
                    if(jQuery(e).is(':visible')){
                        oHeight=e.offsetHeight;
                        oWidth=e.offsetWidth;
                    }else{
                        e=jQuery(e.cloneNode(true)).find(":radio").removeAttr("checked").end().css({
                            visibility:"hidden",
                            position:"absolute",
                            display:"block",
                            right:"0",
                            left:"0"
                        }).appendTo(e.parentNode)[0];
                        var parPos=jQuery.css(e.parentNode,"position")||"static";
                        if(parPos=="static")e.parentNode.style.position="relative";
                        oHeight=e.clientHeight;
                        oWidth=e.clientWidth;
                        if(parPos=="static")e.parentNode.style.position="static";
                        e.parentNode.removeChild(e);
                    }
                });
                return p=="height"?oHeight:oWidth;
            }
            return jQuery.curCSS(e,p);
        },
        curCSS:function(elem,prop,force){
            var ret,stack=[],swap=[];
            function color(a){
                if(!jQuery.browser.safari)return false;
                var ret=document.defaultView.getComputedStyle(a,null);
                return!ret||ret.getPropertyValue("color")=="";
            }
            if(prop=="opacity"&&jQuery.browser.msie){
                ret=jQuery.attr(elem.style,"opacity");
                return ret==""?"1":ret;
            }
            if(prop.match(/float/i))prop=styleFloat;
            if(!force&&elem.style[prop])ret=elem.style[prop];
            else if(document.defaultView&&document.defaultView.getComputedStyle){
                if(prop.match(/float/i))prop="float";
                prop=prop.replace(/([A-Z])/g,"-$1").toLowerCase();
                var cur=document.defaultView.getComputedStyle(elem,null);
                if(cur&&!color(elem))ret=cur.getPropertyValue(prop);
                else{
                    for(var a=elem;a&&color(a);a=a.parentNode)stack.unshift(a);
                    for(a=0;a<stack.length;a++)if(color(stack[a])){
                        swap[a]=stack[a].style.display;
                        stack[a].style.display="block";
                    }
                    ret=prop=="display"&&swap[stack.length-1]!=null?"none":document.defaultView.getComputedStyle(elem,null).getPropertyValue(prop)||"";
                    for(a=0;a<swap.length;a++)if(swap[a]!=null)stack[a].style.display=swap[a];
                }
                if(prop=="opacity"&&ret=="")ret="1";
            }else if(elem.currentStyle){
                var newProp=prop.replace(/\-(\w)/g,function(m,c){
                    return c.toUpperCase();
                });
                ret=elem.currentStyle[prop]||elem.currentStyle[newProp];
                if(!/^\d+(px)?$/i.test(ret)&&/^\d/.test(ret)){
                    var style=elem.style.left;
                    var runtimeStyle=elem.runtimeStyle.left;
                    elem.runtimeStyle.left=elem.currentStyle.left;
                    elem.style.left=ret||0;
                    ret=elem.style.pixelLeft+"px";
                    elem.style.left=style;
                    elem.runtimeStyle.left=runtimeStyle;
                }
            }
            return ret;
        },
        clean:function(a,doc){
            var r=[];
            doc=doc||document;
            jQuery.each(a,function(i,arg){
                if(!arg)return;
                if(arg.constructor==Number)arg=arg.toString();
                if(typeof arg=="string"){
                    arg=arg.replace(/(<(\w+)[^>]*?)\/>/g,function(m,all,tag){
                        return tag.match(/^(abbr|br|col|img|input|link|meta|param|hr|area)$/i)?m:all+"></"+tag+">";
                    });
                    var s=jQuery.trim(arg).toLowerCase(),div=doc.createElement("div"),tb=[];
                    var wrap=!s.indexOf("<opt")&&[1,"<select>","</select>"]||!s.indexOf("<leg")&&[1,"<fieldset>","</fieldset>"]||s.match(/^<(thead|tbody|tfoot|colg|cap)/)&&[1,"<table>","</table>"]||!s.indexOf("<tr")&&[2,"<table><tbody>","</tbody></table>"]||(!s.indexOf("<td")||!s.indexOf("<th"))&&[3,"<table><tbody><tr>","</tr></tbody></table>"]||!s.indexOf("<col")&&[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"]||jQuery.browser.msie&&[1,"div<div>","</div>"]||[0,"",""];
                    div.innerHTML=wrap[1]+arg+wrap[2];
                    while(wrap[0]--)div=div.lastChild;
                    if(jQuery.browser.msie){
                        if(!s.indexOf("<table")&&s.indexOf("<tbody")<0)tb=div.firstChild&&div.firstChild.childNodes;
                        else if(wrap[1]=="<table>"&&s.indexOf("<tbody")<0)tb=div.childNodes;
                        for(var n=tb.length-1;n>=0;--n)if(jQuery.nodeName(tb[n],"tbody")&&!tb[n].childNodes.length)tb[n].parentNode.removeChild(tb[n]);if(/^\s/.test(arg))div.insertBefore(doc.createTextNode(arg.match(/^\s*/)[0]),div.firstChild);
                    }
                    arg=jQuery.makeArray(div.childNodes);
                }
                if(0===arg.length&&(!jQuery.nodeName(arg,"form")&&!jQuery.nodeName(arg,"select")))return;
                if(arg[0]==undefined||jQuery.nodeName(arg,"form")||arg.options)r.push(arg);else
                    r=jQuery.merge(r,arg);
            });
            return r;
        },
        attr:function(elem,name,value){
            var fix=jQuery.isXMLDoc(elem)?{}:jQuery.props;
            if(name=="selected"&&jQuery.browser.safari)elem.parentNode.selectedIndex;
            if(fix[name]){
                if(value!=undefined)elem[fix[name]]=value;
                return elem[fix[name]];
            }else if(jQuery.browser.msie&&name=="style")return jQuery.attr(elem.style,"cssText",value);
            else if(value==undefined&&jQuery.browser.msie&&jQuery.nodeName(elem,"form")&&(name=="action"||name=="method"))return elem.getAttributeNode(name).nodeValue;
            else if(elem.tagName){
                if(value!=undefined){
                    if(name=="type"&&jQuery.nodeName(elem,"input")&&elem.parentNode)throw"type property can't be changed";
                    elem.setAttribute(name,value);
                }
                if(jQuery.browser.msie&&/href|src/.test(name)&&!jQuery.isXMLDoc(elem))return elem.getAttribute(name,2);
                return elem.getAttribute(name);
            }else{
                if(name=="opacity"&&jQuery.browser.msie){
                    if(value!=undefined){
                        elem.zoom=1;
                        elem.filter=(elem.filter||"").replace(/alpha\([^)]*\)/,"")+(parseFloat(value).toString()=="NaN"?"":"alpha(opacity="+value*100+")");
                    }
                    return elem.filter?(parseFloat(elem.filter.match(/opacity=([^)]*)/)[1])/100).toString():"";
                }
                name=name.replace(/-([a-z])/ig,function(z,b){
                    return b.toUpperCase();
                });
                if(value!=undefined)elem[name]=value;
                return elem[name];
            }
        },
        trim:function(t){
            return(t||"").replace(/^\s+|\s+$/g,"");
        },
        makeArray:function(a){
            var r=[];
            if(typeof a!="array")for(var i=0,al=a.length;i<al;i++)r.push(a[i]);else
                r=a.slice(0);
            return r;
        },
        inArray:function(b,a){
            for(var i=0,al=a.length;i<al;i++)if(a[i]==b)return i;return-1;
        },
        merge:function(first,second){
            if(jQuery.browser.msie){
                for(var i=0;second[i];i++)if(second[i].nodeType!=8)first.push(second[i]);
            }else
                for(var i=0;second[i];i++)first.push(second[i]);
            return first;
        },
        unique:function(first){
            var r=[],done={};

            try{
                for(var i=0,fl=first.length;i<fl;i++){
                    var id=jQuery.data(first[i]);
                    if(!done[id]){
                        done[id]=true;
                        r.push(first[i]);
                    }
                }
            }catch(e){
                r=first;
            }
            return r;
        },
        grep:function(elems,fn,inv){
            if(typeof fn=="string")fn=eval("false||function(a,i){return "+fn+"}");
            var result=[];
            for(var i=0,el=elems.length;i<el;i++)if(!inv&&fn(elems[i],i)||inv&&!fn(elems[i],i))result.push(elems[i]);return result;
        },
        map:function(elems,fn){
            if(typeof fn=="string")fn=eval("false||function(a){return "+fn+"}");
            var result=[];
            for(var i=0,el=elems.length;i<el;i++){
                var val=fn(elems[i],i);
                if(val!==null&&val!=undefined){
                    if(val.constructor!=Array)val=[val];
                    result=result.concat(val);
                }
            }
            return result;
        }
    });
    var userAgent=navigator.userAgent.toLowerCase();
    jQuery.browser={
        version:(userAgent.match(/.+(?:rv|it|ra|ie)[\/: ]([\d.]+)/)||[])[1],
        safari:/webkit/.test(userAgent),
        opera:/opera/.test(userAgent),
        msie:/msie/.test(userAgent)&&!/opera/.test(userAgent),
        mozilla:/mozilla/.test(userAgent)&&!/(compatible|webkit)/.test(userAgent)
    };

    var styleFloat=jQuery.browser.msie?"styleFloat":"cssFloat";
    jQuery.extend({
        boxModel:!jQuery.browser.msie||document.compatMode=="CSS1Compat",
        styleFloat:jQuery.browser.msie?"styleFloat":"cssFloat",
        props:{
            "for":"htmlFor",
            "class":"className",
            "float":styleFloat,
            cssFloat:styleFloat,
            styleFloat:styleFloat,
            innerHTML:"innerHTML",
            className:"className",
            value:"value",
            disabled:"disabled",
            checked:"checked",
            readonly:"readOnly",
            selected:"selected",
            maxlength:"maxLength"
        }
    });
    jQuery.each({
        parent:"a.parentNode",
        parents:"jQuery.dir(a,'parentNode')",
        next:"jQuery.nth(a,2,'nextSibling')",
        prev:"jQuery.nth(a,2,'previousSibling')",
        nextAll:"jQuery.dir(a,'nextSibling')",
        prevAll:"jQuery.dir(a,'previousSibling')",
        siblings:"jQuery.sibling(a.parentNode.firstChild,a)",
        children:"jQuery.sibling(a.firstChild)",
        contents:"jQuery.nodeName(a,'iframe')?a.contentDocument||a.contentWindow.document:jQuery.makeArray(a.childNodes)"
    },function(i,n){
        jQuery.fn[i]=function(a){
            var ret=jQuery.map(this,n);
            if(a&&typeof a=="string")ret=jQuery.multiFilter(a,ret);
            return this.pushStack(jQuery.unique(ret));
        };

    });
    jQuery.each({
        appendTo:"append",
        prependTo:"prepend",
        insertBefore:"before",
        insertAfter:"after",
        replaceAll:"replaceWith"
    },function(i,n){
        jQuery.fn[i]=function(){
            var a=arguments;
            return this.each(function(){
                for(var j=0,al=a.length;j<al;j++)jQuery(a[j])[n](this);
            });
        };

    });
    jQuery.each({
        removeAttr:function(key){
            jQuery.attr(this,key,"");
            this.removeAttribute(key);
        },
        addClass:function(c){
            jQuery.className.add(this,c);
        },
        removeClass:function(c){
            jQuery.className.remove(this,c);
        },
        toggleClass:function(c){
            jQuery.className[jQuery.className.has(this,c)?"remove":"add"](this,c);
        },
        remove:function(a){
            if(!a||jQuery.filter(a,[this]).r.length){
                jQuery.removeData(this);
                this.parentNode.removeChild(this);
            }
        },
        empty:function(){
            jQuery("*",this).each(function(){
                jQuery.removeData(this);
            });
            while(this.firstChild)this.removeChild(this.firstChild);
        }
    },function(i,n){
        jQuery.fn[i]=function(){
            return this.each(n,arguments);
        };

    });
    jQuery.each(["Height","Width"],function(i,name){
        var n=name.toLowerCase();
        jQuery.fn[n]=function(h){
            return this[0]==window?jQuery.browser.safari&&self["inner"+name]||jQuery.boxModel&&Math.max(document.documentElement["client"+name],document.body["client"+name])||document.body["client"+name]:this[0]==document?Math.max(document.body["scroll"+name],document.body["offset"+name]):h==undefined?(this.length?jQuery.css(this[0],n):null):this.css(n,h.constructor==String?h:h+"px");
        };

    });
    var chars=jQuery.browser.safari&&parseInt(jQuery.browser.version)<417?"(?:[\\w*_-]|\\\\.)":"(?:[\\w\u0128-\uFFFF*_-]|\\\\.)",quickChild=new RegExp("^>\\s*("+chars+"+)"),quickID=new RegExp("^("+chars+"+)(#)("+chars+"+)"),quickClass=new RegExp("^([#.]?)("+chars+"*)");
    jQuery.extend({
        expr:{
            "":"m[2]=='*'||jQuery.nodeName(a,m[2])",
            "#":"a.getAttribute('id')==m[2]",
            ":":{
                lt:"i<m[3]-0",
                gt:"i>m[3]-0",
                nth:"m[3]-0==i",
                eq:"m[3]-0==i",
                first:"i==0",
                last:"i==r.length-1",
                even:"i%2==0",
                odd:"i%2",
                "first-child":"a.parentNode.getElementsByTagName('*')[0]==a",
                "last-child":"jQuery.nth(a.parentNode.lastChild,1,'previousSibling')==a",
                "only-child":"!jQuery.nth(a.parentNode.lastChild,2,'previousSibling')",
                parent:"a.firstChild",
                empty:"!a.firstChild",
                contains:"(a.textContent||a.innerText||jQuery(a).text()||'').indexOf(m[3])>=0",
                visible:'"hidden"!=a.type&&jQuery.css(a,"display")!="none"&&jQuery.css(a,"visibility")!="hidden"',
                hidden:'"hidden"==a.type||jQuery.css(a,"display")=="none"||jQuery.css(a,"visibility")=="hidden"',
                enabled:"!a.disabled",
                disabled:"a.disabled",
                checked:"a.checked",
                selected:"a.selected||jQuery.attr(a,'selected')",
                text:"'text'==a.type",
                radio:"'radio'==a.type",
                checkbox:"'checkbox'==a.type",
                file:"'file'==a.type",
                password:"'password'==a.type",
                submit:"'submit'==a.type",
                image:"'image'==a.type",
                reset:"'reset'==a.type",
                button:'"button"==a.type||jQuery.nodeName(a,"button")',
                input:"/input|select|textarea|button/i.test(a.nodeName)",
                has:"jQuery.find(m[3],a).length",
                header:"/h\\d/i.test(a.nodeName)",
                animated:"jQuery.grep(jQuery.timers,function(fn){return a==fn.elem;}).length"
            }
        },
        parse:[/^(\[) *@?([\w-]+) *([!*$^~=]*) *('?"?)(.*?)\4 *\]/,/^(:)([\w-]+)\("?'?(.*?(\(.*?\))?[^(]*?)"?'?\)/,new RegExp("^([:.#]*)("+chars+"+)")]
                ,multiFilter:function(expr,elems,not){var old,cur=[];while(expr&&expr!=old){old=expr;var f=jQuery.filter(expr,elems,not);expr=f.t.replace(/^\s*,\s*/,"");cur=not?elems=f.r:jQuery.merge(cur,f.r);}return cur;}
                ,find:function(t,context){if(typeof t!="string")return[t];if(context&&!context.nodeType)context=null;context=context||document;var ret=[context],done=[],last;while(t&&last!=t){var r=[];last=t;t=jQuery.trim(t);var foundToken=false;var re=quickChild;var m=re.exec(t);if(m){var nodeName=m[1].toUpperCase();for(var i=0;ret[i];i++)for(var c=ret[i].firstChild;c;c=c.nextSibling)if(c.nodeType==1&&(nodeName=="*"||c.nodeName.toUpperCase()==nodeName.toUpperCase()))r.push(c);ret=r;t=t.replace(re,"");if(t.indexOf(" ")==0)continue;foundToken=true;}else{re=/^([>+~])\s*(\w*)/i;if((m=re.exec(t))!=null){r=[];var nodeName=m[2],merge={};m=m[1];for(var j=0,rl=ret.length;j<rl;j++){var n=m=="~"||m=="+"?ret[j].nextSibling:ret[j].firstChild;for(;n;n=n.nextSibling)if(n.nodeType==1){var id=jQuery.data(n);if(m=="~"&&merge[id])break;if(!nodeName||n.nodeName.toUpperCase()==nodeName.toUpperCase()){if(m=="~")merge[id]=true;r.push(n);}if(m=="+")break;}}ret=r;t=jQuery.trim(t.replace(re,""));foundToken=true;}}if(t&&!foundToken){if(!t.indexOf(",")){if(context==ret[0])ret.shift();done=jQuery.merge(done,ret);r=ret=[context];t=" "+t.substr(1,t.length);}else{var re2=quickID;var m=re2.exec(t);if(m){m=[0,m[2],m[3],m[1]];}else{re2=quickClass;m=re2.exec(t);}m[2]=m[2].replace(/\\/g,"");var elem=ret[ret.length-1];if(m[1]=="#"&&elem&&elem.getElementById&&!jQuery.isXMLDoc(elem)){var oid=elem.getElementById(m[2]);if((jQuery.browser.msie||jQuery.browser.opera)&&oid&&typeof oid.id=="string"&&oid.id!=m[2])oid=jQuery('[@id="'+m[2]+'"]',elem)[0];ret=r=oid&&(!m[3]||jQuery.nodeName(oid,m[3]))?[oid]:[];}else{for(var i=0;ret[i];i++){var tag=m[1]=="#"&&m[3]?m[3]:m[1]!=""||m[0]==""?"*":m[2];if(tag=="*"&&ret[i].nodeName.toLowerCase()=="object")tag="param";r=jQuery.merge(r,ret[i].getElementsByTagName(tag));}if(m[1]==".")r=jQuery.classFilter(r,m[2]);if(m[1]=="#"){var tmp=[];for(var i=0;r[i];i++)if(r[i].getAttribute("id")==m[2]){tmp=[r[i]];break;}r=tmp;}ret=r;}t=t.replace(re2,"");}}if(t){var val=jQuery.filter(t,r);ret=r=val.r;t=jQuery.trim(val.t);}}if(t)ret=[];if(ret&&context==ret[0])ret.shift();done=jQuery.merge(done,ret);return done;}
                ,classFilter:function(r,m,not){m=" "+m+" ";var tmp=[];for(var i=0;r[i];i++){var pass=(" "+r[i].className+" ").indexOf(m)>=0;if(!not&&pass||not&&!pass)tmp.push(r[i]);}return tmp;}
                ,filter:function(t,r,not){var last;while(t&&t!=last){last=t;var p=jQuery.parse,m;for(var i=0;p[i];i++){m=p[i].exec(t);if(m){t=t.substring(m[0].length);m[2]=m[2].replace(/\\/g,"");break;}}if(!m)break;if(m[1]==":"&&m[2]=="not")r=jQuery.filter(m[3],r,true).r;else if(m[1]==".")r=jQuery.classFilter(r,m[2],not);else if(m[1]=="["){var tmp=[],type=m[3];for(var i=0,rl=r.length;i<rl;i++){var a=r[i],z=a[jQuery.props[m[2]]||m[2]];if(z==null||/href|src|selected/.test(m[2]))z=jQuery.attr(a,m[2])||'';if((type==""&&!!z||type=="="&&z==m[5]||type=="!="&&z!=m[5]||type=="^="&&z&&!z.indexOf(m[5])||type=="$="&&z.substr(z.length-m[5].length)==m[5]||(type=="*="||type=="~=")&&z.indexOf(m[5])>=0)^not)tmp.push(a);}r=tmp;}else if(m[1]==":"&&m[2]=="nth-child"){var merge={},tmp=[],test=/(\d*)n\+?(\d*)/.exec(m[3]=="even"&&"2n"||m[3]=="odd"&&"2n+1"||!/\D/.test(m[3])&&"n+"+m[3]||m[3]),first=(test[1]||1)-0,last=test[2]-0;for(var i=0,rl=r.length;i<rl;i++){var node=r[i],parentNode=node.parentNode,id=jQuery.data(parentNode);if(!merge[id]){var c=1;for(var n=parentNode.firstChild;n;n=n.nextSibling)if(n.nodeType==1)n.nodeIndex=c++;merge[id]=true;}var add=false;if(first==1){if(last==0||node.nodeIndex==last)add=true;}else if((node.nodeIndex+last)%first==0)add=true;if(add^not)tmp.push(node);}r=tmp;}else{var f=jQuery.expr[m[1]];if(typeof f!="string")f=jQuery.expr[m[1]][m[2]];f=eval("false||function(a,i){
                            return "+f+"
                        }
                        ");r=jQuery.grep(r,f,not);}}return{r:r
                        ,t:t};}
                ,dir:function(elem,dir){var matched=[];var cur=elem[dir];while(cur&&cur!=document){if(cur.nodeType==1)matched.push(cur);cur=cur[dir];}return matched;}
                ,nth:function(cur,result,dir,elem){result=result||1;var num=0;for(;cur;cur=cur[dir])if(cur.nodeType==1&&++num==result)break;return cur;}
                ,sibling:function(n,elem){var r=[];for(;n;n=n.nextSibling){if(n.nodeType==1&&(!elem||n!=elem))r.push(n);}return r;}});jQuery.event={add:function(element,type,handler,data){if(jQuery.browser.msie&&element.setInterval!=undefined)element=window;if(!handler.guid)handler.guid=this.guid++;if(data!=undefined){var fn=handler;handler=function(){return fn.apply(this,arguments);};handler.data=data;handler.guid=fn.guid;}var parts=type.split(".");type=parts[0];handler.type=parts[1];var events=jQuery.data(element,"events")||jQuery.data(element,"events",{});var handle=jQuery.data(element,"handle",function(){var val;if(typeof jQuery=="undefined"||jQuery.event.triggered)return val;val=jQuery.event.handle.apply(element,arguments);return val;});var handlers=events[type];if(!handlers){handlers=events[type]={};if(element.addEventListener)element.addEventListener(type,handle,false);else
                            element.attachEvent("on"+type,handle);
                    }
                    handlers[handler.guid]=handler;this.global[type]=true;
                },
                guid:1,
                global:{},
                remove:function(element,type,handler){
                    var events=jQuery.data(element,"events"),ret,index;if(typeof type=="string"){
                        var parts=type.split(".");type=parts[0];
                    }
                    if(events){
                        if(type&&type.type){
                            handler=type.handler;type=type.type;
                        }
                        if(!type){
                            for(type in events)this.remove(element,type);
                        }else if(events[type]){
                            if(handler)delete events[type][handler.guid];else
                                for(handler in events[type])if(!parts[1]||events[type][handler].type==parts[1])delete events[type][handler];for(ret in events[type])break;if(!ret){
                                    if(element.removeEventListener)element.removeEventListener(type,jQuery.data(element,"handle"),false);else
                                        element.detachEvent("on"+type,jQuery.data(element,"handle"));
                                    ret=null;
                                    delete events[type];
                                }
                        }
                        for(ret in events)break;if(!ret){
                            jQuery.removeData(element,"events");
                            jQuery.removeData(element,"handle");
                        }
                    }
                },
                trigger:function(type,data,element,donative,extra){
                    data=jQuery.makeArray(data||[]);
                    if(!element){
                        if(this.global[type])jQuery("*").add([window,document]).trigger(type,data);
                    }else{
                        var val,ret,fn=jQuery.isFunction(element[type]||null),evt=!data[0]||!data[0].preventDefault;
                        if(evt)data.unshift(this.fix({
                            type:type,
                            target:element
                        }));
                        data[0].type=type;
                        if(jQuery.isFunction(jQuery.data(element,"handle")))val=jQuery.data(element,"handle").apply(element,data);
                        if(!fn&&element["on"+type]&&element["on"+type].apply(element,data)===false)val=false;
                        if(evt)data.shift();
                        if(extra&&extra.apply(element,data)===false)val=false;
                        if(fn&&donative!==false&&val!==false&&!(jQuery.nodeName(element,'a')&&type=="click")){
                            this.triggered=true;
                            element[type]();
                        }
                        this.triggered=false;
                    }
                    return val;
                },
                handle:function(event){
                    var val;
                    event=jQuery.event.fix(event||window.event||{});
                    var parts=event.type.split(".");
                    event.type=parts[0];
                    var c=jQuery.data(this,"events")&&jQuery.data(this,"events")[event.type],args=Array.prototype.slice.call(arguments,1);
                    args.unshift(event);
                    for(var j in c){
                        args[0].handler=c[j];
                        args[0].data=c[j].data;
                        if(!parts[1]||c[j].type==parts[1]){
                            var tmp=c[j].apply(this,args);
                            if(val!==false)val=tmp;
                            if(tmp===false){
                                event.preventDefault();
                                event.stopPropagation();
                            }
                        }
                    }
                    if(jQuery.browser.msie)event.target=event.preventDefault=event.stopPropagation=event.handler=event.data=null;
                    return val;
                },
                fix:function(event){
                    var originalEvent=event;
                    event=jQuery.extend({},originalEvent);
                    event.preventDefault=function(){
                        if(originalEvent.preventDefault)originalEvent.preventDefault();
                        originalEvent.returnValue=false;
                    };

                    event.stopPropagation=function(){
                        if(originalEvent.stopPropagation)originalEvent.stopPropagation();
                        originalEvent.cancelBubble=true;
                    };

                    if(!event.target&&event.srcElement)event.target=event.srcElement;
                    if(jQuery.browser.safari&&event.target.nodeType==3)event.target=originalEvent.target.parentNode;
                    if(!event.relatedTarget&&event.fromElement)event.relatedTarget=event.fromElement==event.target?event.toElement:event.fromElement;
                    if(event.pageX==null&&event.clientX!=null){
                        var e=document.documentElement,b=document.body;
                        event.pageX=event.clientX+(e&&e.scrollLeft||b.scrollLeft||0);
                        event.pageY=event.clientY+(e&&e.scrollTop||b.scrollTop||0);
                    }
                    if(!event.which&&(event.charCode||event.keyCode))event.which=event.charCode||event.keyCode;
                    if(!event.metaKey&&event.ctrlKey)event.metaKey=event.ctrlKey;
                    if(!event.which&&event.button)event.which=(event.button&1?1:(event.button&2?3:(event.button&4?2:0)));
                    return event;
                }
            };

            jQuery.fn.extend({
                bind:function(type,data,fn){
                    return type=="unload"?this.one(type,data,fn):this.each(function(){
                        jQuery.event.add(this,type,fn||data,fn&&data);
                    });
                },
                one:function(type,data,fn){
                    return this.each(function(){
                        jQuery.event.add(this,type,function(event){
                            jQuery(this).unbind(event);
                            return(fn||data).apply(this,arguments);
                        },fn&&data);
                    });
                },
                unbind:function(type,fn){
                    return this.each(function(){
                        jQuery.event.remove(this,type,fn);
                    });
                },
                trigger:function(type,data,fn){
                    return this.each(function(){
                        jQuery.event.trigger(type,data,this,true,fn);
                    });
                },
                triggerHandler:function(type,data,fn){
                    if(this[0])return jQuery.event.trigger(type,data,this[0],false,fn);
                },
                toggle:function(){
                    var a=arguments;
                    return this.click(function(e){
                        this.lastToggle=0==this.lastToggle?1:0;
                        e.preventDefault();
                        return a[this.lastToggle].apply(this,[e])||false;
                    });
                },
                hover:function(f,g){
                    function handleHover(e){
                        var p=e.relatedTarget;
                        while(p&&p!=this)try{
                            p=p.parentNode;
                        }catch(e){
                            p=this;
                        };

                        if(p==this)return false;
                        return(e.type=="mouseover"?f:g).apply(this,[e]);
                    }
                    return this.mouseover(handleHover).mouseout(handleHover);
                },
                ready:function(f){
                    bindReady();
                    if(jQuery.isReady)f.apply(document,[jQuery]);else
                        jQuery.readyList.push(function(){
                            return f.apply(this,[jQuery]);
                        });
                    return this;
                }
            });
            jQuery.extend({
                isReady:false,
                readyList:[],
                ready:function(){
                    if(!jQuery.isReady){
                        jQuery.isReady=true;
                        if(jQuery.readyList){
                            jQuery.each(jQuery.readyList,function(){
                                this.apply(document);
                            });
                            jQuery.readyList=null;
                        }
                        if(jQuery.browser.mozilla||jQuery.browser.opera)document.removeEventListener("DOMContentLoaded",jQuery.ready,false);
                        if(!window.frames.length)jQuery(window).load(function(){
                            jQuery("#__ie_init").remove();
                        });
                    }
                }
            });
            jQuery.each(("blur,focus,load,resize,scroll,unload,click,dblclick,"+"mousedown,mouseup,mousemove,mouseover,mouseout,change,select,"+"submit,keydown,keypress,keyup,error").split(","),function(i,o){
                jQuery.fn[o]=function(f){
                    return f?this.bind(o,f):this.trigger(o);
                };

            });
            var readyBound=false;
            function bindReady(){
                if(readyBound)return;
                readyBound=true;
                if(jQuery.browser.mozilla||jQuery.browser.opera)document.addEventListener("DOMContentLoaded",jQuery.ready,false);
                else if(jQuery.browser.msie){
                    document.write("<scr"+"ipt id=__ie_init defer=true "+"src=//:><\/script>");
                    var script=document.getElementById("__ie_init");
                    if(script)script.onreadystatechange=function(){
                        if(this.readyState!="complete")return;
                        jQuery.ready();
                    };

                    script=null;
                }else if(jQuery.browser.safari)jQuery.safariTimer=setInterval(function(){
                    if(document.readyState=="loaded"||document.readyState=="complete"){
                        clearInterval(jQuery.safariTimer);
                        jQuery.safariTimer=null;
                        jQuery.ready();
                    }
                },10);
                jQuery.event.add(window,"load",jQuery.ready);
            }
            jQuery.fn.extend({
                load:function(url,params,callback){
                    if(jQuery.isFunction(url))return this.bind("load",url);
                    var off=url.indexOf(" ");
                    if(off>=0){
                        var selector=url.slice(off,url.length);
                        url=url.slice(0,off);
                    }
                    callback=callback||function(){};

                    var type="GET";
                    if(params)if(jQuery.isFunction(params)){
                        callback=params;
                        params=null;
                    }else{
                        params=jQuery.param(params);
                        type="POST";
                    }
                    var self=this;
                    jQuery.ajax({
                        url:url,
                        type:type,
                        data:params,
                        complete:function(res,status){
                            if(status=="success"||status=="notmodified")self.html(selector?jQuery("<div/>").append(res.responseText.replace(/<script(.|\s)*?\/script>/g,"")).find(selector):res.responseText);
                            setTimeout(function(){
                                self.each(callback,[res.responseText,status,res]);
                            },13);
                        }
                    });
                    return this;
                },
                serialize:function(){
                    return jQuery.param(this.serializeArray());
                },
                serializeArray:function(){
                    return this.map(function(){
                        return jQuery.nodeName(this,"form")?jQuery.makeArray(this.elements):this;
                    }).filter(function(){
                        return this.name&&!this.disabled&&(this.checked||/select|textarea/i.test(this.nodeName)||/text|hidden|password/i.test(this.type));
                    }).map(function(i,elem){
                        var val=jQuery(this).val();
                        return val==null?null:val.constructor==Array?jQuery.map(val,function(val,i){
                            return{
                                name:elem.name,
                                value:val
                            };

                        }):{
                            name:elem.name,
                            value:val
                        };

                    }).get();
                }
            });
            jQuery.each("ajaxStart,ajaxStop,ajaxComplete,ajaxError,ajaxSuccess,ajaxSend".split(","),function(i,o){
                jQuery.fn[o]=function(f){
                    return this.bind(o,f);
                };

            });
            var jsc=(new Date).getTime();
            jQuery.extend({
                get:function(url,data,callback,type){
                    if(jQuery.isFunction(data)){
                        callback=data;
                        data=null;
                    }
                    return jQuery.ajax({
                        type:"GET",
                        url:url,
                        data:data,
                        success:callback,
                        dataType:type
                    });
                },
                getScript:function(url,callback){
                    return jQuery.get(url,null,callback,"script");
                },
                getJSON:function(url,data,callback){
                    return jQuery.get(url,data,callback,"json");
                },
                post:function(url,data,callback,type){
                    if(jQuery.isFunction(data)){
                        callback=data;
                        data={};

                    }
                    return jQuery.ajax({
                        type:"POST",
                        url:url,
                        data:data,
                        success:callback,
                        dataType:type
                    });
                },
                ajaxSetup:function(settings){
                    jQuery.extend(jQuery.ajaxSettings,settings);
                },
                ajaxSettings:{
                    global:true,
                    type:"GET",
                    timeout:0,
                    contentType:"application/x-www-form-urlencoded",
                    processData:true,
                    async:true,
                    data:null
                },
                lastModified:{},
                ajax:function(s){
                    var jsonp,jsre=/=(\?|%3F)/g,status,data;
                    s=jQuery.extend(true,s,jQuery.extend(true,{},jQuery.ajaxSettings,s));
                    if(s.data&&s.processData&&typeof s.data!="string")s.data=jQuery.param(s.data);
                    if(s.dataType=="jsonp"){
                        if(s.type.toLowerCase()=="get"){
                            if(!s.url.match(jsre))s.url+=(s.url.match(/\?/)?"&":"?")+(s.jsonp||"callback")+"=?";
                        }else if(!s.data||!s.data.match(jsre))s.data=(s.data?s.data+"&":"")+(s.jsonp||"callback")+"=?";
                        s.dataType="json";
                    }
                    if(s.dataType=="json"&&(s.data&&s.data.match(jsre)||s.url.match(jsre))){
                        jsonp="jsonp"+jsc++;
                        if(s.data)s.data=s.data.replace(jsre,"="+jsonp);
                        s.url=s.url.replace(jsre,"="+jsonp);
                        s.dataType="script";
                        window[jsonp]=function(tmp){
                            data=tmp;
                            success();
                            complete();
                            window[jsonp]=undefined;
                            try{
                                delete window[jsonp];
                            }catch(e){}
                        };

                    }
                    if(s.dataType=="script"&&s.cache==null)s.cache=false;
                    if(s.cache===false&&s.type.toLowerCase()=="get")s.url+=(s.url.match(/\?/)?"&":"?")+"_="+(new Date()).getTime();
                    if(s.data&&s.type.toLowerCase()=="get"){
                        s.url+=(s.url.match(/\?/)?"&":"?")+s.data;
                        s.data=null;
                    }
                    if(s.global&&!jQuery.active++)jQuery.event.trigger("ajaxStart");
                    if(!s.url.indexOf("http")&&s.dataType=="script"){
                        var head=document.getElementsByTagName("head")[0];
                        var script=document.createElement("script");
                        script.src=s.url;
                        if(!jsonp&&(s.success||s.complete)){
                            var done=false;
                            script.onload=script.onreadystatechange=function(){
                                if(!done&&(!this.readyState||this.readyState=="loaded"||this.readyState=="complete")){
                                    done=true;
                                    success();
                                    complete();
                                    head.removeChild(script);
                                }
                            };

                        }
                        head.appendChild(script);
                        return;
                    }
                    var requestDone=false;
                    var xml=window.ActiveXObject?new ActiveXObject("Microsoft.XMLHTTP"):new XMLHttpRequest();
                    xml.open(s.type,s.url,s.async);
                    if(s.data)xml.setRequestHeader("Content-Type",s.contentType);
                    if(s.ifModified)xml.setRequestHeader("If-Modified-Since",jQuery.lastModified[s.url]||"Thu, 01 Jan 1970 00:00:00 GMT");
                    xml.setRequestHeader("X-Requested-With","XMLHttpRequest");
                    if(s.beforeSend)s.beforeSend(xml);
                    if(s.global)jQuery.event.trigger("ajaxSend",[xml,s]);
                    var onreadystatechange=function(isTimeout){
                        if(!requestDone&&xml&&(xml.readyState==4||isTimeout=="timeout")){
                            requestDone=true;
                            if(ival){
                                clearInterval(ival);
                                ival=null;
                            }
                            status=isTimeout=="timeout"&&"timeout"||!jQuery.httpSuccess(xml)&&"error"||s.ifModified&&jQuery.httpNotModified(xml,s.url)&&"notmodified"||"success";
                            if(status=="success"){
                                try{
                                    data=jQuery.httpData(xml,s.dataType);
                                }catch(e){
                                    status="parsererror";
                                }
                            }
                            if(status=="success"){
                                var modRes;
                                try{
                                    modRes=xml.getResponseHeader("Last-Modified");
                                }catch(e){}
                                if(s.ifModified&&modRes)jQuery.lastModified[s.url]=modRes;
                                if(!jsonp)success();
                            }else
                                jQuery.handleError(s,xml,status);
                            complete();
                            if(s.async)xml=null;
                        }
                    };

                    if(s.async){
                        var ival=setInterval(onreadystatechange,13);
                        if(s.timeout>0)setTimeout(function(){
                            if(xml){
                                xml.abort();
                                if(!requestDone)onreadystatechange("timeout");
                            }
                        },s.timeout);
                    }
                    try{
                        xml.send(s.data);
                    }catch(e){
                        jQuery.handleError(s,xml,null,e);
                    }
                    if(!s.async)onreadystatechange();
                    return xml;
                    function success(){
                        if(s.success)s.success(data,status);
                        if(s.global)jQuery.event.trigger("ajaxSuccess",[xml,s]);
                    }
                    function complete(){
                        if(s.complete)s.complete(xml,status);
                        if(s.global)jQuery.event.trigger("ajaxComplete",[xml,s]);
                        if(s.global&&!--jQuery.active)jQuery.event.trigger("ajaxStop");
                    }
                },
                handleError:function(s,xml,status,e){
                    if(s.error)s.error(xml,status,e);
                    if(s.global)jQuery.event.trigger("ajaxError",[xml,s,e]);
                },
                active:0,
                httpSuccess:function(r){
                    try{
                        return!r.status&&location.protocol=="file:"||(r.status>=200&&r.status<300)||r.status==304||jQuery.browser.safari&&r.status==undefined;
                    }catch(e){}
                    return false;
                },
                httpNotModified:function(xml,url){
                    try{
                        var xmlRes=xml.getResponseHeader("Last-Modified");
                        return xml.status==304||xmlRes==jQuery.lastModified[url]||jQuery.browser.safari&&xml.status==undefined;
                    }catch(e){}
                    return false;
                },
                httpData:function(r,type){
                    var ct=r.getResponseHeader("content-type");
                    var xml=type=="xml"||!type&&ct&&ct.indexOf("xml")>=0;
                    var data=xml?r.responseXML:r.responseText;
                    if(xml&&data.documentElement.tagName=="parsererror")throw"parsererror";
                    if(type=="script")jQuery.globalEval(data);
                    if(type=="json")data=eval("("+data+")");
                    return data;
                },
                param:function(a){
                    var s=[];
                    if(a.constructor==Array||a.jquery)jQuery.each(a,function(){
                        s.push(encodeURIComponent(this.name)+"="+encodeURIComponent(this.value));
                    });else
                        for(var j in a)if(a[j]&&a[j].constructor==Array)jQuery.each(a[j],function(){
                            s.push(encodeURIComponent(j)+"="+encodeURIComponent(this));
                        });else
                        s.push(encodeURIComponent(j)+"="+encodeURIComponent(a[j]));return s.join("&").replace(/%20/g,"+");
                }
            });
            jQuery.fn.extend({
                show:function(speed,callback){
                    return speed?this.animate({
                        height:"show",
                        width:"show",
                        opacity:"show"
                    },speed,callback):this.filter(":hidden").each(function(){
                        this.style.display=this.oldblock?this.oldblock:"";
                        if(jQuery.css(this,"display")=="none")this.style.display="block";
                    }).end();
                },
                hide:function(speed,callback){
                    return speed?this.animate({
                        height:"hide",
                        width:"hide",
                        opacity:"hide"
                    },speed,callback):this.filter(":visible").each(function(){
                        this.oldblock=this.oldblock||jQuery.css(this,"display");
                        if(this.oldblock=="none")this.oldblock="block";
                        this.style.display="none";
                    }).end();
                },
                _toggle:jQuery.fn.toggle,
                toggle:function(fn,fn2){
                    return jQuery.isFunction(fn)&&jQuery.isFunction(fn2)?this._toggle(fn,fn2):fn?this.animate({
                        height:"toggle",
                        width:"toggle",
                        opacity:"toggle"
                    },fn,fn2):this.each(function(){
                        jQuery(this)[jQuery(this).is(":hidden")?"show":"hide"]();
                    });
                },
                slideDown:function(speed,callback){
                    return this.animate({
                        height:"show"
                    },speed,callback);
                },
                slideUp:function(speed,callback){
                    return this.animate({
                        height:"hide"
                    },speed,callback);
                },
                slideToggle:function(speed,callback){
                    return this.animate({
                        height:"toggle"
                    },speed,callback);
                },
                fadeIn:function(speed,callback){
                    return this.animate({
                        opacity:"show"
                    },speed,callback);
                },
                fadeOut:function(speed,callback){
                    return this.animate({
                        opacity:"hide"
                    },speed,callback);
                },
                fadeTo:function(speed,to,callback){
                    return this.animate({
                        opacity:to
                    },speed,callback);
                },
                animate:function(prop,speed,easing,callback){
                    var opt=jQuery.speed(speed,easing,callback);
                    return this[opt.queue===false?"each":"queue"](function(){
                        opt=jQuery.extend({},opt);
                        var hidden=jQuery(this).is(":hidden"),self=this;
                        for(var p in prop){
                            if(prop[p]=="hide"&&hidden||prop[p]=="show"&&!hidden)return jQuery.isFunction(opt.complete)&&opt.complete.apply(this);
                            if(p=="height"||p=="width"){
                                opt.display=jQuery.css(this,"display");
                                opt.overflow=this.style.overflow;
                            }
                        }
                        if(opt.overflow!=null)this.style.overflow="hidden";
                        opt.curAnim=jQuery.extend({},prop);
                        jQuery.each(prop,function(name,val){
                            var e=new jQuery.fx(self,opt,name);
                            if(/toggle|show|hide/.test(val))e[val=="toggle"?hidden?"show":"hide":val](prop);
                            else{
                                var parts=val.toString().match(/^([+-]=)?([\d+-.]+)(.*)$/),start=e.cur(true)||0;
                                if(parts){
                                    var end=parseFloat(parts[2]),unit=parts[3]||"px";
                                    if(unit!="px"){
                                        self.style[name]=(end||1)+unit;
                                        start=((end||1)/e.cur(true))*start;
                                        self.style[name]=start+unit;
                                    }
                                    if(parts[1])end=((parts[1]=="-="?-1:1)*end)+start;
                                    e.custom(start,end,unit);
                                }else
                                    e.custom(start,val,"");
                            }
                        });
                        return true;
                    });
                },
                queue:function(type,fn){
                    if(jQuery.isFunction(type)){
                        fn=type;
                        type="fx";
                    }
                    if(!type||(typeof type=="string"&&!fn))return queue(this[0],type);
                    return this.each(function(){
                        if(fn.constructor==Array)queue(this,type,fn);
                        else{
                            queue(this,type).push(fn);
                            if(queue(this,type).length==1)fn.apply(this);
                        }
                    });
                },
                stop:function(){
                    var timers=jQuery.timers;
                    return this.each(function(){
                        for(var i=0;i<timers.length;i++)if(timers[i].elem==this)timers.splice(i--,1);
                    }).dequeue();
                }
            });
            var queue=function(elem,type,array){
                if(!elem)return;
                var q=jQuery.data(elem,type+"queue");
                if(!q||array)q=jQuery.data(elem,type+"queue",array?jQuery.makeArray(array):[]);
                return q;
            };

            jQuery.fn.dequeue=function(type){
                type=type||"fx";
                return this.each(function(){
                    var q=queue(this,type);
                    q.shift();
                    if(q.length)q[0].apply(this);
                });
            };

            jQuery.extend({
                speed:function(speed,easing,fn){
                    var opt=speed&&speed.constructor==Object?speed:{
                        complete:fn||!fn&&easing||jQuery.isFunction(speed)&&speed,
                        duration:speed,
                        easing:fn&&easing||easing&&easing.constructor!=Function&&easing
                    };

                    opt.duration=(opt.duration&&opt.duration.constructor==Number?opt.duration:{
                        slow:600,
                        fast:200
                    }
                    [opt.duration])||400;
                    opt.old=opt.complete;
                    opt.complete=function(){
                        jQuery(this).dequeue();
                        if(jQuery.isFunction(opt.old))opt.old.apply(this);
                    };

                    return opt;
                },
                easing:{
                    linear:function(p,n,firstNum,diff){
                        return firstNum+diff*p;
                    },
                    swing:function(p,n,firstNum,diff){
                        return((-Math.cos(p*Math.PI)/2)+0.5)*diff+firstNum;
                    }
                },
                timers:[],
                fx:function(elem,options,prop){
                    this.options=options;
                    this.elem=elem;
                    this.prop=prop;
                    if(!options.orig)options.orig={};

                }
            });
            jQuery.fx.prototype={
                update:function(){
                    if(this.options.step)this.options.step.apply(this.elem,[this.now,this]);
                    (jQuery.fx.step[this.prop]||jQuery.fx.step._default)(this);
                    if(this.prop=="height"||this.prop=="width")this.elem.style.display="block";
                },
                cur:function(force){
                    if(this.elem[this.prop]!=null&&this.elem.style[this.prop]==null)return this.elem[this.prop];
                    var r=parseFloat(jQuery.curCSS(this.elem,this.prop,force));
                    return r&&r>-10000?r:parseFloat(jQuery.css(this.elem,this.prop))||0;
                },
                custom:function(from,to,unit){
                    this.startTime=(new Date()).getTime();
                    this.start=from;
                    this.end=to;
                    this.unit=unit||this.unit||"px";
                    this.now=this.start;
                    this.pos=this.state=0;
                    this.update();
                    var self=this;
                    function t(){
                        return self.step();
                    }
                    t.elem=this.elem;
                    jQuery.timers.push(t);
                    if(jQuery.timers.length==1){
                        var timer=setInterval(function(){
                            var timers=jQuery.timers;
                            for(var i=0;i<timers.length;i++)if(!timers[i]())timers.splice(i--,1);if(!timers.length)clearInterval(timer);
                        },13);
                    }
                },
                show:function(){
                    this.options.orig[this.prop]=jQuery.attr(this.elem.style,this.prop);
                    this.options.show=true;
                    this.custom(0,this.cur());
                    if(this.prop=="width"||this.prop=="height")this.elem.style[this.prop]="1px";
                    jQuery(this.elem).show();
                },
                hide:function(){
                    this.options.orig[this.prop]=jQuery.attr(this.elem.style,this.prop);
                    this.options.hide=true;
                    this.custom(this.cur(),0);
                },
                step:function(){
                    var t=(new Date()).getTime();
                    if(t>this.options.duration+this.startTime){
                        this.now=this.end;
                        this.pos=this.state=1;
                        this.update();
                        this.options.curAnim[this.prop]=true;
                        var done=true;
                        for(var i in this.options.curAnim)if(this.options.curAnim[i]!==true)done=false;if(done){
                            if(this.options.display!=null){
                                this.elem.style.overflow=this.options.overflow;
                                this.elem.style.display=this.options.display;
                                if(jQuery.css(this.elem,"display")=="none")this.elem.style.display="block";
                            }
                            if(this.options.hide)this.elem.style.display="none";
                            if(this.options.hide||this.options.show)for(var p in this.options.curAnim)jQuery.attr(this.elem.style,p,this.options.orig[p]);
                        }
                        if(done&&jQuery.isFunction(this.options.complete))this.options.complete.apply(this.elem);
                        return false;
                    }else{
                        var n=t-this.startTime;
                        this.state=n/this.options.duration;
                        this.pos=jQuery.easing[this.options.easing||(jQuery.easing.swing?"swing":"linear")](this.state,n,0,1,this.options.duration);
                        this.now=this.start+((this.end-this.start)*this.pos);
                        this.update();
                    }
                    return true;
                }
            };

            jQuery.fx.step={
                scrollLeft:function(fx){
                    fx.elem.scrollLeft=fx.now;
                },
                scrollTop:function(fx){
                    fx.elem.scrollTop=fx.now;
                },
                opacity:function(fx){
                    jQuery.attr(fx.elem.style,"opacity",fx.now);
                },
                _default:function(fx){
                    fx.elem.style[fx.prop]=fx.now+fx.unit;
                }
            };

            jQuery.fn.offset=function(){
                var left=0,top=0,elem=this[0],results;
                if(elem)with(jQuery.browser){
                    var absolute=jQuery.css(elem,"position")=="absolute",parent=elem.parentNode,offsetParent=elem.offsetParent,doc=elem.ownerDocument,safari2=safari&&parseInt(version)<522;
                    if(elem.getBoundingClientRect){
                        box=elem.getBoundingClientRect();
                        add(box.left+Math.max(doc.documentElement.scrollLeft,doc.body.scrollLeft),box.top+Math.max(doc.documentElement.scrollTop,doc.body.scrollTop));
                        if(msie){
                            var border=jQuery("html").css("borderWidth");
                            border=(border=="medium"||jQuery.boxModel&&parseInt(version)>=7)&&2||border;
                            add(-border,-border);
                        }
                    }else{
                        add(elem.offsetLeft,elem.offsetTop);
                        while(offsetParent){
                            add(offsetParent.offsetLeft,offsetParent.offsetTop);
                            if(mozilla&&/^t[d|h]$/i.test(parent.tagName)||!safari2)border(offsetParent);
                            if(safari2&&!absolute&&jQuery.css(offsetParent,"position")=="absolute")absolute=true;
                            offsetParent=offsetParent.offsetParent;
                        }while(parent.tagName&&!/^body|html$/i.test(parent.tagName)){
                            if(!/^inline|table-row.*$/i.test(jQuery.css(parent,"display")))add(-parent.scrollLeft,-parent.scrollTop);
                            if(mozilla&&jQuery.css(parent,"overflow")!="visible")border(parent);
                            parent=parent.parentNode;
                        }
                        if(safari2&&absolute)add(-doc.body.offsetLeft,-doc.body.offsetTop);
                    }
                    results={
                        top:top,
                        left:left
                    };

                }
                return results;
                function border(elem){
                    add(jQuery.css(elem,"borderLeftWidth"),jQuery.css(elem,"borderTopWidth"));
                }
                function add(l,t){
                    left+=parseInt(l)||0;
                    top+=parseInt(t)||0;
                }
            };

        })();