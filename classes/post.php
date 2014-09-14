<?php
	class Post {
		private $_db,
				$_data;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
		}

		public function create($fields = array()) {
			if(!$this->_db->insert('blog_post', $fields)) {
				throw new Exception('There was a problem occured on adding post.');
			}
		}

		public function get($id) {
			if($id) {
				$data = $this->_db->get('blog_post', array('id', '=', $id));
				if($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			print_r($this->_data);
			return false;
		}

		public function update($id, $fields) {
			if(!$this->_db->update('blog_post', $id, $fields)) {
				throw new Exception('There was a problem occured on updating the post.');
			}
		}

		public function delete($where) {
			if(!$this->_db->delete('blog_post', $where)) {
				throw new Exception('There was a problem occured on deleting the post.');
			}
		}

		public function data() {
			return $this->_data;
		}

	}

?>