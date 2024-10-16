<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();



$users = $override->getData('user');
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {

        if (Input::get('search_by_site')) {
            $validate = new validate();
            $validate = $validate->check($_POST, array(
                'site_id' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {

                $url = 'index1.php?&site_id=' . Input::get('site_id');
                Redirect::to($url);
                $pageError = $validate->errors();
            }
        }
    }


    $staff_all = $override->getNo('user');
    $staff_active = $override->getDataStaffCount('user', 'status', 1, 'power', 0, 'count', 4, 'id');
    $staff_inactive = $override->getDataStaffCount('user', 'status', 0, 'power', 0, 'count', 4, 'id');
    $staff_lock_active = $override->getDataStaff1Count('user', 'status', 1, 'power', 0, 'count', 4, 'id');
    $staff_lock_inactive = $override->getDataStaff1Count('user', 'status', 0, 'power', 0, 'count', 4, 'id');



    if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
        if ($_GET['site_id'] != null) {
            // $kap = $override->getCount1('kap', 'status', 1, 'site_id', $_GET['site_id']);
            // $histroy = $override->getCount1('history', 'status', 1, 'site_id', $_GET['site_id']);
            // $results = $override->getCount1('results', 'status', 1, 'site_id', $_GET['site_id']);
            // $classification = $override->getCount1('classification', 'status', 1, 'site_id', $_GET['site_id']);
            // $outcome = $override->getCount1('outcome', 'status', 1, 'site_id', $_GET['site_id']);
            // $economic = $override->getCount1('economic', 'status', 1, 'site_id', $_GET['site_id']);
            // $visit = $override->getCount1('visit', 'status', 1, 'site_id', $_GET['site_id']);

            $registered = $override->getCount1('clients', 'status', 1, 'site', $_GET['site_id']);
            // $screened = $override->getCount1('history', 'status', 1, 'site_id', $_GET['site_id']);
            // $eligible = $override->getCount1('history', 'eligible', 1, 'site_id', $_GET['site_id']);
            // $enrolled = $override->getCount1('results', 'status', 1, 'site_id', $_GET['site_id']);
            // $end = $override->getCount1('clients', 'status', 0, 'site_id', $_GET['site_id']);
        } else {
            // $kap = $override->getCount('kap', 'status', 1);
            // $history = $override->getCount('history', 'status', 1);
            // $results = $override->getCount('results', 'status', 1);
            // $classification = $override->getCount('classification', 'status', 1);
            // $outcome = $override->getCount('outcome', 'status', 1);
            // $economic = $override->getCount('economic', 'status', 1);
            // $visit = $override->getCount('visit', 'status', 1);

            $registered = $override->getCount('clients', 'status', 1);
            // $screened = $override->getCount('history', 'status', 1);
            // $eligible = $override->getCount('history', 'eligible', 1);
            // $enrolled = $override->getCount('results', 'status', 1);
            // $end = $override->getCount('clients', 'status', 0);
        }
    } else {
        // $kap = $override->getCount1('kap', 'status', 1, 'site_id', $user->data()->site_id);
        // $histroy = $override->getCount1('history', 'status', 1, 'site_id', $user->data()->site_id);
        // $results = $override->getCount1('results', 'status', 1, 'site_id', $user->data()->site_id);
        // $classification = $override->getCount1('classification', 'status', 1, 'site_id', $user->data()->site_id);
        // $outcome = $override->getCount1('outcome', 'status', 1, 'site_id', $user->data()->site_id);
        // $economic = $override->getCount1('economic', 'status', 1, 'site_id', $user->data()->site_id);
        // $visit = $override->getCount1('visit', 'status', 1, 'site_id', $user->data()->site_id);

        $registered = $override->getCount1('clients', 'status', 1, 'site', $user->data()->site_id);
        // $screened = $override->getCount1('history', 'status', 1, 'site_id', $user->data()->site_id);
        // $eligible = $override->getCount1('history', 'eligible', 1, 'site_id', $user->data()->site_id);
        // $enrolled = $override->getCount1('results', 'status', 1, 'site_id', $user->data()->site_id);
        // $end = $override->getCount1('clients', 'status', 0, 'site_id', $user->data()->site_id);
    }
} else {
    Redirect::to('index.php');
}

