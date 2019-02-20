<?php

$myarr = array(1,2,3,4,5,6,3,5,1,7);

$myarr2 = array_unique($myarr);

echo array_search(7,$myarr,TRUE);

print_r($myarr2);
?>