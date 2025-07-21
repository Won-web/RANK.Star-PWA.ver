<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get Sales Data */
    public function getSalesData($searchText, $order_by, $sort_by, $offset, $limit){
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $group_by = "GROUP BY tsp.contest_id";
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE tsp.type = 'paid'";
        $like = "";
        if(!empty($searchText)){
            $like = " AND (tc.contest_name LIKE '%{$searchText}%')";
        }
        $qry = "SELECT tsp.contest_id, SUM(tsp.amount) as total_sales,((SUM(tsp.amount) * tc.fees_percent) - cost) as total_profit, tc.contest_name
                FROM tbl_star_purchase tsp
                INNER JOIN tbl_contest tc ON tc.contest_id = tsp.contest_id
                {$where} {$like} {$group_by}  {$offset_limit}";
        
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    public function getTotalSalesProfit($searchText){
        $group_by = "GROUP BY tsp.contest_id";
                $where = " WHERE  tsp.type =  'starshop' OR tsp.type='paid' OR tsp.type='coupon'";
        $like = "";
        if(!empty($searchText)){
            $like = " AND (tc.contest_name LIKE '%{$searchText}%')";
        }
        $qry = "SELECT IFNULL(SUM(total_sales), 0) total_sales, IFNULL(SUM(total_profit), 0) total_profit FROM(
        SELECT tsp.contest_id, SUM(tsp.amount) as total_sales,((SUM(tsp.amount) * tc.fees_percent) - cost) as total_profit, tc.contest_name
        FROM tbl_star_purchase tsp
        INNER JOIN tbl_contest tc ON tc.contest_id = tsp.contest_id
        {$where} {$like} {$group_by}
        ) tmp";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }
    
    /* Get Sales Details Data */
    // public function getSalesDetails($contest_id, $from_date, $to_date, $order_by, $sort_by, $offset, $limit){
    //     $offset_limit = "";
    //     if(! empty($limit))
	// 	{
	// 		$offset_limit = "LIMIT {$offset},{$limit}";
    //     }
    //     $order_by = "ORDER BY {$order_by} {$sort_by}";
    //     $where = " WHERE tsp.contest_id = {$contest_id}  AND tsp.type = 'paid'";
    //     if(!empty($from_date) && !empty($to_date))
	// 	{
	// 		$where .= " AND (tsp.purchase_date >= '{$from_date}' AND tsp.purchase_date <= '{$to_date}')";
    //     }
    //     $qry = "SELECT tsp.contest_id, tsp.amount, tsp.refund, tsp.purchase_date, tsp.description, tu.email
    //             FROM tbl_star_purchase tsp
    //             INNER JOIN tbl_user tu ON tu.user_id = tsp.user_id
    //             {$where} {$order_by} {$offset_limit}";
        
    //     $result = $this->db->query($qry);
    //     return $this->returnRows($result);
    // }

    /* Get Sales Details Data */
    public function getSalesDetails($from_date, $to_date, $amountType, $searchText, $order_by, $sort_by, $offset, $limit) {
        $offset_limit = "";
        $fields = "tsp.user_id, '' as name, u.email, tsp.description, tsp.star, tsp.amount, tsp.created_date, tsp.refund";
        if(!empty($limit)){
			$offset_limit = "LIMIT {$offset},{$limit}";
        }else{
            $fields = "count(*) as total_records, IFNULL(SUM(tsp.amount), 0) total_sales, 
            IFNULL(SUM(tsp.refund), 0) total_refund";
        }
        $order_by = " ORDER BY {$order_by} {$sort_by}";
        //$where = "WHERE tsp.type =  'starshop' OR tsp.type='paid'";
        // $where = "WHERE tsp.type IN('free','paid','signup','daily','gift','starshop','coupon')";
        $where = "WHERE tsp.type IN('paid','free', 'starshop') AND u.user_type = 'user'";
        if(!empty($from_date) && !empty($to_date))
		{
			$where .= " AND (tsp.purchase_date >= '{$from_date}' AND tsp.purchase_date <= '{$to_date}')";
        }
        if(!empty($amountType)) {
            $where .= " AND (tsp.type = '{$amountType}')";
        }
        $like = "";
        // if(!empty($searchText)) {
        //     $like = " AND (tsp.star LIKE '%{$searchText}%'
        //         OR tsp.amount LIKE '%{$searchText}%'
        //         OR tsp.refund LIKE '%{$searchText}%'
        //         OR u.name LIKE '%{$searchText}%'
        //         OR u.email LIKE '%{$searchText}%')";
        // }
        if(!empty($searchText)) {
            $like = " AND (tsp.star LIKE '%{$searchText}%'
                OR tsp.amount LIKE '%{$searchText}%'
                OR tsp.refund LIKE '%{$searchText}%'
                OR u.email LIKE '%{$searchText}%')";
        }
        // $qry = "SELECT {$fields}
        // FROM tbl_star_purchase tsp
        // INNER JOIN (
        //     SELECT tu.user_id, tud.name, tu.email
        //         FROM `tbl_user` tu
        //         INNER JOIN `tbl_user_details` tud
        //         ON tud.user_id = tu.user_id
        //         AND tu.user_type = 'user' 
        //     UNION
        //     SELECT tu.user_id, tcd.name, tu.email
        //         FROM `tbl_user` tu
        //         INNER JOIN `tbl_contestant_details` tcd 
        //         ON tcd.user_id = tu.user_id
        //         AND tu.user_type = 'contestant' 
        // ) u 
        // ON tsp.user_id = u.user_id {$where} {$like} {$order_by} {$offset_limit}";

        $qry = "SELECT {$fields}
        FROM tbl_star_purchase tsp
        INNER JOIN `tbl_user` u ON u.user_id = tsp.user_id
        -- INNER JOIN `tbl_user_details` tud ON tud.user_id = tsp.user_id
        {$where} {$like} {$order_by} {$offset_limit}";
        $result = $this->db->query($qry)->result_array();
        return $result;
        // return $this->returnRows($result);
    }

    public function getSalesDetailsTotal($from_date, $to_date, $amountType, $searchText, $order_by, $sort_by, $offset, $limit) {
        $offset_limit = "";
        $fields = "count(tsp.purchase_id) as total_records, IFNULL(SUM(tsp.amount), 0) total_sales, IFNULL(SUM(tsp.refund), 0) total_refund";
        $where = "WHERE u.user_type = 'user'";
        if(!empty($from_date) && !empty($to_date))
		{
			$where .= " AND (tsp.purchase_date >= '{$from_date}' AND tsp.purchase_date <= '{$to_date}')";
        }
        if(!empty($amountType)) {
            $where .= " AND (tsp.type = '{$amountType}')";
        }else{
            $where .= " AND tsp.type IN('paid','free', 'startshop')";
        }
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (tsp.star LIKE '%{$searchText}%'
                OR tsp.amount LIKE '%{$searchText}%'
                OR tsp.refund LIKE '%{$searchText}%'
                OR u.email LIKE '%{$searchText}%')";
        }

        $qry = "SELECT {$fields}
        FROM tbl_star_purchase tsp
        INNER JOIN `tbl_user` u ON u.user_id = tsp.user_id
        {$where} {$like}";
        $result = $this->db->query($qry)->result_array();
        return $result;
    }

    public function getTotalSalesRefund($from_date, $to_date, $searchText, $order_by, $sort_by, $offset, $limit) {
        // $where = " WHERE tsp.type =  'starshop' OR tsp.type='paid'";
        $where = "WHERE tsp.type IN('free','paid','signup','daily','gift','starshop','coupon')";
        if(!empty($from_date) && !empty($to_date))
        {
            $where .= " AND (tsp.purchase_date >= '{$from_date}' AND tsp.purchase_date <= '{$to_date}')";
        }
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (tsp.star LIKE '%{$searchText}%'
                OR tsp.amount LIKE '%{$searchText}%'
                OR tsp.refund LIKE '%{$searchText}%'
                OR u.email LIKE '%{$searchText}%')";
        }
        $qry = "SELECT IFNULL(SUM(tsp.amount), 0) total_sales, 
        IFNULL(SUM(tsp.refund), 0) total_refund
        FROM tbl_star_purchase tsp
        {$where} {$like}";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }
}