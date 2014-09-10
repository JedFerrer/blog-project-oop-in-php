<?php
	class User {
		private $_db,
				$_data,
				$_sessionName,
				$_isLoggedIn;

		public function __construct($user = null) {
			$this->_db = DB::getInstance();
			$this->_sessionName = config::get('session/session_name');

			if (!$user) {
				if(Session::exists($this->_sessionName)) {
					$user = Session::get($this->_sessionName);
					
					if($this->find($user)) {
						$this->_isLoggedIn = true;
					} else {
						//
					}
				}
			}
		}

		public function create($fields = array()) {
			if(!$this->_db->insert('blog_users', $fields)) {
				throw new Exception('There was a problem creating an account.');
			}
		}

		public function find($user = null) {
			if($user) {
				$field = (is_numeric($user)) ? 'id' : 'user_email';
				$data = $this->_db->get('blog_users', array($field, '=', $user));

				if($data->count()) {
					$this->_data = $data->first();
					return true;
				}
			}
			return false;
		}

		public function login($username = null, $password = null) {

			$user = $this->find($username);
			if($user) {
				if($this->data()->user_pass === md5($password)) {
					session::put($this->_sessionName, $this->data()->id);
					return true;
				}	
			}
			//print_r( $this->_data);
			return false;
		}

		public function logout() {
			Session::delete($this->_sessionName);
		}

		public function data() {
			return $this->_data;
		}

		public function isLoggedIn() {
			return $this->_isLoggedIn;
		}
	}
?>