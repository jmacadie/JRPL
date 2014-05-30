<?php

function JMLevenshtein($sought, $searched) {
    
	$matchWeight = 0.75;
	$lengthWeight = 0.05;
	
    $s1 = strlen($sought);
	$s2 = strlen($searched);
    $minLev = $s1;
    
    if ($s1 >= $s2) {
		$out = levenshtein($sought, $searched) * $matchWeight;
		$out += ($s1 - $s2) * $lengthWeight;
        return $out;
    } else {
        for ($i = 0; $i <= ($s2 - $s1); $i++) {
            $j = levenshtein($sought, substr($searched, $i, $s1));
            if ($j < $minLev) $minLev = $j;
			if ($j == 0) break;
        }
        //return (($minLev * $matchWeight) + (($s2 - $s1) * $lengthWeight));
		$out = $minLev * $matchWeight;
		$out += ($s2 - $s1) * $lengthWeight;
        return $out;
    }
	
}
	
?>