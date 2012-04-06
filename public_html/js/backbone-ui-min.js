(function(){typeof Backbone==="undefined"&&alert("backbone environment not loaded");typeof $==="undefined"&&alert("jquery environment not loaded");Backbone.UI=Backbone.UI||{KEYS:{KEY_BACKSPACE:8,KEY_TAB:9,KEY_RETURN:13,KEY_ESC:27,KEY_LEFT:37,KEY_UP:38,KEY_RIGHT:39,KEY_DOWN:40,KEY_DELETE:46,KEY_HOME:36,KEY_END:35,KEY_PAGEUP:33,KEY_PAGEDOWN:34,KEY_INSERT:45},GLYPH_DIR:"/images/glyphs",setSkin:function(a){Backbone.UI.currentSkin&&$(document.body).removeClass("skin_"+Backbone.UI.currentSkin);$(document.body).addClass("skin_"+
a);Backbone.UI.currentSkin=a},noop:function(){}};_(Backbone.View.prototype).extend({resolveContent:function(a,b){a=_(a).exists()?a:this.model;b=_(b).exists()?b:this.options.content;var c=_(a).exists()&&_(b).exists();return _(b).isFunction()?b(a):c&&_(a[b]).isFunction()?a[b]():c?_(a).resolveProperty(b):b},mixin:function(a){var b=_(this.options).clone();_(a).each(function(a){$.extend(!0,this,a)},this);$.extend(!0,this.options,b)}});_.mixin({nameForIndex:function(a,b){return a.length===1?"first last":
b===0?"first":b===a.length-1?"last":"middle"},exists:function(a){return!_(a).isNull()&&!_(a).isUndefined()},resolveProperty:function(a,b){var c=null;if(_(b).exists()&&_(b).isString()){var d=b.split(".");_(d).each(function(b){if(_(a).exists()){var d=c||a;c=_(d.get).isFunction()?d.get(b):d[b]}})}return c},setProperty:function(a,b,c,d){if(b){var e=b.split(".");_(e.slice(0,e.length-2)).each(function(b){!_(a).isNull()&&!_(a).isUndefined()&&(a=_(a.get).isFunction()?a.get(b):a[b])});a&&(_(a.set).isFunction()?
(e={},e[b]=c,a.set(e,{silent:d})):a[b]=c)}}});_($.fn).extend({alignTo:function(a,b,c,d){_.each(this,function(e){var h=!1;e.style.display==="none"&&(h=!0,$(e).css({position:"absolute",top:"-10000px",left:"-10000px",display:"block"}));var f,j,i=a;f=b;j=$(e);i=$(i);f=f||"";var g=i.offset();i={width:i.width(),height:i.height()};j.offset();var k={width:j.width(),height:j.height()};j=f.indexOf("-left")>=0?g.left:f.indexOf("left")>=0?g.left-k.width:f.indexOf("-right")>=0?g.left+i.width-k.width:f.indexOf("right")>=
0?g.left+i.width:g.left+(i.width-k.width)/2;g=f.indexOf("-top")>=0?g.top:f.indexOf("top")>=0?g.top-k.height:f.indexOf("-bottom")>=0?g.top+i.height-k.height:f.indexOf("bottom")>=0?g.top+i.height:g.top+(i.height-k.height)/2;f.indexOf("no-constraint");j+=c||0;g+=d||0;f={x:j,y:g};$(e).css({position:"absolute",left:Math.round(f.x)+"px",top:Math.round(f.y)+"px"});h&&$(e).hide()})},autohide:function(a){_.each(this,function(b){a=_.extend({leaveOpen:!1,hideCallback:!1,ignoreInputs:!1,ignoreKeys:[],leaveOpenTargets:[]},
a||{});b._autoignore=!0;setTimeout(function(){b._autoignore=!1;$(b).removeAttr("_autoignore")},0);if(!b._autohider)b._autohider=_.bind(function(c){var d=c.target;if($(b).is(":visible")&&(!a.ignoreInputs||!/input|textarea|select|option/i.test(d.nodeName)))if(!b._autoignore&&(!c.type||!c.type.match(/keypress/)||!_.include(a.ignoreKeys,c.keyCode))&&(!a.leaveOpenTargets||!_(a.leaveOpenTargets).find(function(a){return c.target===a||$(c.target).closest($(a)).length>0})))if(a.hideCallback?a.hideCallback(b):
1)$(b).hide(),$(document).bind("click",b._autohider),$(document).bind("keypress",b._autohider),b._autohider=null},this),$(document).bind("click",b._autohider),$(document).bind("keypress",b._autohider)})}})})(this);
(function(){window.Backbone.UI.Button=Backbone.View.extend({options:{tagName:"a",disabled:!1,active:!1,hasBorder:!0,onClick:null,isSubmit:!1},initialize:function(){this.mixin([Backbone.UI.HasModel,Backbone.UI.HasGlyph]);_(this).bindAll("render");$(this.el).addClass("button");document.ontouchstart!==void 0||document.ontouchstart===null?$(this.el).bind("touchstart",_(function(){$(this.el).addClass("active");Backbone.UI._activeButton=this;var a=$(document.body).bind("touchend",function(b){if(Backbone.UI._activeButton){if((b.target===
Backbone.UI._activeButton.el||$(b.target).closest(".button.active").length>0)&&Backbone.UI._activeButton.options.onClick)Backbone.UI._activeButton.options.onClick(b);$(Backbone.UI._activeButton.el).removeClass("active")}Backbone.UI._activeButton=null;$(document.body).unbind("touchend",a)});return!1}).bind(this)):$(this.el).bind("click",_(function(a){if(!this.options.disabled&&!this.options.active&&this.options.onClick)this.options.onClick(a);return!1}).bind(this))},render:function(){var a=this.resolveContent();
this._observeModel(this.render);$(this.el).empty();$(this.el).toggleClass("has_border",this.options.hasBorder);this.options.isSubmit&&$.el.input({type:"submit",value:""}).appendTo(this.el);$.el.span({className:"label"},a).appendTo(this.el);this.insertGlyph(this.el,this.options.glyph);this.insertGlyphRight(this.el,this.options.glyphRight);this.setEnabled(!this.options.disabled);this.setActive(this.options.active);return this},setEnabled:function(a){a?this.el.href="#":this.el.removeAttribute("href");
this.options.disabled=!a;$(this.el)[a?"removeClass":"addClass"]("disabled")},setActive:function(a){this.options.active=a;$(this.el)[a?"addClass":"removeClass"]("active")}})})();
(function(){var a=["jan","feb","mar","apr","may","jun","jul","aug","sep","oct","nov","dec"],b=["s","m","t","w","t","f","s"],c=function(a){var b=a.getYear();return[31,b%4===0&&b%100!==0||b%400===0?29:28,31,30,31,30,31,31,30,31,30,31][a.getMonth()]};window.Backbone.UI.Calendar=Backbone.View.extend({options:{date:null,weekStart:0,onSelect:null},date:null,initialize:function(){$(this.el).addClass("calendar");_(this).bindAll("render")},render:function(){if(_(this.model).exists()&&_(this.options.content).exists()){this.date=
this.resolveContent();var a="change:"+this.options.content;this.model.unbind(a,this.render);this.model.bind(a,this.render)}else this.date=this.date||this.options.date||new Date;this._renderDate(this.date);return this},_selectDate:function(a){this.date=a;if(_(this.model).exists()&&_(this.options.content).exists()){var b=this.resolveContent();b=new Date(b.getTime());b.setMonth(a.getMonth());b.setDate(a.getDate());b.setFullYear(a.getFullYear());_(this.model).setProperty(this.options.content,b)}this.render();
if(_(this.options.onSelect).isFunction())this.options.onSelect(a);return!1},_renderDate:function(d,e){e&&e.stopPropagation();$(this.el).empty();for(var h=new Date(d.getFullYear(),d.getMonth()+1),f=new Date(d.getFullYear(),d.getMonth()-1),j=(new Date(d.getFullYear(),d.getMonth(),1)).getDay()-this.options.weekStart-1,i=c(d),g=new Date,k=g.getFullYear()===d.getFullYear()&&g.getMonth()===d.getMonth(),p=!!this.date&&this.date.getFullYear()===d.getFullYear()&&this.date.getMonth()===d.getMonth(),m=$.el.tr({className:"row days"}),
n=b.slice(this.options.weekStart).concat(b.slice(0,this.options.weekStart)),l=0;l<n.length;l++)$.el.td(n[l]).appendTo(m);m=$.el.table($.el.thead($.el.th($.el.a({className:"go_back",onclick:_(this._renderDate).bind(this,f)},"\u2039")),$.el.th({className:"title",colspan:5},$.el.div(a[d.getMonth()]+" "+d.getFullYear())),$.el.th($.el.a({className:"go_forward",onclick:_(this._renderDate).bind(this,h)},"\u203a"))),h=$.el.tbody(m));f=j>=0?c(f)-j:1;for(l=n=0;l<6;l++){for(var r=$.el.tr({className:"row"+(l===
0?" first":l===4?" last":"")}),o=0;o<7;o++){var q=n<=j||n>j+i,s=_(this._selectDate).bind(this,new Date(d.getFullYear(),d.getMonth(),f)),t="cell"+(q?" inactive":"")+(o===0?" first":o===6?" last":"")+(k&&!q&&f===g.getDate()?" today":"")+(p&&!q&&f===this.date.getDate()?" selected":"");$.el.td({className:t},q?$.el.div({className:"day"},f):$.el.a({className:"day",onClick:s},f)).appendTo(r);f=l===0&&o===j||l>0&&f===i?1:f+1;n++}r.appendTo(h)}this.el.appendChild(m);return!1}})})();
(function(){window.Backbone.UI.Checkbox=Backbone.View.extend({options:{tagName:"a",labelContent:null,disabled:!1},initialize:function(){this.mixin([Backbone.UI.HasModel]);_(this).bindAll("render");$(this.el).click(_(this._onClick).bind(this));$(this.el).attr({href:"#"});$(this.el).addClass("checkbox")},render:function(){this._observeModel(this.render);$(this.el).empty();this.checked=this.checked||this.resolveContent();var a=$.el.div({className:"checkmark"});this.checked&&a.appendChild($.el.div({className:"checkmark_fill"}));
var b=_(this.model).resolveProperty(this.options.labelContent)||this.options.labelContent;this._label=$.el.div({className:"label"},b);this.el.appendChild(a);this.el.appendChild(this._label);this.el.appendChild($.el.br({style:"clear:both"}));return this},_onClick:function(){if(this.options.disabled)return!1;this.checked=!this.checked;_(this.model).exists()&&_(this.options.content).exists()?_(this.model).setProperty(this.options.content,this.checked):this.render();return!1}})})();
(function(){window.Backbone.UI.CollectionView=Backbone.View.extend({options:{model:null,itemView:null,emptyContent:null,onItemClick:Backbone.UI.noop,maxHeight:null},itemViews:{},_emptyContent:null,_renderItem:Backbone.UI.noop,initialize:function(){this.model&&(this.model.bind("add",_.bind(this._onItemAdded,this)),this.model.bind("change",_.bind(this._onItemChanged,this)),this.model.bind("remove",_.bind(this._onItemRemoved,this)),this.model.bind("refresh",_.bind(this.render,this)),this.model.bind("reset",
_.bind(this.render,this)))},_onItemAdded:function(a,b){if(!this.itemViews[a.cid]){if(this._emptyContent)this._emptyContent.parentNode&&this._emptyContent.parentNode.removeChild(this._emptyContent),this._emptyContent=null;var c=b.indexOf(a),d=this._renderItem(a,c);c=this.collectionEl.childNodes[c];this.collectionEl.insertBefore(d,_(c).isUndefined()?null:c);this._updateClassNames()}},_onItemChanged:function(a){(a=this.itemViews[a.cid])&&a.el&&a.el.parentNode?(a.render(),this._ensureProperPosition(a)):
this.render()},_onItemRemoved:function(a){var b=this.itemViews[a.cid],c=b.el.parentNode;b&&c&&c.parentNode&&c.parentNode.removeChild(c);delete this.itemViews[a.cid];this._updateClassNames()},_updateClassNames:function(){var a=this.collectionEl.childNodes;a.length>0&&(_(a).each(function(a){$(a).removeClass("first");$(a).removeClass("last")}),$(a[0]).addClass("first"),$(a[a.length-1]).addClass("last"))},_ensureProperPosition:function(a){if(_(this.model.comparator).isFunction()){this.model.sort({silent:!0});
var b=a.el.parentNode,c=_(this.collectionEl.childNodes).indexOf(b,!0);a=this.model.indexOf(a.model);c!==a&&(b.parentNode.removeChild(b),(c=this.collectionEl.childNodes[a])?this.collectionEl.insertBefore(b,c):this.collectionEl.appendChild(b))}}})})();
(function(){window.Backbone.UI.DatePicker=Backbone.View.extend({options:{format:"MM/DD/YYYY",date:null,name:null,onChange:null},initialize:function(){$(this.el).addClass("date_picker");this._calendar=new Backbone.UI.Calendar({className:"date_picker_calendar",model:this.model,property:this.options.content,onSelect:_(this._selectDate).bind(this)});$(this._calendar.el).hide();document.body.appendChild(this._calendar.el);$(this._calendar.el).autohide({ignoreInputs:!0,leaveOpenTargets:[this._calendar.el]});
this.model&&this.options.content&&this.model.bind("change:"+this.options.content,_(this.render).bind(this))},render:function(){$(this.el).empty();this._textField=(new Backbone.UI.TextField({name:this.options.name})).render();$(this._textField.input).click(_(this._showCalendar).bind(this));$(this._textField.input).keyup(_(this._dateEdited).bind(this));this.el.appendChild(this._textField.el);if(this._selectedDate=this.model&&this.options.content?this.resolveContent():this.options.date)this._calendar.options.selectedDate=
this._selectedDate,this._textField.setValue(moment(this._selectedDate).format(this.options.format));this._calendar.render();return this},setEnabled:function(a){this._textField.setEnabled(a)},getValue:function(){return this._selectedDate},setValue:function(a){this._selectedDate=a;this._textField.setValue(moment(a).format(this.options.format));this._dateEdited()},_showCalendar:function(){$(this._calendar.el).show();$(this._calendar.el).alignTo(this._textField.el,"bottom -left",0,2)},_hideCalendar:function(){$(this._calendar.el).hide()},
_selectDate:function(a){a.getMonth();a.getDate();this._textField.setValue(moment(a).format(this.options.format));this._dateEdited();this._hideCalendar();return!1},_dateEdited:function(a){var b=moment(this._textField.getValue(),this.options.format);this._selectedDate=b.toDate();if(!a||a.keyCode===Backbone.UI.KEYS.KEY_RETURN){a=moment(b).format(this.options.format);this._textField.setValue(a);this._hideCalendar();if(this.model&&this.options.content){var c=this.resolveContent()||new Date;c=new Date(c.getTime());
c.setMonth(b.month());c.setDate(b.date());c.setFullYear(b.year());_(this.model).setProperty(this.options.content,c)}if(_(this.options.onChange).isFunction())this.options.onChange(a)}}})})();
(function(){Backbone.UI.DragSession=function(a){this.options=_.extend({dragEvent:null,scope:null,onClick:Backbone.UI.noop,onStart:Backbone.UI.noop,onMove:Backbone.UI.noop,onStop:Backbone.UI.noop,onAbort:Backbone.UI.noop,onDone:Backbone.UI.noop},a);Backbone.UI.DragSession.currentSession&&Backbone.UI.DragSession.currentSession.abort();this._doc=this.options.scope||document;this._handleEvent=_.bind(this._handleEvent,this);this._handleEvent(this.options.dragEvent);this._activate(!0);this.options.dragEvent.stopPropagation();
Backbone.UI.DragSession.currentSession=this};_.extend(Backbone.UI.DragSession,{SLOP:2,BASIC_DRAG_CLASSNAME:"dragging",enableBasicDragSupport:function(a){a=a?a.document||a:document;if(!a._basicDragSupportEnabled)a._basicDragSupportEnabled=!0,$(a).bind("mousedown",function(a){var c=a.target;if(!/(input|textarea|button|select|option)/i.exec(c.nodeName)&&c.hasClassName){var d=c.hasClassName("draggable")?c:c.up(".draggable");if(d=d?d.up(".draggable-container")||d:null){var e=d.getBounds(),h=document.activeElement;
new Backbone.UI.DragSession({dragEvent:a,scope:d.ownerDocument,onStart:function(a){h&&h.blur&&h.blur();a.pos=d.positionedOffset();$(d).addClass(Backbone.UI.DragSession.BASIC_DRAG_CLASSNAME)},onMove:function(){d.style.left=e.x+"px";d.style.top=e.y+"px"},onDone:function(){h&&h.focus&&h.focus();d.removeClassName(Backbone.UI.DragSession.BASIC_DRAG_CLASSNAME)}})}}})}});_.extend(Backbone.UI.DragSession.prototype,{stop:function(){this._stop()},abort:function(){this._stop(!0)},_activate:function(a){a=a?"bind":
"unbind";$(this._doc)[a]("mousemove",this._handleEvent);$(this._doc)[a]("mouseup",this._handleEvent);$(this._doc)[a]("keyup",this._handleEvent)},_handleEvent:function(a){a.stopPropagation();a.preventDefault();this.x=a.pageX;this.y=a.pageY;if(a.type==="mousedown")this.xStart=this.x,this.yStart=this.y;this.dx=this.x-this.xStart;this.dy=this.y-this.yStart;switch(a.type){case "mousemove":if(this._dragging)this.options.onMove(this,a);else if(this.dx*this.dx+this.dy*this.dy>=Backbone.UI.DragSession.SLOP*
Backbone.UI.DragSession.SLOP)this._dragging=!0,this.options.onStart(this,a);break;case "mouseup":if(this._dragging)this.stop();else this.options.onClick(this,a);break;case "keyup":if(a.keyCode!==Backbone.UI.KEYS.KEY_ESC)break;this.abort()}},_stop:function(a){Backbone.UI.DragSession.currentSession=null;this._activate(!1);if(this._dragging){if(a)this.options.onAbort(this);else this.options.onStop(this);this.options.onDone(this)}}})})();
(function(){Backbone.UI.HasAlternativeProperty={options:{alternatives:null,altLabelContent:null,altValueContent:null,altGlyph:null,altGlyphRight:null},_determineSelectedItem:function(){var a;if(_(this.model).exists()&&_(this.options.content).exists()&&(a=_(this.model).resolveProperty(this.options.content),_(this.options.altValueContent).exists())){var b=_(this._collectionArray()).detect(function(b){return(b.attributes||b)[this.options.altValueContent]===a},this);_(b).isUndefined()||(a=b)}return a||
this.options.selectedItem},_setSelectedItem:function(a,b){this.selectedItem=this.selectedValue=a;if(_(this.model).exists()&&_(this.options.content).exists())this.selectedValue=this._valueForItem(a),_(this.model).setProperty(this.options.content,this.selectedValue,b)},_valueForItem:function(a){return _(this.options.altValueContent).exists()?_(a).resolveProperty(this.options.altValueContent):a},_collectionArray:function(){return _(this.options.alternatives).exists()?this.options.alternatives.models||
this.options.alternatives:[]},_observeCollection:function(a){_(this.options.alternatives).exists()&&_(this.options.alternatives.bind).exists()&&(this.options.alternatives.unbind("change",a),this.options.alternatives.bind("change",a))}}})();
(function(){Backbone.UI.HasGlyph={GLYPH_SIZE:22,options:{glyph:null,glyphRight:null},insertGlyph:function(a,b){return this._insertGlyph(a,b,!1)},insertGlyphRight:function(a,b){return this._insertGlyph(a,b,!0)},_insertGlyph:function(a,b,c){var d=c?"has_glyph_right":"has_glyph";if(!b||!a)return $(a).removeClass(d),null;$(a).addClass(d);d="glyph "+b+(c?" right":"");var e;b.length===1?(b=$.el.span({className:d,style:"margin: 0 8px 0 0"},b),a.insertBefore(b,c?null:a.firstChild)):(e=new Image,$(e).hide(),
e.onload=function(){var a=Math.max(1,(28-e.height)/2),b=Math.max(3,(28-e.width)/2);$(e).css({top:a+"px",left:c?"auto":b+"px",right:c?b+"px":"auto",border:"none"});$(e).show()},e.src=b.match(/(http:\/\/)|(https:\/\/)/)?b:Backbone.UI.GLYPH_DIR+"/"+b+(b.indexOf(".")>0?"":".png"),e.className=d,a.insertBefore(e,c?null:a.firstChild));return e}}})();
(function(){Backbone.UI.HasModel={options:{model:null,content:null},_observeModel:function(a){_(this.model).exists()&&_(this.model.unbind).isFunction()&&_(["content","labelContent"]).each(function(b){b=this.options[b];_(b).exists()&&(b="change:"+b,this.model.unbind(b,a),this.model.bind(b,a))},this)}}})();
(function(){window.Backbone.UI.Link=Backbone.View.extend({options:{tagName:"a",disabled:!1,onClick:null},initialize:function(){this.mixin([Backbone.UI.HasModel,Backbone.UI.HasGlyph]);_(this).bindAll("render");$(this.el).addClass("link");$(this.el).bind("click",_(function(a){if(!this.options.disabled&&this.options.onClick)this.options.onClick(a);return!1}).bind(this))},render:function(){var a=this.resolveContent();this._observeModel(this.render);$(this.el).empty();$.el.span({className:"label"},a).appendTo(this.el);
this.insertGlyph(this.el,this.options.glyph);this.insertGlyphRight(this.el,this.options.glyphRight);this.setEnabled(!this.options.disabled);return this},setEnabled:function(a){a?this.el.href="#":this.el.removeAttribute("href");this.options.disabled=!a;$(this.el)[a?"removeClass":"addClass"]("disabled")}})})();
(function(){window.Backbone.UI.List=Backbone.UI.CollectionView.extend({options:{itemView:null},initialize:function(){Backbone.UI.CollectionView.prototype.initialize.call(this,arguments);$(this.el).addClass("list")},render:function(){$(this.el).empty();this.itemViews={};this.collectionEl=$.el.ul();!_(this.model).exists()||this.model.length===0?(this._emptyContent=_(this.options.emptyContent).isFunction()?this.options.emptyContent():this.options.emptyContent,(this._emptyContent=$.el.li(this._emptyContent))&&
this.collectionEl.appendChild(this._emptyContent)):_(this.model.models).each(function(a,b){this.collectionEl.appendChild(this._renderItem(a,b))},this);_(this.options.maxHeight).exists()?this.el.appendChild((new Backbone.UI.Scroller({content:$.el.div({style:"max-height:"+this.options.maxHeight+"px"},this.collectionEl)})).render().el):this.el.appendChild(this.collectionEl);this._updateClassNames();return this},_renderItem:function(a){var b;if(_(this.options.itemView).exists())_(this.options.itemView).isString()?
b=this.resolveContent(a,this.options.itemView):(b=new this.options.itemView({model:a}),b.render(),this.itemViews[a.cid]=b,b=b.el);b=$.el.li(b);this.options.onItemClick&&$(b).click(_(this.options.onItemClick).bind(this,a));return b}})})();
(function(){window.Backbone.UI.Menu=Backbone.View.extend({options:{emptyItem:null},initialize:function(){this.mixin([Backbone.UI.HasModel,Backbone.UI.HasAlternativeProperty]);_(this).bindAll("render");$(this.el).addClass("menu");this._textField=(new Backbone.UI.TextField).render()},scroller:null,render:function(){$(this.el).empty();this._observeModel(this.render);this._observeCollection(this.render);var a=$.el.ul();this.options.emptyItem&&this._addItemToMenu(a,this.options.emptyItem);var b=this._determineSelectedItem();
_(this._collectionArray()).each(function(c){var d=this._valueForItem(b),e=this._valueForItem(c);this._addItemToMenu(a,c,_(d).isEqual(e))},this);this.scroller=(new Backbone.UI.Scroller({content:a})).render();$(this.scroller.el).bind("mousewheel",function(){return!1});$(this.scroller.el).addClass("menu_scroller");this.el.appendChild(this.scroller.el);this._menuWidth=$(this.scroller.el).width()+20;return this},scrollToSelectedItem:function(){this._selectedAnchor&&this.scroller.setScrollPosition($(this._selectedAnchor.parentNode).position().top-
10)},_addItemToMenu:function(a,b,c){var d=$.el.a({href:"#"},$.el.span(this._labelForItem(b)||"\u00a0")),e;this.options.altGlyph&&(e=this.resolveContent(b,this.options.altGlyph),Backbone.UI.HasGlyph.insertGlyph(d,e));this.options.altGlyphRight&&(e=_(b).resolveProperty(this.options.altGlyphRight),Backbone.UI.HasGlyph.insertGlyphRight(d,e));e=$.el.li(d);var h=_.bind(function(a,c){this._selectedAnchor&&$(this._selectedAnchor).removeClass("selected");this._setSelectedItem(_(b).isEqual(this.options.emptyItem)?
null:b,c);this._selectedAnchor=d;$(d).addClass("selected");if(_(this.options.onChange).isFunction())this.options.onChange(b);return!1},this);$(d).click(h);c&&h(null,!0);a.appendChild(e)},_labelForItem:function(a){return!_(a).exists()?this.options.placeholder:_(a).resolveProperty(this.options.altLabelContent)}})})();
(function(){window.Backbone.UI.Pulldown=Backbone.View.extend({options:{placeholder:"Select...",alignRight:!1,onChange:Backbone.UI.noop,onMenuShow:Backbone.UI.noop,onMenuHide:Backbone.UI.noop,emptyItem:null},initialize:function(){this.mixin([Backbone.UI.HasGlyph]);$(this.el).addClass("pulldown");var a=this.options.onChange;delete this.options.onChange;var b=_(this.options).extend({onChange:_(function(b){this._onItemSelected(b);_(a).isFunction()&&a(b)}).bind(this)});this._menu=(new Backbone.UI.Menu(b)).render();
$(this._menu.el).autohide({ignoreKeys:[Backbone.UI.KEYS.KEY_UP,Backbone.UI.KEYS.KEY_DOWN],ignoreInputs:!1,hideCallback:_.bind(this._onAutoHide,this)});$(this._menu.el).hide();document.body.appendChild(this._menu.el);_(this.model).exists()&&_(this.model.bind).isFunction()&&(this.model.unbind("change",_(this.render).bind(this)),_(this.options.content).exists()&&this.model.bind("change:"+this.options.content,_(this.render).bind(this)));_(this.options.alternatives).exists()&&_(this.options.alternatives.bind).isFunction()&&
(this.options.alternatives.unbind("all",_(this.render).bind(this)),this.options.alternatives.bind("all",_(this.render).bind(this)))},button:null,render:function(){$(this.el).empty();var a=this._menu.selectedItem;this.button=(new Backbone.UI.Button({className:"pulldown_button",model:{label:this._labelForItem(a)},content:"label",glyph:_(a).resolveProperty(this.options.altGlyph),glyphRight:"\u25bc",onClick:_.bind(this.showMenu,this)})).render();this.el.appendChild(this.button.el);return this},setEnabled:function(a){this.button&&
this.button.setEnabled(a)},_labelForItem:function(a){return!_(a).exists()?this.options.placeholder:_(a).resolveProperty(this.options.altLabelContent)},setSelectedItem:function(a){this._setSelectedItem(a);this.button.options.label=this._labelForItem(a);this.button.options.glyph=_(a).resolveProperty(this.options.altGlyph);this.button.render()},hideMenu:function(a){$(this._menu.el).hide();if(this.options.onMenuHide)this.options.onMenuHide(a)},showMenu:function(a){var b=this.button.el,c=(this.options.alignRight?
"-right":"-left")+($(window).height()-($(b).offset().top-document.body.scrollTop)<150?"top":" bottom");$(this._menu.el).alignTo(b,c,0,1);$(this._menu.el).show();$(this._menu.el).css({width:Math.max($(this.button.el).innerWidth(),this._menuWidth)});if(this.options.onMenuShow)this.options.onMenuShow(a);this._menu.scrollToSelectedItem()},_onItemSelected:function(a){if(this.button)$(this.el).removeClass("placeholder"),this.button.model={label:this._labelForItem(a)},this.button.options.glyph=_(a).resolveProperty(this.options.altGlyph),
this.button.render(),this.hideMenu()},_onAutoHide:function(){if(this.options.onMenuHide)this.options.onMenuHide();return!0}})})();
(function(){window.Backbone.UI.RadioGroup=Backbone.View.extend({options:{onChange:Backbone.UI.noop},initialize:function(){this.mixin([Backbone.UI.HasGlyph,Backbone.UI.HasModel,Backbone.UI.HasAlternativeProperty]);_(this).bindAll("render");$(this.el).addClass("radio_group")},selectedItem:null,render:function(){$(this.el).empty();this._observeModel(this.render);this._observeCollection(this.render);this.selectedItem=this._determineSelectedItem();var a=$.el.ul(),b=this._valueForItem(this.selectedItem);
_(this._collectionArray()).each(function(c){var d=b===this._valueForItem(c),e=this.resolveContent(c,this.options.altLabelContent);d=$.el.li($.el.a({className:"choice"+(d?" selected":"")},$.el.div({className:"mark"+(d?" selected":"")},d?"\u25cf":""),$.el.div({className:"label"},e)));a.appendChild(d);$(d).bind("click",_.bind(this._onChange,this,c))},this);this.el.appendChild(a);return this},_onChange:function(a){this._setSelectedItem(a);this.render();if(_(this.options.onChange).isFunction())this.options.onChange(a);
return!1}})})();
(function(){window.Backbone.UI.Scroller=Backbone.View.extend({options:{className:"scroller",content:null,scrollAmount:5,onScroll:null},initialize:function(){Backbone.UI.DragSession.enableBasicDragSupport();setInterval(_(this.update).bind(this),40)},render:function(){$(this.el).empty();$(this.el).addClass("scroller");this._scrollContent=this.options.content;$(this._scrollContent).addClass("content");this._knob=$.el.div({className:"knob"},$.el.div({className:"knob_top"}),$.el.div({className:"knob_middle"}),$.el.div({className:"knob_bottom"}));
this._tray=$.el.div({className:"tray"});this._tray.appendChild(this._knob);this._scrollContentWrapper=$.el.div({className:"content_wrapper"});this._scrollContentWrapper.appendChild(this._scrollContent);this.el.appendChild(this._tray);this.el.appendChild(this._scrollContentWrapper);this.el.tabIndex=-1;$(this._knob).bind("mousedown",_.bind(this._onKnobMouseDown,this));$(this._tray).bind("click",_.bind(this._onTrayClick,this));$(this.el).bind("mousewheel",_.bind(this._onMouseWheel,this));$(this.el).bind($.browser.msie?
"keyup":"keypress",_.bind(this._onKeyPress,this));$(this.el).addClass("disabled");return this},scrollRatio:function(){return this.scrollPosition()/(this._totalHeight-this._visibleHeight)},setScrollRatio:function(a){var b=this._totalHeight-this._visibleHeight;a=Math.max(0,Math.min(b>0?1:0,a));this._scrollContent.scrollTop=Math.round(a*b);if(this.options.onScroll)this.options.onScroll();setTimeout(_.bind(this._updateKnobPosition,this),10);this._updateKnobPosition()},scrollBy:function(a){this.setScrollPosition(this.scrollPosition()+
a)},scrollPosition:function(){return this._scrollContent.scrollTop},setScrollPosition:function(a){this.update();var b=this._totalHeight-this._visibleHeight;this.setScrollRatio(b?a/b:0);this.update()},scrollToEnd:function(){this.setScrollRatio(1)},update:function(){var a=this._scrollContent.offsetHeight,b=this._scrollContent.scrollHeight;this.maxY=$(this._tray).height()-$(this._knob).height();if(this._visibleHeight!==a||this._totalHeight!==b)if(this._disabled=b<=a+2,$(this.el).toggleClass("disabled",
this._disabled),this._visibleHeight=a,this._totalHeight=b,this._totalHeight>=this._visibleHeight)this._updateKnobSize(),this.minY=0;this._updateKnobPosition();this._updateKnobSize()},_updateKnobPosition:function(){var a=this.minY+(this.maxY-this.minY)*this.scrollRatio();if(!isNaN(a))this._knob.style.top=a+"px"},_updateKnobSize:function(){var a=$(this._tray).height()*(this._visibleHeight/this._totalHeight);a=a>20?a:20;$(this._knob).css({height:a+"px"})},_knobRatio:function(a){a=a||this._knob.offsetTop;
a=Math.max(this.minY,Math.min(this.maxY,a));return(a-this.minY)/(this.maxY-this.minY)},_onTrayClick:function(a){a=a||event;if(a.target===this._tray){var b=a.layerY||a.y;b||(b=a.originalEvent.layerY||a.originalEvent.y);b-=this._knob.offsetHeight/2;this.setScrollRatio(this._knobRatio(b))}a.stopPropagation()},_onKnobMouseDown:function(a){this.el.focus();new Backbone.UI.DragSession({dragEvent:a,scope:this.el.ownerDocument,onStart:_.bind(function(a){a.pos=this._knob.offsetTop;a.scroller=this;$(this.el).addClass("dragging")},
this),onMove:_.bind(function(a){this.setScrollRatio(this._knobRatio(a.pos+a.dy))},this),onStop:_.bind(function(){$(this.el).removeClass("dragging")},this)});a.stopPropagation()},_onMouseWheel:function(a,b){if(!this._disabled){var c=this.options.scrollAmount;this.setScrollPosition(this.scrollPosition()-b*c);a.preventDefault();return!1}},_onKeyPress:function(a){switch(a.keyCode){case Backbone.UI.KEYS.KEY_DOWN:this.scrollBy(this.options.scrollAmount);break;case Backbone.UI.KEYS.KEY_UP:this.scrollBy(-this.options.scrollAmount);
break;case Backbone.UI.KEYS.KEY_PAGEDOWN:this.scrollBy(this.options.scrollAmount);break;case Backbone.UI.KEYS.KEY_PAGEUP:this.scrollBy(-this.options.scrollAmount);break;case Backbone.UI.KEYS.KEY_HOME:this.setScrollRatio(0);break;case Backbone.UI.KEYS.KEY_END:this.setScrollRatio(1);break;default:return}a.stopPropagation();a.preventDefault()}})})();
(function(){Backbone.UI.TabSet=Backbone.View.extend({options:{tabs:[]},initialize:function(){$.extend(!0,this,Backbone.UI.HasGlyph);$(this.el).addClass("tab_set")},render:function(){$(this.el).empty();this._tabs=[];this._contents=[];this._callbacks=[];this._tabBar=$.el.div({className:"tab_bar"});this._contentContainer=$.el.div({className:"content_container"});this.el.appendChild(this._tabBar);this.el.appendChild(this._contentContainer);for(var a=0;a<this.options.tabs.length;a++)this.addTab(this.options.tabs[a]);
this.activateTab(0);return this},addTab:function(a){var b=$.el.a({href:"#",className:"tab"});a.glyphRight&&this.insertGlyph(b,a.glyphRight);a.className&&$(b).addClass(a.className);b.appendChild(document.createTextNode(a.label||""));a.glyph&&this.insertGlyph(b,a.glyph);this._tabBar.appendChild(b);this._tabs.push(b);var c=a.content&&a.content.nodeType?a.content:$.el.div(a.content);this._contents.push(c);$(c).hide();this._contentContainer.appendChild(c);var d=this._tabs.length-1;$(b).bind("click",_.bind(function(){this.activateTab(d);
return!1},this));this._callbacks.push(a.onActivate||Backbone.UI.noop)},activateTab:function(a){_(this._contents).each(function(a){$(a).hide()});_(this._tabs).each(function(a){$(a).removeClass("selected")});_(this._selectedIndex).exists()&&$(this.el).removeClass("index_"+this._selectedIndex);$(this.el).addClass("index_"+a);this._selectedIndex=a;$(this._tabs[a]).addClass("selected");$(this._contents[a]).show();this._callbacks[a]()}})})();
(function(){window.Backbone.UI.TableView=Backbone.UI.CollectionView.extend({options:{columns:[],emptyContent:"no entries",onItemClick:Backbone.UI.noop,sortable:!1,onSort:null},initialize:function(){Backbone.UI.CollectionView.prototype.initialize.call(this,arguments);$(this.el).addClass("table_view");this._sortState={reverse:!0}},render:function(){$(this.el).empty();this.itemViews={};var a=$.el.div({className:"content"},this.collectionEl=$.el.table({cellPadding:"0",cellSpacing:"0"}));$(this.el).toggleClass("clickable",
this.options.onItemClick!==Backbone.UI.noop);var b=$.el.tr(),c=!1,d=null;_(this.options.columns).each(_(function(a,e,j){this.options.sortable&&!this._sortState.content&&(c=!0);var i=_(a.title).isFunction()?a.title():a.title,g=a.width?parseInt(a.width,10)+5:null;g=g?"width:"+g+"px; max-width:"+g+"px; ":"";g+=this.options.sortable?"cursor: pointer; ":"";a.comparator=_(a.comparator).isFunction()?a.comparator:function(b,c){return b.get(a.content)<c.get(a.content)?-1:b.get(a.content)>c.get(a.content)?
1:0};var k=c&&d===null,p=this._sortState.content===a.content||k;k=$.el.div({className:"glyph"},p?this._sortState.reverse&&!k?"\u25b2 ":"\u25bc ":"");var m=this.options.sortable?_(this.options.onSort).isFunction()?_(function(){this.options.onSort(a)}).bind(this):_(function(b,c){this._sort(a,c)}).bind(this):Backbone.UI.noop;e=$.el.th({className:_(j).nameForIndex(e),style:g,onclick:m},k,$.el.div({className:"wrapper"+(p?" sorted":"")},i)).appendTo(b);d===null&&(d=e)}).bind(this));if(c&&d)d.onclick(null,
!0);this.el.appendChild($.el.table({className:"heading",cellPadding:"0",cellSpacing:"0"},$.el.thead(b)));var e=$.el.tbody();this.collectionEl.appendChild(e);!_(this.model).exists()||this.model.length===0?(this._emptyContent=_(this.options.emptyContent).isFunction()?this.options.emptyContent():this.options.emptyContent,(this._emptyContent=$.el.tr($.el.td(this._emptyContent)))&&e.appendChild(this._emptyContent)):_(this.model.models).each(function(a,b){var c=this._renderItem(a,b);e.appendChild(c)},this);
_(this.options.maxHeight).exists()?this.el.appendChild((new Backbone.UI.Scroller({content:$.el.div({style:"max-height:"+this.options.maxHeight+"px"},a)})).render().el):this.el.appendChild(a);this._updateClassNames();return this},_renderItem:function(a){var b=$.el.tr();_(this.options.columns).each(function(c,d,e){var h=c.width?parseInt(c.width,10)+5:null;h=h?"width:"+h+"px; max-width:"+h+"px":null;c=this.resolveContent(a,c.content);b.appendChild($.el.td({className:_(e).nameForIndex(d),style:h},$.el.div({className:"wrapper",
style:h},c)))},this);this.options.onItemClick&&$(b).click(_(this.options.onItemClick).bind(this,a));return this.itemViews[a.cid]=b},_sort:function(a,b){this._sortState.reverse=!this._sortState.reverse;this._sortState.content=a.content;var c=a.comparator;this._sortState.reverse&&(c=function(b,c){return-a.comparator(b,c)});this.model.comparator=c;this.model.sort({silent:!!b})}})})();
(function(){window.Backbone.UI.TextArea=Backbone.View.extend({options:{className:"text_area",textAreaId:null,disabled:!1,enableScrolling:!0,tabIndex:null},textArea:null,initialize:function(){this.mixin([Backbone.UI.HasGlyph,Backbone.UI.HasModel]);$(this.el).addClass("text_area")},render:function(){var a=(this.textArea&&this.textArea.value.length)>0?this.textArea.value:this.resolveContent();$(this.el).empty();a=this.textArea=$.el.textarea({id:this.options.textAreaId,tabIndex:this.options.tabIndex,
placeholder:this.options.placeholder},a);if(this.options.enableScrolling)this._scroller=(new Backbone.UI.Scroller({content:this.textArea})).render(),a=this._scroller.el;this.insertGlyphRight(this.el,this.options.glyphRight);this.el.appendChild(a);this.insertGlyph(this.el,this.options.glyph);this.setEnabled(!this.options.disabled);$(this.textArea).keyup(_.bind(function(){_.defer(_(this._updateModel).bind(this))},this));return this},getValue:function(){return this.textArea.value},setValue:function(a){$(this.textArea).empty();
this.textArea.value=a;this._updateModel()},setEnabled:function(a){a?$(this.el).removeClass("disabled"):$(this.el).addClass("disabled");this.textArea.disabled=!a},_updateModel:function(){_(this.model).setProperty(this.options.content,this.textArea.value)}})})();
(function(){window.Backbone.UI.TextField=Backbone.View.extend({options:{disabled:!1,type:"text",name:null,tabIndex:null,onKeyPress:Backbone.UI.noop,maxLength:null},input:null,initialize:function(){this.mixin([Backbone.UI.HasGlyph,Backbone.UI.HasModel]);_(this).bindAll("_refreshValue");$(this.el).addClass("text_field");this.input=$.el.input({maxLength:this.options.maxLength});$(this.input).keyup(_.bind(function(a){_.defer(_(this._updateModel).bind(this));if(_(this.options.onKeyPress).exists()&&_(this.options.onKeyPress).isFunction())this.options.onKeyPress(a,
this)},this));this._observeModel(this._refreshValue)},render:function(){var a=(this.input&&this.input.value.length)>0?this.input.value:this.resolveContent();$(this.el).empty();$(this.input).attr({type:this.options.type?this.options.type:"text",name:this.options.name,id:this.options.name,tabIndex:this.options.tabIndex,placeholder:this.options.placeholder,value:a});this.insertGlyphRight(this.el,this.options.glyphRight);this.el.appendChild($.el.div({className:"input_wrapper"},this.input));this.insertGlyph(this.el,
this.options.glyph);this.setEnabled(!this.options.disabled);return this},getValue:function(){return this.input.value},setValue:function(a){this.input.value=a;this._updateModel()},setEnabled:function(a){a?$(this.el).removeClass("disabled"):$(this.el).addClass("disabled");this.input.disabled=!a},_updateModel:function(){_(this.model).setProperty(this.options.content,this.input.value)},_refreshValue:function(){var a=this.resolveContent();if(this.input&&this.input.value!==a)this.input.value=_(a).exists()?
a:null}})})();
(function(){window.Backbone.UI.TimePicker=Backbone.View.extend({options:{format:"hh:mm a",interval:30,name:null},initialize:function(){$(this.el).addClass("time_picker");this._timeModel={};this._menu=new Backbone.UI.Menu({model:this._timeModel,altLabelContent:"label",altValueContent:"label",content:"value",onChange:_(this._onSelectTimeItem).bind(this)});$(this._menu.el).hide();$(this._menu.el).autohide({ignoreInputs:!0});document.body.appendChild(this._menu.el);this.model&&this.options.content&&this.model.bind("change:"+
this.options.content,_(this.render).bind(this))},render:function(){$(this.el).empty();this._textField=(new Backbone.UI.TextField({name:this.options.name})).render();$(this._textField.input).click(_(this._showMenu).bind(this));$(this._textField.input).keyup(_(this._timeEdited).bind(this));this.el.appendChild(this._textField.el);var a=this.resolveContent();if(a){var b=moment(a).format(this.options.format);this._textField.setValue(b);this._timeModel.value=b;this._selectedTime=a}this._menu.options.alternatives=
this._collectTimes();this._menu.options.model=this._timeModel;this._menu.render();return this},getValue:function(){return this._selectedTime},setValue:function(a){this._selectedTime=a;this._textField.setValue(moment(a).format(this.options.format));this._timeEdited();this._menu.options.selectedValue=a;this._menu.render()},setEnabled:function(a){this._textField.setEnabled(a)},_collectTimes:function(){for(var a=[],b=moment().sod(),c=b.date();b.date()===c;)a.push({label:b.format(this.options.format),
value:new Date(b)}),b.add("minutes",this.options.interval);return a},_showMenu:function(){$(this._menu.el).alignTo(this._textField.el,"bottom -left",0,2);$(this._menu.el).show();this._menu.scrollToSelectedItem()},_hideMenu:function(){$(this._menu.el).hide()},_onSelectTimeItem:function(a){this._hideMenu();this._selectedTime=a.value;this._textField.setValue(moment(this._selectedTime).format(this.options.format));this._timeEdited()},_timeEdited:function(a){var b=moment(this._textField.getValue(),this.options.format);
if(!a||a.keyCode===Backbone.UI.KEYS.KEY_RETURN){a=moment(b).format(this.options.format);this._textField.setValue(a);this._hideMenu();if(this.model&&this.options.content){var c=this.resolveContent();c=new Date(c);c.setHours(b.hours());c.setMinutes(b.minutes());_(this.model).setProperty(this.options.content,c)}if(_(this.options.onChange).isFunction())this.options.onChange(a)}}})})();
