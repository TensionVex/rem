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

$buttBook = array();  // Declaring array to store scraped book data.
       // Function to return XPath object
function returnXPathObject($item) {
    $xmlPageDom = new DomDocument();      // Instantiating a new DomDocument object
    @$xmlPageDom->loadHTML($item); // Loading the HTML from downloaded page
    $xmlPageXPath = new DOMXPath($xmlPageDom); // Instantiating new XPath DOM object
    return $xmlPageXPath; // Returning XPath object
}

$buttPage = curlGet('http://www.mystore411.com/store/view/11720775/Foot-Locker-Anchorage');  // Calling function curlGet and storing returned results in $buttPage variable
$buttPageXpath = returnXPathObject($buttPage);  // Instantiating new XPath DOM object

$title = $buttPageXpath->query('//div[@class="adr"]');  // Querying for <h1> (title of book)
// If title exists
if ($title->length > 0) {
    $buttBook['title'] = $title->item(0)->nodeValue;  // Add title to array
}

print_r($buttBook);

?>