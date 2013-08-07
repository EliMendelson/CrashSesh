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
    
    $topic = getTopic($idNum, $dbhandle);
    $description = getDescription($idNum, $dbhandle);
    
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
<html>
    <head>
        <title><?=$topic?></title>
    </head>
    <body>
        <h1 align="center"><?=$topic?></h1>
        <h2 align="center"><?=$description?></h2>

    <ol id="update" class="timeline">
    <?php
    $result = $dbhandle -> query("SELECT Post FROM Posts" . $idNum . ";");
    while($row=$result->fetchArray())
    {
        $post=$row['Post'];
    ?>
        <li class="box">
        <?php echo $post; ?></li>
        <?php
        }
        ?>
        </ol>
    <div id="flash"></div>
    <div id="form">
    
    <form action="#" method="post">
    <textarea id="comment"></textarea><br />
    <input type="submit" class="submit" value=" Submit Comment " />
    </form>
    </div>

    <script type="text/javascript" src="jquery.js"></script>
    <script type="text/javascript" >
        $(function() {
          //function redirect() {
            //window.location = "results.php"
          //alert("Comment");
          //}
          //var timer = setTimeout("redirect()", 20000);
          
          setTimeout(function() { $("#form").remove(); }, 20000);
          //$("#form").delay(20000).fadeOut();
          
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
    </script>

    </body>
</html>