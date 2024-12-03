<?php  
     $election_id = $_GET['viewResult'];



?>





<div class="row my-3">
    <div class="col-12">
        <h3>Election Result</h3>
        <?php
        include 'connect.php';

        // Fetch all active elections grouped by election topic
        $query = "SELECT * FROM election WHERE Id = '".$election_id."'";
        $data = mysqli_query($conn, $query);

        // Initialize an empty array to track already displayed topics
        $displayed_topics = [];

        if (mysqli_num_rows($data) > 0) {
            while ($row = mysqli_fetch_assoc($data)) {
                $election_id = $row['Id'];
                $election_topic = strtoupper($row['election_topic']);

                // Check if this election topic has been displayed already
                if (!in_array($election_topic, $displayed_topics)) {
                    // Add this topic to the displayed array to avoid duplicate rendering
                    $displayed_topics[] = $election_topic;
        ?>
                    <!-- Create a single table for each unique election topic -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="4" class="bg-green">ELECTION TOPIC: <?php echo $election_topic; ?></th>
                            </tr>
                            <tr>
                                <th>Photo</th>
                                <th>Candidate Details</th>
                                <th># of Votes</th>
                                <!--<th>Action</th>-->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Fetch candidates for the current election topic
                            $candidate_query = "SELECT * FROM candidate_details WHERE election_topic = '$election_topic'";
                            $candidate_data = mysqli_query($conn, $candidate_query);

                            if (mysqli_num_rows($candidate_data) > 0) {
                                while ($candidate_row = mysqli_fetch_assoc($candidate_data)) {
                                    $candidate_id = $candidate_row['id'];
                                    $candidate_photo = $candidate_row['candidate_photo'];

                                    // Fetch total votes for the candidate
                                    $fetchingVotes = "SELECT * FROM votings WHERE candidate_id = '$candidate_id'";
                                    $fetchingVotesData = mysqli_query($conn, $fetchingVotes);
                                    $totalVotes = mysqli_num_rows($fetchingVotesData);
                            ?>
                                    <tr>
                                        <td>
                                            <img src="../assets/images/candidate_photos/<?= $candidate_photo ?>" 
                                                style="border-radius: 50%; border: 2px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" 
                                                width="80" height="80">
                                        </td>
                                        <td>
                                            <b><?= $candidate_row['candidate_name'] ?></b><br><?= $candidate_row['candidate_details'] ?>
                                        </td>
                                        <td><?= $totalVotes ?></td>
                                        
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>No candidates available for this election topic.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
        <?php
                }
            }
        } else {
        ?>
            <p class="text-center">No active elections found.</p>
        <?php
        }
        ?>


        <hr>

        <h3>Voting Details</h3>
        
            <?php
                 $fetchingVoteDetails = mysqli_query($conn,"SELECT * FROM votings WHERE election_id = '".$election_id."' ");
                $number_of_votes = mysqli_num_rows($fetchingVoteDetails);

                if($number_of_votes > 0)
                {
                    $sno=1;

                    ?>

                            <table class="table">
                                        <tr>
                                            <th>S.no</th>
                                            <th>Voter Name</th>
                                            <th>Contact No</th>
                                            <th>Voted to</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                        </tr>
                    <?php
                    while($data = mysqli_fetch_assoc($fetchingVoteDetails))
                    {
                        $voters_id = $data['voters_id'];
                        $candidate_id = $data['candidate_id'];
                        $fetchingUsername = mysqli_query($conn, "SELECT * FROM user WHERE id='".$voters_id."'") or die(mysqli_error($conn));
                        $isDataAvailable = mysqli_num_rows($fetchingUsername);
                        $userData = mysqli_fetch_assoc($fetchingUsername);
                        if($isDataAvailable > 0)
                        {
                            
                            $username = $userData['username'];
                            $phone_number = $userData['phone_number'];

                        }else{
                            $username = "no_data";
                            $phone_number = $userData['phone_number'];
                        }

                        $fetchingCandidateName = mysqli_query($conn, "SELECT * FROM candidate_details WHERE id='".$candidate_id."'") or die(mysqli_error($conn));
                        $isDataAvailable = mysqli_num_rows($fetchingCandidateName);
                        $candidateData = mysqli_fetch_assoc($fetchingCandidateName);
                        if($isDataAvailable > 0)
                        {
                            
                            $candidate_name = $candidateData['candidate_name'];
                            

                        }else{
                            $candidate_name = "no data";
                        }


                ?>
                        <tr>
                            <td><?php echo $sno++; ?></td>
                            <td><?php echo $username; ?></td>
                            <td><?php echo $phone_number; ?></td>
                            <td><?php echo $candidate_name; ?></td>
                            <td><?php echo $data['vote_date']; ?></td>
                            <td><?php echo $data['vote_time']; ?></td>

                <?php

                    }
                    echo "</table>";

                }else{
                    echo "No any vote details is available ";
                }
                
            
            ?>
        
    </div>
</div>