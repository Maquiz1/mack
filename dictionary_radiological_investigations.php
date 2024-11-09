<?php
require 'vendor/autoload.php';

use TCPDF;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'ecg',
            'field_label' => 'Electrocardiogram (ECG)',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'ecg_date',
            'field_label' => 'Date of ECG',
            'field_type' => 'date',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'quality_ecg',
            'field_label' => 'What is the Quality of ECG?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Good\n2=Sub-optimal\n3=Poor quality",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'qualitative_ecg',
            'field_label' => 'Qualitative',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Slow\n3=Fast",
            'units' => 'Based on reference',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'regularity_ecg',
            'field_label' => 'Regularity',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'heart_rythm_ecg',
            'field_label' => 'Heart Rhythm',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Sinus ryhthm\n2=Other specify",
            'units' => 'Based on reference',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'other_heart_rhythm_ecg',
            'field_label' => 'Other heart Rhythm',
            'field_type' => 'text',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'qrs_axis_no_ecg',
            'field_label' => '5. Axis: QRS axis ( Specify number )',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'qrs_axis_state_ecg',
            'field_label' => '5. And state whether QRS axis is normal or not',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Right Axis deviation\n3=Left Axis Deviation\n4=Indeterminate",
            'units' => 'Based on reference',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'pr_interval_ecg',
            'field_label' => '6. PR interval',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'pr_inter_specify_ecg',
            'field_label' => '6. PR interval specify;',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Slow\n3=Fast",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'qtc_interval_ecg',
            'field_label' => 'Qtc Interval',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'qtc_inter_specify_ecg',
            'field_label' => 'Qtc Interval specify',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Slow\n3=Fast",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'abnormal_waves_ecg',
            'field_label' => '7. Abnomalities of waves noted:assess P, QRS, T-waves, Q-waves and report any abnormalities, if any, of the waves eg tall p-waves; wide QRS complex; RBBB/LBBB pattern',
            'field_type' => 'text',
            'required' => 'Yes',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'repolarizatn_abno_ecg',
            'field_label' => '8.Repolarization abnormalities if any eg ST-segment depression, elevation, etc',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'conclusion_ecg',
            'field_label' => 'Summary statement: In conclusion the ECG is?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Abnormal\n3=Borderline",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'conclusion_ecg',
            'field_label' => 'Summary statement: In conclusion the ECG is?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Abnormal\n3=Borderline",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'abno_o_borderl_specify',
            'field_label' => 'If abnormal or borderline specify',
            'field_type' => 'text',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'echocardiogram',
            'field_label' => 'Echocardiogram',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'quality_of_image_echo',
            'field_label' => 'What is quality of the Image?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Abnormal",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'brief_exp_subopt_echo',
            'field_label' => 'Brief explanation why suboptimal',
            'field_type' => 'text',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'situs_echo',
            'field_label' => 'Situs',
            'field_type' => 'checkbox',
            'required' => 'Yes',
            'values' => "1=Solitus\n2=Inversus\n3=Ambiguous",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'cardiac_axis_echo',
            'field_label' => 'Cardiac axis',
            'field_type' => 'checkbox',
            'required' => 'Yes',
            'values' => "1=Levocardia\n2=Mesocardia\n3=Dextrocardia",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'syst_vein_connect_echo',
            'field_label' => 'Systemic veinous connections',
            'field_type' => 'checkbox',
            'required' => 'Yes',
            'values' => "1=Normal\n2=Abnormal",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'specify_ab_sysvein_con',
            'field_label' => 'Specify abnormal Systemic veinous connections',
            'field_type' => 'text',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'laboratory_results_complete',
            'field_label' => 'Complete?',
            'field_type' => 'checkbox',
            'required' => 'Yes',
            'values' => "0=Incomplete\n1=Unverified\n2=Complete",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ]
    ];


    // Generate PDF in landscape mode
    $pdf = new TCPDF('L', 'mm', 'A4');
    $pdf->AddPage();

    // Set document title and headings
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, $_GET['table'] . ' Data Dictionary ( EAPOC-VL STUDY - TANZANIA)', 0, 1, 'C');

    // Create table headings for all field types
    $pdf->Ln(10);
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(30, 10, 'Field Name', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Field Label', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Field Type', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Required', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Values', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Units', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Range', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Format', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Decimals', 1, 1, 'C');

    // Fill table with data dictionary values
    $pdf->SetFont('helvetica', '', 10);
    foreach ($dataDictionary as $field) {
        $rowHeight = 10;  // Default row height

        // Determine the maximum height needed for wrapped cells
        $valuesHeight = $pdf->getStringHeight(40, $field['values']);  // Adjust width as needed
        $labelHeight = $pdf->getStringHeight(50, $field['field_label']);
        $fieldNameHeight = $pdf->getStringHeight(30, $field['field_name']);  // Adjust width as needed
        $rowHeight = max($rowHeight, $valuesHeight, $labelHeight, $fieldNameHeight);  // Use the maximum height

        $pdf->MultiCell(30, $rowHeight, $field['field_name'], 1, 'C', 0, 0);  // Wrap 'field_name' cell
        $pdf->MultiCell(50, $rowHeight, $field['field_label'], 1, 'L', 0, 0);
        $pdf->Cell(30, $rowHeight, $field['field_type'], 1, 0, 'C');
        $pdf->Cell(20, $rowHeight, $field['required'], 1, 0, 'C');
        $pdf->MultiCell(40, $rowHeight, $field['values'], 1, 'L', 0, 0);  // Wrap 'values' cell
        $pdf->Cell(20, $rowHeight, $field['units'], 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['range'], 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['format'], 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['decimal_points'], 1, 1, 'C');
    }

    // Save the PDF and display it in the browser
    $pdf->Output($_GET['table'] . ' Data Dictionary.pdf', 'I');

    exit;
} else {
    echo "Please access this page via a GET request.";
}
?>