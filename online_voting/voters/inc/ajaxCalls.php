<?php 
require_once("../../connect.php");

if (isset($_POST['e_id']) && isset($_POST['c_id']) && isset($_POST['v_id'])) {
    // Ensure the database connection is valid
    if (!$conn instanceof mysqli) {
        die("Database connection error.");
    }

    // Sanitize inputs
    $election_id = $conn->real_escape_string($_POST['e_id']);
    $candidate_id = $conn->real_escape_string($_POST['c_id']);
    $voters_id = $conn->real_escape_string($_POST['v_id']);

    $vote_date = date("Y-m-d");
    $vote_time = date("h:i:s a");

    // Fetch the election_topic based on the election_id
    $fetch_topic_query = "SELECT election_topic FROM election WHERE Id = '$election_id'";
    $fetch_topic_result = $conn->query($fetch_topic_query);

    if ($fetch_topic_result && $fetch_topic_result->num_rows > 0) {
        $election_topic_row = $fetch_topic_result->fetch_assoc();
        $election_topic = $election_topic_row['election_topic'];

        // Insert vote record with election_topic
        $query = "INSERT INTO votings (election_id, election_topic, voters_id, candidate_id, vote_date, vote_time) 
                  VALUES ('$election_id', '$election_topic', '$voters_id', '$candidate_id', '$vote_date', '$vote_time')";

        if ($conn->query($query)) {
            echo "Success";
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: Election topic not found for the provided election ID.";
    }
} else {
    echo "Invalid parameters.";
}
?>