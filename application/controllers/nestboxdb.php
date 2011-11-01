<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nestboxdb extends CI_Controller {
	
	// ---------------------------------------------------------------------------------------
	/*
	Running this fetches tweets from Twitter search API by hashtag
	
	TODO:
	- Handling Twitter errors (http error codes?)
	*/
	public function fetch($hashtag)
	{
		$tweetCount = 30; // How many tweets to retrieve

		// -----------------------------------------------------------------------------------
			
		$this->load->model('nestboxmodel');
		$this->nestboxmodel->connect();

		$hashtag = $this->security->xss_clean($hashtag);
		
		$url = "http://search.twitter.com/search.json?q=%23" . $hashtag . "&with_twitter_user_id=true&rpp=" . $tweetCount . "&include_entities=true";
		
		// Fetches data using CURL
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url);  
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);  
		$str = curl_exec($curl);  
		curl_close($curl);
		
		$viewData['rawData'] = $str;
		
		// JSON to associative array
		$data = json_decode($str, TRUE);
		
//		echo "<pre>$url DEBUG:\n"; print_r ($data); // DEBUG

		$viewData['url'] = $url;
		$viewData['count'] = 0;
		
		// Creates a simplified array
		foreach ($data['results'] as $item)
		{
			$doc['hashtag'] = $hashtag;
			
			$doc['title'] = $item['text'];
			$doc['pubdate'] = $item['created_at'];
			$doc['timestamp'] = strtotime($doc['pubdate']);
			
			$doc['id_str'] = $item['id_str'];
			$doc['author'] = $item['from_user'];
			
			$doc['profile_image_url'] = $item['profile_image_url'];
			$doc['to_user'] = @$item['to_user'];
			$doc['iso_language_code'] = $item['iso_language_code'];
			$doc['source'] = $item['source'];
			
			$doc['entities'] = @$item['entities'];
			
			$doc['link'] = "https://twitter.com/#!/" . $item['from_user'] . "/status/" . $item['id_str'];

			
			// Insert array into database
			$this->nestboxmodel->insertDocument($doc, $doc['link']);
		
//			print_r ($doc); // DEBUG
			
			$viewData['count']++;
		}
		
		$this->load->view('nestboxdb_fetch', $viewData);

	}
	// ---------------------------------------------------------------------------------------
	/*
	Displays tweet count by authors as JSON
	*/
	public function authors($hashtag)
	{
		$this->load->model('nestboxmodel');
		$this->nestboxmodel->connect();
		
		$hashtag = $this->security->xss_clean($hashtag);
		
		$authors = $this->nestboxmodel->activeAuthors($hashtag);
		
		header('Content-Type: text/html; charset=utf-8'); 
		echo json_encode($authors);
	}
	// ---------------------------------------------------------------------------------------
	/*
	Displays tweets as JSON
	*/
	public function json($hashtag)
	{
		$this->load->model('nestboxmodel');
		$this->nestboxmodel->connect();
		
		$hashtag = $this->security->xss_clean($hashtag);
		
		$viewData['json'] = json_encode($this->nestboxmodel->returnByHashtag($hashtag));
		$this->load->view('nestboxdb_json', $viewData);

	}
	// ---------------------------------------------------------------------------------------
	/*
	This can be used to remove all content from database collection. Use carefully!
	*/
/*
	public function removeall()
	{
		$this->load->model('nestboxmodel');
		$this->nestboxmodel->connect();
		$this->nestboxmodel->remove();
	}
*/
	// ---------------------------------------------------------------------------------------
}

/* End of file */
