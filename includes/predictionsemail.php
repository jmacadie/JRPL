<?php

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Includes
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
require_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includesfile.inc.php';

// Get DB connection
include 'db.inc.php';

// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
// Get event details for events not yet sent and past the lock-down point
// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
$sql = "SELECT
            CASE
                WHEN d.`Name` = sp.`Name` THEN sp.`Name`
                ELSE CONCAT(d.`Name`, ' - ', sp.`Name`)
            END AS `Sport`,
            CONCAT(g.`Possessive`, ' ', be.`Name`) AS `Event`,
            e.`EventID`

        FROM `KeySession` ks
          INNER JOIN `Event` e ON e.`EventID` = ks.`EventID`
          INNER JOIN `BaseEvent` be ON be.`BaseEventID` = e.`BaseEventID`
          INNER JOIN `Gender` g ON g.`GenderID` = e.`GenderID`
          INNER JOIN `Sport` sp ON sp.`SportID` = be.`SportID`
          INNER JOIN `Discipline`d ON d.`DisciplineID` = sp.`DisciplineID`

          INNER JOIN `SessionEvent` se ON se.`SessionEventID` = ks.`LockDownSessionEventID`
          INNER JOIN `Session` s ON s.`SessionID` = se.`SessionID`

          INNER JOIN `Email` em ON em.`EventID` = e.`EventID`

        WHERE
          em.`PredictionsSent` = 0
          AND DATE_ADD(NOW(), INTERVAL 30 MINUTE) > TIMESTAMP(s.`Date`, s.`StartTime`);";

$result = mysqli_query($link, $sql);
if (!$result)
{
    $error = 'Error getting not yet submitted events: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
    sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
    exit();
}

