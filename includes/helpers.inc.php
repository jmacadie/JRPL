<?php
function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function htmlout($text)
{
    echo html($text);
}

function bbcode2html($text)
{
    $text = html($text);

    // [B]old
    $text = preg_replace('/\[B](.+?)\[\/B]/i', '<strong>$1</strong>', $text);

    // [I]talic
    $text = preg_replace('/\[I](.+?)\[\/I]/i', '<em>$1</em>', $text);

    // Convert Windows (\r\n) to Unix (\n)
    $text = str_replace("\r\n", "\n", $text);

    // Convert Macintosh (\r) to Unix (\n)
    $text = str_replace("\r", "\n", $text);

    // Paragraphs
    $text = '<p>' . str_replace("\n\n", '</p><p>', $text) . '</p>';

    // Line breaks
    $text = str_replace("\n", '<br/>', $text);

    // [URL]link[/URL]
    $text = preg_replace(
            '/\[URL]([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)\[\/URL]/i',
            '<a href="$1">$1</a>', $text);

    // [URL=url]link[/URL]
    $text = preg_replace(
            '/\[URL=([-a-z0-9._~:\/?#@!$&\'()*+,;=%]+)](.+?)\[\/URL]/i',
            '<a href="$1">$2</a>', $text);

    return $text;
}

function bbcodeout($text)
{
    echo bbcode2html($text);
}

function int($int)
{

    // First check if it's a numeric value as either a string or number
    if(is_numeric($int) === TRUE)
    {

        // It's a number, but it has to be an integer
        if((int)$int == $int){

            return TRUE;

        // It's a number, but not an integer, so we fail
        }else{

            return FALSE;

        }

        // Not a number
    }else{

        return FALSE;

    }
}

function quickSort( $arr, $left = 0 , $right = NULL )
{
	// when the call is recursive we need to change
	//the array passed to the function earlier
	static $array = array();
	if( $right == NULL ) $array = $arr;
	if( $right == NULL ) $right = count($array)-1; //last element of the array
	 
	$i = $left;
	$j = $right;
	 
	$tmp = $array[(int)( ($left+$right)/2 )];
	 
	// partion the array in two parts.
	// left from $tmp are with smaller values,
	// right from $tmp are with bigger ones
	do
	{
		while( $array[$i] < $tmp ) $i++;
		while( $tmp < $array[$j] ) $j--;
		 
		// swap elements from the two sides
		if( $i <= $j )
		{
			$w = $array[$i];
			$array[$i] = $array[$j];
			$array[$j] = $w;
			 
			$i++;
			$j--;
		}
	} while( $i <= $j );
	 
	// devide left side if it is longer the 1 element
	if( $left < $j ) quickSort(NULL, $left, $j);
	 
	// the same with the right side
	if( $i < $right ) quickSort(NULL, $i, $right);
	 
	// when all partitions have one element
	// the array is sorted
	return $array;
}

function HSVtoRGB($h,$s,$v)
{

	$hDash = $h/60;
	
	$c = $s * $v;
	$x = $c*(1-abs(fmod($hDash,2)-1));
	$m = $v - $c;
	
	switch ($hDash) {
			case ($hDash < 1) : $r=$c; $g=$x; $b=0; break;
			case ($hDash < 2) : $r=$x; $g=$c; $b=0; break;
			case ($hDash < 3) : $r=0; $g=$c; $b=$x; break;
			case ($hDash < 4) : $r=0; $g=$x; $b=$c; break;
			case ($hDash < 5) : $r=$x; $g=0; $b=$c; break;
			case ($hDash <= 6) : $r=$c; $g=0; $b=$x; break;
			default : $r=0; $g=0; $b=0;
		}
	
	$r = round(($r+$m)*255);
	$g = round(($g+$m)*255);
	$b = round(($b+$m)*255);
	
	$out = array(
		'r' => $r,
		'g' => $g,
		'b' => $b);
	
	return $out;
}

