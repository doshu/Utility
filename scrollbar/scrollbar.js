$.fn.doshuScroll = function(options) {

	var settings = $.extend({
		type:'v'
	}, options );
	
	
	return this.each(function() {
		if(settings.type == 'v') {
			return $(this).doshuScrollCreateVerticalBar(settings);
		}
		else if(settings.type == 'h') {
			return $(this).doshuScrollCreateHorizontalBar(settings);
		}
    });
        
}

$.fn.doshuSetVerticalScroll = function(y) {
	
	var cursor = $.fn.doshuScroll.dragElement;
	var currentScroll = y - $(this).offset().top;
	
	currentScroll = Math.min(
		Math.max(currentScroll, 0), 
		$($(cursor).parents('.doshu-vertical-scrollbar')[0]).innerHeight() - $(cursor).innerHeight()
	);
	
	$(cursor).css('top', currentScroll+'px');
	
	
	contentScroll = 0 - $($($(cursor).parents('.doshu-scrollbar-wrapper')[0]).find('.doshu-scrollable')[0]).innerHeight() * currentScroll / $($(cursor).parents('.doshu-vertical-scrollbar')[0]).innerHeight();
	
	
	$($($(cursor).parents('.doshu-scrollbar-wrapper')[0]).find('.doshu-scrollable')[0]).css('top', contentScroll);
}


$.fn.doshuSetHorizontalScroll = function(x) {
	
	var cursor = $.fn.doshuScroll.dragElement;
	var currentScroll = x - $(this).offset().left;
	
	currentScroll = Math.min(
		Math.max(currentScroll, 0), 
		$($(cursor).parents('.doshu-horizontal-scrollbar')[0]).innerWidth() - $(cursor).innerWidth()
	);
	
	$(cursor).css('left', currentScroll+'px');
	
	
	contentScroll = 0 - $($($(cursor).parents('.doshu-scrollbar-wrapper')[0]).find('.doshu-scrollable')[0]).innerWidth() * currentScroll / $($(cursor).parents('.doshu-horizontal-scrollbar')[0]).innerWidth();
	
	
	$($($(cursor).parents('.doshu-scrollbar-wrapper')[0]).find('.doshu-scrollable')[0]).css('left', contentScroll);
}


$.fn.doshuScrollCreateVerticalBar = function(settings) {
	
	var wrapperCss = { position: 'relative', overflow: 'hidden'};
	var css = { position: 'relative' };
	
	if(settings.width) {
		wrapperCss.width = settings.width;
		css.width = settings.width;
	}
	if(settings.height)
		wrapperCss.height = settings.height;
		
	var wrapper = $('<div class="doshu-scrollbar-wrapper"></div>');
	wrapper.css(wrapperCss);
	
	this.css(css);
	this.addClass('doshu-scrollable doshu-vertical-scrollable');
	
	this.wrap(wrapper);
	
	var scrollbar = $('<div class="doshu-scrollbar doshu-vertical-scrollbar"></div>');
	var cursor = $('<div class="doshu-cursor doshu-vertical-cursor"></div>');
	scrollbar.append(cursor);
	
	var scrollbarHeight = wrapper.innerHeight();
	scrollbar.css('height', scrollbarHeight);
	
	var cursorHeight = (scrollbarHeight*wrapper.innerHeight())/this.innerHeight();
	cursor.css('height', cursorHeight+'px');
	
	cursor.on('mousedown', function(e) {
		e.preventDefault();
		$.fn.doshuScroll.dragElement = this;
		$(document.body).on('mousemove', function(e) {
			
			e.preventDefault();
			$(this).doshuSetVerticalScroll(e.clientY);
			
			return false;
		});
		
		$(document.body).one('mouseup mouseenter', function(e) {
			$.fn.doshuScroll.dragElement = null;
			$(document.body).off('mousemove');
		});
		return false;
	});
	
	scrollbar.on('click', function(e) {
		$.fn.doshuScroll.dragElement = $(this).find('.doshu-vertical-cursor');
		$(document.body).doshuSetVerticalScroll(e.clientY);
		$.fn.doshuScroll.dragElement = null;
	});
	
	this.on('mousewheel DOMMouseScroll', function(e) {
	
		var cursor = $($(this).parents('.doshu-scrollbar-wrapper')[0]).find('.doshu-vertical-cursor');
		$.fn.doshuScroll.dragElement = cursor;
		var currentScroll = cursor.offset().top;
		
		if(e.originalEvent.wheelDelta) {
			var dir = e.originalEvent.wheelDelta > 0?'up':'down';
		}
		else if(e.originalEvent.detail) {
			var dir = e.originalEvent.detail > 0?'down':'up';
		}
		
		
		var newScroll = currentScroll;
		if(dir == 'up') {
			newScroll -= cursor.innerHeight();
		}
		else if(dir == 'down'){
			newScroll += cursor.innerHeight();
		}
		
		
		$(document.body).doshuSetVerticalScroll(newScroll);
		
		$.fn.doshuScroll.dragElement = null;
	});
	

	$(this.parents('.doshu-scrollbar-wrapper')).append(scrollbar);
	
}

