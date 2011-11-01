<?php

class Nestboxmodel extends CI_Model {

    var $connection = NULL;
    var $db = NULL;
    var $collection = NULL;


	// ---------------------------------------------------------------------------------------
	// Initializes the model
		
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	// ---------------------------------------------------------------------------------------
	// Connects to database
	
    function connect()
    {
		// Reads setup info outside of the root directory
		require_once "../secure/database.eap.php";
		
		$connectionString = "mongodb://$setUser:$setPassword@$setServer:$setPort/$setDB";

		$this->connection = new Mongo($connectionString);
		$this->db = $this->connection->$setDB; // selects database (first creates it if doesn't exist yet)
		$this->collection = $this->db->$setCollection; // selects a collection
    }
	
	// ---------------------------------------------------------------------------------------
	// Inserts a document

	function insertDocument($document, $id = FALSE)
	{
		// Jos ID annettu, käytetään sitä. Muuten MongoDB luo ID:n automaattisesti.
		if ($id)
		{
			$document['_id'] = $id;
		}
	
		$options['safe'] = FALSE;
		$ret = $this->collection->insert($document, $options);
		return $ret;
	}
	
	// ---------------------------------------------------------------------------------------
	// TEST
	
    function test()
    {
		echo "<pre>\n";
        $dbs = $this->connection->listDBs();
		print_r($dbs);
    }	
	
	// ---------------------------------------------------------------------------------------
	// Returns document count
	
    function returnDocumentCount()
    {
        $count = $this->collection->count();
		return $count;
    }
	
	// ---------------------------------------------------------------------------------------
	// Returns documents by hashtag
	
	function returnByHashtag($hashtag)
	{
		$ret = NULL;
		
		$js = "function() {
		  return this.hashtag == '" . $hashtag . "';
		}";
		$cursor = $this->collection->find(array('$where' => $js));
		
		$cursor->sort(array('timestamp' => -1)); // order by

		$ret = iterator_to_array($cursor);
			
		return $ret;
	}
	
	// ---------------------------------------------------------------------------------------
	// Returns authors
	
	function activeAuthors($hashtag)
	{
		$authors = NULL;
		$data = $this->returnByHashtag($hashtag);
		foreach ($data as $id => $item)
		{
			@$authors[$item['author']]++;
		}
		
		arsort($authors);
		
		return $authors;
	}
	
	// ---------------------------------------------------------------------------------------
	// Removes the collection. Use carefully.

	function remove()
	{
		$this->collection->remove();
	}

	// ---------------------------------------------------------------------------------------

}