function getLeagueTable($link) {
	
	// Create temporary table to hold submitted matches count
	$sql = "CREATE TEMPORARY TABLE `SubmittedMatches` (
					`UserID` INT NOT NULL,
					`Submitted` INT NOT NULL,
					`NotSubmitted` INT NOT NULL) ; ";

	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error creating submitted matches temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Add submitted matches count data to temporary table
	$sql = "INSERT INTO `SubmittedMatches`
					SELECT
						u.`UserID`,
						(SELECT COUNT(*)
						FROM `Match` m
							LEFT JOIN `Prediction` p ON p.`MatchID` = m.`MatchID`
						WHERE p.`UserID` = u.`UserID`
							AND (p.`HomeTeamGoals` IS NOT NULL AND p.`AwayTeamGoals` IS NOT NULL)
							AND (m.`ResultPostedBy` IS NOT NULL)) AS `Submitted`,
						(SELECT COUNT(*)
						FROM (SELECT `MatchID`, `UserID` FROM `Match`, `User` WHERE `ResultPostedBy` IS NOT NULL) mu
							LEFT JOIN `Prediction` p ON
								p.`MatchID` = mu.`MatchID`
								AND p.`UserID` = mu.`UserID`
						WHERE mu.`UserID` = u.`UserID`
							AND p.`PredictionID` IS NULL) AS `NotSubmitted`
					FROM `User` u ; ";

	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error adding submitted matches data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Create temporary table to hold points by user
	$sql = "CREATE TEMPORARY TABLE `PointsByUser` (
					`UserID` INT NOT NULL,
					`DisplayName` VARCHAR(100) NOT NULL,
					`ResultPoints` INT NOT NULL,
					`ScorePoints` INT NOT NULL,
					`TotalPoints` INT NOT NULL) ; ";

	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error creating points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Add points by user data to temporary table
	$sql = "INSERT INTO `PointsByUser`
					SELECT
						tmp.`UserID`,
						tmp.`DisplayName`,
						SUM(tmp.`ResultPoints`) AS `ResultPoints`,
						SUM(tmp.`ScorePoints`) AS `ScorePoints`,
						SUM(tmp.`TotalPoints`) AS `TotalPoints`
					FROM
					(SELECT
						u.`UserID`,
						IFNULL(u.`DisplayName`,CONCAT(u.`FirstName`,' ',u.`LastName`)) AS `DisplayName`,
						IFNULL(po.`ResultPoints`,0) AS `ResultPoints`,
						IFNULL(po.`ScorePoints`,0) AS `ScorePoints`,
						IFNULL(po.`TotalPoints`,0) AS `TotalPoints`

					FROM `User` u
					
						LEFT JOIN `Points` po
								po.`UserID` = u.`UserID`) tmp

					GROUP BY tmp.`DisplayName`; ";

	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error adding points by user data to temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Create 2nd temporary table to hold points by user
	$sql = "CREATE TEMPORARY TABLE `PointsByUser2` SELECT * FROM `PointsByUser`; ";
	
	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error creating 2nd points by user temporary table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Final query
	$sql = "SELECT
					(SELECT COUNT(*) + 1
					FROM `PointsByUser2` pbu2
					WHERE pbu2.`TotalPoints`>pbu.`TotalPoints`) AS `Rank`,
					pbu.*,
					sm.`Submitted`,
					sm.`NotSubmitted`
					
				FROM `PointsByUser` pbu
					INNER JOIN `SubmittedMatches` sm ON sm.`UserID` = pbu.`UserID`

				ORDER BY
					pbu.`TotalPoints` DESC,
					pbu.`ScorePoints` DESC,
					pbu.`ResultPoints` DESC,
					pbu.`DisplayName` ASC;";

	$result = mysqli_query($link, $sql);
	if (!$result)
	{
		$error = 'Error fetching league table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
		
		header('Content-type: application/json');
		$arr = array('result' => 'No', 'message' => $error);
		echo json_encode($arr);
		die();
	}
	
	// Build array of outputs 
	while ($row = mysqli_fetch_array($result))
	{
		$out[] = array(
			'rank' => $row['Rank'],
			'name' => $row['DisplayName'],
			'submitted' => $row['Submitted'],
			'notSubmitted' => $row['NotSubmitted'],
			'resultPoints' => $row['ResultPoints'],
			'scorePoints' => $row['TeamScorePoints'],
			'totalPoints' => $row['TotalPoints']);
	}
	
	return $out;
}
?>