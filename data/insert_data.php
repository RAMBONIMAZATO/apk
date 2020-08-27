<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <link rel="stylesheet" href="../assets/vendor/charts/chartist-bundle/chartist.css">
    <link rel="stylesheet" href="../assets/vendor/charts/morris-bundle/morris.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../assets/vendor/charts/c3charts/c3.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/flag-icon-css/flag-icon.min.css">
    <!-- Ajout libraray -->
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/select.bootstrap4.css"/>
    <title>Collection des données</title>
</head>

<body>
    <!-- ============================================================== -->
    <!-- main wrapper -->
    <!-- ============================================================== -->
    <div class="dashboard-main-wrapper">
        <!-- ============================================================== -->
        <!-- navbar -->
        <!-- ============================================================== -->
        <?php include('../config/template/header.php'); ?>
        <!-- ============================================================== -->
        <!-- end navbar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- left sidebar  -->
        <!-- ============================================================== -->
        <?php include('../config/template/leftbar_data.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="dashboard-ecommerce">
                <div class="container-fluid dashboard-content ">
                    <!-- ============================================================== -->
                    <!-- pageheader  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="page-header">
                                <h2 class="pageheader-title">Absent </h2>
                                <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris facilisis faucibus at enim quis massa lobortis rutrum.</p>
                                <div class="page-breadcrumb">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Liste</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Jours</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- INSERTION JOURS -->
                        <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        /*
                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours`  
                                WHERE ((Dates=Date(now())) AND (Code!='ADM') AND (Code!='GNR') AND (H_E between '07:10:00' and '10:00:00'))
                                UNION
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
                                WHERE ((Dates=Date(now())) AND (Code='ADM') AND (H_E between '08:10:00' and '10:00:00'))
                                UNION
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
                                WHERE ((Dates=Date(now())) AND (Code='GNR') AND (H_E between '06:10:00' and '10:00:00'))*/
                        $db = mysqli_select_db($connection, 'ebp');
                        if (isset($_POST['insert_btn_1'])) {
                                $insert_l_ret="
                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE (
                                (
                                Dates = DATE( NOW( ) )
                                )
                                AND (
                                Code !=  'ADM'
                                )
                                AND (
                                Code !=  'GNR'
                                )
                                AND (
                                H_E
                                BETWEEN  '07:05:00'
                                AND  '10:00:00'
                                )
                                )
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE (
                                (
                                Dates = DATE( NOW( ) )
                                )
                                AND (
                                Code =  'ADM'
                                )
                                AND (
                                H_E
                                BETWEEN  '08:05:00'
                                AND  '10:00:00'
                                )
                                )
                                UNION DISTINCT
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E
                                FROM  `t_pres_h_jours` 
                                WHERE (
                                (
                                Dates = DATE( NOW( ) )
                                )
                                AND (
                                Code =  'GNR'
                                )
                                AND (
                                H_E
                                BETWEEN  '06:05:00'
                                AND  '10:00:00'
                                )
                                )
                                ";
                                $r_insert_l_ret = mysqli_query($connection, $insert_l_ret);
                                if($insert_l_ret){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                    /*header("Location: insert_data.php");*/
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['update_btn_1'])) {
                            $q_update=" UPDATE t_retard_jours  
                                        SET P_E=(
                                        CASE
                                           WHEN Code='GNR' THEN '06:00:00'
                                           WHEN Code='ADM' THEN '08:00:00'
                                           ELSE '07:00:00'
                                        END),
                                        H_ret=abs(TIMEDIFF(H_E, P_E))  WHERE Dates=Date(now())
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            /*if($r_update){
                                echo '<script> alert("Data Updated");</script>';
                                header("Location: insert_data.php");
                            }else{
                                echo '<script>alert("Data Not Updated");</script>';
                            }*/
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is updated!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not updated!
                                    </div>';
                            }
                        }
                        if (isset($_POST['insert_btn_2'])) {
                                $insert_p_ret = "
                                        INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                        SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                        FROM t_retard_jours WHERE Dates=Date(now()) GROUP BY DeptId
                                        ";
                                $r_insert_p_ret = mysqli_query($connection, $insert_p_ret);
                                if($r_insert_p_ret){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['insert_btn_3'])) {
                                $insert_l_abs = "
                                            INSERT INTO t_absence_jours(UserId, Name, DeptId, Code,Effectif, Dates)
                                            SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, DATE( NOW( ) ) AS Dates
                                            FROM t_dept_user
                                            WHERE UserId NOT IN (
                                            SELECT DISTINCT UserId
                                            FROM t_present_jours
                                            WHERE Dates = DATE( NOW( ) )
                                            )
                                            ";
                                            /*
                                            SELECT t_dept_user.UserId, t_dept_user.Name, t_dept_user.Fonction, t_dept_user.DeptId, t_dept_user.Code, t_dept_user.Effectif, t_present_jours.Dates
                                            FROM t_present_jours
                                            RIGHT JOIN t_dept_user ON t_present_jours.UserId = t_dept_user.UserId
                                            WHERE t_present_jours.Dates IS NULL 
                                            */
                                $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                                if($r_insert_l_abs){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['insert_btn_4'])) {
                            $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs) 
                                    SELECT DISTINCT DeptId as DeptId, DeptCode as Code, DeptEff as Effectif, Dates, COUNT( UserId ) as Nb_pres , (
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) as Nb_abs, ((
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) *100 / DeptEff) as p_abs
                                    FROM  `t_present_jours` 
                                    WHERE Dates =  Date(now())
                                    GROUP BY DeptId 
                                ";
                                $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
                                if($r_insert_p_abs){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is inserted!
                                    </div>';
                                }else{
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      Pourcentage is not inserted!
                                    </div>';
                                }
                        }
                    ?>  
                    <!-- END INSERTION JOURS -->
                    <!-- ============================================================== -->
                    <!-- end pageheader  -->
                    <!-- ============================================================== -->
                    <!-- <div class="row"> -->
                    <!-- ============================================================== -->
                    <!-- begin  pagebody  -->
                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- begin collectioin des données jours  -->
                    <!-- ============================================================== -->
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTIOIN DES DONNÉES JOURS</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste retard jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_1">INSERTION</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours liste retard jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-success" type="submit" name="update_btn_1">UPDATE</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage retard jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_2">INSERTION</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste absent jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_3">INSERTION</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage absent jours</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_4">INSERTION</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- ============================================================== -->
	                    <!-- end collectioin des données jours  -->
	                    <!-- ============================================================== -->
                    <!-- INSERTION JOURS -1 OU DIMANCHE -->

                        <?php 
                        $connection = mysqli_connect("localhost", "root", "");
                        $db = mysqli_select_db($connection, 'ebp');
                        if (isset($_POST['insert_btn_5'])) {
                                $insert_l_ret="
                                INSERT INTO t_retard_jours(UserId, Name, DeptId, Code, Effectif, Dates, H_E)
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours`
                                WHERE ((Dates=date_add(curdate(), interval -1 day)) AND (Code!='ADM') AND (Code!='GNR') AND (H_E between '07:05:00' and '10:00:00'))
                                UNION
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
                                WHERE ((Dates=date_add(curdate(), interval -1 day)) AND (Code='ADM') AND (H_E between '08:05:00' and '10:00:00'))
                                UNION
                                SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, Dates, H_E FROM `t_pres_h_jours` 
                                WHERE ((Dates=date_add(curdate(), interval -1 day)) AND (Code='GNR') AND (H_E between '06:05:00' and '10:00:00'))
                                ";
                                $r_insert_l_ret = mysqli_query($connection, $insert_l_ret);
                                if($insert_l_ret){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                    /*header("Location: insert_data.php");*/
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                                }
                        }
                        if (isset($_POST['update_btn_2'])) {
                            $q_update=" UPDATE t_retard_jours  
                                        SET P_E=(
                                        CASE
                                           WHEN Code='GNR' THEN '06:00:00'
                                           WHEN Code='ADM' THEN '08:00:00'
                                           ELSE '07:00:00'
                                        END),
                                        H_ret=abs(TIMEDIFF(H_E, P_E))  
                                        WHERE Dates=date_add(curdate(), interval -1 day)
                                        ";
                            $r_update = mysqli_query($connection, $q_update);
                            /*if($r_update){
                                echo '<script> alert("Data Updated");</script>';
                                header("Location: insert_data.php");
                            }else{
                                echo '<script>alert("Data Not Updated");</script>';
                            }*/
                            if($r_update){
                                    echo '
                                    <div class="alert alert-success" role="alert">
                                      The data is inserted!
                                    </div>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '
                                    <div class="alert alert-danger" role="alert">
                                      The data is not inserted!
                                    </div>';
                            }
                        }
                        if (isset($_POST['insert_btn_6'])) {
                                $insert_p_ret = "
                                        INSERT INTO t_pourcentage_retard(DeptId, Code, Effectif, Nb_ret, P_ret, Dates)
                                        SELECT  DISTINCT DeptId, Code, Effectif, count(UserId) as Nb_ret, (count(UserId)*100/Effectif) AS P_ret, Dates 
                                        FROM t_retard_jours WHERE Dates=date_add(curdate(), interval -1 day) GROUP BY DeptId
                                        ";
                                $r_insert_p_ret = mysqli_query($connection, $insert_p_ret);
                                if($r_insert_p_ret){
                                    echo '<script> alert("Data Inserted");</script>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '<script>alert("Data Not Updated");</script>';
                                }
                        }
                        if (isset($_POST['insert_btn_7'])) {
                                $insert_l_abs = "
                                            INSERT INTO t_absence_jours(UserId, Name, DeptId, Code,Effectif, Dates)
                                            SELECT DISTINCT UserId, Name, DeptId, Code, Effectif, date_add(curdate(), interval -1 day) AS Dates
                                            FROM t_dept_user
                                            WHERE UserId NOT IN (
                                            SELECT DISTINCT UserId
                                            FROM t_present_jours
                                            WHERE Dates = date_add(curdate(), interval -1 day)
                                            )
                                            ";
                                $r_insert_l_abs = mysqli_query($connection, $insert_l_abs);
                                if($r_insert_l_abs){
                                    echo '<script> alert("Data Inserted");</script>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '<script>alert("Data Not Updated");</script>';
                                }
                        }
                        if (isset($_POST['insert_btn_8'])) {
                            $insert_p_abs="INSERT INTO `t_abs`(DeptId, Code, Effectif, Dates, Nb_pres, Nb_abs, p_abs) 
                                    SELECT DISTINCT DeptId as DeptId, DeptCode as Code, DeptEff as Effectif, Dates, COUNT( UserId ) as Nb_pres , (
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) as Nb_abs, ((
                                    DeptEff - COUNT( distinct(Userid) )
                                    ) *100 / DeptEff) as p_abs
                                    FROM  `t_present_jours` 
                                    WHERE Dates =  date_add(curdate(), interval -1 day)
                                    GROUP BY DeptId 
                                ";
                                $r_insert_p_abs = mysqli_query($connection, $insert_p_abs);
                                if($r_insert_p_abs){
                                    echo '<script> alert("Data Inserted");</script>';
                                    header("Location: insert_data.php");
                                }else{
                                    echo '<script>alert("Data Not Updated");</script>';
                                }
                        }
                    ?>
                    <!-- END INSERTION JOURS -1 OU DIMANCHE  -->
                        <!-- ============================================================== -->
	                    <!-- begin collectioin des données jours -1 -->
	                    <!-- ============================================================== -->
                        <div class="row">		
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <h5 class="card-header">COLLECTIOIN DES DONNÉES DIMANCHE</h5>
                                <div class="card-body">
                                    <form id="validationform" data-parsley-validate="" novalidate="" action="insert_data.php" method="post">
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste retard dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_5">INSERTION</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Mise à jours liste retard dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-success" type="submit" name="update_btn_2">UPDATE</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage retard dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_6">INSERTION</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Insertion liste absent dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_7">INSERTION</button>
                                            </div>
                                        </div>
                                    	<div class="form-group row">
                                            <label class="col-12 col-sm-3 col-form-label text-sm-right">Pourcentage absent dimanche</label>
                                            <div class="col-12 col-sm-8 col-lg-6">
                                                <button class="btn btn-primary" type="submit" name="insert_btn_8">INSERTION</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div></div>
                        <!-- ============================================================== -->
	                    <!-- end collectioin des données jours -1 -->
	                    <!-- ============================================================== -->

                    <!-- ============================================================== -->
                    <!-- end pagebody  -->
                    <!-- ============================================================== -->
                       <!-- </div> -->
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include('../config/template/footer.php'); ?>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- end wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstap bundle js -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js -->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- main js -->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- chart chartist js -->
    <script src="../assets/vendor/charts/chartist-bundle/chartist.min.js"></script>
    <!-- sparkline js -->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <!-- morris js -->
    <script src="../assets/vendor/charts/morris-bundle/raphael.min.js"></script>
    <script src="../assets/vendor/charts/morris-bundle/morris.js"></script>
    <!-- chart c3 js -->
    <script src="../assets/vendor/charts/c3charts/c3.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/d3-5.4.0.min.js"></script>
    <script src="../assets/vendor/charts/c3charts/C3chartjs.js"></script>
    <script src="../assets/libs/js/dashboard-ecommerce.js"></script>
    <!--  ajout js-->
    <script type="text/javascript" src="../assets/vendor/datatables/js/datatables.min.js"></script>

</body>
 
</html>