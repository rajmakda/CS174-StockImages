<?php
setcookie("user", "", time() - 3600, '/');
echo '<script>window.location = "home.php";</script>'    
?>