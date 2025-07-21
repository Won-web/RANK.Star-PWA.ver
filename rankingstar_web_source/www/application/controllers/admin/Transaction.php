<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaction extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        $this->setWebLanguage();
        $this->load->model('Transaction_Model','TransactionModel');
    }

    /* Transaction List View */
    public function index()
    {
        $this->load->view('transaction_details_view');
    }


    public function getDisplayStatusStr($status_from_db){
        if($status_from_db == "cancel") {
          return lang('TRA_STATUS_CANCEL');
        } 
        else if($status_from_db == "productfail" || $status_from_db == "fail" || $status_from_db == "pending" || $status_from_db == "consumefail"){
          return lang('TRA_STATUS_APPROVAL_ERROR');
        }
        else if($status_from_db == "success" || $status_from_db == "paymentcompleted"){
          return lang('TRA_STATUS_APPROVED');
        }
        return null;
    }


    
    /* Transaction Details List */
    public function transactionDetails() {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');

        $sortColumn = ['count', 'u.name', 'u.email', 'tt.description', 'tpp.star', 'tt.amount', 'tt.payment_transaction_id', 'tt.os', 'tt.created_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        
        //Get Search Value
        $searchText = "";
        if (!empty($search['value'])) {
            $searchText = $search['value'];
        }

        //Get Order By And Direction
        $column = $order[0]['column'];
        $sort_by = $order[0]['dir'];
        $order_by = $sortColumn[$column];
        // $order_by=null;
        
        $totalData = $this->TransactionModel->getTransactionDetails($from_date, $to_date, $searchText, $order_by, $sort_by, $offset, 0);
        $transactionDetails = $this->TransactionModel->getTransactionDetails($from_date, $to_date, $searchText, $order_by, $sort_by, $offset, $limit);
        //Process Data
        $data = array();
    
        foreach ($transactionDetails as $transaction) {
            $offset++;
            $markAsSuccess = '';
            $sessionData = $this->auth->getUserSession();
            if ($sessionData['user_type'] === "admin" && (($transaction['os'] == "Android" && $transaction['payment_status'] == "paymentcompleted") || ($transaction['os'] == "iOS" && $transaction['payment_status'] == "pending"))){
              $markAsSuccess = '<a data-toggle="tooltip" title="' . lang('TT_MARK_AS_SUCCESS') . '" class="mark-success" data-url="' . BASE_URL . 'transaction/markAsSuccess/' . $transaction['transaction_id'] . '" href="#" data-id="' . $transaction['transaction_id'] . '"><i class="fa fa-check"></i></a>';
            } else {
		$markAsSuccess = "<div class='empty-btn'></div>";
	         }
            $transactionID = "";
            if(!empty($transaction['payment_transaction_id'])){
                $transactionID = "<span style='font-weight : bold;'>".lang('LBL_TRANSACTION_ID')." : </span>".$transaction['payment_transaction_id'];
		
            }
            if(!empty($transactionID) && !empty($transaction['trans_identifier'])){
                $transactionID .= "<br><span style='font-weight : bold;'>".lang('LBL_TRANSACTION_NO')." : </span>".$transaction['trans_identifier'];
		
            }else if(empty($transactionID) && !empty($transaction['trans_identifier'])){
                $transactionID = "<span style='font-weight : bold;'>".lang('LBL_TRANSACTION_NO')." : </span>".$transaction['trans_identifier'];
            }
	      $transactionID = "<span class='small-font'>".$transactionID."</span>";
            $name = "<a href='" . BASE_URL . 'user/details/' . $transaction['user_id'] . "'>".$transaction['name']."</a>";
            $email = "<a href='" . BASE_URL . 'user/details/' . $transaction['user_id'] . "'>".$transaction['email']."</a>";
            $delete = '<a class="deleteTransaction mr-3" title="Delete Transaction" data-id="' . $transaction['transaction_id'] . '" ><i class="fas fa-trash"></i></a>';
            $action= $delete.$markAsSuccess;
            $data[] = array($offset, $name, $email, $this->getDisplayStatusStr($transaction['payment_status']), $transaction['star'],  $transaction['amount'], $transactionID, $transaction['os'], date('Y-m-d H:i:s' , strtotime($transaction['created_date'])), $action);
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($totalData),
            "recordsFiltered" => count($totalData),
            "data" => $data,
        );
        echo json_encode($output);
        exit();
    }

    /* User Details View */
    public function markAsSuccess()
    {
        $transaction_id = $this->uri->segment(4);
        //Check Transaction Id is fail or consume fail or not
        $whereArr = array('transaction_id'=> $transaction_id);
        $transactionDetails = $this->TransactionModel->getByWhere('tbl_transaction', $whereArr);
        if(!empty($transactionDetails)){
            // if($transactionDetails[0]['payment_status'] == "fail" || $transactionDetails[0]['payment_status'] == "consumefail" || $transactionDetails[0]['payment_status'] == "paymentcompleted"){
            if((($transactionDetails[0]['os'] == "Android" && $transactionDetails[0]['payment_status'] == "paymentcompleted") || ($transactionDetails[0]['os'] == "iOS" && $transactionDetails[0]['payment_status'] == "pending"))){
                //Mark Transaction as Success and Give Credit star to user
                //Complete Transaction
                $transactionArr = array(
                    'status' => 'completed',
                    'payment_status' => 'success',
                    'transaction_complete_date' => date('Y-m-d H:i:s')
                );
                $isUpdated = $this->TransactionModel->update('tbl_transaction', $transactionArr, $whereArr);
                if($isUpdated){                  
                    log_message('info','Ranking Star => Api Name:markAsSuccess , updated_id'.$transaction_id);
                    //Fetch Plan Details to assign star to user
                    $whereArr = array('plan_id'=>$transactionDetails[0]['plan_id']);
                    $planDetails = $this->TransactionModel->getByWhere('tbl_purchase_plan', $whereArr);
                    if(!empty($planDetails)){
                        //Get star and Extra star and assign it to user
                        $purchase_star = $planDetails[0]['star'];
                        $extra_star = $planDetails[0]['extra_star'];
                        $total_star = $purchase_star + $extra_star;

                        $purchaseArr = array(
                            'user_id' => $transactionDetails[0]['user_id'],
                            'contest_id' => $transactionDetails[0]['contest_id'],
                            'star' => $total_star,
                            'amount' => $transactionDetails[0]['amount'],
                            'transaction_id' => $transactionDetails[0]['transaction_id'],
                            'description' => 'APP (관리자가 수동으로 추가)',
                            'type' => 'paid',
                            'purchase_date' => date('Y-m-d'),
                            'created_date' => date('Y-m-d H:i:s'),
                            'updated_date' => date('Y-m-d H:i:s')
                        );
                        $purchase_id = $this->TransactionModel->insert('tbl_star_purchase', $purchaseArr);
                        log_message('info','Ranking Star => Api Name:markAsSuccess , insert_id'.$purchase_id);
                        $resData = array('res_code' => 1, 'res_message' => lang('MSG_TRANSACTION_COMPLETE'));

                    }else{
                        $resData = array('res_code' => 0, 'res_message' => lang('MSG_TRANSACTION_FAIL'));
                    }
                }else{
                    $resData = array('res_code' => 0, 'res_message' => lang('MSG_TRANSACTION_FAIL'));
                }
            }else{
                $resData = array('res_code' => 0, 'res_message' => lang('LBL_TRANSACTION_CAN_NOT_SUCCESS'));
            }
        }else{
            $resData = array('res_code' => 0, 'res_message' => lang('LBL_TRANSACTION_NOT_FOUND'));
        }
        $datArr = array('transaction_id'=>$transaction_id);
        logMessage('markAsSuccess',$datArr, $resData);
        header('Content-Type: application/json');
        echo json_encode($resData);
    }

    /**
     * Delete transaction
     */
    public function deleteTransaction() {
        $transactionId = $this->input->post('transactionId');
        $this->resArr[CON_RES_DATA] = [];
        if($transactionId) {
            $whereArr = array('transaction_id'=> $transactionId);
            $transactionDetails = $this->TransactionModel->getByWhere('tbl_transaction', $whereArr);
            if(!empty($transactionDetails)){
                $isDelete = $this->TransactionModel->deleteTransaction($transactionId);
                if($isDelete) {
                    $this->resArr[CON_RES_CODE] = CON_CODE_SUCCESS;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_DELETE_SUCCESS');
                } else {
                    $this->resArr[CON_RES_CODE] = CON_CODE_FAIL;
                    $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_DELETE_FAILED');
                }
            }else{
                $this->resArr[CON_RES_CODE] = CON_CODE_FAIL;
                $this->resArr[CON_RES_MESSAGE] = lang('LBL_TRANSACTION_NOT_FOUND');
            }
        } else {
            $this->resArr[CON_RES_CODE] = CON_CODE_FAIL;
            $this->resArr[CON_RES_MESSAGE] = lang('MSG_TRANSACTION_DELETE_FAILED');
        }
        $this->sendResponse($this->resArr);
    }
}