
<?php
include 'connect.php';
?>

<div class="row my-3">
    <div class="col-12">
        <h3>Elections</h3>
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
                include 'connect.php';
                $query = "SELECT * FROM election";
                $data = mysqli_query($conn, $query);
                $total = mysqli_num_rows($data);

                if ($total != 0) {
                    while ($result = mysqli_fetch_assoc($data)) {
                        $election_id=$result['Id'];
                ?>
                        <tr>
                            <td><?php echo $result['Id']; ?></td>
                            <td><?php echo $result['election_topic']; ?></td>
                            <td><?php echo $result['number_of_candidate']; ?></td>
                            <td><?php echo $result['starting_date']; ?></td>
                            <td><?php echo $result['ending_date']; ?></td>
                            <td><?php echo $result['status']; ?></td>
                            <td>
                                <a href="adminDash.php?viewResult=<?php echo $election_id; ?> " class="btn btn-sm btn-success">View Result</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>No Record Found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



