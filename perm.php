<?php

function Fuchs_perm($buf){
  $res = implode("",$buf);
  echo("$res\n");
  $string_length = count($buf);
  for($i=0;$i<$string_length;$i++){
    $p[$i]=0;
  }
  $i=1;
  while($i < $string_length){
   if ($p[$i] < $i) {
      $j = $i % 2 * $p[$i];
      $tmp=$buf[$j];
      $buf[$j]=$buf[$i];
      $buf[$i]=$tmp;
      $res = implode("",$buf);
      echo("$res\n");
      $p[$i]++;
      $i=1;
   } else {
      $p[$i] = 0;
      $i++;
   }
  }
}


function permutations ($alphabet, $output_length=1) {

    $output = array();

    if ($alphabet AND ($output_length > 0)) {

      // Handles both string alphabets and array alphabets
      if (is_string ($alphabet)) {
        $alphabet_length = strlen ($alphabet);
        $symbol = str_split ($alphabet);
      } elseif (is_array ($alphabet)) {
        $alphabet_length = count ($alphabet);
        $symbol = $alphabet;
      } else {
        return $output;
      }

      if ($alphabet_length < 2) return $output;


      // Creates a -1 index in order to avoid the out-of-bounds
      // warning during the last loop of the do-while structure
      $pointer = array_fill (-1, $output_length+1, 0);
      
      // How much iterations to perform
      $iterations = pow ($alphabet_length, $output_length);
  
      // To avoid all the "- 1"...
      $alphabet_length--;
      $output_length--;
  
      // Do the job
      for ($i=0; $i < $iterations; $i++) {
        $permutation = "";
        for ($c = 0; $c <= $output_length; $c++) {
          $permutation .= $symbol[$pointer[$c]];
        }
        $output[] = $permutation;
  
  
        // Updates the pointers
        $c = $output_length;
  
        do {
          $pointer[$c]++;
          if ($pointer[$c] <= $alphabet_length) {
            break;
          } else {
            $pointer[$c] = 0;
            $c--;
          }
        } while (TRUE);
      }
    }
    
    return $output;
  }

//$start = time();
//Fuchs_perm(range('a', 'd'));
//echo "\nFuchs disposizioni senza ripetizione: ".(time() - $start)."\n";

$alpha = array_merge(range('a', 'z'), range('A', 'Z'), range(0, 9), array('!', '?', '.'));
print_r($alpha);
$start = time();
permutantions($alpha, 4);
echo "\npermutations disposizioni con ripetizione: ".(time() - $start)."\n";
?>


