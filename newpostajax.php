<?php
    
    session_start();
    foreach ($_GET AS $key => $val){
		$_SESSION[$key] = $val;
	}unset($key);
	unset($val);
    
    $dbhandle = new SQLite3('main');
    
    if($_POST)
    {
        $comment=$_POST['comment'];
        $dbhandle -> exec("INSERT INTO Posts" . $_SESSION['id'] . "(Post) VALUES (\"" . $comment . "\");");
    }
    
?>

<li class="box">
    <?php echo $comment; ?>
</li>