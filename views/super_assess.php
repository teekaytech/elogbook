<html>
<?php

@session_start();
require_once "../public/super_header.php";
require_once "../public/footer.php";
require_once "../classes/supervisor.php";

$supervisor = new supervisor();
$handle = $supervisor->dbEngine();

if ($_SESSION['status']==1) { main_header(); } else { industry_header(); }

$array_of_id = array();
$stud_status = false;
?>
<style>
    table.details th, table.details td {
        border: 1px solid black;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
    }
</style>
<body>
<div id="wrapper">
    <section id="content">
        <div class="container">
            <section id="inner-headline">
                <div style="height: 70px; padding-top: 0.5px; padding-bottom: 1px;">
                    <h3 align="center">| Report Assessment Page (Institution-based Supervisors only) |</h3>
                </div>
            </section><br>
            <?php
            if (($_SESSION['super_id']) && ($_SESSION['key'])) { ?>
                <center>
                    <div class="row">
                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
                            <div class="form-group">
                                <label for="matric" style="font-size: 16px;">Enter student Matriculation Number:</label><br>
                                <input class="form-control" name="matric" type="text" required />
                            </div>
                            <div class="text-center"><input type="submit" name="search"  style="color: white; background-color: blue;" value="Search Report"/>
                            </div>
                        </form>
                    </div>
                </center>
            <?php }
            
            //processing display of reports
            if (!empty($_POST['matric']) && isset($_POST['search'])) { ?>
            <?php
            $stud = $_POST['matric'];
            $full_name = '';
            //fetching student details to display to user
            $student_details = $supervisor->fetch_student_details($stud);
            //checking if student is found
            if ($student_details == null) { ?>
                <script type="text/javascript"> alert('Student not found!');
                    window.location = "super_endorse.php"; </script><?php
            } else {
            echo '<p style="color:#ffffff; padding-left:10px; background-color:#900000;">Student Details</p>';
            $stud_status = true;
            ?><table><col width="0.1%"><col width="0.9%"><?php
                foreach ($student_details as $index) {
                    $full_name = $index['stud_lname'].' '.$index['stud_fname'].' '.$index['stud_mname']; ?>
                    <tr>
                        <td>Name:</td>
                        <td><b><?php echo $full_name; ?></b></td>
                    </tr>
                    <tr>
                        <td>Level:</td>
                        <td><?php echo $index['stud_level']; ?></td>
                    </tr>
                    <tr>
                        <td>IT Commencement Date:</td>
                        <td><?php echo $index['it_date']; ?></td>
                    </tr>
                    <tr>
                        <td>IT Duration:</td>
                        <td><?php echo $index['stud_it_duration'] . ' Months'; ?></td>
                    </tr>
                <?php }
                echo '</table>';
                }
                //processing report details
                echo '<p style="color:#ffffff; padding-left:10px; background-color:#900000;">Daily Report Details</p>';
                if ($stud_status) {
                    $results = $supervisor->fetch_student_report($stud);
                    $availability = false;
                    foreach ($results as $item) { if ($item['inst_appr_status'] == '0') { $availability = true; } }
                    if ($availability==false) {
                        echo '<p align=\'center\' style="color:darkred;">Yay...all reports already endorsed!</p>';
                    }
                    else { ?>
                        <table style="border: 1px solid black; border-collapse: collapse;" class="details">
                            <col width="6%">
                            <col width="13%">
                            <col width="75%">
                            <col width="6%">
                            <tr>
                                <th>Week</th>
                                <th>Date (Y-M-D)</th>
                                <th>Description</th>
                                <th>Attachment?</th>
                            </tr>
                            <?php
                            foreach ($results as $key => $it) {
                                if (($_SESSION['status'] == 1) && ($it['inst_appr_status'] == '0')) {
                                    global $array_of_id;
                                    $check = FALSE;
                                    $pref = '';
                                    array_push($array_of_id, $it['rpt_id']);
                                    //processing whether report has attachment or not
                                    foreach ($supervisor->fetch_report_attachment() as $item) {
                                        if ($item['DAILY_REPORTrpt_id'] == $it['rpt_id']) {
                                            $pref = '../std_upld/'.$item['attach_file'];
                                            $check = TRUE;
                                        }
                                    } ?>
                                    <!--Displaying report details-->
                                    <tr>
                                        <td><?php echo $it['week']; ?></td>
                                        <td><?php echo $it['rpt_date']; ?></td>
                                        <td><?php echo $it['rpt_content']; ?></td>
                                        <?php
                                        if ($check) { ?>
                                            <td><a data-toggle="modal" href="#imageModal<?php echo $key; ?>">Yes!</a></td>
                                            <!-- Bootstrap Modal -->
                                            <div class="modal fade" id="imageModal<?php echo $key; ?>" role="dialog">
                                                <div class="modal-dialog">
                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;
                                                            </button>
                                                            <h4 class="modal-title"><?php echo $full_name; ?>'s
                                                                Attachment</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><?php echo $pref; ?></p><img src="<?php echo $pref; ?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Close
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } else {
                                            echo '<td>No.</td>';
                                        } ?>
                                    </tr>
                                <?php }
                            }
                            ?>
                        </table><br>
                        
                        <!--Displaying institution-based supervisor's previous assessment-->
                        <p style="color:#ffffff; padding-left:10px; background-color:#900000;">Institution-based Supervisor's previous assessment (<?php echo $_SESSION['super_name']; ?>)</p>
                        <?php
                        $reports = $supervisor->fetch_assessment($stud);
                        if ($reports == null) {
                            echo '<p align=\'center\' style="color:darkred;"> '.$stud.' has not been assessed previously!</p>';
                        }
                        else { ?>
                            <table style="border: 1px solid black; border-collapse: collapse;" class="details">
                            <col width="5%"><col width="15%"><col width="18%"><col width="57%"><col width="5%">
                            <tr>
                                <th>ID</th>
                                <th>Date (Y-M-D)</th>
                                <th>Supervisor ID</th>
                                <th>Comment(s)</th>
                                <th>Grade</th>
                            </tr><?php
                            $id = 1;
                            foreach ($reports as $rpt) { ?>
                                <tr>
                                    <td><?php echo $id; ?></td>
                                    <td><?php echo $rpt['assess_date']; ?></td>
                                    <td><?php echo $rpt['SUPERVISORsuper_id']; ?></td>
                                    <td><?php echo $rpt['assess_comment']; ?></td>
                                    <td><?php echo $rpt['assess_grade']; ?></td>
                                </tr><?php
                                $id++;
                            }
                        }
                    } ?>
                    </table><br>
                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm">
                        <div class="form-group">
                            <textarea cols="50" rows="5" NAME="comment" placeholder="<?php if ($_SESSION['status'] == 1) {
                                echo 'Institution-based supervisor\'s comments';
                            } else {
                                echo 'Industry-based supervisor\'s comments';
                            } ?>" class="form-control" required></textarea>
                            <br><select name="sat_type" class="form-control" required>
                                <option value="">--level of satisfaction---</option>
                                <option value="5">Abosulte satisfactory!</option>
                                <option value="4">Satisfactory</option>
                                <option value="3">Not satisfied</option>
                            </select>
                        </div>
                        <div style="display: none; ">
                            <input type="text" name="stud_id" value="<?php echo $stud; ?>">
                        </div>
                        <div><input type="submit" name="report" style="color: white; background-color: red;" value="Submit Assessment"/></div>
                    </form>
                    <?php }
                }

                if (isset($_POST['report']) && $_SESSION['status'] == 1) {
                    $approval_date = date('Y-m-d');
                    $comment = $_POST['comment'];
                    $sat_level = $_POST['sat_type'];
                    $stud_id = $_POST['stud_id'];
                    //storing institution-based supervisor's assessment
                    if ($supervisor->report_assessment_upload($stud_id, $approval_date, $comment, $sat_level) &&
                        $supervisor->ins_report_update($stud_id)) { ?>
                        <script type="text/javascript"> alert('Report(s) Assessment Successful!');
                            window.location = "super_dboard.php"; </script><?php
                    } else { ?>
                        <script type="text/javascript"> alert('Report(s) Assessment NOT Successful!');</script><?php
                    }
                }
                
                ?>
        </div>
    </section>
</div>
<footer style="position: static; bottom: 0px; right: 0px; left: 0px;"><?php footer(); ?></footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="../bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
<?php

?>