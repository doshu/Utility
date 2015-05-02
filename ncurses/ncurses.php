<?php

	$GLOBALS['selected'] = 0;

	function draw_base(&$screen) {
	
		ncurses_curs_set(0);
		ncurses_noecho();
		ncurses_keypad ($screen, true);
		ncurses_start_color();
		ncurses_init_pair(1, NCURSES_COLOR_YELLOW, NCURSES_COLOR_BLUE);
		ncurses_wcolor_set($screen, 1);
		ncurses_wborder($screen, 0,0, 0,0, 0,0, 0,0);


		ncurses_getmaxyx($screen, $y, $x);
		
		
		for($i = 1; $i < $x-1; $i++) {
			for($j = 1; $j < $y-1; $j++)
				ncurses_mvwaddstr($screen, $j, $i, ' ');
				ncurses_wrefresh($screen);
		}
		
		print_menu($screen);
		ncurses_wrefresh($screen);
	}
	
	function print_menu(&$screen) {
		
		$menu = array(
			0 => 'VOCE MENU 1',
			1 => 'VOCE MENU 2',
			2 => 'VOCE MENU 3',  
		);
		
		for($i = 0; $i < count($menu); $i++) {
			$sel = $GLOBALS['selected'] == $i?'ncurses_wattron':'ncurses_wattroff';
			$sel($screen, NCURSES_A_REVERSE);
			ncurses_mvwaddstr($screen, $i+2, 5, $menu[$i]);
			ncurses_wrefresh($screen);
		}
	}
	
	
	function loop(&$screen) {
		
		$newmask = NCURSES_ALL_MOUSE_EVENTS;
		$mask = ncurses_mousemask($newmask, $oldmask);
		
		
		
		while(1) {
		
			switch(ncurses_wgetch($screen)) {
				case NCURSES_KEY_DOWN:
					$GLOBALS['selected'] = $GLOBALS['selected'] == 2?0:($GLOBALS['selected']+1);
					print_menu($screen);
				break;
			}
			
			/*	
			if(!ncurses_getmouse($event)) {
				$x = $event['x'];
				$y = $event['y'];
				ncurses_mvwaddstr($screen, 1, 1, str_pad($x.' '.$y, 50));
				ncurses_wrefresh($screen);
				//ncurses_wmove($screen, $y, $x);
			}
			*/
				
				
		}
		
	}

	function main() {
	
		ncurses_init();
		$screen = ncurses_newwin(0, 0, 0, 0);
		draw_base($screen);
		loop($screen);
		ncurses_wgetch($screen);
		ncurses_end();
		
	}
	
	
	/*
		@ Class for using ncurses OOP and create a multi-page program with menu 
	*/
	class ncursesProgram {
	
		// default options: not show cursor, disable echo and enable keypad (arrow keys ... )
		private $_defaultOptions = array(
			'showCursor' => false,
			'enableEcho' => false,
			'enableKeypad' => true
		);
		
		// user set options
		private $_options;
		
		// main window resource
		private $_mainWindow;
		
		// array contain the pages function name
		private $_pages = array();
		
		// current pages number
		private $_currentPageNumber = 0;
		
		// current pages pointer
		private $_currentPagePointer;
		
		// stop the program if true
		private $_stop = false;
		
		// background color int
		private $_background = NCURSES_COLOR_RED;
		
		// foreground color int
		private $_foreground = NCURSES_COLOR_GREEN;
		
		// FG + BG color combo int
		private $_pair = 1;
		
		// color combo used as default terminal color by ncourses
		private $_defaultPair = -1;
				
		// merge the default options with the custom options and initialize it
		public function __construct($options = array()) {
			$this->options = array_merge($this->_defaultOptions, $options);
			$this->_init();
		}
		
		
		private function _init() {
			
			// call ncurses init to start a ncurses development
			ncurses_init();
			
			// initialize the color functions and set default color
			ncurses_start_color();
			$this->setDefaultColor();
			
			//create the main window
			$this->_mainWindow = $this->_newWindow();
			
			// enable or disable the cursor visibility
			$this->setCursorVisibility(intval($this->_options['showCursor']));
			
			// enable or disable the keyboard echo
			$this->setEcho($this->_options['enableEcho']);
			
			//enable or disable the keypad use for the main window
			$this->setKeypad($this->_mainWindow, $this->_options['enableKeypad']);
		}
		
		private function _waitingForExit() {
			ncurses_wgetch($this->_mainWindow);
			ncurses_end();
		}
		
		private function _newWindow($row = 0, $col = 0, $orig_y = 0, $orig_x = 0) {
			return ncurses_newwin($row, $col, $orig_y, $orig_x);
		}
		
		public function setCursorVisibility($visibility) {
			ncurses_curs_set($visibility);
		}
		
		public function setEcho($status) {
			$echo = $status?'ncurses_echo':'ncurses_noecho';
			$echo();
		}
		
		public function setKeypad($window, $status) {
			ncurses_keypad($this->_mainWindow, $status);
		}
		
		public function write($y, $x, $string, $window = null) {
			$window = is_null($window)?$this->_mainWindow:$window;
			ncurses_mvwaddstr($window, $y, $x, $string);
			$this->refresh($window);
		}
		
		public function refresh($window = null) {
			$window = is_null($window)?$this->_mainWindow:$window;
			ncurses_wrefresh($window);
		}
		
		public function setForeground($r, $g, $b, $window = null) {
			ncurses_init_color($this->_foreground, $r , $g , $b);
			$this->updateColor($window);
		}
		
		public function setBackground($r, $g, $b, $window = null) {
			ncurses_init_color($this->_background, $r , $g , $b);
			$this->updateColor($window);
		}
		
		public function updateColor($window = null) {
			$window = is_null($window)?$this->_mainWindow:$window;
			ncurses_init_pair($this->_pair, $this->_foreground, $this->_background);
			ncurses_wcolor_set($window, $this->_pair);
		}
		
		public function setDefaultColor($window = null) {
			$window = is_null($window)?$this->_mainWindow:$window;
			ncurses_use_default_colors();
			ncurses_wcolor_set($window, $this->_defaultPair);
		}
		
		public function pushPage($func, $pos = null) {
			if(is_callable($func)) {
				if(is_null($pos))
					array_push($this->_pages, $func);
				elseif($pos == 0) {
					array_unshift($this->_pages, $func);
				}
				else {
					$before = array_slice($this->_pages, 0, $pos);
					$after = array_slice($this->_pages, $pos, count($this->_pages));
					$this->_pages = array_merge($before, array($func), $after); 
				}
				return true;
			}
			return false;
		}
		
		private function _renderPage() {
			$this->_currentPagePointer = new ReflectionFunction($this->_pages[$this->_currentPageNumber]);
			$this->_currentPagePointer->invokeArgs(array(&$this));
		}
		
		public function prevPage() {
			if($this->_currentPageNumber)
				$this->_currentPageNumber--;	
		}
		
		public function nextPage() {
			if($this->_currentPageNumber < (count($this->_pages)-1))
				$this->_currentPageNumber++;
		}
		
		public function stop() {
			$this->_stop = true;
		}
		
		public function run() {
			
			while(!$this->_stop) {
				try {
					if(!empty($this->_pages)) {
						$this->_renderPage();
					} 
					else {
						// print that there in no pages available
						throw new Exception('No page Available');
					}
				} 
				catch (Exception $e) {
					//catch the exception and print them
					$this->write(0, 0, $e->getMessage());
					$this->stop();
				}
			}
			
			$this->_waitingForExit();
		}
		
	}
	
	$p = new ncursesProgram();
	$p->pushPage('one');
	$p->pushPage('two');
	$p->run();

	function one($p) {
	
		//$p->setForeground(1000, 0, 0);
		$p->write(0, 0, 'Pagina 1');
		sleep(5);
		$p->nextPage();
	}
	
	function two($p) {
		
		$p->write(0, 0, 'Pagina 2');
		$p->stop();
	}
?>
