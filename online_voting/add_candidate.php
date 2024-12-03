<?php
    if (isset($_GET['added'])) {
?>    
        <div class="alert alert-success my-3" role="alert">
            Candidate has been added successfully.
        </div>
<?php      
    } elseif (isset($_GET['largerFile'])) {
?>        
        <div class="alert alert-danger my-3" role="alert">
            Candidate image is too large, please upload smaller images.
        </div>
<?php            
    } elseif (isset($_GET['invalidFile'])) {
?>        
        <div class="alert alert-danger my-3" role="alert">
            Invalid image type. Only .jpg, .png files are allowed.
        </div>
<?php
    } elseif (isset($_GET['failed'])) {
?>        
        <div class="alert alert-danger my-3" role="alert">
            Image uploading failed, please try again.
        </div>
<?php
    } elseif (isset($_GET['deleted'])) {
?>        
        <div class="alert alert-success my-3" role="alert">
            Candidate has been deleted successfully.
        </div>
<?php
    }
?>

<?php
    include 'connect.php';
?>

<div class="row my-3">
    <div class="col-4">
        <h3>Add New Candidates</h3>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select name="election_id" class="form-control" required>
                    <option value="">Select Election</option>
                    <?php
                        $query = "SELECT Id, election_topic 
                                  FROM election 
                                  WHERE Id NOT IN (SELECT DISTINCT election_id FROM candidate_details)";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['Id']}'>{$row['election_topic']}</option>";
                            }
                        } else {
                            echo "<option value=''>No elections available</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="candidate_name" class="form-control" placeholder="Candidate Name" required />
            </div>
            <div class="form-group">
                <input type="file" name="candidate_photo" class="form-control" required />
            </div>
            <div class="form-group">
                <input type="text" name="candidate_details" class="form-control" placeholder="Candidate Details" required />
            </div>
            <input type="submit" value="Add Candidate" name="addCandidateBtn" class="btn btn-success" />
        </form>
    </div>

    <div class="col-8">
        <h3>Candidates Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $query = "SELECT c.id, c.candidate_name, c.candidate_details, c.candidate_photo, e.election_topic
                          FROM candidate_details c
                          INNER JOIN election e ON c.election_id = e.Id";
                $data = mysqli_query($conn, $query);
                $total = mysqli_num_rows($data);

                if ($total != 0) {
                    $index = 1;
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "
                        <tr>
                            <td>{$index}</td>
                            <td>
                                <img src='{$result['candidate_photo']}' alt='Candidate Photo' 
                                  style='border-radius: 50%; border: 2px solid #ddd; box-shadow: 0 2px 5px rgba(0,0,0,0.1);' 
                                  width='80' height='80'>
                            </td>
                            <td>{$result['candidate_name']}</td>
                            <td>{$result['candidate_details']}</td>
                            <td>{$result['election_topic']}</td>
                            <td>
                                <a href='deleteCandidate.php?id={$result['id']}' 
                                   class='btn btn-sm btn-danger delete-btn'
                                   onclick='return confirm(\"Are you sure you want to delete this candidate?\");'>Delete</a>
                            </td>
                        </tr>";
                        $index++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No candidates found</td></tr>";
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST['addCandidateBtn'])) {
    $election_id = $_POST['election_id'];
    $candidate_name = $_POST['candidate_name'];
    $candidate_details = $_POST['candidate_details'];
    $inserted_on = date("Y-m-d");

    $fetchElectionTopicQuery = "SELECT election_topic FROM election WHERE Id = '$election_id'";
    $fetchElectionTopicResult = mysqli_query($conn, $fetchElectionTopicQuery);
    $election_topic = '';

    if (mysqli_num_rows($fetchElectionTopicResult) > 0) {
        $row = mysqli_fetch_assoc($fetchElectionTopicResult);
        $election_topic = $row['election_topic'];
    }

    $targetted_folder = "assets/images/candidate_photos/";
    $candidate_photo = $targetted_folder . rand(11111111, 99999999999999) . $_FILES['candidate_photo']['name'];
    $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "png", "jpeg");
    $image_size = $_FILES['candidate_photo']['size'];

    if ($image_size < 2000000) {
        if (in_array($candidate_photo_type, $allowed_types)) {
            $sql = "INSERT INTO candidate_details (election_id, election_topic, candidate_name, candidate_details, candidate_photo, inserted_on) 
                    VALUES ('$election_id', '$election_topic', '$candidate_name', '$candidate_details', '$candidate_photo', '$inserted_on')";

            if ($conn->query($sql) === TRUE) {
                move_uploaded_file($_FILES['candidate_photo']['tmp_name'], $candidate_photo);
                echo "<script> location.assign('adminDash.php?addCandidatePage=1&added=1'); </script>";
            } else {
                echo "<script> location.assign('adminDash.php?addCandidatePage=1&failed=1'); </script>";
            }
        } else {
            echo "<script> location.assign('adminDash.php?addCandidatePage=1&invalidFile=1'); </script>";
        }
    } else {
        echo "<script> location.assign('adminDash.php?addCandidatePage=1&largerFile=1'); </script>";
    }
}
?>
