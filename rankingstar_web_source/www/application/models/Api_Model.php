<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_Model extends MY_Model
{

    public function __construct()
    {
        parent::__construct();
        
    }

    /* Login */
    public function checkLogin($email, $password, $login_type)
    {
        if ($login_type === "auth") {
            $userType = ['user', 'contestant'];
            return $this->db->select('*')
                ->where('email', $email)
                ->where('password', md5($password))
                ->where('login_type', 'auth')
                ->where('user_status', 'active')
                ->where_in('user_type', $userType)
                ->get('tbl_user')->row_array();
        } else {
            return false;
        }

    }

    /* Get End User Profile */
    public function getUserProfileDetails($user_id)
    {
        return $this->db->select("tu.user_id, tu.email, tu.mobile, tu.user_type, tu.is_autologin, tu.social_id, tu.login_type, tud.name, tud.nick_name, IF(IFNULL(tud.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tud.main_image)) as main_image")
            ->join('tbl_user_details tud', 'tud.user_id = tu.user_id', 'INNER')
            ->where('tu.user_id', $user_id)
            ->get('tbl_user tu')->row_array();
    }

    /* Get Contestant Profile */
    public function getContestantProfileDetails($user_id)
    {
        return $this->db->select("tu.user_id, tu.email, tu.mobile, tu.user_type, tu.is_autologin, tu.social_id, tu.login_type, tcd.name, tcd.nick_name, IF(IFNULL(tcd.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tcd.main_image)) as main_image, IF(IFNULL(tcd.thumb_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tcd.thumb_image)) as thumb_image")
            ->join('tbl_contestant_details tcd', 'tcd.user_id = tu.user_id', 'INNER')
            ->where('tu.user_id', $user_id)
            ->get('tbl_user tu')->row_array();
    }
    /* Get Banner List */
    public function getBannerList()
    {
        $qry = "SELECT contest_id,show_main_banner, contest_name, IF(IFNULL(main_banner, '') = '', '' , CONCAT('" . CON_CONTEST_URL . "',main_banner)) as main_banner FROM tbl_contest WHERE status NOT IN ('close','delete') AND show_main_banner = 'true'";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Contest List */
    public function getContestList($page, $searchText = '')
    {
        $offset = ($page - 1) * CON_APP_PAGE_LIMIT;
        $limit = " LIMIT $offset, " . CON_APP_PAGE_LIMIT;
        $where = " WHERE status != 'delete' AND hide_contest = 'Show'";
        if ($searchText) {
            $where = " AND contest_name LIKE '%$searchText%'";
        }
        $qry = "SELECT *, IF(IFNULL(main_banner, '') = '', '' , CONCAT('" . CON_CONTEST_URL . "',main_banner)) as main_banner, IF(IFNULL(sub_banner, '') = '', '' , CONCAT('" . CON_CONTEST_URL . "',sub_banner)) as sub_banner FROM tbl_contest" . $where . "ORDER BY status='close',status='preparing',status='open',created_date DESC,contest_name ASC". $limit;
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Sub Banner Image */
    public function getSubBannerImage($contest_id)
    {
        $qry = "SELECT IF(IFNULL(sub_banner, '') = '', '' , CONCAT('" . CON_CONTEST_URL . "',sub_banner)) as sub_banner FROM tbl_contest WHERE contest_id = {$contest_id}";
        $result = $this->db->query($qry);
        return $result->row_array();
    }

    /* Get Contest Details */
    public function getContestDetailsById($contest_id)
    {
        $qry = "SELECT tc.*,IFNULL(SUM(tv.vote), 0) as total_vote, IF(IFNULL(tc.main_banner, '') = '', '' , CONCAT('" . CON_CONTEST_URL . "', tc.main_banner)) as main_banner, IF(IFNULL(tc.sub_banner, '') = '', '' , CONCAT('" . CON_CONTEST_URL . "', tc.sub_banner)) as sub_banner FROM tbl_contest tc LEFT JOIN tbl_voting tv ON tv.contest_id = tc.contest_id WHERE tc.contest_id = {$contest_id}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }
 
    /* Get Contestant Ranking */
    public function getContestantRankingByContest($params) {
        $qry = "SELECT tcd.contestant_id, tcd.name , IFNULL(SUM(tv.vote), 0) as total_vote, IF(IFNULL(tcd.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "', tcd.main_image)) as main_image, IF(IFNULL(tcd.thumb_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "', tcd.thumb_image)) as thumb_image,  tcm.current_ranking, tcm.previous_ranking, tcm.contest_id, tcm.contest_category_id
                FROM tbl_contestant_details tcd 
                INNER JOIN tbl_contestant_mapping tcm ON tcm.contestant_id = tcd.contestant_id 
                LEFT JOIN tbl_voting tv ON tv.contestant_id = tcm.contestant_id  AND tv.contest_id = tcm.contest_id
                WHERE tcm.contest_id = {$params['contest_id']} AND tcd.status != 'deleted'
                GROUP BY tcm.contestant_id
                ORDER BY total_vote DESC, tcm.current_ranking ASC , tcd.name ASC";
        
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    public function getCategoryItems($contest_id)
    {
        $query = "SELECT tc.contest_category_id, tc.contest_id, tc.category_name, tc.status
                    FROM tbl_contest_category tc
                    WHERE tc.status = 'active' AND tc.contest_id = {$contest_id}";
        $result = $this->db->query($query);
        return $this->returnRows($result);
    }

    /* Get Contestant Details */
    public function getContestantDetailsById($contestant_id, $contest_id){
        $qry = "SELECT tcd.*, tcd.name , IFNULL(SUM(tv.vote), 0) as total_vote, IF(IFNULL(tcd.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "', tcd.main_image)) as main_image, IF(IFNULL(tcd.thumb_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "', tcd.thumb_image)) as thumb_image, IFNULL(tcm.current_ranking, 0) as current_ranking, IFNULL(tcm.previous_ranking, 0) as previous_ranking, IFNULL(tcm.contest_id, 0) as contest_id, tc.contest_name,tc.status AS contest_status
                FROM tbl_contestant_details tcd 
                INNER JOIN tbl_contestant_mapping tcm ON tcm.contestant_id = tcd.contestant_id 
                INNER JOIN tbl_contest tc ON tcm.contest_id = tc.contest_id
                LEFT JOIN tbl_voting tv ON tv.contestant_id = tcm.contestant_id  AND tv.contest_id = tcm.contest_id
                WHERE tcm.contest_id = {$contest_id} AND tcm.contestant_id = {$contestant_id}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Media By Contestant */
    public function getMediaById($key, $value){
        // $qry = "SELECT *, IF(IFNULL(media_path, '') = '', '' , CONCAT('" . CON_GALLARY_URL . "', media_path)) as media_path, IF(IFNULL(thumb_path, '') = '', '' , CONCAT('" . CON_GALLARY_THUMB_URL . "', thumb_path)) as thumb_path 
        // FROM tbl_gallary
        // WHERE status = 'active' AND {$key}= {$value}";
        $qry = "SELECT t1.media_id,t1.contestant_id,t1.media_name,(CASE  WHEN t1.media_type='youtube' THEN t1.media_path ELSE  CONCAT('".CON_GALLARY_URL."', media_path) END) AS media_path,t1.media_type,(CASE  WHEN t1.media_type='youtube' THEN t1.thumb_path ELSE CONCAT('". CON_GALLARY_THUMB_URL ."',thumb_path) END) AS thumb_path,t1.media_type,t1.status,t1.created_date,t1.updated_date
        FROM tbl_gallary t1
        WHERE status = 'active' AND {$key}= {$value}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Comment List */
    public function getCommentByContestant($contestant_id){
        $qry = "SELECT tc.*, (SELECT count(*) FROM tbl_comment_like WHERE comment_id = tc.comment_id) as like_count
                FROM tbl_comment tc
                WHERE tc.contestant_id = {$contestant_id}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Voting History List */
    public function getVotingHistory($contestant_id, $contest_id){

        //Client want nick name as display name so temporary created alias of nick_name as name
        $qry = "SELECT *,(@row_number:=@row_number + 1) AS ranking FROM(SELECT tv.voter_id, SUM(tv.vote) as vote, tu.user_type, tud.nick_name as name, tud.nick_name, IF(IFNULL(tud.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "', tud.main_image)) as main_image
                FROM tbl_voting tv
                INNER JOIN tbl_user tu ON tu.user_id = tv.voter_id AND tu.user_type = 'user' AND tv.contest_id = {$contest_id} AND tv.contestant_id = {$contestant_id}
                INNER JOIN tbl_user_details tud ON tud.user_id = tu.user_id GROUP BY tv.voter_id
                UNION
                SELECT tv.voter_id, SUM(tv.vote) as vote, tu.user_type,tcd.nick_name as name, tcd.nick_name, IF(IFNULL(tcd.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "', tcd.main_image)) as main_image
                FROM tbl_voting tv
                INNER JOIN tbl_user tu ON tu.user_id = tv.voter_id AND tu.user_type = 'contestant' AND tv.contest_id = {$contest_id} AND tv.contestant_id = {$contestant_id}
                INNER JOIN tbl_contestant_details tcd ON tcd.user_id = tu.user_id GROUP BY tv.voter_id) tmp ORDER BY vote DESC LIMIT 0,50";
        $setQry = "SET @row_number = 0";
        $this->db->query($setQry);
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Star Usage List */
    public function getStarUsage($user_id){
        // $qry = "SELECT tv.*, tcd.name, tc.contest_name
        //         FROM tbl_voting tv
        //         INNER JOIN tbl_contestant_details tcd ON tv.contestant_id = tcd.contestant_id
        //         INNER JOIN tbl_contest tc ON tc.contest_id = tv.contest_id
        //         WHERE tv.voter_id = {$user_id}";
    //     $qry="SELECT tv.contestant_id AS receiver_id,tv.voter_id As sender_id,tv.vote AS star, tv.description,tv.vote_date AS date,tv.contest_id,tcd.name as receiver_name,tc.contest_name, ('vote')AS type FROM tbl_voting tv 
    //     INNER JOIN tbl_contestant_details tcd ON tcd.contestant_id=tv.contestant_id INNER JOIN tbl_contest tc ON tc.contest_id=tv.contest_id
    //      WHERE tv.voter_id={$user_id}  UNION
    //       SELECT t1.receiver_id AS receiver_id,t1.sender_id As sender_id,t1.star as star,
    //       t1.description,t1.gift_date As date,('') As contest_id, ( CASE WHEN tcd.name IS NULL THEN tu.name ELSE tcd.name END ) AS receiver_name,
    //        ('') AS contest_name,('gift') As type FROM tbl_gift_star AS t1
    //      LEFT JOIN tbl_contestant_details tcd ON t1.receiver_id=tcd.contestant_id
    // LEFT JOIN tbl_user_details tu ON t1.receiver_id=tu.user_id WHERE t1.sender_id={$user_id} ORDER BY date DESC";
    $qry = "SELECT tv.contestant_id AS receiver_id,tv.voter_id As sender_id,tv.vote AS star, tv.description,tv.vote_date AS date,tv.contest_id,(CASE WHEN tcd.name IS NULL THEN tud.name ELSE tcd.name END ) as receiver_name,tc.contest_name, ('vote')AS type FROM tbl_voting tv 
    LEFT JOIN tbl_contestant_details tcd ON tcd.contestant_id=tv.contestant_id 
     LEFT JOIN tbl_user_details tud ON tud.user_id = tv.contestant_id INNER JOIN tbl_contest tc ON tc.contest_id=tv.contest_id
      WHERE tv.voter_id={$user_id}  UNION
       SELECT t1.receiver_id AS receiver_id,t1.sender_id As sender_id,t1.star as star,
       t1.description,t1.gift_date As date,('') As contest_id, ( CASE WHEN tcd.name IS NULL THEN tu.name ELSE tcd.name END ) AS receiver_name,
        ('') AS contest_name,('gift') As type FROM tbl_gift_star AS t1
      LEFT JOIN tbl_contestant_details tcd ON t1.receiver_id=tcd.user_id
 LEFT JOIN tbl_user_details tu ON t1.receiver_id=tu.user_id WHERE t1.sender_id={$user_id} ORDER BY date DESC";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Purchase History */
    public function getPurchaseHistory($user_id){
        // $qry = "SELECT tsp.*, IFNULL(tc.contest_name, '') as contest_name
        // FROM tbl_star_purchase tsp
        // LEFT JOIN tbl_contest tc ON tc.contest_id = tsp.contest_id
        // WHERE tsp.user_id = {$user_id}";
        $qry = "SELECT tsp.*, IFNULL(tc.contest_name, '') as contest_name,IFNULL((CASE WHEN tud.name IS NULL THEN tcd.name ELSE tud.name END),'') as Sender_name
        FROM tbl_star_purchase tsp
        LEFT JOIN tbl_contest tc ON tc.contest_id = tsp.contest_id
        LEFT JOIN tbl_gift_star tgs ON tgs.gift_id= tsp.gift_id
        LEFT JOIN tbl_contestant_details tcd ON tcd.user_id = tgs.sender_id
        LEFT JOIN tbl_user_details tud ON tud.user_id = tgs.sender_id
    WHERE tsp.user_id = {$user_id} ORDER BY  tsp.created_date DESC";
       
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Available Star */
    public function getAvailableStarCount($user_id) {
        //If User Have not voted or gifted yet then directly give total purchase as remaining star
        $query  = "SELECT vote as star FROM tbl_voting WHERE voter_id = {$user_id}
                    UNION 
                SELECT star FROM tbl_gift_star WHERE sender_id = {$user_id}"; 
        $result = $this->db->query($query);
        $isVoted = $this->returnRows($result);
        if(!empty($isVoted)) {
            $qry = "SELECT IFNULL((total_purchase - total_usage), 0) AS remaining_star 
                FROM (
                (SELECT SUM(star) as total_purchase, user_id FROM tbl_star_purchase WHERE user_id = {$user_id}) as total_purchase
                LEFT JOIN
                (SELECT SUM(total_usage) as total_usage, voter_id FROM ( SELECT IFNULL(SUM(vote), 0) as total_usage, voter_id FROM tbl_voting WHERE voter_id = {$user_id} UNION SELECT IFNULL(SUM(star), 0), sender_id as voter_id FROM tbl_gift_star WHERE sender_id = {$user_id}) tmp WHERE voter_id IS NOT NULL) as total_usage      
                ON total_usage.voter_id = total_purchase.user_id)";
        } else {
            $qry = "SELECT IFNULL(SUM(star), 0) as remaining_star FROM tbl_star_purchase WHERE user_id = {$user_id}";
        }
        // echo $qry;
        $result = $this->db->query($qry)->row_array();
        return $result;
    } 

    /* Get Notification List */
    public function getNotificationList($user_id){
        $qry = "SELECT am.apns_master_id, am.message_title, am.message, am.message_type, am.sender_id, am.created_date
                FROM apns_master am 
                INNER JOIN apns_messages ams ON am.apns_master_id = ams.apns_master_id AND ams.status = 'delivered'
                INNER JOIN apns_devices ad ON ad.device_id = ams.device_id
                WHERE ad.user_id={$user_id} AND am.message_type='push' GROUP BY am.apns_master_id ORDER BY am.created_date DESC";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Notice List */
    public function getNoticeList() {
        $qry = "SELECT tn.notice_id, tn.notice_title, tn.notice_description, tn.sender_id, tn.notice_date, IF(IFNULL(notice_description, '') = '', '' , CONCAT('" . CON_NOTICE_WEB_VIEW_URL . "api/getNoticeWebView?notice_id=', notice_id)) as web_view_url
                FROM tbl_notice tn WHERE tn.status !='deactive'
                ORDER BY tn.notice_date DESC";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Notice Description by Id */
    public function getNoticeById($notice_id){
        $qry = "SELECT notice_id, notice_description
                FROM tbl_notice
                WHERE notice_id = {$notice_id}";
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    // public function getNoticeList(){
    //     $qry = "SELECT am.apns_master_id, am.message_title, am.message, am.message_type, am.sender_id, am.created_date
    //             FROM apns_master am 
    //             WHERE am.message_type='notice' ORDER BY am.created_date DESC";
    //     $result = $this->db->query($qry);
    //     return $this->returnRows($result);
    // }

    /* Update Ranking */
    public function updatePreviousRanking($contest_id){
        $qry = "UPDATE tbl_contestant_mapping SET previous_ranking = current_ranking WHERE contest_id = {$contest_id}";
        $result = $this->db->query($qry);
    }
    
    /* Update Current Ranking */
    public function updateCurrentRanking($contest_id) {
        //Fetch User List with Highest to Lowest 
        // $qry = "SELECT contestant_id, contest_id, SUM(vote) total_vote FROM tbl_voting WHERE contest_id = {$contest_id} GROUP BY contestant_id ORDER BY total_vote DESC";
        $qry = "SELECT t1.contestant_id,t1.contest_id,IFNULL((SELECT IFNULL(SUM(vote),0)total_vote FROM tbl_voting WHERE contestant_id=t1.contestant_id AND contest_id = t1.contest_id GROUP BY contestant_id),0) AS total_vote FROM tbl_contestant_mapping t1 
            INNER JOIN tbl_contestant_details tcd ON t1.contestant_id = tcd.contestant_id
            WHERE t1.contest_id = {$contest_id} AND t1.status != 'deleted' AND tcd.status != 'deleted'
            ORDER BY total_vote DESC,t1.contestant_id ASC";
        $result = $this->db->query($qry);
        $votingData = $this->returnRows($result);
  
        if(count($votingData) > 0){
            $rank = 1;
            $prevVote = NULL;
            $prevRank = $rank;
            for($i = 0; $i < count($votingData); $i++ ){
                //Check if vote is same then give same rank
                if($votingData[$i]['total_vote'] == $prevVote){
                    $qry ="UPDATE tbl_contestant_mapping SET current_ranking={$prevRank} WHERE contestant_id = {$votingData[$i]['contestant_id']} AND contest_id = {$votingData[$i]['contest_id']}";    
                }else{
                    $qry ="UPDATE tbl_contestant_mapping SET current_ranking={$rank} WHERE contestant_id = {$votingData[$i]['contestant_id']} AND contest_id = {$votingData[$i]['contest_id']}";
                    $prevRank = $rank;
                }
                //Update ranking 
                $this->db->query($qry);
                $prevVote = $votingData[$i]['total_vote'];
                $rank++;
            }
            
        }
    }

    /* Get Contestant List By Search */
    public function getContestantBySearch($page, $searchText = '')
    {
        $offset = ($page - 1) * CON_APP_PAGE_LIMIT;
        $limit = " LIMIT $offset, " . CON_APP_PAGE_LIMIT;
        $where = "";
        if ($searchText) {
            $where = " WHERE tcd.name LIKE '%$searchText%'";
        }
        $qry = "SELECT tcd.contestant_id, tcd.name, tc.contest_id, tc.contest_name , IF(IFNULL(tcd.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tcd.main_image)) as main_image , IF(IFNULL(tcd.thumb_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tcd.thumb_image)) as thumb_image
        FROM tbl_contestant_details tcd
        INNER JOIN tbl_contestant_mapping tcm ON tcm.contestant_id = tcd.contestant_id
        INNER JOIN tbl_contest tc ON tc.contest_id = tcm.contest_id AND tc.status != 'delete' AND tc.hide_contest='Show'" . $where . $limit;
        $result = $this->db->query($qry);
        return $this->returnRows($result);
    }

    /* Get Push Setting */
    public function getPushSetting($user_id){
        $qry = "SELECT push_alert, push_sound, push_vibrate, user_id FROM apns_devices WHERE user_id = {$user_id}";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    /* Find User By Phone */
    public function findByPhone($mobile){
        $qry = "SELECT tu.user_id, tu.mobile, tu.user_type, tud.name, IF(IFNULL(tud.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tud.main_image)) as main_image
                FROM tbl_user tu
                INNER JOIN tbl_user_details tud ON tu.user_id = tud.user_id AND tu.user_type = 'user' AND tu.mobile = '{$mobile}' AND tu.user_status = 'active'
                UNION
                SELECT tu.user_id, tu.mobile, tu.user_type, tcd.name, IF(IFNULL(tcd.main_image, '') = '', '' , CONCAT('" . CON_CONTESTANT_URL . "',tcd.main_image)) as main_image
                FROM tbl_user tu
                INNER JOIN tbl_contestant_details tcd ON tu.user_id = tcd.user_id AND tu.user_type = 'contestant' AND tu.mobile = '{$mobile}' AND tu.user_status = 'active'";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    /* Get Vote per day */
    public function getTotalVote($voter_id){
        $today = date('Y-m-d');
        $qry = "SELECT IFNULL(SUM(vote), 0) as total_vote 
                FROM tbl_voting
                WHERE voter_id = {$voter_id} AND date(vote_date)='{$today}'";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    /* Check Daily Attendace */
    public function checkDailyAttendace($user_id){
        $today = date('Y-m-d');
        $qry = "SELECT * FROM tbl_star_purchase
                WHERE user_id = {$user_id} AND type='daily' AND purchase_date = '{$today}'";
        $result = $this->db->query($qry)->row_array();
        return $result;
    }

    // New code added for V2
    public function isValidOtp($data) {
		// $where = array(
		// 	"user_id" => $data['user_id'],
        //     "otp" => $data['otp'],
        //     "status !=" => "deleted",
        //     "otp_for" => $data['otp_for'],
        //     "expired_at" => current_datetime()
        // );
        // $res = $this->setWhere($where)->getAll('tbl_otp');
        // return isset($res[0])? $res[0] : [];

        $date = current_datetime();
        $qry = "SELECT tt.* FROM tbl_otp tt WHERE tt.user_id = {$data['user_id']} AND 
            tt.otp = {$data['otp']} AND tt.status != 'deleted' AND tt.otp_for = '{$data['otp_for']}'
           ";
        // print_r($qry);
        $result = $this->db->query($qry);
        return $this->returnRows($result);
        
	}

    public function checkLoginOAuth($email, $login_type)
    {
        if ($login_type === "auth") {
            $userType = ['user', 'contestant'];
            return $this->db->select('tbl_user.*')
                ->join('oauth_users oau', 'oau.username = email', 'INNER')
                ->where('email', $email)
                ->where('login_type', 'auth')
                ->where('user_status', 'active')
                ->where_in('user_type', $userType)
                ->get('tbl_user')->row_array();
        }
         else {
            return false;
        }
    }  
    
    public function updateUserData($table_name, $data = array(), $whereArr = array())
    {
        try {
            $this->db->or_where($whereArr);
            if ($this->db->update($table_name, $data)) {
                return $this->db->affected_rows();
            } else {
                return 0;
            }
        } catch (Exception $ex) {
            return false;
        }
    }
}
