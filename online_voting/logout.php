<?php
     session_start();
     session_destroy();
     session_unset();

?>

<script>
    location.assign("Welcome_For_Online_Voting.php");
</script>