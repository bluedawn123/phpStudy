<?php
/*
$myArray = [];

function addItem($item){
  global $myArray;
  array_push($myArray, $item);
}
addItem('c');
print_r($myArray);


$myArray = [];

function addItem($item,$myArray){
  array_push($myArray, $item);
  // echo '함수내';
  return $myArray;
}
$result = addItem('c',$myArray);

print_r($result );

*/
$myArray = [];

function addItem($item,&$myArray){
  array_push($myArray, $item);
}
addItem('c',$myArray);

print_r($myArray);
?>