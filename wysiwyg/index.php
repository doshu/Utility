<!doctype html>
<html lang="it">
	<head>
		<title>wysisyg</title>
		<meta charset="utf-8"/>
		<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
		<link href="css/dw/doshu_wysiwyg.css" rel="stylesheet" type="text/css">
		<link href="css/font-awesome.min" rel="stylesheet" type="text/css">
		<!--[if IE 7]>
			<link href="css/font-awesome-ie7.min.css" rel="stylesheet" type="text/css">
		<![endif]-->
		<script src="js/jquery-1.9.1.min"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/dw/doshu_wysiwyg.js"></script>
		<script>
			$(function() {
				
				
				$('textarea').doshuwysiwyg({
					asd:'lol', 
					onSave:function(text) {alert(text);},
					
				});
				
				
			});
		</script>
		

	</head>
	<body>
		<div style="width:70%; padding:50px;">
			<textarea id="lol"></textarea>
		</div>
		<div style="width:70%; padding:50px;">
			<textarea id="asd"></textarea>
		</div>
		
		<!--div style="width:70%; padding:50px; ">
			<div class="dw_wrap">
				<div class="dw_toolbar_wrap">
					<div class="dw_toolbar_line">
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_source_code">Codice sorgente</button>
							<button class="btn btn-small dw_save"><i class="icon icon-save"></i></button>
							<button class="btn btn-small dw_preview"><i class="icon icon-eye-open"></i></button>
							<button class="btn btn-small dw_print"><i class="icon icon-print"></i></button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_cut"><i class="icon icon-cut"></i></button>
							<button class="btn btn-small dw_copy"><i class="icon icon-copy"></i></button>
							<button class="btn btn-small dw_paste"><i class="icon icon-paste"></i></button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_undo"><i class="icon icon-undo"></i></button>
							<button class="btn btn-small dw_repeat"><i class="icon icon-repeat"></i></button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_search"><i class="icon icon-search"></i></button>
							<button class="btn btn-small dw_replace"><i class="icon icon-random"></i></button>
						</span>
					</div>
					<div class="dw_toolbar_line">
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_bold"><i class="icon icon-bold"></i></button>
							<button class="btn btn-small dw_italic"><i class="icon icon-italic"></i></button>
							<button class="btn btn-small dw_underline"><i class="icon icon-underline"></i></button>
							<button class="btn btn-small dw_strikethrough"><i class="icon icon-strikethrough"></i></button>
							<button class="btn btn-small dw_sup">
								<i>X<span style="position:relative; top:-4px;">2</span></i>
							</button>
							<button class="btn btn-small dw_sub">
								<i>X<span style="position:relative; top:4px;">2</span></i>
							</button>
							<button class="btn btn-small dw_unformat"><i class="icon icon-remove-sign"></i></button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_ol"><i class="icon icon-list-ol"></i></button>
							<button class="btn btn-small dw_ul"><i class="icon icon-list-ul"></i></button>
							<button class="btn btn-small dw_indent_right"><i class="icon icon-indent-right"></i></button>
							<button class="btn btn-small dw_indent_left"><i class="icon icon-indent-left"></i></button>
							<button class="btn btn-small dw_cite"><i class="icon icon-quote-right"></i></button>
							<button class="btn btn-small dw_div">
								<i>&lt;DIV&gt;</i>
							</button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_align_left"><i class="icon icon-align-left"></i></button>
							<button class="btn btn-small dw_align_center"><i class="icon icon-align-center"></i></button>
							<button class="btn btn-small dw_align_right"><i class="icon icon-align-right"></i></button>
							<button class="btn btn-small dw_align_jistify"><i class="icon icon-align-justify"></i></button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_text_right"><i class="icon icon-arrow-right"></i></button>
							<button class="btn btn-small dw_text_left"><i class="icon icon-arrow-left"></i></button>
						</span>
					</div>
					<div class="dw_toolbar_line">
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_link"><i class="icon icon-link"></i></button>
							<button class="btn btn-small dw_nolink"><i class="icon icon-link"></i><i class="icon icon-remove"></i></button>
							<button class="btn btn-small dw_anchor"><i class="icon icon-flag"></i></button>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small dw_img"><i class="icon icon-picture"></i></button>
							<button class="btn btn-small dw_table"><i class="icon icon-table"></i><i class="icon icon-remove"></i></button>
							<button class="btn btn-small dw_hr"><i class="icon icon-minus"></i></button>
							<button class="btn btn-small dw_symbol"><i class="icon icon-asterisk"></i></button>
							<button class="btn btn-small dw_iframe"><i class="icon icon-globe"></i></button>
						</span>
					</div>
					<div class="dw_toolbar_line">
					    <div class="btn-group dw_select">
							<button class="btn dropdown-toggle dw_format" data-toggle="dropdown">
								<span class="dw_select_caption">Formato</span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu text-format">
								<li><a href="">normale</a></li>
								<li><a href=""><h1>Titolo 1</h1></a></li>
								<li><a href=""><h2>Titolo 2</h2></a></li>
								<li><a href=""><h3>Titolo 3</h3></a></li>
								<li><a href=""><h4>Titolo 4</h4></a></li>
								<li><a href=""><h5>Titolo 5</h5></a></li>
								<li><a href=""><h6>Titolo 6</h6></a></li>
							</ul>
						</div>
						<div class="btn-group dw_select">
							<button class="btn dropdown-toggle dw_font_family" data-toggle="dropdown">
								<span class="dw_select_caption">Carattere</span>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu text-font">
								 <li><a href="" style="font-family:andale mono">Andale Mono</a></li>
								 <li><a href="" style="font-family:arial">Arial</a></li>
								 <li><a href="" style="font-family:comic sans ms">Comic Sans MS</a></li>
								 <li><a href="" style="font-family:courier new">Courier New</a></li>
								 <li><a href="" style="font-family:georgia">Georgia</a></li>
								 <li><a href="" style="font-family:impact">Impact</a></li>
								 <li><a href="" style="font-family:times new roman">Times New Roman</a></li>
								 <li><a href="" style="font-family:trebuchet ms">Trebuchet MS</a></li>
								 <li><a href="" style="font-family:verdana">Verdana</a></li>
							</ul>
						</div>
						<div class="btn-group dw_select">
							<button class="btn dropdown-toggle dw_font_size" data-toggle="dropdown">
								<span class="dw_select_caption">Dimensione</span>
								<span class="caret"></span>
							</button>
							<div class="dropdown-menu text-size">
								 <div class="input-append">
									<input class="span2" type="number">
									<span class="add-on">px</span>
								</div>
							</div>
						</div>
						<span class="btn-group dw_toolbar">		
							<button class="btn dropdown-toggle btn-small dw_color" data-toggle="dropdown">
								<i class="icon icon-font"></i>
							</button>
							<ul class="dropdown-menu">
							</ul>
						</span>
						<span class="btn-group dw_toolbar">		
							<button class="btn dropdown-toggle btn-small dw_background_color" data-toggle="dropdown">
								<i class="icon icon-font icon-backgroundcolor"></i>
							</button>
							<ul class="dropdown-menu">
							</ul>
						</span>
						<span class="btn-group dw_toolbar">
							<button class="btn btn-small"><i class="icon icon-flag"></i></button>
						</span>
					</div>
				</div>
				<div class="dw_html_container">
					<iframe class="dw_html" src="about::blank"></iframe>
				</div>
			</div>
		</div-->
	</body>
</html>
