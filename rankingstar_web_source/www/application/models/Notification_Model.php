<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Notice Data */
    public function getNotificationData($searchText, $order_by, $sort_by, $offset, $limit) {
        $offset_limit = "";
        if(! empty($limit)) {
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = "WHERE am.message_type = 'notice' ";
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (am.message_title LIKE '%{$searchText}%' OR am.message LIKE '%{$searchText}%' OR am.message_type LIKE '%{$searchText}%')";
        }
        $query = "SELECT am.apns_master_id, am.message_title, am.message, am.message_type, am.created_date
                FROM apns_master am  WHERE   am.push_type='Admin' AND am.message_type = 'push'           
                 {$like} ORDER BY  am.created_date DESC  {$offset_limit}";
                        
        $result = $this->db->query($query);
        return $this->returnRows($result);
    }

    /* Get Notice Details */
    public function getNoticeDetails($apnsMasterId) {
        $qry = "SELECT am.apns_master_id, am.notice_title, am.notice_description, am.notice_by
                FROM apns_master am
                WHERE am.notice_id = {$apnsMasterId}";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    public function getContestantList($searchText, $order_by, $sort_by, $offset, $limit)
    {
        $offset_limit = "";
        if (!empty($limit)) {
            $offset_limit = " LIMIT {$offset},{$limit}";
        }

        $order_sort_by = "";
        if (!empty($order_by) && !empty($sort_by)) {
            $order_sort_by = " ORDER BY {$order_by} {$sort_by}";
        }
        
        $like = "";
        if (!empty($searchText)) {
            $like = " AND (tu.email LIKE '%{$searchText}%' OR tcd.name LIKE '%{$searchText}%' )";
        }

        $sql = "SELECT tu.user_id, tcd.name, tu.email
        FROM `tbl_user` tu
        INNER JOIN `tbl_contestant_details` tcd ON tu.user_id = tcd.user_id
        WHERE tu.user_status != 'deleted' {$like} {$order_sort_by} {$offset_limit}";

        $result = $this->db->query($sql);

        return $this->returnRows($result);
    }

    public function getAllContenstant()
    {
        $sql = "SELECT tu.user_id, tcd.name, tu.email
        FROM `tbl_user` tu
        LEFT JOIN `tbl_contestant_details` tcd ON tu.user_id = tcd.user_id
        WHERE tu.user_status != 'deleted' ";

        $result = $this->db->query($sql);

        return $this->returnRows($result);
    }
}
