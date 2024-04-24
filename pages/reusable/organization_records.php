<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Application Forms</h3>
            </div>

            <div class="card-body">
                <table id="example4" class="table table-head-fixed table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $query1 = " SELECT * FROM user_tbl WHERE id = $user_id; ";
                            $result1 = mysqli_query($conn, $query1);
                            $row = mysqli_fetch_array($result1);
                            $user_organization = $row['organization'];

                            $query2 = " SELECT * FROM application_tbl WHERE organization = '$user_organization'; ";
                            $result2 = mysqli_query($conn, $query2);

                            $result_count = mysqli_num_rows($result2);

                            if($result_count > 0)
                            {
                                while($row = mysqli_fetch_assoc($result2))
                                {
                        ?>          
                                    <tr>
                                        <td> <?php echo $row['organization'] ?> </td>
                                        <td> <?php echo $row['president'] ?> </td>
                                        <td> <?php echo $row['year'] ?> </td>
                                        <td> 
                                            <?php 
                                                if(strtolower($row['status']) === 'pending')
                                                {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                                } else if(strtolower($row['status']) === 'success'){
                                                    echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                                }
                                            ?> 
                                        </td>
                                    </tr>   
                        <?php 
                                }
                            }
                        ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Renewal Forms</h3>
            </div>

            <div class="card-body">
                <table id="example3" class="table table-head-fixed table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>College</th>
                            <th>Academic Year</th>
                            <th>President</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $query1 = " SELECT * FROM user_tbl WHERE id = $user_id; ";
                            $result1 = mysqli_query($conn, $query1);
                            $row = mysqli_fetch_array($result1);
                            $user_organization = $row['organization'];

                            $query2 = " SELECT * FROM renewal_tbl WHERE organization = '$user_organization'; ";
                            $result2 = mysqli_query($conn, $query2);

                            $result_count = mysqli_num_rows($result2);

                            if($result_count > 0)
                            {
                                while($row = mysqli_fetch_assoc($result2))
                                {
                        ?>          
                                    <tr>
                                        <td> <?php echo $row['organization'] ?> </td>
                                        <td> <?php echo $row['college'] ?> </td>
                                        <td> <?php echo $row['year'] ?> </td>
                                        <td> <?php echo $row['president'] ?> </td>
                                        <td> 
                                            <?php 
                                                if(strtolower($row['status']) === 'pending')
                                                {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                                } else if(strtolower($row['status']) === 'success'){
                                                    echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                                }
                                            ?> 
                                        </td>
                                    </tr>   
                        <?php 
                                }
                            }
                        ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Commitment Forms</h3>
            </div>

            <div class="card-body">
                <table id="example1" class="table table-head-fixed table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>Adviser</th>
                            <th>Address</th>
                            <th>Contact</th>
                            <th>College</th>
                            <th>Academic Rank</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $query1 = " SELECT * FROM user_tbl WHERE id = $user_id; ";
                            $result1 = mysqli_query($conn, $query1);
                            $row = mysqli_fetch_array($result1);
                            $user_organization = $row['organization'];

                            $query2 = " SELECT * FROM commitment_tbl WHERE organization = '$user_organization'; ";
                            $result2 = mysqli_query($conn, $query2);

                            $result_count = mysqli_num_rows($result2);

                            if($result_count > 0)
                            {
                                while($row = mysqli_fetch_assoc($result2))
                                {
                        ?>          
                                    <tr>
                                        <td> <?php echo $row['organization'] ?> </td>
                                        <td> <?php echo $row['adviser'] ?> </td>
                                        <td> <?php echo $row['address'] ?> </td>
                                        <td> <?php echo $row['contact'] ?> </td>
                                        <td> <?php echo $row['college'] ?> </td>
                                        <td> <?php echo $row['rank'] ?> </td>
                                        <td> <?php echo $row['year'] ?> </td>
                                        <td> 
                                            <?php 
                                                if(strtolower($row['status']) === 'pending')
                                                {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                                } else if(strtolower($row['status']) === 'success'){
                                                    echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                                }
                                            ?> 
                                        </td>
                                    </tr>   
                        <?php 
                                }
                            }
                        ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Plan of Activities Forms</h3>
            </div>

            <div class="card-body">
                <table id="example2" class="table table-head-fixed table-striped" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th>Organization</th>
                            <th>President</th>
                            <th>Secretary</th>
                            <th>Academic Year</th>
                            <th>Status</th>
                            <th>Objectives</th>
                            <th>Activities</th>
                            <th>Brief Description</th>
                            <th>People Involved</th>
                            <th>Target Date</th>
                            <th>Budget</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php 
                            $query1 = " SELECT * FROM user_tbl WHERE id = $user_id; ";
                            $result1 = mysqli_query($conn, $query1);
                            $row = mysqli_fetch_array($result1);
                            $user_organization = $row['organization'];

                            $query2 = " SELECT * FROM plans WHERE organization = '$user_organization'; ";
                            $result2 = mysqli_query($conn, $query2);

                            $result_count = mysqli_num_rows($result2);

                            if($result_count > 0)
                            {
                                while($row = mysqli_fetch_assoc($result2))
                                {
                                    $sql2 = "SELECT objective FROM objectives WHERE plan_id = " . $row['id'];
                                    $result2 = mysqli_query($conn, $sql2);
                                    $objectives = mysqli_fetch_all($result2, MYSQLI_ASSOC);

                                    $sql3 = "SELECT activity FROM activities WHERE plan_id = " . $row['id'];
                                    $result3 = mysqli_query($conn, $sql3);
                                    $activities = mysqli_fetch_all($result3, MYSQLI_ASSOC);

                                    $sql4 = "SELECT description FROM brief_description WHERE plan_id = " . $row['id'];
                                    $result4 = mysqli_query($conn, $sql4);
                                    $descriptions = mysqli_fetch_all($result4, MYSQLI_ASSOC);

                                    $sql5 = "SELECT person FROM persons_involved WHERE plan_id = " . $row['id'];
                                    $result5 = mysqli_query($conn, $sql5);
                                    $people = mysqli_fetch_all($result5, MYSQLI_ASSOC);

                                    $sql6 = "SELECT date FROM target_date WHERE plan_id = " . $row['id'];
                                    $result6 = mysqli_query($conn, $sql6);
                                    $dates = mysqli_fetch_all($result6, MYSQLI_ASSOC);

                                    $sql7 = "SELECT budget FROM target_budget WHERE plan_id = " . $row['id'];
                                    $result7 = mysqli_query($conn, $sql7);
                                    $budgets = mysqli_fetch_all($result7, MYSQLI_ASSOC);
                        ?>          
                                    <tr>
                                        <td> <?php echo $row['organization'] ?> </td>
                                        <td> <?php echo $row['president'] ?> </td>
                                        <td> <?php echo $row['secretary'] ?> </td>
                                        <td> <?php echo $row['year'] ?> </td>
                                        <td> 
                                            <?php 
                                                if(strtolower($row['status']) === 'pending')
                                                {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-warning btn-sm">PENDING</button>';
                                                } else if(strtolower($row['status']) === 'success'){
                                                    echo '<button type="button" class="btn btn-block bg-gradient-success btn-sm"> SUCCESS </button>';
                                                } else {
                                                    echo '<button type="button" class="btn btn-block bg-gradient-danger btn-sm">FAILED</button>';
                                                }
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($objectives as $objective)
                                                {
                                                    echo $objective['objective'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($activities as $activity)
                                                {
                                                    echo $activity['activity'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($descriptions as $description)
                                                {
                                                    echo $description['description'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($people as $person)
                                                {
                                                    echo $person['person'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($dates as $date)
                                                {
                                                    echo $date['date'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                        <td> 
                                            <?php 
                                                foreach($budgets as $budget)
                                                {
                                                    echo $budget['budget'];
                                                    echo "<hr>";
                                                } 
                                            ?> 
                                        </td>
                                    </tr>   
                        <?php 
                                }
                            }
                        ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>