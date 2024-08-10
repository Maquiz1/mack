<?php

require_once 'pdf.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();

if ($user->isLoggedIn()) {
    try {
        // switch (Input::get('report')) {
        //     case 1:
        //         $data = $override->searchBtnDate3('batch', 'create_on', $_GET['start'], 'create_on', $_GET['end'], 'use_group', $_GET['group']);
        //         $data_count = $override->getCountReport('batch', 'create_on', $_GET['start'], 'create_on', $_GET['end'], 'use_group', $_GET['group']);
        //         break;
        //     case 2:
        //         $data = $override->searchBtnDate3('check_records', 'create_on', $_GET['start'], 'create_on', $_GET['end'], 'use_group', $_GET['group']);
        //         $data_count = $override->getCountReport('check_records', 'create_on', $_GET['start'], 'create_on', $_GET['end'], 'use_group', $_GET['group']);
        //         break;
        //     case 3:
        //         $data = $override->searchBtnDate3('batch_records', 'create_on', $_GET['start'], 'create_on', $_GET['end'], 'use_group', $_GET['group']);
        //         $data_count = $override->getCountReport('batch_records', 'create_on', $_GET['start'], 'create_on', $_GET['end'], 'use_group', $_GET['group']);
        //         break;
        // }

        // $site_data = $override->get('eligibility','status',1);
        $screened1 = $override->ListByMonth('eligibility','create_on');
        $screened2 = $override->CountByMonth('eligibility', 'create_on');
        // $hiv_history_and_medication1 = $override->ListByMonth('hiv_history_and_medication', 'create_on');
        // $hiv_history_and_medication2 = $override->CountByMonth('hiv_history_and_medication', 'create_on');
        // $ListByMonthAll = $override->ListByMonthAll('eligibility', 'hiv_history_and_medication', 'create_on');
        $ListByMonthAllTables = $override->ListByMonthAllTables('clients', 'hiv_history_and_medication', 'eligibility', 'enrollments', 'risk_factors', 'medications', 'chronic_illnesses', 'laboratory_results', 'radiological_investigations', 'create_on');

    
        $screened = $override->getCount('eligibility', 'status', 1);
        // $enrolled = $override->CountByMonth('eligibility', 'status', 1, 'create_on');
        // $enrolled_Total = $override->getCount1('clients', 'status', 1, 'enrolled', 1);
        $enrolled = $override->getCount2('clients', 'status', 1, 'enrolled', 1);
        // $name = $override->get('user', 'status', 1, 'screened', $user->data()->id);
        // $data_count = $override->getCount2('clients', 'status', 1, 'screened',1, 'site_id', $ussite_dataer->data()->site_id);

        $successMessage = 'Report Successful Created';
    } catch (Exception $e) {
        die($e->getMessage());
    }
} else {
    Redirect::to('index.php');
}

if ($_GET['group'] == 1) {
    $title = 'Medicines';
} elseif ($_GET['group'] == 2) {
    $title = 'Medical Equipments';
} elseif ($_GET['group'] == 3) {
    $title = 'Accessories';
} elseif ($_GET['group'] == 4) {
    $title = 'Supplies';
}


$span0 = 9;
$span1 = 9;
$span2 = 9;

$title = 'MACK-STUDY SUMMARY REPORT_' . date('Y-m-d');

$pdf = new Pdf();

// $title = 'NIMREGENIN SUMMARY REPORT_'. date('Y-m-d');
$file_name = $title . '.pdf';

$output = ' ';

