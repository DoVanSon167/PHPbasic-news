<?php

echo "<html><br><br><br><div id='loading'><p><img src='loader.gif'> Please wait 6 seconds...</p></div></html>";
@ob_flush(); //flush the output buffer
flush(); //flush anything else
sleep(6); //wait
header('Location: http://google.com/'); //redirect

?>