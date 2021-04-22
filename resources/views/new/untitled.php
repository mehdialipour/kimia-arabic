<?php
//call soap client
$soap=new SoapClient("http://185.112.33.61/webservice/send.php?wsdl");


//SendSMS
$soap->Username="faya";
$soap->Password="2580";
$soap->fromNum="+9850005725029";
$soap->toNum=array("09338708767");
$soap->Content = "تست";
$soap->Type = '0';


$array = $soap->SendSMS($soap->fromNum,$soap->toNum,$soap->Content,$soap->Type,$soap->Username,$soap->Password);
var_dump($array);


//GetStatus
// $soap->Username="";
// $soap->Password="";
// $soap->Unique_ids=array("","");


// $array = $soap->GetStatus($soap->Username,$soap->Password,$soap->Unique_ids);
// var_dump($array);

// //GetCredit
// $soap->Username="";
// $soap->Password="";


// $string = $soap->GetCredit($soap->Username,$soap->Password);
// var_dump($string);

?>