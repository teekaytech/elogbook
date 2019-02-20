<html>
<?php

@session_start();
require_once "../public/std_header.php";
require_once "../public/footer.php";
require_once "../classes/student.php";

$student = new student();
$handle = $student->dbEngine();

if (isset($_POST['upload'])) {
    if (isset($_SESSION['matric']) && isset($_SESSION['key'])) {
        //handling end-of-SIWES slip upload uploads
        $folder = "../end-of-siwes-upload/";
        $file = $_FILES['file']['name'];
        if ($student->upload_image($folder)) {
            if ($student->upload_completion_slip($file, $_SESSION['matric'])) {
                ?>
                <script type="text/javascript">
                    alert('END-OF-SIWES Slip Upload is Successful!');
                    window.location = 'std_dboard.php';
                </script><?php
            } else { ?> <script type="text/javascript">alert('Upload NOT Successful!');</script><?php }
        } else {
            ?><script type="text/javascript">alert('File size cannot be more than 200kb and MUST be in PDF format.');</script><?php
        }
    }
}

if ($student->check_final_slip_status($_SESSION['matric'])) {
main_header();
    ?>
    <body>
    <div id="wrapper">
        <section id="content">
            <div class="container">
                <section id="inner-headline">
                    <div class="container">
                        <h3 align="center">Upload End-of-SIWES Slip (<?php echo $_SESSION['name']; ?>)</h3>
                    </div>
                </section><br>
                <?php
                if (($_SESSION['matric']) && ($_SESSION['key'])) { ?>
                    <div class="row">
                        <dl>
                            <dt style="color: red;">Note the following:</dt><br>
                            <dd>Slip must be approved at the nearest ITF office before uploading.</dd>
                            <dd>Scan the fully approved slip and upload in PDF format ONLY.</dd>
                            <dd>Ensure the upload is successful, as this is a one-time process. </dd>
                        </dl>
                        <p style="color: green;">Best of luck!</p>
                        <div align="center">
                            <!-- <p style="color: red;">Note: Slip must be approved at the nearest ITF office before uploading!!!</p> -->
                            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" role="form" class="contactForm" enctype="multipart/form-data">
                                <label style="color: red;"><b>*Select file to upload:</b></label><br>
                                <input class="form-control" name="file" type="file" required accept="application/pdf"/><br>
                                <div class="text-center"><input type="submit" name="upload" style="color: white; background-color: blue;" value="Upload Report"/>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </section>
    </div>
    <footer><?php footer(); ?></footer>
    </body>
    </html> <?php
} else {
    ?> <script type="text/javascript">
        alert('Slip already uploaded!');
        window.location = 'std_dboard.php';
    </script> <?php
}

