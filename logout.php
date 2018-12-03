<!-- Written by Raj Makda SJSU ID: 010128222 -->

<?php
setcookie("user", "", time() - 3600, '/');
echo '<script>window.location = "home.php";</script>'    
?>