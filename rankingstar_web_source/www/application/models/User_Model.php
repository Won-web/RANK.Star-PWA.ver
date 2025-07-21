<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /* Get User Data */
    public function getUserData($searchText, $order_by, $sort_by, $offset, $limit) {
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = " ORDER BY  {$order_by} {$sort_by}";
		$where = " WHERE tu.user_type = 'user' AND tu.user_status != 'deleted'";
        $like = "";
        $like2 = "";
        if(!empty($searchText)) {
            $like = " AND (tu.email LIKE '%{$searchText}%' OR tu.mobile LIKE '%{$searchText}%' OR tud.name LIKE '%{$searchText}%')";
            $like2 = " AND (t3.email LIKE '%{$searchText}%' OR t3.mobile LIKE '%{$searchText}%' OR tcd.name LIKE '%{$searchText}%')";
        }
        // $qry = "SELECT tu.user_id, tu.email, tu.mobile, tu.user_status, tu.register_date_time, tud.name
        //         FROM tbl_user tu
        //         INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id
        //         {$where} {$like} {$order_by} {$offset_limit}";

        $qry = "SELECT tu.user_id as user_id, tu.email as email, tu.mobile as mobile, tu.user_status as user_status, tu.register_date_time as register_date_time, tud.name as name
        FROM tbl_user tu
        INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id   WHERE tu.user_type = 'user' AND tu.user_status != 'deleted' {$like}
        UNION SELECT tcd.user_id as user_id,t3.email as email,t3.mobile as mobile,t3.user_status as user_status,t3.register_date_time as register_date_time,tcd.name as name  FROM tbl_contestant_details tcd 
        INNER JOIN tbl_user t3 ON tcd.user_id=t3.user_id WHERE t3.user_type = 'contestant' AND t3.user_status != 'deleted' AND tcd.status != 'deleted'  {$like2}  {$order_by} {$offset_limit}";
        // print_r($qry);die;
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    public function getAdminManagerData($searchText, $order_by, $sort_by, $offset, $limit) {
                
        $this->db->select("tu.user_id, tu.mobile, tu.user_status, tu.register_date_time, tud.name, tu.email, tu.user_type");
        $this->db->from("tbl_user tu");
        $this->db->join("tbl_user_details tud", "tu.user_id = tud.user_id", "INNER");
        $this->db->where_in('tu.user_type', array('admin','manager'));
        $this->db->where('tu.user_status !=','deleted');
        $this->db->order_by($order_by, $sort_by);
        if(!empty($searchText)){
            $searchArray = array('tu.email' => $searchText, 'tu.mobile' => $searchText, 'tud.name' => $searchText);
            $this->db->or_like($searchArray);
        }
        if(! empty($limit)){
            $this->db->limit($limit, $offset);
        }
        $result = $this->db->get();
        return $result->result_array();
        
        // $offset_limit = "";
        // if(! empty($limit))
		// {
		// 	$offset_limit = "LIMIT {$offset},{$limit}";
        // }
        // $order_by = " ORDER BY  {$order_by} {$sort_by}";
		// $where = " WHERE tu.user_type IN ('admin','manager') AND tu.user_status != 'deleted'";
        // $like = "";
        // if(!empty($searchText)) {
        //     $like = " AND (tu.email LIKE '%{$searchText}%' OR tu.mobile LIKE '%{$searchText}%' OR tud.name LIKE '%{$searchText}%')";
        // }

        // $qry = "SELECT tu.user_id as user_id, tu.email as email, tu.mobile as mobile, tu.user_status as user_status, tu.register_date_time as register_date_time, tud.name as name
        // FROM tbl_user tu
        // INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id   WHERE tu.user_type = 'user' AND tu.user_status != 'deleted' {$like}
        // UNION SELECT tcd.user_id as user_id,t3.email as email,t3.mobile as mobile,t3.user_status as user_status,t3.register_date_time as register_date_time,tcd.name as name  FROM tbl_contestant_details tcd 
        // INNER JOIN tbl_user t3 ON tcd.user_id=t3.user_id WHERE t3.user_type = 'contestant' AND t3.user_status != 'deleted' AND tcd.status != 'deleted'  {$like2}  {$order_by} {$offset_limit}";
        // // print_r($qry);die;
        // $result = $this->db->query($qry);
        // return $this->returnRows($result);
    }

    /* Get User Details */
    public function getUserDetails($user_id){
        // var_dump($user_id);die;
        // $qry = "SELECT tu.user_id, tu.email, tu.mobile, tud.name, tud.nick_name, tu.user_status, tu.login_type, tu.user_type
        //         FROM tbl_user tu
        //         INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id
        //         WHERE tu.user_id = {$user_id}";
      $qry =  "SELECT tu.user_id as user_id, tu.email as email, tu.mobile as mobile, tud.name as name, tud.nick_name as nick_name, tu.user_status as user_status,
         tu.login_type login_type, tu.user_type as user_type, tu.device_id as device_id, tu.ip_addr as ip_addr,
            tu.register_date_time as register_date_time, tu.update_date_time as update_date_time, tu.last_access_date as last_access_date
                FROM tbl_user tu
                INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id
                WHERE tu.user_id = $user_id
                UNION SELECT tcd.user_id as user_id , t3.email as email,t3.mobile
                 as mobile,tcd.name as name,tcd.nick_name as nick_name,t3.device_id as device_id, t3.update_date_time as update_date_time,
                 t3.ip_addr as ip_addr, t3.register_date_time as register_date_time, t3.last_access_date as last_access_date,
                 t3.user_status as user_status,t3.login_type as login_type,t3.user_type as user_type
    FROM tbl_contestant_details as tcd INNER JOIN  tbl_user t3 ON tcd.user_id = t3.user_id  WHERE t3.user_id = $user_id";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    /* Get User Purchase Data */
    public function getUserPurchaseData($user_id, $searchText, $order_by, $sort_by, $offset, $limit){
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE tsp.user_id = {$user_id}";
        $like = "";
        if(!empty($searchText)){
            $like = " AND (tsp.description LIKE '%{$searchText}%' OR tsp.purchase_date LIKE '%{$searchText}%' OR tsp.type LIKE '%{$searchText}%' OR tsp.star LIKE '%{$searchText}%')";
        }
        // $qry = "SELECT tsp.purchase_id, tsp.star, tsp.description, tsp.type, tsp.purchase_date
        //         FROM tbl_star_purchase tsp
        //         {$where}  {$like} ORDER BY tsp.created_date DESC  {$offset_limit}";

        $qry = "SELECT tsp.purchase_id, tsp.star, tsp.description, tsp.type, tsp.purchase_date,(CASE WHEN tcd.name IS NULL THEN tud.name ELSE tcd.name END) AS reciever_name,
        (CASE WHEN t8.name IS NULL THEN t7.name ELSE t8.name END) AS sender_name
                        FROM tbl_star_purchase tsp LEFT JOIN tbl_gift_star tgs ON tsp.gift_id=tgs.gift_id
                        LEFT JOIN tbl_user_details tud ON tgs.receiver_id=tud.user_id
                        LEFT JOIN tbl_contestant_details tcd ON tcd.user_id = tgs.receiver_id 
                        LEFT JOIN tbl_user_details t7 ON tgs.sender_id = t7.user_id
                        LEFT JOIN tbl_contestant_details t8 ON t8.user_id= tgs.sender_id
                        WHERE tsp.user_id='{$user_id}' {$like} ORDER BY tsp.created_date DESC  {$offset_limit}";
        
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Total of Purchase Data */
    public function getTotalPurchase($user_id, $searchText){
        $where = " WHERE tsp.user_id = {$user_id}";
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (tsp.description LIKE '%{$searchText}%' OR tsp.purchase_date LIKE '%{$searchText}%' OR tsp.type LIKE '%{$searchText}%' OR tsp.star LIKE '%{$searchText}%')";
        }
        $qry = "SELECT tsp.user_id, IFNULL(SUM(tsp.star), 0) as total_purchase
        FROM tbl_star_purchase tsp
        {$where} {$like}";
     
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    /* Get User Vote Data */
    public function getUserVoteData($user_id, $searchText, $order_by, $sort_by, $offset, $limit){
        $offset_limit = "";
        if(! empty($limit))
		{
			$offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
		$where = " WHERE tv.voter_id = {$user_id}";
        $like = "";
        if(!empty($searchText)){
            $like = " AND (tv.description LIKE '%{$searchText}%' OR tc.contest_name LIKE '%{$searchText}%' OR tcd.name LIKE '%{$searchText}%' OR tv.vote LIKE '%{$searchText}%' OR tv.vote_date LIKE '%{$searchText}%')";
        }
        // $qry = "SELECT tv.vote_id, tv.description, tv.vote, tv.vote_date, tc.contest_name, tcd.name
        //         FROM tbl_voting tv
        //         LEFT JOIN tbl_contest tc ON tc.contest_id = tv.contest_id
        //         LEFT JOIN tbl_contestant_details tcd ON tcd.contestant_id = tv.contestant_id
        //         {$where} {$like} {$order_by} {$offset_limit}";
        $qry = "SELECT tv.vote AS vote, tv.description,tv.vote_date AS vote_date,(CASE WHEN tcd.name IS NULL THEN tud.name ELSE tcd.name END ) as receiver_name,tc.contest_name FROM tbl_voting tv 
        LEFT JOIN tbl_contestant_details tcd ON tcd.contestant_id=tv.contestant_id 
         LEFT JOIN tbl_user_details tud ON tud.user_id = tv.contestant_id INNER JOIN tbl_contest tc ON tc.contest_id=tv.contest_id
          WHERE tv.voter_id={$user_id}  UNION
           SELECT t1.star as vote,
           t1.description,t1.gift_date As vote_date,( CASE WHEN tcd.name IS NULL THEN tu.name ELSE tcd.name END ) AS receiver_name,
            ('') AS contest_name FROM tbl_gift_star AS t1
          LEFT JOIN tbl_contestant_details tcd ON t1.receiver_id=tcd.contestant_id
     LEFT JOIN tbl_user_details tu ON t1.receiver_id=tu.user_id WHERE t1.sender_id={$user_id} {$like}  ORDER BY vote_date DESC {$offset_limit}";
        
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Total Usage */
    public function getTotalUsage($user_id, $searchText) {
        $where = " WHERE tv.voter_id = {$user_id}";
        $like = "";
        if(!empty($searchText)) {
            $like = " AND (tv.description LIKE '%{$searchText}%' OR tc.contest_name LIKE '%{$searchText}%' OR tcd.name LIKE '%{$searchText}%' OR tv.vote LIKE '%{$searchText}%' OR tv.vote_date LIKE '%{$searchText}%')";
        }
        // $qry = "SELECT tv.voter_id, SUM(tv.vote) as total_usage,
        // FROM tbl_voting tv
        // LEFT JOIN tbl_contest tc ON tc.contest_id = tv.contest_id
        // LEFT JOIN tbl_contestant_details tcd ON tcd.contestant_id = tv.contestant_id
   
        // {$where} {$like}";
        $qry = "SELECT SUM(total_usage) As total_usage FROM (SELECT SUM(tv.vote) as total_usage
        FROM tbl_voting tv
        LEFT JOIN tbl_contest tc ON tc.contest_id = tv.contest_id 
        LEFT JOIN tbl_contestant_details tcd ON tcd.contestant_id = tv.contestant_id WHERE  tv.voter_id={$user_id}
        UNION SELECT SUM(tg.star) AS total_usage FROM tbl_gift_star tg
       LEFT JOIN tbl_contestant_details tcd ON tg.receiver_id=tcd.contestant_id
        LEFT JOIN tbl_user_details tu ON tg.receiver_id=tu.user_id 
         WHERE  tg.sender_id={$user_id}) tmp";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }
}
