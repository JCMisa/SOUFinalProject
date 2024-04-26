<?php $currentYear = date("Y"); ?>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-2"><?php echo $user_organization ?> Activities For Year <?php echo $currentYear ?> </h5>
    </div>
    <div class="card card-success">
        <div class="card-body">
            <div class="row">
                <?php
                    $userOrganization = $user_organization;

                    $sql_act = " SELECT a.activity, p.status
                        FROM activities a
                        INNER JOIN plans p ON a.plan_id = p.id
                        WHERE p.year = $currentYear AND p.organization = '$userOrganization'; ";
                    $result_act = mysqli_query($conn, $sql_act);

                    $sql_desc = " SELECT d.description, d.plan_id 
                        FROM brief_description d
                        INNER JOIN plans p ON d.plan_id = p.id
                        WHERE p.year = $currentYear AND p.organization = '$userOrganization'; ";
                    $result_desc = mysqli_query($conn, $sql_desc);

                    if (mysqli_num_rows($result_act) > 0 && mysqli_num_rows($result_desc) > 0) 
                    {
                        $activities = mysqli_fetch_all($result_act, MYSQLI_ASSOC);
                        $descriptions = mysqli_fetch_all($result_desc, MYSQLI_ASSOC);

                        for($i = 0; $i < count($activities); $i++)
                        {

                ?>
                            <div class="col-md-12 col-lg-6 col-xl-4">
                                <div class="plan-item card mb-2 bg-gradient-dark">
                                    <img class="card-img-top" src="./profile_images/6621f62f831807.16544073.jpg" alt="Dist Photo 1">
                                    <div class="plan-content card-img-overlay d-flex flex-column justify-content-end">
                                        <h5 class="card-title text-primary text-white"> <?php echo $activities[$i]['activity'] ?> </h5>

                                        <?php
                                            if(isset($descriptions[$i]))
                                            {
                                        ?>
                                                <p class="card-text text-white pb-2 pt-1">
                                                    <?php echo $descriptions[$i]['description'] ?>
                                                </p>
                                        <?php 
                                            }
                                        ?>
                                        

                                        <?php 
                                            if($activities[$i]['status'] === 'pending')
                                            {
                                                echo '<p class="text-yellow"> pending </p>';
                                            }
                                            else if($activities[$i]['status'] === 'success')
                                            {
                                                echo '<p class="text-green"> success </p>';
                                            } 
                                            else
                                            {
                                                echo '<p class="text-red"> failed </p>';
                                            } 
                                        ?>
                                    </div>
                                </div>
                            </div>
                <?php 
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

