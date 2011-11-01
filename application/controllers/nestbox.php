<?php
class Nestbox extends CI_Controller {
	// ---------------------------------------------------------------------------------------
	
	function hashtag($hashtag)
	{
		$this->load->helper('url');
		header('Content-Type: text/html; charset=utf-8');
	
		// Data security
		$hashtag = $this->security->xss_clean($hashtag);
		
		$this->load->model('nestboxmodel');
		$this->nestboxmodel->connect();
		
		$viewData['data'] = $this->nestboxmodel->returnByHashtag($hashtag);
					
		// -----------------------------------------------------------------------------------
		
		$viewData['hashtag'] = $hashtag;
		
		$this->load->view('nestbox_hashtag', $viewData);
	}
	// ---------------------------------------------------------------------------------------
	function authors($hashtag)
	{
		$this->load->helper('url');
		header('Content-Type: text/html; charset=utf-8');
		
		// Data security
		$hashtag = $this->security->xss_clean($hashtag);
		

		$this->load->model('nestboxmodel');
		$this->nestboxmodel->connect();
		
		$viewData['data'] = $this->nestboxmodel->activeAuthors($hashtag);
		
		// -----------------------------------------------------------------------------------
		
		$viewData['hashtag'] = $hashtag;
		
		$this->load->view('nestbox_authors', $viewData);
	}
	// ---------------------------------------------------------------------------------------
}