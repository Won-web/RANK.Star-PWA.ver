<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notice_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Notice Data */
    public function getNoticeData($searchText, $order_by, $sort_by, $offset, $limit) {
        $offset_limit = "";
        if(!empty($limit)) {
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE status != 'deactive'";
        $like = "";
        if(!empty($searchText)) {
            $like = " WHERE (tn.notice_title LIKE '%{$searchText}%')";
        }
        $query = "SELECT tn.notice_id, tn.notice_title, tn.send_notice ,tn.notice_date
                FROM tbl_notice tn                
                {$where} {$like} ORDER BY tn.notice_date DESC {$offset_limit}";
              
        $result = $this->db->query($query);
        return $this->returnRows($result);
    }

    // public function getNoticeData($searchText, $order_by, $sort_by, $offset, $limit) {
    //     $offset_limit = "";
    //     if(! empty($limit)) {
	// 		$offset_limit = "LIMIT {$offset},{$limit}";
    //     }
    //     $order_by = "ORDER BY {$order_by} {$sort_by}";
	// 	$where = "WHERE am.message_type = 'notice'";
    //     $like = "";
    //     if(!empty($searchText)) {
    //         $like = " AND (am.message_title LIKE '%{$searchText}%' OR am.message LIKE '%{$searchText}%' OR am.message_type LIKE '%{$searchText}%')";
    //     }
    //     $query = "SELECT am.apns_master_id, am.message_title, am.message, am.message_type
    //             FROM apns_master am                
    //             {$where} {$like} {$order_by} {$offset_limit}";
                        
    //     $result = $this->db->query($query);
    //     return $this->returnRows($result);
    // }

    /* Get Notice Details */
    public function getNoticeDetails($noticeId) {
        // $qry = "SELECT am.apns_master_id, am.notice_title, am.notice_description, am.notice_by
        //         FROM apns_master am
        //         WHERE am.notice_id = {$apnsMasterId}";
        $qry = "SELECT * FROM tbl_notice WHERE notice_id={$noticeId}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }    
}
