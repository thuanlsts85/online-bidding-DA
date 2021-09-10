<?php
session_start();
error_reporting(0);
include('../../includes/data_connect.php');
if (strlen($_SESSION['alogin']) == 0) {
    header('location:../../index.php');
} else {
    $email = $_SESSION['alogin'];


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>Online Auction Management System | Admin Dash Board</title>
        <!-- CUSTOM STYLE  -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
        <link href="../../assets/css/style.css" rel="stylesheet" />
        <!-- GOOGLE FONT -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>

    <body>
        <?php include('../includes/header.php'); ?>
        <!-- MENU SECTION END-->
        <div class="content-wrapper">
            <div class="container">
                <div class="row pad-botm">
                    <div class="col-md-12">
                        <h4 class="header-line">MANAGE CUSTOMER</h4>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Country</th>
                                            <th>City</th>
                                            <th>Image</th>
                                            <th>Status</th>
                                            <th>Balance</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sql = "SELECT id, Fname, Lname, email, phone, country, branch_id, img, status, balance
                                                    FROM customer";
                                        $query = $pdo->prepare($sql);

                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {
                                        ?>
                                                <tr class="odd gradeX">
                                                    <td class="center"><?php echo htmlentities($result->id); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->Fname); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->Lname); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->email); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->phone); ?></td>
                                                    <td class="center"><?php echo htmlentities($result->country); ?></td>
                                                    <td class="center">
                                                        <?php
                                                        if ($result->branch_id == 1) {
                                                            echo 'Ho Chi Minh';
                                                        } elseif ($result->branch_id == 2) {
                                                            echo 'Ha Noi';
                                                        } elseif ($result->branch_id == 3) {
                                                            echo 'Da Nang';
                                                        }
                                                        ?>
                                                    </td>
                                                    <td class="center"><?php echo "<img src='../../assets/img/" . htmlentities($result->img) . "' style='max-height: 50px; max-width: 50px'> " ?></td>
                                                    <td class="center">
                                                        <?php if ($result->status == 1) { ?>
                                                            <span style="color: green">Active</span>
                                                        <?php } else { ?>
                                                            <span style="color: red">Blocked</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="center"><?php echo htmlentities($result->balance); ?> VND</td>
                                                    <td class="center">
                                                        <div class="button">
                                                            <a href="detail-customer.php?view=<?php echo htmlentities($result->id); ?>">
                                                                View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <!-- CONTENT-WRAPPER SECTION END-->
        <?php include('../includes/footer.php'); ?>
        <!-- FOOTER SECTION END-->
    </body>

    </html>
<?php } ?>