<?php
// butts and stuff here
//$butts = "039";

function curlGet($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; Linux x86_64; rv:30.0)");
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}

$packtBook = array();  // Declaring array to store scraped book data.
       // Function to return XPath object
function returnXPathObject($item) {
    $xmlPageDom = new DomDocument();      // Instantiating a new DomDocument object
    @$xmlPageDom->loadHTML($item); // Loading the HTML from downloaded page
    $xmlPageXPath = new DOMXPath($xmlPageDom); // Instantiating new XPath DOM object
    return $xmlPageXPath; // Returning XPath object
}

$packtPage = curlGet('http://www.packtpub.com/learning-ext-js/book');  // Calling function curlGet and storing returned results in $packtPage variable
$packtPageXpath = returnXPathObject($packtPage);  // Instantiating new XPath DOM object

$title = $packtPageXpath->query('//h1');  // Querying for <h1> (title of book)
// If title exists
if ($title->length > 0) {
    $packtBook['title'] = $title->item(0)->nodeValue;  // Add title to array
}

print_r($packtBook);

?>