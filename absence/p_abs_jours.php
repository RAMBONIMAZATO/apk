<!doctype html>
<html lang="en">

 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pourcentage absence jours</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">

    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/dataTables.bootstrap4.css"/>
    <link rel="stylesheet" type="text/css" href="../assets/vendor/datatables/css/select.bootstrap4.css"/>
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
        <!-- left sidebar -->
        <!-- ============================================================== -->
        <?php include('../config/template/leftbar_abs.php'); ?>
        <!-- ============================================================== -->
        <!-- end left sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- wrapper  -->
        <!-- ============================================================== -->
        <div class="dashboard-wrapper">
            <div class="container-fluid dashboard-content">
                <!-- ============================================================== -->
                <!-- pageheader -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">Résultat sur l'absence journalier </h2>
                            <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Département</a></li>
                                        <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Absence journalier</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Pourcentage absent jours</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end pageheader -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- page body -->
                <!-- ============================================================== -->
                <div class="row">
                    <!-- ============================================================== -->
                    <!-- Chart departement  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Graphe d'absence jours</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="graph_dept"></canvas>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end Chart  -->
                    <!-- ============================================================== -->
                </div>
                <div class="row">
                    
                <!-- ============================================================== -->
                <!-- table absence resultat hebdomadaire -->
                <!-- ============================================================== -->
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Tableau représentative absent jours</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <?php
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $bd = mysqli_select_db($connection, 'ebp');
                                            //include('../config/connection/conn.php'); 
                                            $p_abs_jours = "
                                                    SELECT DISTINCT Code, Effectif, Dates, Nb_pres, Nb_abs, ROUND(p_abs, 2) AS p_abs FROM t_abs WHERE (Dates=Date(now()) AND Code!='STC') ORDER BY Code";
                                            $r_abs_jours = mysqli_query($connection, $p_abs_jours);
                                        ?>
                                        <table id="table_data" class="table table-striped table-bordered second" style="text-align: center;">
                                            <thead>
                                                  <tr>
                                                   <th>Departement</th>
                                                   <th>Effectif</th>
                                                   <th>Dates</th>
                                                   <th>Nb present</th>
                                                   <th>Nb absent</th>
                                                   <th>% absent</th>
                                                  </tr>
                                            </thead>
                                            <tbody>
                                        <?php 
                                            while ($row = mysqli_fetch_array($r_abs_jours)) {
                                        ?>        
                                                    <tr>
                                                        <td><?php echo $row["Code"]; ?></td>
                                                        <td><?php echo $row["Effectif"]; ?></td>
                                                        <td><?php echo $row["Dates"]; ?></td>
                                                        <td><?php echo $row["Nb_pres"]; ?></td>
                                                        <td><?php echo $row["Nb_abs"]; ?></td>
                                                        <td><?php echo $row["p_abs"]; ?></td>
                                                    </tr>

                                        <?php        
                                            }
                                        ?>
                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                        <?php
                                            $connection = mysqli_connect("localhost", "root", "");
                                            $bd = mysqli_select_db($connection, 'ebp');
                                            $q_sum = "
                                                    SELECT ROUND(sum(Nb_pres),0) AS T_pres, ROUND(sum(Nb_abs),0) AS T_abs, ROUND((sum(p_abs)), 2) AS T_p FROM t_abs WHERE (Dates=Date(now()) AND Code!='STC')";
                                            $r_q_sum = mysqli_query($connection, $q_sum);
                                        ?>
                                                <td>Total</td>

                                        <?php 
                                            while ($row = mysqli_fetch_array($r_q_sum)) {
                                        ?>        
                                                <td><?php echo $row['T_pres']; ?></td>
                                                <td><?php echo $row['T_abs']; ?></td>
                                                <td><?php echo $row['T_p']; ?></td>
                                            </tr>
                                        <?php        
                                            }
                                        ?>
                                        </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                <!-- ============================================================== -->
                <!-- end table absence resultat hebdomadaire-->
                <!-- ============================================================== -->
                </div>
                <!-- ============================================================== -->
                <!-- end page body -->
                <!-- ============================================================== -->
                
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
        <!-- end main wrapper -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- end main wrapper -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <!-- jquery 3.3.1 js-->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <!-- bootstrap bundle js-->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
    <!-- slimscroll js-->
    <script src="../assets/vendor/slimscroll/jquery.slimscroll.js"></script>
    <!-- chartjs js-->
    <script src="../assets/vendor/charts/charts-bundle/Chart.bundle.js"></script>
    <script src="../assets/vendor/charts/charts-bundle/chartjs.js"></script>
    <!-- main js-->
    <script src="../assets/libs/js/main-js.js"></script>
    <!-- jvactormap js-->
    <script src="../assets/vendor/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../assets/vendor/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- sparkline js-->
    <script src="../assets/vendor/charts/sparkline/jquery.sparkline.js"></script>
    <script src="../assets/vendor/charts/sparkline/spark-js.js"></script>
     <!-- dashboard sales js-->
    <script src="../assets/libs/js/dashboard-sales.js"></script>
    <!-- Javascript datatable-->
    <script type="text/javascript" src="../assets/vendor/datatables/js/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <!-- Print data -->
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.flash.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/buttons.print.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/jszip.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/datatables.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/pdfmake.min.js"></script>
    <script type="text/javascript" src="../assets/vendor/datatables/js/vfs_fonts.js"></script>
    <!--  print data-->
    <script type="text/javascript" language="javascript">
        $(document).ready(function() {
            $('#table_data').DataTable({
                dom: 'lBfrtip',
                buttons: [
                    {extend: 'excel', footer: true},
                    {extend: 'pdf', footer: true},
                    {extend: 'copy', footer: true},
                    {extend: 'print', footer: true},
                    {extend: 'csv', footer: true}
                ],
                "lengthMenu": [[10, 25, 50, -1],[10, 25, 50, "All"]]
            });
        });
    </script>
    <!-- Script filter table -->
    <script type="text/javascript" language="javascript" >
        $(document).ready(function(){
        	showGraph();
    	});
        function showGraph()
        {
            {
                $.post("../config/graph/g_abs_j.php",
                function (data)
                {
                    console.log(data);
                    var name = [];
                    var effectif = [];

                    for (var i in data) {
                        name.push(data[i].Code);
                        effectif.push(data[i].Nb_abs);
                    }

                    var chartdata = {
                        labels: name,
                        datasets: [
                            {
                                label: 'Abs journalier',
                                backgroundColor: '#49e2ff',
                                borderColor: '#46d5f1',
                                hoverBackgroundColor: '#CCCCCC',
                                hoverBorderColor: '#666666',
                                data: effectif
                            }
                        ]
                    };
                    var graphTarget = $("#graph_dept");

                    var barGraph = new Chart(graphTarget, {
                        type: 'bar',
                        data: chartdata
                    });
                });
            }
        }
    </script>
</body>
 
</html>