<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
header('Content-Type: application/json');


if ($_GET['content'] == 'all') {
    if ($_GET['getUid']) {
        $data = array();
        $result = $override->getDataRegister3('status', 1);
        foreach ($result as $value) {
            $monthname = $value['monthname'];
            $site_id = $value['site_id'];
            $count = $value['count'];

            if (!isset($data[$monthname])) {
                $data[$monthname] = array('1' => 0, '2' => 0, '3' => 0, '4' => 0, '5' => 0);
            }

            $data[$monthname][$site_id] = $count;
        }


        echo json_encode($data);
    }
} elseif ($_GET['content'] == 'site') {
    if ($_GET['getUid']) {

        $site_ID = $user->data()->site_id;
        $sites = $override->getData($site['id']);

        foreach ($sites as $site) {
            $output = array();
            $query = $override->getMonthCountSite($site['id']);
            foreach ($query as $data) {
                $output[] = $data;
            }
        }
        // // Convert PHP array to JSON
        $chartDataJSON = json_encode($output);

        // Output JSON data
        echo $chartDataJSON;
    }
} elseif ($_GET['content'] == 'site1') {
    if ($_GET['getUid']) {
        $output = array();
        $query = $override->getMonthCountSite($site['id']);
        foreach ($query as $data) {
            $site = $row['site_id'];
            $month = $row['monthname'];
            $countData = $row['count_data'];

            $output[$site][] = [
                'monthname' => $month,
                'count_data' => $countData,
            ];
        }
        // // Convert PHP array to JSON
        $chartDataJSON = json_encode($output);

        // Output JSON data
        echo $chartDataJSON;
    }
} elseif ($_GET['content'] == 'diseases') {
    if ($_GET['getUid']) {
        $output = array();
        $query = $override->getMonthCount();
        foreach ($query as $data) {
            $output[] = $data;
        }
        // // Convert PHP array to JSON
        $chartDataJSON = json_encode($output);

        // Output JSON data
        echo $chartDataJSON;
    }
} elseif ($_GET['content'] == 'region_id') {
    if ($_GET['region_id']) {
        $districts = $override->getNews('districts', 'status', 1, 'region_id', $_GET['region_id']);
?>
        <option value="">Select Districts</option>
        <?php foreach ($districts as $district) { ?>
            <option value="<?= $district['id'] ?>"><?= $district['name'] ?></option>
        <?php }
    }
} elseif ($_GET['content'] == 'district_id') {
    if ($_GET['district_id']) {
        $wards = $override->getNews('wards', 'status', 1, 'district_id', $_GET['district_id']);
        ?>
        <option value="">Select Wards</option>
        <?php foreach ($wards as $ward) { ?>
            <option value="<?= $ward['id'] ?>"><?= $ward['name'] ?></option>
<?php }
    }
} else {
    // Define start and end dates (modify as needed)
    $startDate = '2024-01-01';
    $endDate = '2024-12-31';

    // SQL query to count data for each site between two dates
    // $sql = "SELECT site, MONTH(date_column) as month, COUNT(*) as count_data
    //         FROM your_table
    //         WHERE date_column BETWEEN '$startDate' AND '$endDate'
    //         GROUP BY site, MONTH(date_column)
    //         ORDER BY site, MONTH(date_column)";

    // $result = $conn->query($sql);

    $result = $override->getMonthCountSiteTest('2023-01-01', '2024-01-31');

    // Fetch the data and format it for Charts.js

    $data = [];
    foreach ($result as $row) {
        $site = $row['site'];
        $month = $row['month'];
        $countData = $row['count_data'];

        $data[$site][] = [
            'month' => $month,
            'count_data' => $countData,
        ];
    }

    // Close the database connection
    // $conn->close();

    // Convert data to JSON for Charts.js
    echo json_encode($data);
}

// $query = $override->getMonthCountSite();
// print_r($data);
