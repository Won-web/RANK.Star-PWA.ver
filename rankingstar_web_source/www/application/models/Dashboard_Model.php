<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();

    }

    /* Get Contest By Status */
    public function getContestByStatus($status){
        $qry = "SELECT tc.contest_id, tc.contest_name, tc.status, IFNULL((SELECT count(*) FROM tbl_contestant_mapping t1 INNER JOIN tbl_contestant_details t2 ON t1.contestant_id=t2.contestant_id   WHERE t1.contest_id = tc.contest_id AND t2.status != 'deleted'), 0) as contestant_count
                FROM tbl_contest tc 
                WHERE tc.status ='{$status}'   ORDER BY tc.created_date DESC";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get User Count  OLD*/
    // public function getUserCount(){
    //     $qry = "SELECT count(*) as user_count FROM tbl_user WHERE user_type IN ('user','contestant')
    //     AND user_status != 'deleted'";
    //     return $this->db->query($qry)->row_array();   
    // }

    /* Get User Count  NEW V1*/
//     public function getUserCount(){
//         $qry = "SELECT count(tu.user_id) as user_count, tu.user_id as user_id, tu.email as email, tu.mobile as mobile, tu.user_status as user_status, tu.register_date_time as register_date_time, tud.name as name
//         FROM tbl_user tu
//         INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id   WHERE tu.user_type = 'user' AND tu.user_status != 'deleted' 
//         UNION SELECT count(tcd.user_id) as user_count, tcd.user_id as user_id,t3.email as email,t3.mobile as mobile,t3.user_status as user_status,t3.register_date_time as register_date_time,tcd.name as name  FROM tbl_contestant_details tcd 
//         INNER JOIN tbl_user t3 ON tcd.user_id=t3.user_id WHERE t3.user_type = 'contestant' AND t3.user_status != 'deleted' AND tcd.status != 'deleted' ";
//         return $this->db->query($qry)->result_array();   
//    }

    /* Get User Count  NEW V2*/
    public function getUserCount(){
        $qry = "SELECT count(tu.user_id) as user_count FROM tbl_user tu
        INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id WHERE tu.user_type = 'user' AND tu.user_status != 'deleted' 
        UNION SELECT count(tcd.user_id) as user_count FROM tbl_contestant_details tcd 
        INNER JOIN tbl_user t3 ON tcd.user_id=t3.user_id WHERE t3.user_type = 'contestant' AND t3.user_status != 'deleted' AND tcd.status != 'deleted' ";
        return $this->db->query($qry)->result_array();   
   }

    public function getSalesByFilter($filter = "today"){
        $result = array();
        $currentDate = date('Y-m-d');
        if($filter == "total"){
            $qry = "SELECT IFNULL(SUM(tsp.amount), 0) as total_sales 
            FROM tbl_star_purchase tsp
            INNER JOIN `tbl_user` u ON u.user_id = tsp.user_id AND u.user_type = 'user'
            WHERE  tsp.type = 'paid' ";
            // print_r($qry);die;
            $result = $this->db->query($qry)->row_array();   
        }elseif($filter == "month"){
            $qry = "SELECT IFNULL(SUM(tsp.amount), 0) as total_sales 
            FROM tbl_star_purchase tsp
            INNER JOIN `tbl_user` u ON u.user_id = tsp.user_id AND u.user_type = 'user'
            WHERE  tsp.type = 'paid' AND MONTH(purchase_date) = MONTH('{$currentDate}')
            AND YEAR(purchase_date) = YEAR('{$currentDate}')";
            $result = $this->db->query($qry)->row_array();   
        }elseif($filter == "today"){
            $qry = "SELECT IFNULL(SUM(tsp.amount), 0) as total_sales 
            FROM tbl_star_purchase tsp
            INNER JOIN `tbl_user` u ON u.user_id = tsp.user_id AND u.user_type = 'user'
            WHERE  tsp.type = 'paid' AND purchase_date = '{$currentDate}'";
            $result = $this->db->query($qry)->row_array(); 
        }
        return $result;
    }
    
    /////////// New V1 //
   //public function getSalesInCalendar(){
    	//$currentDate = date('Y-m-d');
    	//$qry = "SELECT IFNULL(SUM(tsp.amount), 0) as amount, tsp.purchase_date 
           // FROM tbl_star_purchase tsp
           // INNER JOIN `tbl_user` u ON u.user_id = tsp.user_id AND u.user_type = 'user'
          //  WHERE  tsp.type = 'paid' AND MONTH(purchase_date) = MONTH('{$currentDate}')
          //  AND YEAR(purchase_date) = YEAR('{$currentDate}') GROUP BY purchase_date";
            
            // $result = $this->db->query($qry)->result_array(); 
           //  return $result;
             //return array();  
   // }

///// OLD //////

   // public function getSalesInCalendar(){
        //$currentDate = date('Y-m-d');
        //$qry = "SELECT IFNULL(SUM(amount), 0) as amount, purchase_date FROM tbl_star_purchase 
       // WHERE  (type = 'paid' OR type='free') GROUP BY purchase_date";
       // $result = $this->db->query($qry)->result_array(); 
        // print_r($result);die;
       // return $result;
      // return array();
    //}
    
   ////////// NEW V2///////////
    public function getSalesInCalendar(){
        $qry = "SELECT IFNULL(SUM(amount), 0) as amount, purchase_date FROM tbl_star_purchase 
        INNER JOIN `tbl_user` u ON u.user_id = tbl_star_purchase.user_id AND u.user_type = 'user'
        WHERE  tbl_star_purchase.type = 'paid'  GROUP BY purchase_date";
        $result = $this->db->query($qry)->result_array(); 
        // print_r($result);die;
        return $result;
    }
}
