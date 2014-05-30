<?php
/*

http://www.sitepoint.com/forums/showthread.php?p=4399349#post4399349

I recently came across a problem when working through the 4th edition of Kevin
Yank's "Build Your Own Data-Driven Website."

There appears to be an incompatibility between certain software packages and
operating systems. In particular, this affects PHP 5.3 when trying to connect to
MySQL while running on Windows Vista with Apache. It is not really a bug, but a
discrepancy between how far along the different elements are in the transition
from IPv4 to IPv6.

Basically, when PHP tries to connect to the database, it times out because it
does not recognize localhost, only 127.0.0.1, and produces the following
error message:

=========================

Warning: mysqli_connect() [function.mysqli-connect]: [2002] A connection attempt
failed because the connected party did not (trying to connect via tcp://
localhost:3306) in C:\Program Files\Apache Software Foundation\Apache2.2\htdocs\
phpmysql-4\chapter4\connect\index.php on line 2

Warning: mysqli_connect() [function.mysqli-connect]: (HY000/2002): A connection
attempt failed because the connected party did not properly respond after a
period of time, or established connection failed because connected host has
failed to respond. in C:\Program Files\Apache Software Foundation\Apache2.2\
htdocs\phpmysql-4\chapter4\connect\index.php on line 2

Fatal error: Maximum execution time of 30 seconds exceeded in C:\Program Files\
Apache Software Foundation\Apache2.2\htdocs\phpmysql-4\chapter4\connect\index.php
on line 2

=========================

There are two possible solutions to this problem:

=========================

1. Replace "localhost" with "127.0.0.1" in all PHP files that you wish to have
connect to a MySQL database

2. Locate the "hosts" file on your computer. It is typically at a location such
as this:

C:\Windows\System32\drivers\etc\hosts

Open it up, and comment out the line that prevents the localhost from "mapping"
correctly; in otherwords, change

::1 localhost

to

#::1 localhost

This solution was, in fact, presented in the SitePoint forums previously, though
without a full explanation of the details.

http://www.sitepoint.com/forums/showthread.php?t=637612

=========================

The issue is described in detail on the PHP forum at the following link:

http://bugs.php.net/bug.php?id=45150

Please note that -- from what I understand -- Windows XP does not have this
problem, as it is configured only to IPv4. Vista runs into a problem because it
is designed to handle both, as is Windows 7.

Also, I should mention that using PHP 5.2 with the aforementioned book is not
recommended because there is a bug in that version -- a veritable one -- that
causes Apache to crash when it attempts to open the "deletejoke" file.

*/
$link = mysqli_connect('localhost', 'julianri_admin', '8@xgT54^1n'); /* 8@xgT54^1n */
if (!$link)
{
    $error = 'Unable to connect to the database server';
    include 'error/index.php';
    exit();
}

if (!mysqli_set_charset($link, 'utf8'))
{
    $error = 'Unable to set database connection encoding';
    include 'error/index.php';
    exit();
}

if (!mysqli_select_db($link, 'julianri_worldcup2014'))
{
    $error = 'Unable to locate the database';
    include 'error/index.php';
    exit();
}
?>
