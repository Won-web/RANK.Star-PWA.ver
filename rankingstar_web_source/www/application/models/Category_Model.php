<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Category Data */
    public function getCategoryData($searchText, $order_by, $sort_by, $offset, $limit) {
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE tc.status != 'delete'";
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (tc.category_name LIKE '%{$searchText}%' OR tc.status LIKE '%{$searchText}%')";
        }
        $qry = "SELECT tc.contest_category_id, tc.category_name, tct.contest_name , tc.status, tc.created_date, tc.updated_date
                FROM tbl_contest_category tc   
                INNER JOIN tbl_contest tct ON tct.contest_id = tc.contest_id
                {$where} {$like} {$order_by} {$offset_limit}";
        // print_r($qry);
        // exit;
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Category Details */
    public function getCategoryDetails($contest_category_id) {
        $qry = "SELECT tc.contest_category_id, tc.category_name, tct.contest_name, tct.contest_id, tc.status, tc.created_date, tc.updated_date
                FROM tbl_contest_category tc  
                INNER JOIN tbl_contest tct ON tct.contest_id = tc.contest_id              
                WHERE tc.contest_category_id = {$contest_category_id}";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }    
}
