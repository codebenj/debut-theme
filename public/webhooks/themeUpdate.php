<?php 


$data =file_get_contents('php://input');
$order_data =json_decode($data,true);
$fh =fopen('themeUpdate.txt', 'w');


fwrite($fh, $data);

?>