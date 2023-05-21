<?php
    		
// Date et heure actuelles
$date = new DateTime();
$newTimezone = new DateTimeZone('Africa/Casablanca');
$date->setTimezone($newTimezone);
echo $date->format('Y-m-d H:i:s');





?>