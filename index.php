<?php

$n=41;
echo "well,let  us test $n<br/>";
for($i=1;$i<$n;$i++){
    $a["$i"]=$i+1;
    $flag[$i]="in";
}
$a["$n"]=1;
foreach($a as $key=>$value){
    echo $key."=>".$value."</br>";
}
$key=1;$out=0;$r=0;
while($out<$n){
    $r++;
    if($r==2){
        echo "$a[$key]<br/>";// out
        $a[$key]=$a[$a[$key]];
        $out++;$r=0;
    }
    $key=$a[$key];
}