$.fn.doshuScrollCreateHorizontalBar = function(settings) {
	
	var wrapperCss = { position: 'relative', overflow: 'hidden'};
	var css = { position: 'relative' };
	
	if(settings.width) {
		wrapperCss.width = settings.width;
	}
	if(settings.height) {
		wrapperCss.height = settings.height;
		css.height = settings.height;	
	}
	css.width = settings.contentWidth;
		
	var wrapper = $('<div class="doshu-scrollbar-wrapper"></div>');
	wrapper.css(wrapperCss);
	
	this.css(css);
	this.addClass('doshu-scrollable doshu-horizontal-scrollable');
	
	this.wrap(wrapper);
	
	var scrollbar = $('<div class="doshu-scrollbar doshu-horizontal-scrollbar"></div>');
	var cursor = $('<div class="doshu-cursor doshu-horizontal-cursor"></div>');
	scrollbar.append(cursor);
	
	var scrollbarWidth = wrapper.innerWidth();
	scrollbar.css('width', scrollbarWidth);
	
	var cursorWidth = (scrollbarWidth*wrapper.innerWidth())/this.innerWidth();

	cursor.css('width', cursorWidth+'px');
	
	cursor.on('mousedown', function(e) {
		e.preventDefault();
		$.fn.doshuScroll.dragElement = this;
		$(document.body).on('mousemove', function(e) {
			
			e.preventDefault();
			$(this).doshuSetHorizontalScroll(e.clientX);
			
			return false;
		});
		
		$(document.body).one('mouseup mouseenter', function(e) {
			$.fn.doshuScroll.dragElement = null;
			$(document.body).off('mousemove');
		});
		return false;
	});
	
	scrollbar.on('click', function(e) {
		$.fn.doshuScroll.dragElement = $(this).find('.doshu-horizontal-cursor');
		$(document.body).doshuSetHorizontalScroll(e.clientX);
		$.fn.doshuScroll.dragElement = null;
	});
	
	
	this.on('mousewheel DOMMouseScroll', function(e) {
	
		var cursor = $($(this).parents('.doshu-scrollbar-wrapper')[0]).find('.doshu-horizontal-cursor');
		$.fn.doshuScroll.dragElement = cursor;
		var currentScroll = cursor.offset().left;
		
		if(e.originalEvent.wheelDelta) {
			var dir = e.originalEvent.wheelDelta > 0?'up':'down';
		}
		else if(e.originalEvent.detail) {
			var dir = e.originalEvent.detail > 0?'down':'up';
		}
		
		
		var newScroll = currentScroll;
		if(dir == 'up') {
			newScroll -= cursor.innerWidth();
		}
		else if(dir == 'down'){
			newScroll += cursor.innerWidth();
		}
		
		
		$(document.body).doshuSetHorizontalScroll(newScroll);
		
		$.fn.doshuScroll.dragElement = null;
	});
	

	$(this.parents('.doshu-scrollbar-wrapper')).append(scrollbar);

}
