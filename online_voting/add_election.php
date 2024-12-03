<?php
if (isset($_GET['added'])) {
?>    
    <div class="alert alert-success my-3" role="alert">
        Election has been added successfully.
    </div>
<?php      
}
if (isset($_GET['updated'])) {
?>
    <div class="alert alert-success my-3" role="alert">
        Election has been updated successfully.
    </div>
<?php      
}
if (isset($_GET['deleted'])) {
?>
    <div class="alert alert-success my-3" role="alert">
        Election has been deleted successfully.
    </div>
<?php
}
?>

<?php
include 'connect.php';
?>

<div class="row my-3">
    <div class="col-4">
        <h3>Add Election</h3>
        <form method="POST">
            <div class="form-group">
                <input type="hidden" name="election_id" id="election_id" />
                <input type="text" name="election_topic" id="election_topic" class="form-control" placeholder="Election topic" required />
            </div>
            <div class="form-group">
                <input type="number" name="number_of_candidate" id="number_of_candidate" class="form-control" placeholder="Number of candidates" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='date'" name="starting_date" id="starting_date" class="form-control" placeholder="Starting date" required />
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='date'" name="ending_date" id="ending_date" class="form-control" placeholder="Ending Date" required />
            </div>
            <input type="submit" value="Submit" name="submitElection" class="btn btn-success" />
        </form>
    </div>

    <div class="col-8">
        <h3>Upcoming Elections</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Election Name</th>
                    <th scope="col">Candidates</th>
                    <th scope="col">Starting Date</th>
                    <th scope="col">Ending Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT * FROM election";
                $data = mysqli_query($conn, $query);
                $total = mysqli_num_rows($data);

                if ($total != 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        echo "
                        <tr>
                            <td>".$result['Id']."</td>
                            <td>".$result['election_topic']."</td>
                            <td>".$result['number_of_candidate']."</td>
                            <td>".$result['starting_date']."</td>
                            <td>".$result['ending_date']."</td>
                            <td>".$result['status']."</td>
                            <td>
                                <button class='btn btn-sm btn-danger delete-btn' data-id='".$result['Id']."'>Delete</button>
                            </td>
                        </tr>";
                    }    
                } else {
                    echo "<tr><td colspan='7'>No Record Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if (isset($_POST['submitElection'])) {
    $election_topic = $_POST['election_topic'];
    $number_of_candidate = $_POST['number_of_candidate'];
    $starting_date = $_POST['starting_date'];
    $ending_date = $_POST['ending_date'];
    $inserted_on = date("Y-m-d");

    $status = (date_create($inserted_on) < date_create($starting_date)) ? "Inactive" : "Active";

    // Insert new record
    $sql = "INSERT INTO election (election_topic, number_of_candidate, starting_date, ending_date, status, inserted_on) 
            VALUES ('$election_topic', '$number_of_candidate', '$starting_date', '$ending_date', '$status', '$inserted_on')";

    if ($conn->query($sql) === TRUE) {
        echo "<script> location.assign('adminDash.php?addElectionPage=1&added=1'); </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM election WHERE Id = '$delete_id'";
    if ($conn->query($sql) === TRUE) {
        echo "<script> location.assign('adminDash.php?addElectionPage=1&deleted=1'); </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Handle Delete button click
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            if (confirm('Are you sure you want to delete this election?')) {
                window.location.href = `adminDash.php?addElectionPage=1&delete_id=${id}`;
            }
        });
    });
});
</script>
