<?php

// http://www.footlocker.com/storepickup/locations?action=getLocations&latlng=32.849351,-96.589017&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994

ob_implicit_flush();
$fh = fopen('stores.txt', 'r');
while ($line = fgets($fh)) {
    $url = "http://www.footlocker.com/storepickup/locations?action=getLocations&latlng=" . trim($line) . "&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994";
    echo $url;
    $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_REFERER => "$url",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.10; rv:45.0) Gecko/20100101 Firefox/45.0",
            CURLOPT_HEADER => "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8 Accept-Language: en-US,en;q=0.5",
            CURLOPT_MAXREDIRS => 1,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_URL => $url
            );
    $ch = curl_init($url);
    curl_setopt_array($ch, $options);
    $buttcurl = curl_exec($ch);
    echo $buttcurl;
    ob_flush();
    curl_close($ch);
    sleep(5);
}

fclose($fh);
echo "all done";
?>