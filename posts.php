<?php
    $id = $_SESSION['id'];
    $dbhandle = new SQLite3('main');
        $result = $dbhandle -> query("SELECT Post FROM Posts" . $id . ";");
    
            while($row=$result->fetchArray())
            {
                $post=$row['Post'];
        ?>
        <li class="box">
        <?php echo $post; ?></li>
        <?php
                }
            }
        ?>