// if ($_GET['group'] == 2) {
if ($ListByMonthAllTables) {

    $output .= '
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <td colspan="' . $span0 . '" align="center" style="font-size: 18px">
                        <b>' . $title . '</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="' . $span0 . '" align="center" style="font-size: 18px">
                        <b>Total Screened ( ' . $screened . ' ):  Total Enrolled( ' . $enrolled . ' )</b>
                    </td>
                </tr>
                <tr>
                    <td colspan="' . $span0 . '">                        
                        <br />
                        <table width="100%" border="1" cellpadding="5" cellspacing="0">
                            <tr>
                                <th rowspan="1">No</th>
                                <th rowspan="1">PERIOD</th>
                                <th rowspan="1">Eligibility </th>
                                <th rowspan="1">HIV History And Medication</th>
                                <th rowspan="1">Risk Factors</th>
                                <th rowspan="1">Medications / Short-term illness</th>
                                <th rowspan="1">Chronic Illnesses</th>
                                <th rowspan="1">Laboratory Results</th>
                                <th rowspan="1">Radiological Investigations</th>
                            </tr>
            ';

    // Load HTML content into dompdf
    $x = 1;
    foreach ($ListByMonthAllTables as $row) {
        // $enrolled = $override->countData1('clients', 'status', 1, 'enrolled', 1, 'create_on', $row['create_on']);
        $crf2 = $override->getCount('hiv_history_and_medication', 'status', 1);        
        $crf4 = $override->getCount('eligibility', 'status',1);
        $crf5 = $override->getCount('risk_factors', 'status', 1);
        $crf6 = $override->getCount('medications', 'status', 1);
        $crf7 = $override->getCount('chronic_illnesses', 'status', 1);
        $crf8 = $override->getCount('laboratory_results', 'status', 1);
        $crf9 = $override->getCount('radiological_investigations', 'status', 1);
        // $crf2 = $override->countData('hiv_history_and_medication', 'status', 1, 'site_id', $row['id']);
        // $crf2_Total = $override->getCount('hiv_history_and_medication', 'status', 1);
        // $crf3 = $override->countData('risk_factors', 'status', 1, 'site_id', $row['id']);
        // $crf3_Total = $override->getCount('risk_factors', 'status', 1);
        // $crf4 = $override->countData('medications', 'status', 1, 'site_id', $row['id']);
        // $crf4_Total = $override->getCount('medications', 'status', 1);
        // $crf5 = $override->countData('chronic_illnesses', 'status', 1, 'site_id', $row['id']);
        // $crf5_Total = $override->getCount('chronic_illnesses', 'status', 1);
        // $crf6 = $override->countData('laboratory_results', 'status', 1, 'site_id', $row['id']);
        // $crf6_Total = $override->getCount('laboratory_results', 'status', 1);
        // $crf7 = $override->countData('radiological_investigations', 'status', 1, 'site_id', $row['id']);
        // $crf7_Total = $override->getCount('radiological_investigations', 'status', 1);

        $output .= '
                <tr>
                    <td>' . $x . '</td>
                    <td>' . $row['month']  . '</td>
                    <td>' . $row['count2']  . '</td>
                    <td>' . $row['count4']  . '</td>
                    <td>' . $row['count5']  . '</td>
                    <td>' . $row['count6']  . '</td>
                    <td>' . $row['count7']  . '</td>
                    <td>' . $row['count8']  . '</td>
                    <td>' . $row['count9']  . '</td>
                </tr>
            ';

        $x += 1;
    }

    $output .= '
                <tr>
                    <td align="right" colspan="2"><b>Total</b></td>
                    <td align="right"><b>' . $crf2 . '</b></td>
                    <td align="right"><b>' . $crf4 . '</b></td>
                    <td align="right"><b>' . $crf5 . '</b></td>
                    <td align="right"><b>' . $crf6 . '</b></td>
                    <td align="right"><b>' . $crf7 . '</b></td>
                    <td align="right"><b>' . $crf8 . '</b></td>
                    <td align="right"><b>' . $crf9 . '</b></td>
                </tr>              
';
}

// $output = '<html><body><h1>Hello, dompdf!' . $row . '</h1></body></html>';
$pdf->loadHtml($output);

// SetPaper the HTML as PDF
// $pdf->setPaper('A4', 'portrait');
$pdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$pdf->render();

// Output the generated PDF
$pdf->stream($file_name, array("Attachment" => false));
