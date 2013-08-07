<?php
    
    //error_reporting(E_ALL);
    //ini_set('display_errors', '1');
    
    session_start();
    foreach ($_POST AS $key => $val){
		$_SESSION[$key] = $val;
	}unset($key);
	unset($val);
    
    echo "<html>";
    echo "<head>";
    
    //sqlite3 methods
    
    /*function sqlite_open($location,$mode)
    {
        $handle = new SQLite3($location);
        return $handle;
    }
    function sqlite_query($dbhandle,$query)
    {
        $array['dbhandle'] = $dbhandle;
        $array['query'] = $query;
        $result = $dbhandle->query($query);
        return $result;
    }
    function sqlite_fetch_array(&$result,$type)
    {
        #Get Columns
        $i = 0;
        while ($result->columnName($i))
        {
            $columns[ ] = $result->columnName($i);
            $i++;
        }
        
        $resx = $result->fetchArray(SQLITE3_ASSOC); 
        return $resx; 
    }*/
    
    
    
    
    $dbhandle = new SQLite3('main');
//    $dbhandle = sqlite_open('locahost:8888/main', 0666);
//    if (!$dbhandle) die ($error);
    
    
    function numClicks($dbhandle) {
        
        $getId = uniqid();
        //$getId = "SELECT COUNT(*) as count FROM CrashSesh;"
        //$getId = "SELECT max(Id) FROM CrashSesh;";
        //$id = sqlite_query($dbhandle, $getId);
        //if (!$id) die ("Cannot execute query.");
        $exists = "SELECT EXISTS(SELECT Id FROM CrashSesh WHERE Id=\"" . $getId . "\"); ";
        $results = $dbhandle -> query($exists);
        while ($row = $results->fetchArray()) {
//            var_dump($id);
//            $id = $row[0];
            if ($row[0] == 0)
                return $getId;
            else
                numClicks($dbhandle);
        }
        //$id++;
//        return $id;
 
    }
    

    function currentPageURL() {
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
        $pageURL .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $pageURL;
    }
    
    function sqlGen($id, $topic, $description, $dbhandle) {
        $postTable = "CREATE TABLE Posts" . $id . "(Post Text);";
        $saveSesh = "INSERT INTO CrashSesh(Id, Topic, Description) VALUES (\"" . $id . "\", \"" . $topic . "\", \"" . $description . "\");";
        $dbhandle -> exec($postTable);
        $dbhandle -> exec($saveSesh);
    }

    function pgName($id) {
        $origURL = implode("/", explode("/", currentPageURL(), -1)) . "/session.php?id=" . $id;
        return $origURL;
    }
    
    
    $topic = $_SESSION['topic'];
    $description = $_SESSION['description'];
    $id = numClicks($dbhandle);
    sqlGen($id, $topic, $description, $dbhandle);
    $page = pgName($id);
?>
    <title>URL For <?=$topic?></title>
    </head>
    <body>
    
        <table width="300" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#efa351" style="position:relative;vertical-align:middle;top:100px;">
            <tr><td colspan="3" style="font-size: 24px;"><strong><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif">Session Info</font></strong></td></tr>
            <tr><td width="200"><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif">Topic</font></td>
            <td width="6"><font color="FFFFFF">:</font></td>
            <td width="200"><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif"><?=$topic?> </font></td></tr>
            <tr><td width="200"><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif">Description</font></td>
            <td width="6"><font color="FFFFFF">:</font></td>
            <td width="200"><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif"><?=$description?></font></td></tr>
            <tr><td width="200"><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif">Session URL</font></td>
            <td width="6"><font color="FFFFFF">:</font></td>
            <td width="200"><font color="FFFFFF" face="Trebuchet MS, Tahoma, Verdana, Arial, sans-serif"><a href=<?=$page?>><?=$page?></a></font></td></tr>
    </table>
    </body>
</html>
