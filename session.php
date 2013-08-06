<?php

    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    
    session_start();
    foreach ($_GET AS $key => $val){
		$_SESSION[$key] = $val;
	}unset($key);
	unset($val);
  
    $idNum = $_SESSION['id'];
    //$dbmain = new SQLite3('main');
    //$dbposts = new SQLite3('Posts' . $idNum);
    $dbhandle = new SQLite3('main');
    
    function getTopic($id, $dbhandle) {
        $getTopic = "SELECT Topic FROM CrashSesh WHERE Id=\"" . $id . "\";";
        $result = $dbhandle -> query($getTopic);
        while ($row = $result->fetchArray()) {
            $topic = $row[0];
        }
        return $topic;
    }
    function getDescription($id, $dbhandle) {
        $getDescription = "SELECT Description FROM CrashSesh WHERE Id=\"" . $id . "\";";
        $result = $dbhandle -> query($getDescription);
        while ($row = $result->fetchArray()) {
            $description = $row[0];
        }
        return $description;
    }
    function getTime($id, $dbhandle) {
        $getTime = "SELECT Time FROM timeLeft WHERE Id=\"" . $id . "\";";
        $result = $dbhandle -> query($getTime);
        while ($row = $result->fetchArray()) {
            $time = $row[0];
        }
        return $time;
    }
    
    function setTime($id, $dbhandle) {
        $setTime = "INSERT INTO TimeLeft(Id, Time) VALUES (\"" . $id . "\", " . time() . ");";
        $dbhandle -> exec($setTime);
    }
    
    function timeDiff($time) {
        $timeDiff = time() - $time;
        return $timeDiff;
    }
    
    $topic = getTopic($idNum, $dbhandle);
    $description = getDescription($idNum, $dbhandle);
    $time = 0;
    $timeSince = 0;
    
    /*
     $idNum = $_SESSION['id'];
     $dbhandle = sqlite_open('/Users/elimendelson/main.db', 0666, $error);
     if (!$dbhandle) die ($error);
     
     $ok = sqlite_exec($dbhandle, $getId, $error);
     
     
     class sesh {
     
     public function __construct($topicInput, $descriptionInput, $idNum) {
     $this->topic = $topicInput;
     $this->description = $descriptionInput;
     $this->posts = array();
     $this->id = $idNum;
     }
     
     public function getTopic() {
     return $this->topic;
     }
     
     public function getDescription() {
     return $this->description;
     }
     
     public function getExt() {
     return $this->ext;
     }
     
     }
     */
    
    
    //    $seshInstance = unserialize($_SESSION{"$seshInstance" . $idNum});
    //    $seshInstance = unserialize($_SESSION[$_GET['id']]);
    //    $seshInstance = new Sesh($_SESSION[$_GET['id']]->getTopic(), $_SESSION[$_GET['id']]->getDescription(), $_SESSION[$_GET['id']]->getExt());
    //    echo $_GET['id'];
    //    echo $seshInstance->getExt();
    
    
?>


<script type="text/javascript" >
function currentTime() {
    return <?= $time ?>;
}
function timeElapsed() {
    return <?= $timeSince ?>;
}
</script>


<html>
    <head>
        <title><?=$topic?></title>
    </head>
    <body>
        <h1 align="center"><?=$topic?></h1>
        <h2 align="center"><?=$description?></h2>

        <ol id="update" class="timeline"></ol>

        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" >
            function refresh(){
                $("ol#update").load("posts.php", function(){
                        setTimeout(refresh(), 1000);
                });
            }
            if ((currentTime() != 0) && (timeElapsed() <= 20)) {
                $(document).ready(function(){refresh()});
            }
        </script>

        <div id="flash"></div>
        <div id="startButton"></div>

        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" >
            if ((currentTime() != 0) && (timeElapsed() <= 20)) {
        </script>
        <div >
    
            <form action="#" method="post">
                <textarea id="comment"></textarea><br />
                <input type="submit" class="submit" value=" Submit Comment " />
            </form>
        </div>
    
        <script type="text/javascript" src="jquery.js"></script>
        <script type="text/javascript" >
            $(function() {
              function redirect() {
                alert("Comment");
              }
              var timer = setTimeout("redirect()", 20000);
              $(".submit").click(function()
                         {
                         var comment = $("#comment").val();
                         var dataString = 'comment=' + comment;
                         if(comment=='')
                         {
                         alert('Please Give Valid Details');
                         }
                         else
                         {
                         $("#flash").show();
                         $.ajax({
                                type: "POST",
                                url: "newpostajax.php",
                                data: dataString,
                                cache: false,
                                success: function(html){
                                $("ol#update").append(html);
                                $("ol#update li:last").fadeIn("slow");
                                $("#flash").hide();
                                }
                                });
                         }return false;
                         //clearTimeout(timer);
                         //timer = setTimeout('redirect()', 20000);
                         }); });
    
            } elseif (currentTime() == 0) {
                
                $("#startButton").append('<input type="button" value="Start Session">').button().click(function(){<?php setTime($idNum, $dbhandle); ?>});
                <?php $time = getTime($idNum, $dbhandle); ?>
            }
        </script>

    </body>
</html>