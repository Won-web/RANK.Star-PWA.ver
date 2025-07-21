<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contest_Model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /*  login */

    public function listOfContest($searchText, $order_by, $sort_by, $offset, $limit)
    {
        $offset_limit = "";
        if (!empty($limit)) {
            $offset_limit = "LIMIT {$offset},{$limit}";
        }
        // $order_by = "{$order_by} {$sort_by}";
        
        $like = "";
        if (!empty($searchText)) {
            $like = " AND (t1.contest_name LIKE '%{$searchText}%' OR t1.vote_open_date LIKE '%{$searchText}%' OR t1.vote_close_date LIKE '%{$searchText}%')";
        }

        $sql = "SELECT t1.*, IFNULL((SELECT count(*) FROM tbl_contestant_mapping  tm INNER JOIN tbl_contestant_details t2 ON tm.contestant_id=t2.contestant_id WHERE t2.status != 'deleted' AND tm.contest_id = t1.contest_id),0) as user_count, 
        IFNULL((SELECT sum(vote) FROM tbl_voting WHERE contest_id = t1.contest_id), 0) as total_vote 
        FROM tbl_contest t1 
        WHERE t1.status != 'delete'
        {$like} ORDER BY t1.status='close',t1.status='preparing',t1.status='open',t1.created_date DESC,t1.contest_name ASC {$offset_limit}";

        $result = $this->db->query($sql);

        return $this->returnRows($result);
    }

    public function listOfContestantCount($searchText, $contestId)
    {
        $like = "";
        if (!empty($searchText)) {
            $like = " AND (tcd.name LIKE '%{$searchText}%' OR tc.contest_name LIKE '%{$searchText}%')";
        }

        $contestFilter = "";
        if (!empty($contestId)) {
            $contestFilter = " AND tc.contest_id = '{$contestId}'";
        }

        $sql = "
            SELECT COUNT(*) AS total
            FROM tbl_contestant_details tcd
            INNER JOIN tbl_contestant_mapping tcm ON tcd.contestant_id = tcm.contestant_id
            INNER JOIN tbl_contest tc ON tc.contest_id = tcm.contest_id
            WHERE tcd.status != 'deleted' {$like} {$contestFilter}
        ";

        $result = $this->db->query($sql);
        return $result->row_array();
    }

    public function addContest($contestData)
    {
        return $this->insert('tbl_contest', $contestData);
    }

    public function getContestant($contest_id)
    {
        $sql = "SELECT COUNT(tm.contestant_id) AS Total_contestant FROM tbl_contestant_mapping  tm INNER JOIN tbl_contestant_details t2 ON tm.contestant_id=t2.contestant_id WHERE t2.status != 'deleted' AND tm.contest_id={$contest_id}";
        $result = $this->db->query($sql);
        return $this->returnRows($result);
    }

    public function addMapping($mappingData)
    {
        return $this->insert('tbl_contestant_mapping', $mappingData);
    }
    
    public function getListOfContestant($contest_id)
    {
        // $sql="SELECT t1.contestant_id,t1.name FROM tbl_contestant_details t1 WHERE t1.contestant_id 
        // NOT IN (SELECT contestant_id FROM tbl_contestant_mapping WHERE contest_id !={$contest_id}) AND t1.status='active'
        // ";
        $sql = "SELECT t1.contestant_id,t1.name FROM tbl_contestant_details t1 WHERE t1.contestant_id 
        NOT IN (SELECT t2.contestant_id FROM tbl_contestant_mapping t2 INNER
 JOIN tbl_contest t3 ON t3.contest_id=t2.contest_id WHERE t2.contest_id !={$contest_id} AND t3.status != 'delete') AND t1.status='active'";
        $result = $this->db->query($sql);
       return $this->returnRows($result);
    }
   
}
