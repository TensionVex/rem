<?php
// butts and stuff here
//$butts = "043";
echo "<pre>";

function curlGet($url) {
    $options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_REFERER => "$url",
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_USERAGENT => "Mozilla/5.0 (X11; Linux x86_64; rv:30.0)",
        CURLOPT_MAXREDIRS => 1,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_URL => $url

    );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $results = curl_exec($ch);
    curl_close($ch);
    return $results;
}

function returnXPathObject($item) {
    $xmlPageDom = new DomDocument();
    @$xmlPageDom->loadHTML($item);
    $xmlPageXPath = new DOMXPath($xmlPageDom);
    return $xmlPageXPath;
}

function scrapeStore($url) { // address scraper for pages where the address is visible
    $buttStore = array();
    $buttStorePage = curlGet($url);
    $buttStorePageXpath = returnXPathObject($buttStorePage);

    $address = $buttStorePageXpath->query('//span[@itemprop="streetAddress"]');
    if ($address->length > 0) {
        $buttStore['address'] = "";
//        $buttStore['address'] = strip_tags(trim($address->item(0)->nodeValue, "\r\t\n"),"<br>");
    }

    $city = $buttStorePageXpath->query('//span[@itemprop="addressLocality"]');
    if ($city->length > 0) {
        $buttStore['city'] = trim($city->item(0)->nodeValue);
    }

    $state = $buttStorePageXpath->query('//span[@itemprop="addressRegion"]');
    if ($state->length > 0) {
        $buttStore['state'] = trim($state->item(0)->nodeValue);
    }

    $zip = $buttStorePageXpath->query('//span[@itemprop="postalCode"]');
    if ($zip->length > 0) {
        $buttStore['zip'] = trim($zip->item(0)->nodeValue);
    }
//    echo "printing buttStore <br>";
    print_r($buttStore);
    return $buttStore;
}

function scrapeLocs($url) { // scrape state pages for individual location URLs
    $buttLoc = array();
    $buttDomain = parse_url($url, PHP_URL_HOST);
    $buttLocPage = curlGet($url);
    $buttLocPageXpath = returnXPathObject($buttLocPage);

    $storeLinks = $buttLocPageXpath->query('//td[@class="dotrow"]/a/@href'); //    //td[@class="dotrow"]/a/@href      //a[contains(@href,"view")]/@href
    foreach ($storeLinks as $storeLink) {
        scrapeStore("http://" . $buttDomain . $storeLink->nodeValue);
//        array_push($buttLoc, "http://" . $buttDomain . $storeLink->nodeValue);
    }
//    echo "printing buttLoc <br>";
//    print_r($buttLoc);
    return $buttLoc;
}

// function passLocs($locs) { / pass scraped locations to the address scraper
//    foreach ($locs as $loc) {
//        $buttFinale = scrapeStore($loc);
//        echo trim(implode($buttFinale));
//        print_r($buttFinale);
//        array_push($buttFinale, $loc->nodeValue);
//    }
//}

function scrapeFoot($url) { // scrape the first page for state page URLs
    $buttFoot = array();
    $buttDomain = parse_url($url, PHP_URL_HOST);
    $buttFootPage = curlGet($url);
    $buttFootPageXpath = returnXPathObject($buttFootPage);

//    $locationLinks = $buttFootPageXpath->query('//a[contains(@href,"store/list_state/2174/Alab")]/@href'); // scraping query to get states
    $locationLinks = $buttFootPageXpath->query('//a[contains(@href,"store/list_city")]/@href'); // alternate scraping query to get California cities
    foreach ($locationLinks as $locationLink) {
        array_push($buttFoot, "http://" . $buttDomain . $locationLink->nodeValue);
    }
//    print_r($buttFoot);
    return $buttFoot;
}

function passFoot($locs) { // take state results from first scrape and send to get locations
    foreach ($locs as $loc) {
        $buttMedio = scrapeLocs($loc);
//        echo trim(implode($buttFinale));
//        print_r($buttMedio);
        array_push($buttMedio, $loc->nodeValue);
    }
}

$firstUrl = "http://www.mystore411.com/store/listing/2174/Foot-Locker-store-locations";
$buttStepZero = scrapeFoot($firstUrl);
//print_r($buttStepZero);
passFoot($buttStepZero);
//$scrapeUrl = "http://www.mystore411.com/store/list_state/2174/Alabama/Foot-Locker-store-locations";
//$buttStepOne = scrapeLocs($scrapeUrl);
//passLocs($buttStepOne);


echo nl2br("\n") . "this is the end of the butt";
//echo implode($buttStepOne);
//$buttFinale = scrapeStore($buttStepOne);
//echo "'" . implode("'", $buttFinale) . "'";

//$buttFinale = scrapeStore("http://www.mystore411.com/store/view/11720775/Foot-Locker-Anchorage");
//echo "'" . implode("','", $buttFinale) . "'";

echo "</pre>";
?>