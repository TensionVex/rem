<?php

// http://www.footlocker.com/storepickup/locations?action=getLocations&latlng=32.849351,-96.589017&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994
// http://www.footlocker.com/storepickup/locations?action=getLocations&latlng={"$coord"}&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994

ob_implicit_flush();
$fh = fopen('stores.txt', 'r');
while ($line = fgets($fh)) {
    $buttLink = "http://www.footlocker.com/storepickup/locations?action=getLocations&latlng={$line}&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994";
    echo nl2br($buttLink . "\n");
    ob_flush();
    sleep(1);
}
echo "all done";
?>