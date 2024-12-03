<?php
   
   require_once("header.php");
   require_once("navigation.php");

   if(isset($_GET['homepage']))
   {
    require_once("homepage.php");
   }
    else if(isset($_GET['addElectionPage']))
   {
        require_once("add_election.php");
   }else if(isset($_GET['addCandidatePage']))
   {
        require_once("add_candidate.php");
   }else if(isset($_GET['viewResult']))
   {
      require_once("viewResult.php");
   }

?>

<?php
 
   require_once("footer.php");
?>