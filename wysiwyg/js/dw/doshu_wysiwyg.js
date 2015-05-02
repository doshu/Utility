$(function() {

	
	$.fn.doshuwysiwyg = function(options) {
		
		var settings = $.extend({
      		locale:'ita',
      		page:"javascript:void(function() { document.open(); document.write('<html><head></head><body></body></html>'); document.close();}())",
      		onSave:null
    	}, options);
    	
		var locale = $.fn.doshuwysiwyg.locale[settings.locale];
		
		var template = '<div class="dw_wrap">\
			<div class="dw_toolbar_wrap">\
				<div class="dw_toolbar_line">\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_source_code" data-toggle="button">'+locale.codice_sorgente+'</button>\
						<button class="btn btn-small dw_save"><i class="icon icon-save"></i></button>\
						<button class="btn btn-small dw_preview"><i class="icon icon-eye-open"></i></button>\
						<button class="btn btn-small dw_print"><i class="icon icon-print"></i></button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_cut disabled"><i class="icon icon-cut"></i></button>\
						<button class="btn btn-small dw_copy disabled"><i class="icon icon-copy"></i></button>\
						<button class="btn btn-small dw_paste"><i class="icon icon-paste"></i></button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_undo disabled"><i class="icon icon-undo"></i></button>\
						<button class="btn btn-small dw_repeat disabled"><i class="icon icon-repeat"></i></button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_search"><i class="icon icon-search"></i></button>\
						<button class="btn btn-small dw_replace"><i class="icon icon-random"></i></button>\
					</span>\
				</div>\
				<div class="dw_toolbar_line">\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_bold"><i class="icon icon-bold"></i></button>\
						<button class="btn btn-small dw_italic"><i class="icon icon-italic"></i></button>\
						<button class="btn btn-small dw_underline"><i class="icon icon-underline"></i></button>\
						<button class="btn btn-small dw_strikethrough"><i class="icon icon-strikethrough"></i></button>\
						<button class="btn btn-small dw_sup">\
							<i>X<span style="position:relative; top:-4px;">2</span></i>\
						</button>\
						<button class="btn btn-small dw_sub">\
							<i>X<span style="position:relative; top:4px;">2</span></i>\
						</button>\
						<button class="btn btn-small dw_unformat disabled"><i class="icon icon-remove-sign"></i></button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_ol"><i class="icon icon-list-ol"></i></button>\
						<button class="btn btn-small dw_ul"><i class="icon icon-list-ul"></i></button>\
						<button class="btn btn-small dw_indent_right"><i class="icon icon-indent-right"></i></button>\
						<button class="btn btn-small dw_indent_left"><i class="icon icon-indent-left"></i></button>\
						<button class="btn btn-small dw_cite"><i class="icon icon-quote-right"></i></button>\
						<button class="btn btn-small dw_div">\
							<i>&lt;DIV&gt;</i>\
						</button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_align_left"><i class="icon icon-align-left"></i></button>\
						<button class="btn btn-small dw_align_center"><i class="icon icon-align-center"></i></button>\
						<button class="btn btn-small dw_align_right"><i class="icon icon-align-right"></i></button>\
						<button class="btn btn-small dw_align_justify"><i class="icon icon-align-justify"></i></button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_text_right"><i class="icon icon-arrow-right"></i></button>\
						<button class="btn btn-small dw_text_left"><i class="icon icon-arrow-left"></i></button>\
					</span>\
				</div>\
				<div class="dw_toolbar_line">\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_link"><i class="icon icon-link"></i></button>\
						<button class="btn btn-small dw_nolink disabled"><i class="icon icon-link"></i><i class="icon icon-remove"></i></button>\
						<button class="btn btn-small dw_anchor"><i class="icon icon-flag"></i></button>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_img"><i class="icon icon-picture"></i></button>\
						<button class="btn btn-small dw_table"><i class="icon icon-table"></i></i></button>\
						<button class="btn btn-small dw_hr"><i class="icon icon-minus"></i></button>\
						<button class="btn btn-small dw_symbol"><i class="icon icon-asterisk"></i></button>\
						<button class="btn btn-small dw_iframe"><i class="icon icon-globe"></i></button>\
					</span>\
				</div>\
				<div class="dw_toolbar_line">\
				    <div class="btn-group dw_select">\
						<button class="btn dropdown-toggle dw_format" data-toggle="dropdown">\
							<span class="dw_select_caption">'+locale.formato+'</span>\
							<span class="caret"></span>\
						</button>\
						<ul class="dropdown-menu text-format">\
							<li><a href="">'+locale.normale+'</a></li>\
							<li><a href=""><h1>'+locale.titolo+' 1</h1></a></li>\
							<li><a href=""><h2>'+locale.titolo+' 2</h2></a></li>\
							<li><a href=""><h3>'+locale.titolo+' 3</h3></a></li>\
							<li><a href=""><h4>'+locale.titolo+' 4</h4></a></li>\
							<li><a href=""><h5>'+locale.titolo+' 5</h5></a></li>\
							<li><a href=""><h6>'+locale.titolo+' 6</h6></a></li>\
						</ul>\
					</div>\
					<div class="btn-group dw_select">\
						<button class="btn dropdown-toggle dw_font_family" data-toggle="dropdown">\
							<span class="dw_select_caption">'+locale.carattere+'</span>\
							<span class="caret"></span>\
						</button>\
						<ul class="dropdown-menu text-font">\
							 <li><a href="" style="font-family:andale mono">Andale Mono</a></li>\
							 <li><a href="" style="font-family:arial">Arial</a></li>\
							 <li><a href="" style="font-family:comic sans ms">Comic Sans MS</a></li>\
							 <li><a href="" style="font-family:courier new">Courier New</a></li>\
							 <li><a href="" style="font-family:georgia">Georgia</a></li>\
							 <li><a href="" style="font-family:impact">Impact</a></li>\
							 <li><a href="" style="font-family:times new roman">Times New Roman</a></li>\
							 <li><a href="" style="font-family:trebuchet ms">Trebuchet MS</a></li>\
							 <li><a href="" style="font-family:verdana">Verdana</a></li>\
						</ul>\
					</div>\
					<div class="btn-group dw_select">\
						<button class="btn dropdown-toggle dw_font_size" data-toggle="dropdown">\
							<span class="dw_select_caption">'+locale.dimensione+'</span>\
							<span class="caret"></span>\
						</button>\
						<div class="dropdown-menu text-size">\
							 <div class="input-append">\
								<input class="span2" type="number">\
								<span class="add-on">px</span>\
							</div>\
						</div>\
					</div>\
					<span class="btn-group dw_toolbar">\
						<button class="btn dropdown-toggle btn-small dw_color" data-toggle="dropdown">\
							<i class="icon icon-font"></i>\
						</button>\
						<ul class="dropdown-menu">\
						</ul>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn dropdown-toggle btn-small dw_background_color" data-toggle="dropdown">\
							<i class="icon icon-font icon-backgroundcolor"></i>\
						</button>\
						<ul class="dropdown-menu">\
						</ul>\
					</span>\
					<span class="btn-group dw_toolbar">\
						<button class="btn btn-small dw_fullscreen"><i class="icon icon-fullscreen"></i></button>\
					</span>\
				</div>\
				<div class="dw_toolbar_line dw_alert_container"></div>\
				<div class="dw_toolbar_line dw_form_container"></div>\
			</div>\
			<div class="dw_html_container">\
				<iframe class="dw_html" src="'+settings.page+'"></iframe>\
			</div>\
		</div>';
		
		var templateStyle = "<style>\
				html {\
					background-color:#FFF;\
					margin:0;\
					padding:0;\
					font-size:13px;\
				}\
				\
				body {\
					margin:0;\
					padding:8px;\
					font-family:arial;\
				}\
				\
				body.dw_show_source_code {\
					padding:0;\
				}\
				\
				.dw_show_source_code_container, .dw_show_source_code_container:focus {\
					width: 100%;\
					height: 99%;\
					border:0;\
					resize: none;\
					padding:8px;\
					outline:none;\
				}\
				\
				body.dw_show_source_code {\
					font-family:monospace;\
				}\
			</style>\
		";
		
		var alertTemplate = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button></div>';
		
		/* FUNCTIONS */
		
		function saveSettings(el) {
			el = el.get(0);
			if(!el.doshuwysiwyg)
				el.doshuwysiwyg = {};
			el.doshuwysiwyg.settings = settings;
		}
		
		function getSettings(el) {
			return $(el).parents('.dw_wrap').find('.dw_hidden_main').get(0).doshuwysiwyg.settings;
		}
		
		function getTemplate(el) {
			return $(el).parents('.dw_wrap');
		}
		
		function getVal(el) {
			return $(el).parents('.dw_wrap').find('.dw_hidden_main').val();
		}
		
		function updateFrom(iframeBody, main) {
			$(main).val($(iframeBody).text());
		}
		
		function getIframe(el) {
			return $(el).parents('.dw_wrap').find('iframe.dw_html');
		}
		
		function getIframeWindow(el) {
			
			return (el.ownerDocument.defaultView) ?
			  el.ownerDocument.defaultView : 
			  el.ownerDocument.parentWindow;
		}
		
		function getIframeDocument(el) {
			var iframe = getIframe(el).get(0);
			if(iframe.contentDocument)
				return iframe.contentDocument;
			if(iframe.contentWindow.document)
				return iframe.contentWindow.document;
			
			return null;
		}
		
		function buttonState(button, enabled) {
			if(enabled) {
				$(button).removeClass('disabled');
			}
			else {
				$(button).addClass('disabled');
			}
		}
		
		function getElementDocument(el) {
			el = el.get(0);
			if(el.contentDocument)
				return el.contentDocument;
			if(el.contentWindow.document)
				return el.contentWindow.document;
			return null;
		}
		
		function getWindowFromDocument(d) {
			
			return (d.defaultView) ?
			  d.defaultView : 
			  d.parentWindow;
		}
		
		function getBodySelectionRaw(body) {
			var iframeWindow = getIframeWindow(body);
			if (iframeWindow.getSelection) {
				return iframeWindow.getSelection();
			} else if (body.ownerDocument.selection) {
				return body.ownerDocument.selection;
			}
			return '';	
		}
		
		function getBodySelection(body) {
			var iframeWindow = getIframeWindow(body);
			if (iframeWindow.getSelection) {
				return iframeWindow.getSelection().toString();
			} else if (body.ownerDocument.selection) {
				return body.ownerDocument.selection.createRange().text;
			}
			return '';	
		}
		
		function getWindowSelection(_window) {
			if (_window.getSelection) {
				return _window.getSelection();
			} else if (_window.document.selection) {
				return _window.document.selection;
			}
			return '';	
		}
		
		
		function selectNode (node) {
			
			var elemToSelect = node;
			var _document = node.ownerDocument;
			var _window = getWindowFromDocument(_document);
			
			if (_window.getSelection) {  
            	var selection = _window.getSelection();
            	var rangeToSelect = _document.createRange();
            	rangeToSelect.selectNodeContents(elemToSelect);
            	selection.removeAllRanges();
            	selection.addRange(rangeToSelect);
            }
    		else {       
    			
				if (_document.body.createTextRange) {    
			        var rangeToSelect = _document.body.createTextRange();
			        rangeToSelect.moveToElementText(elemToSelect);
			        rangeToSelect.select();
				}
				else if (_document.createRange && _window.getSelection) {         
					range = _document.createRange();             
					range.selectNodeContents(el);             
					sel = _window.getSelection();     
					sel.removeAllRanges();             
					sel.addRange(range);              
				}
			}  
		}
		
		function selectParentNodeIfEmpty(selection, type) {
			var length = 0;
			
			if(selection.createRange) {
				length = selection.createRange().text.length;
			}
			else {
				length = selection.toString().length;
			}
			
			if(!length) {	
				var node = getSelectionAnchor(selection);
				
				if(selection.anchorOffset && selection.anchorOffset < node.length) {
					if($(node).is(type)) {
						selectNode(node);
					}
					else {
						var parents = $(node).parents(type);
						if(parents.length) {
							selectNode(parents.get(0));
						}
					}
				}
			}	
		}
		
		
		function getSelectionAnchor(selection) {
			//var range = selection.createRange();
			//range.expand('textedit');
			//alert(range.parentElement());
			return selection.anchorNode || selection.createRange().parentElement();
		}
		
		
		function pasteHtml(_document, html) {
			var selection = getBodySelectionRaw(_document.body);
			if(selection.createRange) {
				var range = selection.createRange().pasteHTML(html);
			}
			else {
				_document.execCommand('insertHTML', false, html);	
			}
		}
		
		function insertTextAt(range, val) {
			
			var textNode = document.createTextNode(val);
			if(document.createDocumentFragment) {
				var fragment = document.createDocumentFragment();
				fragment.appendChild(textNode);
				range.collapse(true);
				range.deleteContents();
				range.insertNode(fragment);
				range = range.cloneRange();
                range.setStartAfter(textNode);
                range.collapse(true);
                return range;
			}
		}
		
		function dwAlert(msg, caller) {
			var alert = $(alertTemplate); 
			alert.append(msg);
			getTemplate(caller).find('.dw_alert_container').append(alert);
			setTimeout(function() {
				alert.fadeOut();
			},4000);
		}
		
		function checkIframeOnLoad(iframe) {
			if(getIframeDocument(iframe).readyState == "complete")
				$(iframe).trigger('dw.load');
			else
				setTimeout(function() {
					checkIframeOnLoad(iframe)
				}, 1);
		}
		
		function nodeIs(node, type) {
			return $(node).is(type) || $(node).parents(type).length;
		}
		
		function setContentEditable(frameBody, status) {
			
			if(typeof frameBody.ownerDocument.designMode != 'undefined') {
				frameBody.ownerDocument.designMode = status?"on":"off";
			}
			else {
				if(typeof frameBody.contentEditable != 'undefined'){
					$(frameBody).attr('contenteditable', status);
				}
			}
		}
		
		function createTemplate(el) {
		
			var wysiwyg = $(template);
			el.hide();
			el.addClass('dw_hidden_main');
			saveSettings(el, settings);
			wysiwyg.insertBefore(el);
			wysiwyg.find('.dw_html_container').append(el);
			var iframe  = getIframe(el);
			
			/*
				onload sugli iframe non funzia per chrome
				
			*/
			$(iframe).on('dw.load', function() {
				
				$(this).contents().find('head').append($(templateStyle));
				var iframeBody = $(this).contents().find('body')[0];
				setContentEditable(iframeBody, 1);
				iframeBody.ownerDocument.execCommand('styleWithCSS', false, false);
				
				bindAll($(this));
			});
			
			checkIframeOnLoad(iframe);
			
		}
		
		function bindAll(iframe) {
			var iframeBody = iframe.contents().find('body');
			iframeBody.on('paste', update); //se fatto col tasto destro non va
			iframeBody.on('keyup', update);
			iframeBody.on('keyup', onSelection);
			iframeBody.on('DOMSubtreeModified', onBodyChange);
			iframeBody.on('mouseup', onSelection);
			var template = getTemplate(iframe);
			
			template.find('button.dw_source_code').on('click', onSourceCode);
			template.find('button.dw_save').on('click', onSave);
			template.find('button.dw_preview').on('click', onPreview);
			template.find('button.dw_print').on('click', onPrint);
			
			template.find('button.dw_cut').on('click', onCut);
			template.find('button.dw_copy').on('click', onCopy);
			template.find('button.dw_paste').on('click', onPaste);
			
			template.find('button.dw_undo').on('click', onUndo);
			template.find('button.dw_repeat').on('click', onRedo);
			
			template.find('button.dw_search').on('click', onSearch);
			template.find('button.dw_replace').on('click', onReplace);
			
			template.find('button.dw_bold').on('click', onBold);
			template.find('button.dw_italic').on('click', onItalic);
			template.find('button.dw_underline').on('click', onUnderline);
			template.find('button.dw_strikethrough').on('click', onStrikeThrough);
			template.find('button.dw_sub').on('click', onSub);
			template.find('button.dw_sup').on('click', onSup);
			template.find('button.dw_unformat').on('click', onUnformat);
			
			template.find('button.dw_ol').on('click', onOl);
			template.find('button.dw_ul').on('click', onUl);
			template.find('button.dw_indent_right').on('click', onIndentRight);
			template.find('button.dw_indent_left').on('click', onIndentLeft);
			template.find('button.dw_cite').on('click', onCite);
			
		}
		
		
		
		/* MAIN */
		
		var selectorsize = this.length;
		
		for(var i = 0; i < selectorsize; i++) {
			var element = $(this[i]);
			createTemplate(element);
		}
		
		/* EVENTS */
		
		function onSourceCode(e) {
			var iframeDocument = getIframeDocument($(this));
			var iframeBody = $(iframeDocument.body);
			var isSourceCode = false;
			
			if(iframeBody.hasClass('dw_show_source_code')) {
				var html = iframeBody.find('.dw_show_source_code_container').val();
				iframeBody.empty().html(html);
				iframeBody.removeClass('dw_show_source_code');
				setContentEditable(iframeBody[0], 1);
			}
			else {
				isSourceCode = true;
				var html = iframeBody.html();
				var textarea = $('<textarea class="dw_show_source_code_container"></textarea>');
				textarea.val(html);
				iframeBody.empty().append(textarea);
				iframeBody.addClass('dw_show_source_code');
				setContentEditable(iframeBody[0], 0);
				
			}
			
			var template = getTemplate($(this));
			buttonState(template.find('button.dw_bold, button.dw_italic, button.dw_underline, button.dw_strikethrough, button.dw_sub, button.dw_sup, button.dw_ol, button.dw_ul, button.dw_indent_right, button.dw_indent_left, button.dw_cite, button.dw_div, button.dw_align_left, button.dw_align_right, button.dw_align_center, button.dw_align_justify, button.dw_text_left, button.dw_text_right, button.dw_link, button.dw_nolink, button.dw_anchor, button.dw_img, button.dw_table, button.dw_hr, button.dw_symbol, button.dw_iframe, .dw_format, .dw_font_family, .dw_font_size, .dw_color, .dw_background_color'), !isSourceCode);
				
		}
		
		/*
		function onPaste(e) {
			if($(this).hasClass('dw_show_source_code')) {
				//var selection = getIframeWindow(this).getSelection().getRangeAt(0);
				var selection = getIframeWindow(this).getSelection();
				var range = selection.getRangeAt(0);
				var from  = range.startOffset;
				var to = range.endOffset;
				
				var current = $(this).text();
				var dw_paste = $('<span class="dw_paste_container"></span>');
				dw_paste.appendTo($(this));
				
				dw_paste.append('<!-_->');
				var newRange = this.ownerDocument.createRange();
				newRange.setStart(dw_paste[0].childNodes[0], 3);
				newRange.setEnd(dw_paste[0].childNodes[0], 4);
				selection.removeAllRanges();
				selection.addRange(newRange);
				return false;
				//$(this).empty();
				var that = this;
				setTimeout(function() { onPasteSecondStep(that, current, from, to); }, 1);			
			}
		}
		
		function onPasteSecondStep(body, last, from, to) {
			return false;
			var current = $(body).find('.dw_paste_container');
			var currentText = current.text().replace(/</g, '&lt;').replace(/>/g,'&gt;');
			
			currentText = currentText.substr(0, currentText.length-1);
			current.remove();
			//$(body).empty().text(last);
			var newRange = insertTextOffset(body, from, to, currentText);			
		}
		*/
		
		function onSave() {
			var opt = getSettings(this);
			if(typeof(opt.onSave) == "function") {
				opt.onSave(getVal(this));
			}
			else {
				$(this).parents('form').submit();
			}
		}
		
		function onPreview() {
			var val = getVal(this);
			var w = window.open('','',null, false);
			w.document.body.innerHTML = val;
		}
		
		function onPrint() {
			var iframeWindow = getWindowFromDocument(getIframeDocument(getIframe(this)));
			iframeWindow.print();
		}
		
		
		function update(e) {
			if($(this).hasClass('dw_show_source_code')) {
				$(getIframeWindow(this).frameElement).parents('.dw_wrap').find('.dw_hidden_main').val(
					$(this).find('.dw_show_source_code_container').val()
				);
			}
			else {
				$(getIframeWindow(this).frameElement).parents('.dw_wrap').find('.dw_hidden_main').val($(this).html());
			}
		}
		
		function onSelection(e, body) {
			var that = this;
			if(!body) {
				setTimeout(function() {
					onSelection(e, that);
				},1);
			}
			else {
				
				var wrap = $(getIframeWindow(body).frameElement).parents('.dw_wrap');
				
				//enable or disable button based on selection
				var list = [
					'button.dw_cut',
					'button.dw_copy',
					'button.dw_unformat'
				];
				
				var selection = getBodySelection(body);
				
				if(selection.length) {
					for(button in list) {
						buttonState(wrap.find(list[button]), true);
					}
				}
				else {
					for(button in list) {
						buttonState(wrap.find(list[button]), false);
					}
				}
				
				//check for selection style
				body.focus();
				var rawSel = getBodySelectionRaw(body);
				var node = getSelectionAnchor(rawSel);
				
				var map = {
					'button.dw_bold':['b', 'strong'],
					'button.dw_italic':['i','em'],
					'button.dw_underline':['u'],
					'button.dw_strikethrough':['strike'],
					'button.dw_sub':['sub'],
					'button.dw_sup':['sup'],
					'button.dw_ol':['ol'],
					'button.dw_ul':['ul'],
					'button.dw_cite':['cite']
				};
				
				for(button in map) {
					var is = false;
					for(tag in map[button]) {	
						if(nodeIs(node, map[button][tag])) {
							wrap.find(button).addClass('active');
							break
						}
						else {
							wrap.find(button).removeClass('active');
						}	
					}
				}
				
				/*
				if(nodeIs(node, 'b') || nodeIs(node, 'strong')) {
					
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_bold').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_bold').removeClass('active');
				
				
				if(nodeIs(node, 'i') || nodeIs(node, 'em')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_italic').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_italic').removeClass('active');
					
				
				if(nodeIs(node, 'u')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_underline').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_underline').removeClass('active');
				
				
				if(nodeIs(node, 'strike')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_strikethrough').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_strikethrough').removeClass('active');
				
				
				if(nodeIs(node, 'sub')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_sub').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_sub').removeClass('active');
				
				
				if(nodeIs(node, 'sup')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_sup').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_sup').removeClass('active');
					
				if(nodeIs(node, 'ol')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_ol').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_ol').removeClass('active');
					
				if(nodeIs(node, 'ul')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_ul').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_ul').removeClass('active');
				
				if(nodeIs(node, 'cite')) {
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_cite').addClass('active');
				}
				else
					$(getIframeWindow(body).frameElement).parents('.dw_wrap').find('button.dw_cite').removeClass('active');
				*/
			}
		}
		
		function onCut() {
			if(!$(this).hasClass('disabled')) {
				try { 
					var result = getIframeDocument(this).execCommand('cut', false, null);
					if(!result) {
						throw "notImplemented";
					}
				}
				catch(e) {
					var locale = $.fn.doshuwysiwyg.locale[getSettings(this).locale]; 
					dwAlert(locale.erroreCut, this);
				}	
			}
		}
		
		function onCopy() {
			if(!$(this).hasClass('disabled')) {
				try { 
					var result = getIframeDocument(this).execCommand('copy', false, null);
					if(!result) {
						throw "notImplemented";
					}
				}
				catch(e) {
					var locale = $.fn.doshuwysiwyg.locale[getSettings(this).locale]; 
					dwAlert(locale.erroreCopy, this);
				}	
			}
		}
		
		function onPaste() {
			if(!$(this).hasClass('disabled')) {
				try { 
					var result = getIframeDocument(this).execCommand('paste', false, null);
					if(!result) {
						throw "notImplemented";
					}
				}
				catch(e) {
					var locale = $.fn.doshuwysiwyg.locale[getSettings(this).locale]; 
					dwAlert(locale.errorePaste, this);
				}	
			}
		}
		
		function onBodyChange() {
			buttonState($(getIframeWindow(this).frameElement).parents('.dw_wrap').find('button.dw_undo'), true);
		}
		
		function onUndo() {
			if(!$(this).hasClass('disabled')) {
				getIframeDocument(this).execCommand('undo', false, null);
				var res = getIframeDocument(this).execCommand('undo', false, null);
				if(res)
					getIframeDocument(this).execCommand('redo', false, null)
				buttonState(this, res);
				buttonState(getTemplate(this).find('.dw_repeat'), true);
			}
		}
		
		function onRedo() {
			if(!$(this).hasClass('disabled')) {
				getIframeDocument(this).execCommand('redo', false, null);
				var res = getIframeDocument(this).execCommand('redo', false, null);
				if(res)
					getIframeDocument(this).execCommand('undo', false, null)
				buttonState(this, res);
				buttonState(getTemplate(this).find('.dw_undo'), true);
			}
		}
		
		function onSearch() {
			var locale = $.fn.doshuwysiwyg.locale[getSettings(this).locale];
			var formTemplate = $('<form class="form-inline dw_form_search"><button type="button" class="close" data-dismiss="alert">&times;</button><input type="text" class="input-medium dw_form_search_text" placeholder="'+locale.cercaPlaceholder+'"><label class="checkbox"><input type="checkbox" class="dw_form_search_mM" value="1"> '+locale.mM+'</label><button type="button" class="btn dw_form_search_button">'+locale.cerca+'</button></form>');
			getTemplate(this).find('.dw_form_container').empty().append(formTemplate);
			
			getIframe($(this))[0].contentWindow.document.body.dwTextRange = false;
			
			formTemplate.find('.dw_form_search_button').on('click', function() {
				var parentForm = $($(this).parents('form.dw_form_search')[0]);
				var textTofind = parentForm.find('.dw_form_search_text').val();
				var mM = parentForm.find('.dw_form_search_mM').is(':checked');
				var iframeWindow = getIframe($(this))[0].contentWindow;
				
				if (iframeWindow.find) {
                	var found = iframeWindow.find(textTofind, mM);
                	if(!found) {
                		while(iframeWindow.find(textTofind, mM, 1));
                	}
           		}
            	else {
                	if (iframeWindow.document.selection && iframeWindow.document.body.createTextRange) {

						if(iframeWindow.document.body.dwTextRange) {
							var textRange = iframeWindow.document.body.dwTextRange;
						}
						else {
                    		var textRange = iframeWindow.document.body.createTextRange();
                    		iframeWindow.document.body.dwTextRange = textRange;
                    	}
                    	
                    	if (textRange.text.length > 0 && iframeWindow.document.selection.type == "Text") {
                            textRange.collapse (true);
                            textRange.move ("character", 1);
                        }
                    	
                   		if (textRange.findText) {
                   			          
		                    found = textRange.findText(textTofind, 1, mM?4:0);
		                    if (found) {
		                        textRange.select();
		                    }
		                    else {
								textRange = iframeWindow.document.body.createTextRange();
								iframeWindow.document.body.dwTextRange = textRange;
								
								found = textRange.findText(textTofind, 1, mM?4:0);
								if (found) {
		                    		textRange.select();
		                		}
		                    }
                    	}
                	}
                }
            
			});
		}
			
		function onReplace() {
		
			var locale = $.fn.doshuwysiwyg.locale[getSettings(this).locale];
			var formTemplate = $('<form class="form-inline dw_form_replace"><button type="button" class="close" data-dismiss="alert">&times;</button><input type="text" class="input-medium dw_form_search_text" placeholder="'+locale.cercaPlaceholder+'"><input type="text" class="input-medium dw_form_replace_text" placeholder="'+locale.sostituisciPlaceholder+'"><label class="checkbox"><input type="checkbox" class="dw_form_replace_mM" value="1"> '+locale.mM+'</label><button type="button" class="btn dw_form_search_button">'+locale.cerca+'</button><button type="button" class="btn dw_form_replace_button">'+locale.sostituisci+'</button></form>');
			getTemplate(this).find('.dw_form_container').empty().append(formTemplate);
			getIframe($(this))[0].contentWindow.document.body.dwTextRange = false;
			
		    formTemplate.find('.dw_form_search_button').on('click', function() {
		    
				var parentForm = $($(this).parents('form.dw_form_replace')[0]);
				var textTofind = parentForm.find('.dw_form_search_text').val();
				var textToreplace = parentForm.find('.dw_form_replace_text').val();
				var mM = parentForm.find('.dw_form_replace_mM').is(':checked');
				var iframeWindow = getIframe($(this))[0].contentWindow;
				
				if (iframeWindow.find) {
                	var found = iframeWindow.find(textTofind, mM);
                	if(!found) {
                		while(iframeWindow.find(textTofind, mM, 1))
                			found = true;
                	}
           		}
            	else {
                	if (iframeWindow.document.selection && iframeWindow.document.body.createTextRange) {

						if(iframeWindow.document.body.dwTextRange) {
							var textRange = iframeWindow.document.body.dwTextRange;
						}
						else {
                    		var textRange = iframeWindow.document.body.createTextRange();
                    		iframeWindow.document.body.dwTextRange = textRange;
                    	}
                    	
                    	if (textRange.text.length > 0 && iframeWindow.document.selection.type == "Text") {
                            textRange.collapse(true);
                            textRange.move("character", 1);
                        }
                    	
                   		if (textRange.findText) {
                   			          
		                    found = textRange.findText(textTofind, 1, mM?4:0);
		                    if (found) {
		                        textRange.select();
		                    }
		                    else {
								textRange = iframeWindow.document.body.createTextRange();
								iframeWindow.document.body.dwTextRange = textRange;
								
								found = textRange.findText(textTofind, 1, mM?4:0);
								if (found) {
		                    		textRange.select();
		                		}
		                    }
                    	}
                	}
                }
               	
			});
			
			
			formTemplate.find('.dw_form_replace_button').on('click', function() {
			
				var iframeWindow = getIframe($(this))[0].contentWindow;
	            var selection = getWindowSelection(iframeWindow);
	            var parentForm = $($(this).parents('form.dw_form_replace')[0]);
	            var textToreplace = parentForm.find('.dw_form_replace_text').val();
	            
	            
	            if(selection.rangeCount) {
	            	var range = selection.getRangeAt(0);
	            	if(range.toString().length) {
	            		
	            		range.deleteContents();
	            		range.insertNode(document.createTextNode(textToreplace));
	            	}
	            }
	            else {
	            	var range = selection.createRange();
	            	if(range.pasteHTML) {
	            		range.pasteHTML(textToreplace);
	            	}
	            }
		        
			}); 
			
		}
		
		
		function onBold() {
			getIframeDocument(this).body.focus();
			selectParentNodeIfEmpty(getBodySelectionRaw(getIframeDocument(this).body), 'b, strong');
			getIframeDocument(this).execCommand('bold', false, null);
			//$(this).toggleClass('active');
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onItalic() {
			getIframeDocument(this).body.focus();
			selectParentNodeIfEmpty(getBodySelectionRaw(getIframeDocument(this).body), 'i, em');
			getIframeDocument(this).execCommand('italic', false, null);
			//$(this).toggleClass('active');
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onUnderline() {
			getIframeDocument(this).body.focus();
			selectParentNodeIfEmpty(getBodySelectionRaw(getIframeDocument(this).body), 'u');
			getIframeDocument(this).execCommand('underline', false, null);
			//$(this).toggleClass('active');
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onStrikeThrough() {
			getIframeDocument(this).body.focus();
			selectParentNodeIfEmpty(getBodySelectionRaw(getIframeDocument(this).body), 'strike');
			getIframeDocument(this).execCommand('strikeThrough', false, null);
			//$(this).toggleClass('active');
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onSub() {
			getIframeDocument(this).body.focus();
			selectParentNodeIfEmpty(getBodySelectionRaw(getIframeDocument(this).body), 'sub');
			getIframeDocument(this).execCommand('subscript', false, null);
			//$(this).toggleClass('active');
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onSup() {
			getIframeDocument(this).body.focus();
			selectParentNodeIfEmpty(getBodySelectionRaw(getIframeDocument(this).body), 'sup');
			getIframeDocument(this).execCommand('superscript', false, null);
			//$(this).toggleClass('active');
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onUnformat() {
			getIframeDocument(this).body.focus();
			getIframeDocument(this).execCommand('removeFormat', false, null);
			
		}
		
		function onOl() {
			getIframeDocument(this).body.focus();
			getIframeDocument(this).execCommand('insertOrderedList', false, null);
			$(getIframeDocument(this).body).trigger('keyup');
		}
		
		function onUl() {
			getIframeDocument(this).body.focus();
			getIframeDocument(this).execCommand('insertUnorderedList', false, null);
			$(getIframeDocument(this).body).trigger('keyup');	
		}
		
		function onIndentRight() {
			getIframeDocument(this).body.focus();
			getIframeDocument(this).execCommand('indent', false, null);	
		}
		
		function onIndentLeft() {
			getIframeDocument(this).body.focus();
			getIframeDocument(this).execCommand('outdent', false, null);	
		}
		
		function onCite() {
			getIframeDocument(this).body.focus();
			pasteHtml(getIframeDocument(this), "<cite>"+getBodySelection(getIframeDocument(this).body)+"</cite>");
		}
	}
	
	
	
	
	$.fn.doshuwysiwyg.locale = new Array();
	
	$.fn.doshuwysiwyg.locale['ita'] = {
		codice_sorgente:'Codice sorgente',
		formato:'Formato',
		normale:'normale',
		titolo:'Titolo',
		carattere:'Carattere',
		dimensione:'Dimensione',
		erroreCut:'Impossibile tagliare automaticamente. Utilizza la scorciatoia da tastiera Ctrl+x.',
		erroreCopy:'Impossibile copiare automaticamente. Utilizza la scorciatoia da tastiera Ctrl+c.',
		errorePaste:'Impossibile incollare automaticamente. Utilizza la scorciatoia da tastiera Ctrl+v.',
		cercaPlaceholder:'Testo da cercare',
		mM:'minuscole/Maiuscole',
		cerca:'Cerca',
		sostituisciPlaceholder:'Testo da sostituire',
		sostituisci:'Sostituisci'
	}
});
