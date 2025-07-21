<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->auth->isLogin()){
			redirect(CON_LOGIN_PATH);
		}
		$this->setWebLanguage();
		$this->load->library('calendar');
		
		$this->load->model('Dashboard_Model', 'DashboardModel');
		
	}
	
	
	public function index()
	{
		//Fetch Contest Records
		$data = array();
		//Get Open Contest List with Contestant count
		$contestSummary['openContest'] = $this->DashboardModel->getContestByStatus('open');
		$contestSummary['closedContest'] = $this->DashboardModel->getContestByStatus('close');
		$contestSummary['preparingContest'] = $this->DashboardModel->getContestByStatus('preparing');
		$data['contestSummary'] = $contestSummary;
		
		//Get User Summary List
		$data['userSummary'] = $this->DashboardModel->getUserCount();
		// print_r($data['userSummary']);die;
		$count = [];              
		  foreach($data['userSummary'] as $value){
				                $count[]= $value['user_count'];
				                //print_r($count);
				}
			
		$sum = array_sum($count);
		//print_r($sum);die;
		$data['userSummary']['user_count'] = $sum;
		//echo $sum;die;

		//Get Sales Summary List
		$salesSummary['total_sales'] = $this->DashboardModel->getSalesByFilter('total');
		$salesSummary['monthly_sales'] = $this->DashboardModel->getSalesByFilter('month');
		$salesSummary['daily_sales'] = $this->DashboardModel->getSalesByFilter('today');
		$data['salesSummary'] = $salesSummary;

		$data['result'] = $this->DashboardModel->getSalesInCalendar();
		// echo "<pre>";print_r($data['result']);die;
		foreach ($data['result'] as $key => $value) {
			$data['data'][$key]['title'] = $value["amount"];
            $data['data'][$key]['start'] = $value["purchase_date"];
            // $data['data'][$key]['end'] = $value["purchase_date"];
            // $data['data'][$key]['backgroundColor'] = "#00a65a";
		}
		
		$this->load->view('dashboard_view', $data);
	}
}
