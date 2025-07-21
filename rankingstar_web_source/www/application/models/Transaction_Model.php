<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Transaction Data */
    public function getTransactionDetails($from_date, $to_date, $searchText, $order_by, $sort_by, $offset, $limit){
        $offset_limit = "";
        if(!empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "  ORDER BY {$order_by} {$sort_by}";
        
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (tpp.star LIKE '%{$searchText}%'
                OR tt.amount LIKE '%{$searchText}%'
                OR tt.payment_transaction_id LIKE '%{$searchText}%'
                OR u.name LIKE '%{$searchText}%'
                OR u.email LIKE '%{$searchText}%'
                OR tt.os LIKE '%{$searchText}%'
                OR tt.trans_identifier LIKE '%{$searchText}%')";
        }
        $qry = "SELECT tt.transaction_id, tt.trans_identifier, tt.user_id, tt.plan_id, tpp.star, tt.amount, tt.description, tt.payment_transaction_id, tt.os, tt.created_date, tt.payment_status, u.name, u.email
        FROM tbl_transaction tt
        INNER JOIN tbl_purchase_plan tpp ON tpp.plan_id = tt.plan_id
        INNER JOIN ( SELECT tu.user_id, tud.name, tu.email
                FROM `tbl_user` tu
                INNER JOIN `tbl_user_details` tud
                ON tud.user_id = tu.user_id
                AND tu.user_type = 'user' 
            UNION
            SELECT tu.user_id, tcd.name, tu.email
                FROM `tbl_user` tu
                INNER JOIN `tbl_contestant_details` tcd 
                ON tcd.user_id = tu.user_id
                AND tu.user_type = 'contestant') u 
                ON u.user_id = tt.user_id
        WHERE tt.status != 'deleted' {$like} {$order_by} {$offset_limit}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Update Transaction Data */
    public function deleteTransaction($transactionId){
        $qry = "UPDATE tbl_transaction SET status='deleted' WHERE transaction_id = ".$transactionId."";
        $result = $this->db->query($qry);
        return $result;
    }
}