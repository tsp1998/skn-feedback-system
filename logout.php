<?php
//start the session
session_start();
//remove all session varibles
session_unset();
//destroy the session
session_destroy();
echo "<script>location.href='index.html'</script>";
exit;
