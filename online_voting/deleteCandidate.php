<?php
include 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the candidate photo to delete it from the server
    $query = "SELECT candidate_photo FROM candidate_details WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $photo_path = $row['candidate_photo'];

        // Delete candidate record from the database
        $deleteQuery = "DELETE FROM candidate_details WHERE id = '$id'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Remove photo from server
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
            echo "<script> location.assign('adminDash.php?addCandidatePage=1&deleted=1'); </script>";
        } else {
            echo "<script> location.assign('adminDash.php?addCandidatePage=1&failed=1'); </script>";
        }
    }
}
?>
