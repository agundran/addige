
<?php

class Paging extends Controller {

	function Paging(){

		parent::Controller();
		$this->load->helper(array('form','url'));
		$this->load->helper('text');
		$this->load->library('Ajax_pagination');
	}

	function index()
	{
		redirect ('paging/my_friends');
	}

	function my_friends()
	{
		$pdata['TotalRec'] 	= $this->FriendsModel->TotalRec();
		$pdata['perPage'] 	= $this->perPage();
		$pdata['ajax_function']	= 'get_friends_ajax';

		$subdata['paging'] 	= $this->parser->parse('paging', $pdata, TRUE);
		$subdata['all_friends'] 	= $this->FriendsModel->my_friends($this->perPage());

		$data['body_content'] 	= $this->parser->parse('friend_list', $subdata, TRUE);	

		$this->load->view('main',$data);
	}

	function get_friends_ajax()
	{
             $pdata['TotalRec'] = $this->FriendsModel->TotalRec();
             $pdata['perPage']  = $this->perPage();

	     $pdata['ajax_function'] =  'get_friends_ajax';

	     $data['paging'] =  $this->parser->parse('paging', $pdata, TRUE);
	     $data['all_friends'] = $this->FriendsModel->my_friends($this->perPage());

	     $this->load->view('friend_list',$data);
	}

	function PerPage()
	{
		return 5;
	}

}

?>
