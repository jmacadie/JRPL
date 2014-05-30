<?php

function userIsLoggedIn()
{

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Log In
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if (isset($_POST['action']) and $_POST['action'] === 'login')
    {

        if (!isset($_POST['email']) or $_POST['email'] == '')
        {
            $GLOBALS['loginError'] = 'Please fill in e-mail address field';
            return FALSE;
        }

        $password = md5($_POST['password'] . 'jrp');
        if (correctPassword($_POST['email'], $password))
        {
			setUserSessionInfo($_POST['email']);
            return TRUE;
        }
        else
        {
            unsetUserSessionInfo();

            if (databaseContainsUser($_POST['email']))
            {
                $GLOBALS['loginError'] = 'The password was incorrect';
                return FALSE;
            }
            else
            {
                $GLOBALS['loginError'] = 'The specified email address does not exist';
                return FALSE;
            }
        }
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Log Out
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if (isset($_POST['action']) and $_POST['action'] === 'logout')
    {
        unsetUserSessionInfo();
        header('Location: .');
        exit();
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Update details
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if (isset($_POST['action']) and $_POST['action'] === 'update')
    {

        if (isset($_POST['displayName'])) $displayName = $_POST['displayName'];
        if (isset($_POST['firstName'])) $firstName = $_POST['firstName'];
        if (isset($_POST['lastName'])) $lastName = $_POST['lastName'];
        if (isset($_POST['email'])) $email = $_POST['email'];
        if (isset($_POST['pwd'])) $password = $_POST['pwd'];
        if (isset($_POST['pwd2'])) $password2 = $_POST['pwd2'];

        session_start();
        if (isset($_SESSION['userID'])) $userID = $_SESSION['userID'];

        if ($password <> $password2)
        {
            $GLOBALS['loginError'] = 'The passwords do not match';
            return TRUE;
        }
        
        if ($password == '')
        {
            $updatePasswords=FALSE;
        }
        else
        {
            $updatePasswords=TRUE;
        }

        $password = md5($password . 'jrp');

        include 'db.inc.php';

        $displayName = mysqli_real_escape_string($link, $displayName);
        $firstName = mysqli_real_escape_string($link, $firstName);
        $lastName = mysqli_real_escape_string($link, $lastName);
        $email = mysqli_real_escape_string($link, $email);
        $password = mysqli_real_escape_string($link, $password);
        $userID = mysqli_real_escape_string($link, $userID);

        if ($updatePasswords)
        {
            $sql = "UPDATE `User`
                    SET `DisplayName` = '$displayName',
                        `FirstName` = '$firstName',
                        `LastName` = '$lastName',
                        `Email` = '$email',
                        `Password` = '$password'
                    WHERE `UserID`=$userID";
        }
        else
        {
            $sql = "UPDATE `User`
                    SET `DisplayName` = '$displayName',
                        `FirstName` = '$firstName',
                        `LastName` = '$lastName',
                        `Email` = '$email'
                    WHERE `UserID`=$userID";
        }

        $result = mysqli_query($link, $sql);
        if (!$result)
        {
            $error = 'Error updating details';
            include 'error.html.php';
            exit();
        }

        setUserSessionInfo($email);

        header('Location: .');
        exit();

    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    // Check logged in status
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    
    if (isset($_SESSION['loggedIn']) and $_SESSION['loggedIn']==TRUE)
    {

        return correctPassword($_SESSION['email'], $_SESSION['password']);

    }
    else
    {
        return FALSE;
    }
}

function correctPassword($email, $password)
{
    include 'db.inc.php';

    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);

    $sql = "SELECT COUNT(*) FROM `User`
            WHERE `Email`='$email' AND `Password`='$password'";
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error searching for user password combination';
        include 'error/index.php';
        exit();
    }
    $row = mysqli_fetch_array($result);

    if ($row[0] > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function databaseContainsUser($email)
{
    include 'db.inc.php';

    $email = mysqli_real_escape_string($link, $email);

    $sql = "SELECT COUNT(*) FROM `User`
            WHERE `Email`='$email'";
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error searching for user';
        include 'error/index.php';
        exit();
    }
    $row = mysqli_fetch_array($result);

    if ($row[0] > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function userHasRole($role)
{
    include 'db.inc.php';

    $userID = mysqli_real_escape_string($link, $_SESSION['userID']);
    $role = mysqli_real_escape_string($link, $role);

    $sql = "SELECT COUNT(*) FROM `User` u
            INNER JOIN `UserRole` ur ON ur.UserID = u.`UserID`
            INNER JOIN `Role` r ON r.RoleID = ur.`RoleID`
            WHERE u.`UserID` = $userID AND r.`Name`='$role'";
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error searching for user roles';
        include 'error/index.php';
        exit();
    }
    $row = mysqli_fetch_array($result);

    if ($row[0] > 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function setUserSessionInfo($email)
{
    include 'db.inc.php';
	
    // Make e-mail string safe
    $email = mysqli_real_escape_string($link, $email);

    // Get all fields except role
    $sql = "SELECT `UserID`,`Password`,`FirstName`,`LastName`,`DisplayName`
            FROM `User` u
            WHERE u.`Email` = '".$email."'
            LIMIT 1";

    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error selecting user details';
        include 'error/index.php';
        exit();
    }
    $row = mysqli_fetch_array($result);
	
    // Set session variables
    session_start();
    $_SESSION['loggedIn'] = TRUE;
    $_SESSION['email'] = $email;
    $_SESSION['userID'] = $row['UserID'];
    $_SESSION['password'] = $row['Password'];
    $_SESSION['firstName'] = $row['FirstName'];
    $_SESSION['lastName'] = $row['LastName'];
    $_SESSION['displayName'] = $row['DisplayName'];
	
    // Get admin role
    $userID = $row['UserID'];
    $sql = "SELECT COUNT(*) FROM `User` u
            INNER JOIN `UserRole` ur ON ur.`UserID` = u.`UserID`
            INNER JOIN `Role` r ON r.`RoleID` = ur.`RoleID`
            WHERE u.`UserID` = ".$userID." AND r.`Role`='Admin'";
	
    $result = mysqli_query($link, $sql);
    if (!$result)
    {
        $error = 'Error selecting user roles';
        include 'error/index.php';
        exit();
    }
    $row = mysqli_fetch_array($result);

    if ($row[0] > 0)
    {
        $_SESSION['isAdmin'] = TRUE;
    }
    else
    {
        $_SESSION['isAdmin'] = FALSE;
    }

}

function unsetUserSessionInfo()
{
    session_start();
    //unset($_SESSION['loggedIn']);
    $_SESSION['loggedIn'] = FALSE;
    unset($_SESSION['userID']);
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    unset($_SESSION['firstName']);
    unset($_SESSION['lastName']);
    unset($_SESSION['displayName']);
    unset($_SESSION['isAdmin']);
}

?>
