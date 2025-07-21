<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Advertise_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Advertise Data */
    public function getAdvertisementData($searchText, $order_by, $sort_by, $offset, $limit){
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE ta.status != 'delete'";
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (ta.ad_name LIKE '%{$searchText}%' OR ta.star LIKE '%{$searchText}%' OR ta.ad_type LIKE '%{$searchText}%')";
        }
        $qry = "SELECT ta.ad_id, ta.ad_name, ta.star, ta.ad_path, ta.ad_type, ta.status
                FROM tbl_advertisement ta                
                {$where} {$like} {$order_by} {$offset_limit}";
        
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Advertise Details */
    public function getAdvertiseDetails($ad_id){
        $qry = "SELECT ta.ad_id, ta.ad_name, ta.star, ta.ad_path, ta.ad_type, ta.status
                FROM tbl_advertisement ta
                WHERE ta.ad_id = {$ad_id}";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }    
}
