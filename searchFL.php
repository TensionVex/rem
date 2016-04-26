<?php

// http://www.footlocker.com/storepickup/locations?action=getLocations&latlng=32.849351,-96.589017&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994
// http://www.footlocker.com/storepickup/locations?action=getLocations&latlng={"$coord"}&sku=65515010&size=12.0&qty=1&requestKey=632t7EF10C13FC96&rnd=14616521311994

$fh = fopen('stores.txt', 'r');
while ($line = fgets($fh)) {
    $butts = "butt" . $line;
    echo $line;
    flush();
}
echo "all done";
?>