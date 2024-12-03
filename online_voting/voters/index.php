<?php
require_once("inc/header.php");
require_once("inc/navigation.php");
?>

<div class="row my-3">
    <div class="col-12">
        <h3>Voter Panel</h3>
        <?php
        include '../connect.php';

        // Fetch all active elections grouped by election topic
        $query = "SELECT * FROM election WHERE status = 'Active' ORDER BY election_topic";
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
                                <th>Action</th>
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
                                        <td>
                                            <?php
                                            // Check if the voter has already voted for this election
                                            $checkIfVoteCastedQuery = "
                                                SELECT * FROM votings 
                                                WHERE voters_id = '" . $_SESSION['user_id'] . "' 
                                                AND election_id = '$election_id'
                                            ";
                                            $checkIfVoteCastedResult = mysqli_query($conn, $checkIfVoteCastedQuery);

                                            if ($checkIfVoteCastedResult) {
                                                $isVoteCasted = mysqli_num_rows($checkIfVoteCastedResult);

                                                if ($isVoteCasted > 0) {
                                                    $voteCastedData = mysqli_fetch_assoc($checkIfVoteCastedResult);
                                                    $voteCastedToCandidate = $voteCastedData['candidate_id'];

                                                    // Show "Vote Casted" icon if the user has already voted
                                                    if ($voteCastedToCandidate == $candidate_id) {
                                            ?>
                                                        <img src="../vote.png" alt="" width="100">
                                            <?php
                                                    }
                                                } else {
                                                    // Show the vote button if the user hasn't voted for this election
                                            ?>
                                                    <button class="btn btn-md btn-success" 
                                                        onclick="CastVote(<?= $election_id ?>, <?= $candidate_id ?>, <?= $_SESSION['user_id'] ?>)">
                                                        Vote
                                                    </button>
                                            <?php
                                                }
                                            } else {
                                                echo "Error checking votes: " . mysqli_error($conn);
                                            }
                                            ?>
                                        </td>
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
    </div>
</div>

<script>
    const CastVote = (election_id, candidate_id, voters_id) => {
        if (!voters_id) {
            console.error("User ID is missing. Please log in.");
            return;
        }

        $.ajax({
            type: "POST",
            url: "inc/ajaxCalls.php",
            data: {
                e_id: election_id,
                c_id: candidate_id,
                v_id: voters_id
            },
            success: function(response) {
                if (response.trim() === "Success") {
                    location.assign("index.php?voterCasted=1");
                } else {
                    location.assign("index.php?voterNotCasted=1");
                }
            }
        });
    };
</script>

<?php
require_once("inc/footer.php");
?>
