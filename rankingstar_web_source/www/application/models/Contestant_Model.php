<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contestant_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function listOfContestant($searchText, $order_by, $sort_by, $offset, $limit, $contestId)
    {
        
        if (!empty($contestId)) {
            $contestId = " AND (tcm.contest_id = {$contestId})";
        }
        $offset_limit = "";
        if (!empty($limit)) {
            $offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
        // $order_by = "ORDER BY CASE WHEN tc.status IS NULL THEN 1 ELSE 0 END, FIELD(tc.status, 'open', 'preparing', 'close'), tc.contest_name ASC, tc.created_date DESC, tcm.current_ranking ASC, tcd.name ASC";
        $like = "";
        if (!empty($searchText)) {
            $like = " AND (tc.contest_name LIKE '%{$searchText}%' OR tcd.name LIKE '%{$searchText}%')";
        }

        $sql = "SELECT tcd.contestant_id, tcd.user_id, tcd.name, tcm.contest_id, tcm.current_ranking, tc.contest_name, tcd.created_date, tcd.updated_date,  (select concat(thumb_image, '|', main_image) from tbl_contestant_details where contestant_id = tcd.contestant_id limit 1) as thumb_image,
            (SELECT IFNULL(SUM(vote), 0) 
            FROM tbl_voting 
                WHERE contestant_id = tcd.contestant_id 
                AND contest_id = tcm.contest_id ) as total_voting 
                FROM tbl_contestant_details tcd 
            LEFT JOIN tbl_contestant_mapping tcm 
                ON tcm.contestant_id = tcd.contestant_id 
            LEFT JOIN tbl_contest tc 
                ON tc.contest_id = tcm.contest_id 
                AND tc.status != 'delete'
            WHERE tcd.status != 'deleted' {$like}  {$contestId} {$order_by} {$offset_limit} ";
        $result = $this->db->query($sql);
        return $this->returnRows($result);
    }

	public function listOfContestantCount($searchText, $order_by, $sort_by, $offset, $limit, $contestId)
    {
        
        if (!empty($contestId)) {
            $contestId = " AND (tcm.contest_id = {$contestId})";
        }
        $offset_limit = "";
        if (!empty($limit)) {
            $offset_limit = "LIMIT {$offset},{$limit}";
        }
        $order_by = "ORDER BY {$order_by} {$sort_by}";
        // $order_by = "ORDER BY CASE WHEN tc.status IS NULL THEN 1 ELSE 0 END, FIELD(tc.status, 'open', 'preparing', 'close'), tc.contest_name ASC, tc.created_date DESC, tcm.current_ranking ASC, tcd.name ASC";
        $like = "";
        if (!empty($searchText)) {
            $like = " AND (tc.contest_name LIKE '%{$searchText}%' OR tcd.name LIKE '%{$searchText}%')";
        }

        $sql = "SELECT count(1) as total FROM tbl_contestant_details tcd 
            LEFT JOIN tbl_contestant_mapping tcm 
                ON tcm.contestant_id = tcd.contestant_id 
            LEFT JOIN tbl_contest tc 
                ON tc.contest_id = tcm.contest_id 
                AND tc.status != 'delete'
            WHERE tcd.status != 'deleted' {$like}  {$contestId} {$order_by} {$offset_limit} ";
        $result = $this->db->query($sql);
        return $this->returnRows($result);
    }


    public function addUser($userDetail){
        return $this->insert('tbl_user', $userDetail);
    }

    public function addGalleryDetail($galleryDetail){
        return $this->insert('tbl_gallary' , $galleryDetail);
    }

    public function addContestant($contestantData)
    {
        return $this->insert('tbl_contestant_details', $contestantData);
    }

    public function getContest(){
        $sql = "SELECT contest_id,contest_name FROM tbl_contest WHERE status !='close'";
        $result = $this->db->query($sql);
        return $this->returnRows($result);

    }

    public function addMappingDetail($mappingArr){
        return $this->insert('tbl_contestant_mapping' , $mappingArr);
    }

    public function getcontestant($contestant_id,$contest_id) {
        if($contest_id == "") {
            $sql = "SELECT t1.*,'' AS contest_id,'' AS contest_name,'' AS contest_status FROM tbl_contestant_details AS t1   WHERE t1.contestant_id='{$contestant_id}'";
        } else {
            $sql = "SELECT t1.*,tcc.contest_category_id,tcc.category_name,t3.contest_id,t3.contest_name,t3.status AS contest_status 
            FROM tbl_contestant_details AS t1 
            INNER JOIN tbl_contestant_mapping AS t2 ON t1.contestant_id = t2.contestant_id 
            INNER JOIN tbl_contest AS t3 ON t2.contest_id = t3.contest_id 
            LEFT JOIN tbl_contest_category AS tcc ON tcc.contest_category_id = t2.contest_category_id 
            WHERE t2.contestant_id='{$contestant_id}' AND t2.contest_id='{$contest_id}'";
        }
        $result = $this->db->query($sql);
        return $this->returnRows($result);
    }

    /**
     * For push notification
     */
    public function getContestantList($contestId) {
        $query = "SELECT tcd.contestant_id, tcd.user_id, tcd.name, tcm.contest_id, tcm.current_ranking, tc.contest_name
        FROM tbl_contestant_details tcd 
        LEFT JOIN tbl_contestant_mapping tcm ON tcm.contestant_id = tcd.contestant_id 
        LEFT JOIN tbl_contest tc ON tc.contest_id = tcm.contest_id 
        WHERE tcd.status !='deleted' AND tcm.contest_id = {$contestId}";
        $result = $this->db->query($query);
        return $this->returnRows($result);
    }
}