while ($row = mysqli_fetch_array($result))
{

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Calclate Mr Mode
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    calcMrMode($row['EventID'],$link);

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Email To Addresses
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $toEmail='pierre@julianrimet.com';

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Email Subject
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $emailSubject = 'JRPL: Match Predictions for ' . $row['Sport'] . ': '. $row['Event'];

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // CSS formatting
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    $css = 'table { font: 12px; border-collapse: collapse;} ';
    $css .= 'th { font:14px; padding: 0 0.5em; text-align: left; } ';
    $css .= 'tr.header td { border-top: 1px solid #96824f; border-bottom: 1px solid #96824f; background: #e2dccc; } ';
    $css .= 'tr.secondRow td { background: #efede8; } ';
    $css .= 'td { border-bottom: 1px solid #ccc; padding: 0 0.5em; } ';
    $css .= 'td.left { width: 190px; text-align: left;  } ';
    $css .= 'td.rowDetail { border-left: 1px solid #ccc; width: 300px; text-align: left; } ';
    $css .= 'td span.noPrediction { color: #999; font-style: italic;} ';

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - Get details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $sql = "SELECT
                up.`DisplayName`,
                up.`Medal`,
                IFNULL(tmp.`Name`,'No prediction') AS `Prediction`

            FROM
                (SELECT u.`UserID`, u.`DisplayName`, pt.`PredictionTypeID`, pt.`Name` AS `Medal`
                FROM `User` u, `PredictionType` pt) up

            LEFT JOIN
                (SELECT
                    p.`UserID`,
                    p.`PredictionTypeID`,
                    CONCAT(
                        COALESCE(c.`FirstName`,co2.`Name`),
                        CASE WHEN c.`LastName` IS NULL THEN '' ELSE CONCAT(' ',c.`LastName`) END,
                        ' (',
                        COALESCE(co1.`ShortName`,co2.`ShortName`),
                        ')',
                        CASE
                            WHEN p.`WRJoker` = 1 THEN ' -- WR --'
                            ELSE ''
                        END) AS `Name`

                FROM `Prediction` p
                    INNER JOIN `CompetitorEvent` ce ON ce.`CompetitorEventID` = p.`CompetitorEventID`
                    LEFT JOIN `Competitor` c ON c.`CompetitorID` = ce.`CompetitorID`
                    LEFT JOIN `Country` co1 ON co1.`CountryID` = c.`CountryID`
                    LEFT JOIN `Country` co2 ON co2.`CountryID` = ce.`CountryID`

                WHERE ce.`EventID` = " . $row['EventID'] . "

                UNION ALL

                SELECT
                    p.`UserID`,
                    p.`PredictionTypeID`,
                    CONCAT(
                        COALESCE(c.`FirstName`,co2.`Name`,sc.`FirstName`),
                        CASE
                            WHEN c.`LastName` IS NULL AND sc.`LastName` IS NULL THEN ''
                            WHEN c.`LastName` IS NULL THEN CONCAT(' ',sc.`LastName`)
                            ELSE CONCAT(' ',c.`LastName`)
                        END,
                        ' (',
                        COALESCE(co1.`ShortName`,co2.`ShortName`,co3.`ShortName`),
                        ')',
                        CASE
                            WHEN p.`WRJoker` = 1 THEN ' -- WR --'
                            ELSE ''
                        END,
                        CASE
                            WHEN c.`CompetitorID` IS NOT NULL THEN ' *'
                            ELSE ' **'
                        END) AS `Name`

                FROM `Prediction` p
                    INNER JOIN `SuggestionCompetitorEvent` sce ON sce.`SuggestionCompetitorEventID` = p.`SuggestionCompetitorEventID`
                    LEFT JOIN `Competitor` c ON c.`CompetitorID` = sce.`CompetitorID`
                    LEFT JOIN `Country` co1 ON co1.`CountryID` = c.`CountryID`
                    LEFT JOIN `Country` co2 ON co2.`CountryID` = sce.`CountryID`
                    LEFT JOIN `SuggestionCompetitor` sc ON sc.`SuggestionCompetitorID` = sce.`SuggestionCompetitorID`
                    LEFT JOIN `Country` co3 ON co3.`CountryID` = sc.`CountryID`

                WHERE sce.`EventID` = " . $row['EventID'] . ") tmp ON
                    tmp.`UserID` = up.`UserID` AND tmp.`PredictionTypeID` = up.`PredictionTypeID`

             ORDER BY up.`UserID` ASC, up.`PredictionTypeID` ASC;";

    $resultBody = mysqli_query($link, $sql);
    if (!$resultBody)
    {
        $error = 'Error getting event details: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Body - Write details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    $body = 'All,<br /><br />Predictions for the next event are in:<br /><br />';

    $body .= '<table><tr class="header">';
    $body .= '<td class="left">Name</td>';
    $body .= '<td class="rowDetail">Prediction</td></tr>';

    $i=1;
    while ($rowBody = mysqli_fetch_array($resultBody)) {
        if(!isset($lastName) || $rowBody['DisplayName']!= $lastName) {
            if(isset($lastName)) {
                $body = substr($body,0,-6); // remove the last <br />
                $body .= '</td></tr>'; //finish the cell and row
            }
            if($i==1) {
                $body .= '<tr><td class="left">'.$rowBody['DisplayName'].'</td><td class="rowDetail">';
                $i=2;
            } else{
                $body .= '<tr class="secondRow"><td class="left">'.$rowBody['DisplayName'].'</td><td class="rowDetail">';
                $i=1;
            }
        }
        if ($rowBody['Prediction'] == 'No prediction') $body .= '<span class="noPrediction">';
        $body .= $rowBody['Medal'] . ': ' . $rowBody['Prediction'];
        if ($rowBody['Prediction'] == 'No prediction') $body .= '</span">';
        $body .= '<br />';
        $lastName = $rowBody['DisplayName'];
    }
    $body = substr($body,0,-6); // remove the last <br />
    $body .= '</td></tr></table>'; //finish the cell, row & table

    // unset last name variable so not remebered in next loop
    unset($lastName);

    // Send e-mail
    sendEmail($toEmail,$emailSubject,$css,$body);

    // Update DB to log e-mail being sent
    $sql = "UPDATE `Email`
            SET `PredictionsSent` = TRUE
            WHERE `EventID`=".$row['EventID'];

    $resultBody = mysqli_query($link, $sql);
    if (!$resultBody)
    {
        $error = 'Error updating email table: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }
}

function calcMrMode($eventID,$link) {

    $sql = "DELETE FROM `Prediction`
			   WHERE
					`UserID` = (SELECT `UserID` FROM `User` WHERE `FirstName` = 'Mr.' AND `LastName` = 'Mode')
					AND (`CompetitorEventID` IN (SELECT `CompetitorEventID` FROM `CompetitorEvent` WHERE `EventID` = " . $eventID . ") OR
					`SuggestionCompetitorEventID` IN (SELECT `SuggestionCompetitorEventID` FROM `SuggestionCompetitorEvent` WHERE `EventID` = " . $eventID . ") );";

    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = "Error deleting mr mode's previous predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }

    $sql = "SELECT
                tmp2.`CompetitorEventID`,
                tmp2.`SuggestionCompetitorEventID`
             FROM
                (SELECT
                    tmp.`CompetitorEventID`,
                    tmp.`SuggestionCompetitorEventID`,
                    SUM(tmp.`CompetitorScore`) AS `CompetitorScore`
                FROM
                    (SELECT
                        pr.`CompetitorEventID`,
                        pr.`SuggestionCompetitorEventID`,
                        CASE
                          WHEN pt.`Name` = 'Gold' THEN 3
                          WHEN pt.`Name` = 'Silver' THEN 2
                          WHEN pt.`Name` = 'Bronze' THEN 1
                          ELSE 0
                        END AS `CompetitorScore`

                    FROM `Prediction` pr
                      INNER JOIN `PredictionType` pt ON pt.`PredictionTypeID` = pr.`PredictionTypeID`
                      LEFT JOIN `CompetitorEvent` ce ON ce.`CompetitorEventID` = pr.`CompetitorEventID`
                      LEFT JOIN `SuggestionCompetitorEvent` sce ON sce.`CompetitorEventID` = pr.`CompetitorEventID`

                    WHERE ce.`EventID` = " . $eventID . " OR sce.`EventID` = " . $eventID . ") tmp
                GROUP BY tmp.`CompetitorEventID`, tmp.`SuggestionCompetitorEventID`) tmp2
             ORDER BY tmp2.`CompetitorScore` DESC
			 LIMIT 3;";

    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error calculating top 3 predictions: <br />' . mysqli_error($link) . '<br /><br />' . $sql;
        sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
        exit();
    }

    $i = 1;
    while ($row = mysqli_fetch_array($result)) {

        $sqlAdd = "INSERT INTO `Prediction` (
                    `CompetitorEventID`,
                    `SuggestionCompetitorEventID`,
                    `PredictionTypeID`,
                    `WRJoker`,
                    `UserID`,
                    `DateAdded`)
                 VALUES (
                    " . (($row['CompetitorEventID'] == null) ? 'NULL' : $row['CompetitorEventID'])  . ",
                    " . (($row['SuggestionCompetitorEventID'] == null) ? 'NULL' : $row['SuggestionCompetitorEventID']) . ",
                    " . $i . ",
                    0,
                    (SELECT `UserID` FROM `User` WHERE `FirstName` = 'Mr.' AND `LastName` = 'Mode'),
                    NOW()
                 )";

        $resultAdd = mysqli_query($link, $sqlAdd);
        if (!$resultAdd)
        {
            $error = "Error adding mr mode's predictions: <br />" . mysqli_error($link) . '<br /><br />' . $sqlAdd;
            sendEmail('james.macadie@telerealtrillium.com','Predictions Email Error','',$error);
            exit();
        }

        $i++;

    }

}

?>