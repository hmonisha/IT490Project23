<?php

	require_once('path.inc');
	require_once('get_host_info.inc');
	require_once('rabbitMQLib.inc');

function getBuyLink($bookName){

	

	$curl = curl_init();

	

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.asindataapi.com/request?api_key=40037FC70D4C4E30A9CC83CD2E215809&type=search&amazon_domain=amazon.com&search_term='.str_replace(" ","+",$bookName.'+paperback'),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response = curl_exec($curl);
	
	curl_close($curl);

	$results = json_decode($response);
	$prices= $results->search_results[0]->prices;

$item = $prices[0];


return array("link"=>$item->link,"price"=>$item->value);
}

function getBookInfo($bookSearch){

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://www.googleapis.com/books/v1/volumes?q='.str_replace(" ","%20",$bookSearch).'&orderBy=relevance',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response = curl_exec($curl);

	curl_close($curl);

	return $response;
}



function bookInfoToJsonArray($bookInfo){

$books = json_decode($bookInfo);

$output = array();

foreach($books->items as $book){
		$volume = $book->volumeInfo;
		$sale = $book->saleInfo;
		$name = $volume->title;
		$date = $volume->publishedDate;
		$publisher = $volume->publisher;
		$description = $volume->description;
		$image = 'https://covers.openlibrary.org/b/isbn/'.$volume->industryIdentifiers[0]->identifier.'-L.jpg';
		$isbn = $volume->industryIdentifiers[0]->identifier;
		$lang = $volume->language;
		$country = $sale->country;
		$printType = $volume->printType;
		$category = $volume->categories;
		$isAvailable = $sale->saleability=='FOR_SALE'?'True':'False';
		try{
			$price = $sale->listPrice->amount;
		} catch(Exception $e) {
			$price = 0;
		}
		try{
			$pageCount = $volume->pageCount;
		} catch(Exception $e) {
			$pageCount = 0;
		}
		try{
			$authors = $volume->authors;
		}catch(Exception $e) {
			$authors = "";
		}
		try{
			$linkAndPrice = getBuyLink($name);
			$price = $linkAndPrice["price"];
			$link = $linkAndPrice["link"];
		}
		catch(Exception $e){
			$link = "";
		}
		$bookJsonArr = array(
		'bookName' => $name,
		'publishedBy' => $publisher,
		'publishedDate' => $date,
		'description' => $description,
		'image' => $image,
		'pageCount' => $pageCount,
		'authors' => $authors,
		'ID' => $isbn,
		'language' => $lang,
		'publishedCountry' => $country,
		'printType' => $printType,
		'category' => $category,
		'isAvailable' => $isAvailable==NULL?"False":$isAvailable,
		'price' => $price==NULL?0:$price,
		'link' => $link
		);
		var_dump($bookJsonArr);
		array_push($output,$bookJsonArr);
}
return $output;
}


function getTopBooks($listType){
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://api.nytimes.com/svc/books/v3/lists/current/'.str_replace(" ","_",$listType).'.json?api-key=UyIsdw9fnTnW254GfKrimVGSvcWv5tl2',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => '',
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => 'GET',
	));

	$response = curl_exec($curl);

	Curl_close($curl);

	return $response;

}


function getBooksAsTopBooks($topBooks){

	$books = json_decode($topBooks);
	$bookReturns = array();

	foreach($books->results->books as $bookInfo) {
		$isbn = $bookInfo->primary_isbn13;
		$bookInfo = bookInfoToJsonArray(getBookInfo("isbn:$isbn"))[0];
		array_push($bookReturns, $bookInfo);

	
	
	}
	return $bookReturns;
}






$inputVariable = "Heroes of Olympus";

//var_dump(bookInfoToJsonArray(getBookInfo($inputVariable)));
//
//getBooksAsTopBooks(getTopBooks("hardcover-fiction"));




//////RABBIT STUFF


function requestProcessor($request)
{
  echo "received request".PHP_EOL;
  var_dump($request);
  if(!isset($request['type']))
  {
    return "ERROR: unsupported message type";
  }
  switch (strtolower($request['type']))
  {
  case "booksearch":
		  try{
		  $searchQuery = $request['query'];
		  } catch(Exception $e) {
			  //throw exception into rabbit
		  }
	  $books = getBookInfo($searchQuery);
		  if(true){
			  $bookJson = bookInfoToJsonArray($books);
			  echo "Got Json : Sending request";
	 	return array("returnCode" => '202', 'message'=>"Server received request and return data.", "data" => $bookJson);

	  }
	  else {
		  return array("returnCode" => '401', 'message'=>"Server received request and failed to find any books.", "data" => "");

	  }
	  break;
    case "topbooks":
		  try{
		  $searchQuery = $request['query'];
		  } catch(Exception $e) {
			  //throw exception into rabbit
		  }
		  $books = getTopBooks($searchQuery);
		  if(true){
	 	return array("returnCode" => '202', 'message'=>"Server received request and return data.", "data" => bookInfoToJsonArray($books));

	  }
	  else {
		  //
		  return array("returnCode" => '401', 'message'=>"Server received request and failed to find any books.", "data" => "");

	  }
  
	  return array("returnCode" => '401', 'message'=>"Server received request without a valid type.", "data"=>"");
  }
}



$server = new rabbitMQServer("testRabbitMQ.ini","testServer");

echo "testRabbitMQServer BEGIN".PHP_EOL;

$server->process_requests('requestProcessor');


echo "testRabbitMQServer END".PHP_EOL;
