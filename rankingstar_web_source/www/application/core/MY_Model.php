<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{

    public $return_type = 'array';
    public $dbObj;
	protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->dbObj = $this->db;
    }

    /* -------------- SELECT DATA -------------------------  */
    /*
     * Select All Rows
     */
    public function getAll($table_name)
    {
        try {
            $query = $this->db->get($table_name);
            return $this->returnRows($query);
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     * Select rows by where clause
     */
    public function getByWhere($table_name, $colValArr = array())
    {
        try {
            $query = $this->db->get_where($table_name, $colValArr);
            return $this->returnRows($query);
        } catch (Exception $ex) {
            return false;
        }
    }

    /*
     *  Change Return as Object or Array
     */
    protected function returnRows($query)
    {
        if ($query == null) {
            return array();
        }
        if ($this->return_type == 'object') {
            return $query->result();
        } else if ($this->return_type == 'array') {
            return $query->result_array();
        }
    }

    /* -------------- INSERT DATA -------------------------  */

    public function insert($table_name, $data = array())
    {
        try
        {
            if ($this->db->insert($table_name, $data)) {
                return $this->db->insert_id();
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /* -------------- UPDATE DATA -------------------------  */

    public function update($table_name, $data = array(), $whereArr = array())
    {
        try {
            $this->db->where($whereArr);
            if ($this->db->update($table_name, $data)) {
                return $this->db->affected_rows();
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    /* -------------- DELETE DATA -------------------------  */
    public function delete($table_name, $whereArr = array())
    {
        try {
            if (is_array($whereArr)) {
                $this->db->where($whereArr);
                $this->db->delete($table_name);
                return $this->db->affected_rows();
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getField($fields = "*") {
		if (is_array ( $fields )) {
			$fields = implode ( ",", $fields );
		}
		$this->dbObj->select ( $fields );
		return $this;
	}

    public function setTable($table) {
		$this->table = $table;
		return $this;
	}

    public function get() {		
		$query = $this->dbObj->get ( $this->table );
		$result_set = $this->_setResultSet ( $query );
		$this->logQuery ();
		return $result_set;
	}

    private function _setResultSet($query) {
		$result_set = array ();
		if ($query != FALSE) {
			if ($this->resultType == "array") {
				$result_set = $query->result_array ();
			} else {
				$result_set = $query->result ();
			}
		}
		return $result_set;
	}

    public function setWhere($where = null, $condition = "and") {
		if ($where != null) {
			if (is_array ( $where ) || ! is_numeric ( $where )) {
				$condition = strtolower ( $condition );
				if ($condition == "or") {
					$this->dbObj->or_where ( $where );
				} else {                    
					$this->dbObj->where ( $where );
				}
			} else {
                // if argmument is number                
				$this->dbObj->where ( $this->primaryField, $where );
			}
			return $this;
		}
		log_message ( "ERROR", "Parameter not pass in setWhere()" );
	}

    public function upsertUserAuthData($username, $password)
    {
        try {
            $sql = "INSERT INTO oauth_users (username, password) VALUES ('{$username}', '{$password}')
            ON DUPLICATE KEY UPDATE password='{$password}'";
            $this->db->query($sql);
            return $this->db->insert_id();
        } catch (Exception $ex) {
            return false;
        }
    }
}
