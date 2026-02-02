<?php

session_abort();

unset($_SESSION['username']);

header("Location: ../index.php");
exit;