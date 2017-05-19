<?php

/*$arr = [2, 4, 3, 543, 23, 35, 21, 12];
echo "<pre>";
print_r($arr); echo "simple array"; 
echo "<br />";
asort($arr);
echo "<pre>";
print_r($arr); echo "asort";
echo "<br />";
arsort($arr);
print_r($arr);
echo "<br />";
echo "arsort";
echo "<br />";
ksort($arr);
echo "<pre>";
print_r($arr); echo "ksort";
echo "<br />";
krsort($arr);
print_r($arr);
echo "<br />";
echo "krsort";*/

/*$x = 1;
if ($x == '1') {
echo 'a' . "<br />"; 
}
if ($x == true) {
echo 'b' . "<br />";
}
if((bool)$x === true){
echo 'e';
}
if ($x === true) {
echo 'c';
}
if((int)$x === true){
echo 'd';
}
*/

/*for ($i=1; $i<= 10; $i++) {

	for ($j=1; $j <= 10; $j++) { 
		echo $i * $j  ; 
	
}
echo "<br />";
}*/

//convert_uuencode
//convert_uudecode

//    echo "<a href='$_SERVER[HTTP_HOST]'>$_SERVER[HTTP_HOST]</a>";
/*$str = "sg4fgdflg5";
$coded = md5($str);
echo $coded;*/

$id = "34/";
$email = "druggy3392@gmail.com";
$rand = rand();
$hash = $id . $email . $rand;

$hashed = convert_uuencode($hash);
$hash = convert_uudecode($hash);
 $hash = explode("/", $hash);
 $lol = "A,S";
$hash = convert_uudecode($lol);




print_r($hash);
die();
echo $coded;
echo $decoded;
echo "<br />";