?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index1.php" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Mack Database</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <?php if ($user->data()->sex == 1) { ?>
                    <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">

                <?php } elseif ($user->data()->sex == 2) { ?>
                    <img src="dist/img/avatar3.png" class="img-circle elevation-2" alt="User Image">

                <?php } else { ?>
                    <img src="dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">

                <?php } ?>
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $user->data()->firstname . ' - ' . $user->data()->lastname  ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="./index1.php" class="nav-link active">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="./index3.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Dashboard v3</p>
                            </a>
                        </li> -->
                    </ul>
                </li>
                <?php if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <span class="badge badge-info right"><?= $staff_all; ?></span>
                            <p>
                                Staff <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add.php?id=1" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Register
                                        <span class="right badge badge-danger">New Staff</span>
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=1" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $staff_active; ?></span>
                                    <p>Active</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=2" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $staff_inactive; ?></span>
                                    <p>Inactive</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=3" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $staff_lock_active; ?></span>
                                    <p>Locked And Active</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=1&status=4" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $staff_lock_inactive; ?></span>
                                    <p>Locked And Inactive</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <span class="badge badge-info right"><?= $registered; ?></span>
                        <p>
                            Registration <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php
                        if ($user->data()->position != 5) {
                        ?>
                            <li class="nav-item">
                                <a href="add.php?id=4" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i>
                                    <p>
                                        Register
                                        <span class="right badge badge-danger">New Client</span>
                                    </p>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a href="info.php?id=3&status=7" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <span class="badge badge-info right"><?= $registered; ?></span>
                                <p>Registered</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php
                if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                ?>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Data <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="info.php?id=5&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $registered; ?></span>
                                    <p>CLients</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=6&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $kap; ?></span>
                                    <p>Kap</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=7&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $history; ?></span>
                                    <p>History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=8&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $results; ?></span>
                                    <p>Results</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=9&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $classification; ?></span>
                                    <p>Classification</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=10&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $outcome; ?></span>
                                    <p>Outcome</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=11&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $economic; ?></span>
                                    <p>Economics</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="info.php?id=12&status=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $visit; ?></span>
                                    <p>Visits</p>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Clear Data <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="info.php?id=14" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Tables</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Reports <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="reports.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Over All</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="reports.php" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Progress</p>
                                </a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="nav-item"> -->
                    <!-- <a href="info.php?id=15" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Unset Study ID <i class="fas fa-angle-left right"></i>

                            </p>
                        </a> -->
                    <!-- <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="info.php?id=15" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>List of Tables</p>
                                </a>
                            </li>
                        </ul> -->
                    <!-- </li> -->
                <?php } ?>

                <?php if ($user->data()->accessLevel == 1 || $user->data()->position == 5) { ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Data <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="data.php?id=1" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <!-- <span class="badge badge-info right"> -->
                                    <!-- <?= $all; ?> -->
                                    <!-- </span> -->
                                    <p>Download Data</p>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a href="data.php?id=1&status=1&data=1" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $clients; ?></span>
                                    <p>Registration</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=2&data=2" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $screening; ?></span>
                                    <p>Screening</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=3&data=3" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $demographic; ?></span>
                                    <p>Demographic </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=4&data=4" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $vital; ?></span>
                                    <p>Vital Sign</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=5&data=5" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $main_diagnosis; ?></span>
                                    <p>Patient Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=6&data=6" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $history; ?></span>
                                    <p>Patient & Family History & Complication</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=7&data=7" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $symptoms; ?></span>
                                    <p>Symtom & Exam</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="data.php?id=2&status=8&data=8" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $cardiac; ?></span>
                                    <p>Main diagnosis 1 ( Cardiac )</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=9&data=9" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $diabetic; ?></span>
                                    <p>Main diagnosis 2 ( Diabetes )</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=10&data=10" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $sickle_cell; ?></span>
                                    <p>Main diagnosis 3 ( Sickle Cell )</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=11&data=11" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $siblings; ?></span>
                                    <p>Siblings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=12&data=12" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $results; ?></span>
                                    <p>Results</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=13&data=13" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $hospitalization; ?></span>
                                    <p>Hospitalization</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=14&data=14" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $hospitalization_details; ?></span>
                                    <p>Hospitalization Details </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=15&data=15" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $admissions; ?></span>
                                    <p>Admission</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=16&data=16" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $treatment_plan; ?></span>
                                    <p>Treatment Plan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=17&data=17" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $medications; ?></span>
                                    <p>Medications</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=18&data=18" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $dgns_complctns_comorbdts; ?></span>
                                    <p>Diagnosis, Complications, & Comorbidities</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=19&data=19" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $risks; ?></span>
                                    <p>RISK</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=20&data=20" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $lab_details; ?></span>
                                    <p>Lab Details</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=21&data=21" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $lab_requests; ?></span>
                                    <p>Lab Requests</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=22&data=22" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $test_list; ?></span>
                                    <p>Test Lists</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=23&data=23" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $social_economic; ?></span>
                                    <p>Socioeconomic Status </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=24&data=24" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $summary; ?></span>
                                    <p>Summary</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=3&status=25&data=25" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $schedule; ?></span>
                                    <p>Visits</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=2&status=26&data=26" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $study_id; ?></span>
                                    <p>Study IDs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="data.php?id=4&status=27&data=27" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <span class="badge badge-info right"><?= $sites; ?></span>
                                    <p>Sites</p>
                                </a>
                            </li> -->
                        </ul>
                    </li>
                    <?php
                    if ($user->data()->power == 1) {
                    ?>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Study ID <i class="fas fa-angle-left right"></i>

                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                                <li class="nav-item">
                                    <a href="info.php?id=5" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Set Study Id</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="info.php?id=6" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>UnSet Study Id</p>
                                    </a>
                                </li>

                                <?php if ($user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) { ?>

                                    <li class="nav-item">
                                        <a href="info.php?id=5" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Update Study Id</p>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>


                <?php } ?>
                <?php
                if ($user->data()->position != 5) {
                ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-copy"></i>
                            <p>
                                Extra <i class="fas fa-angle-left right"></i>

                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="add.php?id=24" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Regions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="add.php?id=25" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Disricts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="add.php?id=26" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Wards</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php } ?>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>