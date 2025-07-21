<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Plan_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Plan Data */
    public function getPlanData($searchText, $order_by, $sort_by, $offset, $limit){
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE tp.status != 'delete'";
        $like = "";
        if(!empty($searchText)){
            $like = " AND (tp.price LIKE '%{$searchText}%' OR tp.description LIKE '%{$searchText}%' OR tp.plan_name LIKE '%{$searchText}%' OR tp.star LIKE '%{$searchText}%')";
        }
        $qry = "SELECT tp.plan_id, tp.plan_name, tp.description, tp.star, tp.price, tp.status, tp.plan_type
                FROM tbl_purchase_plan tp                
                {$where} {$like}  {$offset_limit}";
        
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get User Details */
    public function getPlanDetails($plan_id){
        $qry = "SELECT tp.plan_id, tp.plan_name, tp.description, tp.star, tp.price, tp.extra_star, tp.status, tp.plan_type
                FROM tbl_purchase_plan tp                
                WHERE tp.plan_id = {$plan_id}";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }    
}
