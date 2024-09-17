<?php
session_start();
session_destroy();
header("Location: /cabinet/index.php");
exit();
