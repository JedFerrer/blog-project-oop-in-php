<?php
	class Pagination {
		private $_db,
				$_per_page,
				$_pages,
				$_page,
				$_start;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
		}

		public function pagination($per_page, $author_id = null) {
			
			if($author_id) {
				$this->_db->query("SELECT * FROM blog_post WHERE author_id = '$author_id'");
	        } else {
	        	$this->_db->query("SELECT * FROM blog_post");
	        }

	        $this->_pages = ceil($this->_db->count() / $per_page);
	        $this->_page = (isset($_GET['page'])) ? (int)$_GET['page'] : 1;
	        $this->_start = ($this->_page - 1) * $per_page;

	        $this->_per_page = $per_page;

		}

		public function perpage() {
			return $this->_per_page;
		}

		public function pages() {
			return $this->_pages;
		}

		public function page() {
			return $this->_page;
		}

		public function start() {
			return $this->_start;
		}


	}

?>