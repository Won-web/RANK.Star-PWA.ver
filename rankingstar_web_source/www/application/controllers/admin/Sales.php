<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('memory_limit', '-1');
class Sales extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        if (!$this->auth->isLogin()) {
            redirect(CON_LOGIN_PATH);
        }
        $this->setWebLanguage();
        $this->load->model('Sales_Model','SalesModel');
    }

    /* Sales List View */
    public function index()
    {
        // $this->load->view('sales_list_view');
        $data['contest_id'] = 1;
        $this->load->view('sales_details_view', $data);
    }

    /* Sales List */
    public function saleslist(){
        $sortColumn = ['total_sales', 'tc.contest_name', 'total_sales', 'total_profit'];

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

        $totalData = $this->SalesModel->getSalesData($searchText, $order_by, $sort_by, $offset, 0);
        $salesData['sales_list'] = $this->SalesModel->getSalesData($searchText, $order_by, $sort_by, $offset, $limit);
        
        //Get Total Sales Profit
        $totalSalesProfit = $this->SalesModel->getTotalSalesProfit($searchText);

        $salesData['total_sales'] =$totalSalesProfit['total_sales'];
        $salesData['total_profit'] =$totalSalesProfit['total_profit'];

        $output = array(
            "draw" => $draw,
            "recordsTotal" => count($totalData),
            "recordsFiltered" => count($totalData),
            "data" => $salesData,
        );
        echo json_encode($output);
        exit();
    }

    /* Sales Details View */
    public function details()
    {
        $contest_id = $this->uri->segment(3);
        $data['contest_id'] = $contest_id;
        $this->load->view('sales_details_view', $data);
    }

    /* Sales Details List */
    // public function salesdetails() {
    //     $contest_id = $this->input->post('contest_id');
    //     $from_date = $this->input->post('from_date');
    //     $to_date = $this->input->post('to_date');

    //     $sortColumn = ['tsp.purchase_date', 'tsp.description', 'tu.email', 'tsp.amount', 'tsp.refund'];

    //     // Datatables Variables
    //     $draw = intval($this->input->post("draw"));
    //     $offset = intval($this->input->post("start"));
    //     $limit = intval($this->input->post("length"));
    //     $search = $this->input->post("search");
    //     $order = $this->input->post("order");

    //     //Get Search Value
    //     $searchText = "";
    //     if (!empty($search['value'])) {
    //         $searchText = $search['value'];
    //     }

    //     //Get Order By And Direction
    //     $column = $order[0]['column'];
    //     $sort_by = $order[0]['dir'];
    //     $order_by = $sortColumn[$column];

    //     $totalData = $this->SalesModel->getSalesDetails($contest_id, $from_date, $to_date,  $order_by, $sort_by, $offset, 0);
    //     $salesDetailsData['sales_details_list'] = $this->SalesModel->getSalesDetails($contest_id, $from_date, $to_date, $order_by, $sort_by, $offset, $limit);
    //     //Get Total Sales and Refund
    //     $totalSalesRefund = $this->SalesModel->getTotalSalesRefund($contest_id, $from_date, $to_date);
    //     $salesDetailsData['total_sales'] = $totalSalesRefund['total_sales'];
    //     $salesDetailsData['total_refund'] = $totalSalesRefund['total_refund'];

    //     $output = array(
    //         "draw" => $draw,
    //         "recordsTotal" => count($totalData),
    //         "recordsFiltered" => count($totalData),
    //         "data" => $salesDetailsData,
    //     );
    //     echo json_encode($output);
    //     exit();
    // }

    /* Sales Details List */
    public function salesDetails() {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $amountType = $this->input->post('amountType');

        $sortColumn = ['tsp.user_id', 'tud.name', 'u.email', 'tsp.description', 'tsp.star','tsp.created_date', 'tsp.amount', 'tsp.refund'];
        // $sortColumn = ['tsp.user_id', 'u.email', 'tsp.description', 'tsp.star','tsp.created_date', 'tsp.amount', 'tsp.refund', 'tsp.refund_date'];

        // Datatables Variables
        $draw = intval($this->input->post("draw"));
        $offset = intval($this->input->post("start"));
        $limit = intval($this->input->post("length"));
        $search = $this->input->post("search");
        $order = $this->input->post("order");

        
        if($draw === 1){
            $count = 0;
        }else if ($draw > 1){
            $count = $offset;
        }

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
        
        $totalData = $this->SalesModel->getSalesDetailsTotal($from_date, $to_date, $amountType, $searchText, $order_by, $sort_by, $offset, 0);
        // print_r($totalData);die;
        $salesDetailsData['sales_details_list'] = $this->SalesModel->getSalesDetails($from_date, $to_date, $amountType, $searchText, $order_by, $sort_by, $offset, $limit);
        //Get Total Sales and Refund
        // $totalSalesRefund = $this->SalesModel->getTotalSalesRefund($from_date, $to_date, $searchText, $order_by, $sort_by, $offset, 0);
        // $salesDetailsData = array();
        foreach($salesDetailsData['sales_details_list'] as $key => $value)
        {
            //Get User Name Using ID
            $userDetails = $this->SalesModel->getByWhere('tbl_user_details', array('user_id'=>$value['user_id']));
            $salesDetailsData['sales_details_list'][$key]['star'] = number_format($value['star']);
            $salesDetailsData['sales_details_list'][$key]['amount'] = number_format($value['amount']);
            $salesDetailsData['sales_details_list'][$key]['refund'] = number_format($value['refund']);
            $count ++;
            $salesDetailsData['sales_details_list'][$key]['count']= $count;
            $salesDetailsData['sales_details_list'][$key]['created_date'] =  date("Y-m-d",strtotime($value['created_date']));
        
            $salesDetailsData['sales_details_list'][$key][] = array(
                $salesDetailsData['sales_details_list'][$key]['count']= $count,
                $salesDetailsData['sales_details_list'][$key]['name'] ='<a data-toggle="tooltip" title="Details" href="' . BASE_URL . 'user/details/' . $value['user_id'] . '" data-id="' . $value['user_id'] . '">' . $userDetails[0]['name'] . '</a>',
                $salesDetailsData['sales_details_list'][$key]['email'] = $value['email'], 
                $salesDetailsData['sales_details_list'][$key]['description'] = $value['description'], 
                $salesDetailsData['sales_details_list'][$key]['star'] = $value['star'],            
                $salesDetailsData['sales_details_list'][$key]['amount'] = $value['amount'], 
                $salesDetailsData['sales_details_list'][$key]['refund'] = $value['refund'],            
                $salesDetailsData['sales_details_list'][$key]['created_date'] = date('Y-m-d', strtotime($value['created_date'])), 
                // $salesDetailsData['sales_details_list'][$key]['refund_date'] = date('Y-m-d', strtotime($value['refund_date']))
            );
        }
        // $salesDetailsData['total_sales'] = number_format($totalSalesRefund['total_sales']);
        // $salesDetailsData['total_refund'] = number_format($totalSalesRefund['total_refund']);
        $salesDetailsData['total_sales'] = number_format($totalData[0]['total_sales']);
        $salesDetailsData['total_refund'] = number_format($totalData[0]['total_refund']);
        
        
        $output = array(
            "draw" => $draw,
            "recordsTotal" => $totalData[0]['total_records'],
            "recordsFiltered" => $totalData[0]['total_records'],
            "data" => $salesDetailsData,
        );
        echo json_encode($output);
        exit();
    }
}