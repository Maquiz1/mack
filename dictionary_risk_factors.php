<?php
require 'vendor/autoload.php';

use TCPDF;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'smoke_stat',
            'field_label' => '1.13 Do you Smoke?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes (within past 12months)\n2=Never smoked\n3=Former smoker (more than 12  months ago)",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'smoking_yes',
            'field_label' => 'If yes to smoking?',
            'field_type' => 'checkbox',
            'required' => 'No',
            'values' => "1=Smokeless\n2=Smoking\n3=E-Cigarette\n4=Other forms of tobacco",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'duration_smokeless',
            'field_label' => 'Duration (smokeless)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'months',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'frequence_smokeless',
            'field_label' => 'Frequency (smokeless)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'quantity_smokeless',
            'field_label' => 'Quantity (smokeless)',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "",
            'units' => 'number per day',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'duration_smoking',
            'field_label' => 'Duration (smoking)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'months',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'frequence_smoking',
            'field_label' => 'Frequency (smoking)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'quantity_smoking',
            'field_label' => 'Quantity (smoking)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'number per day',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'duration_ecigarette',
            'field_label' => 'Duration (E-cigarette)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'months',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'frequence_ecigarette',
            'field_label' => 'Frequency (E-cigarette)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'quantity_ecigarette',
            'field_label' => 'Quantity (E-cigarette)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'number per day',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'other_tobacco',
            'field_label' => 'Other forms of tobacco, specify',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'duration_other',
            'field_label' => 'Duration (other forms of tobacco)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'months',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'frequence_other',
            'field_label' => 'Frequency (other forms of tobacco)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'quantity_other',
            'field_label' => 'Quantity (other forms of tobacco)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'number per day',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'physically_active',
            'field_label' => '1.14 Are you Physically active?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medical_condtn',
            'field_label' => 'Any medical or other condition in the potential participant or their guardian that preludes the provision of informed consent/ assent?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'enrolled_part',
            'field_label' => 'Is the volunteer eligible to be enrolled?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'participant_id',
            'field_label' => 'If YES, indicate the Participant ID',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'screen_failure',
            'field_label' => 'If NO, give reason for screening failure?',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'eligibility_form_complete',
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
        $rowHeight = max($rowHeight, $valuesHeight, $labelHeight);  // Use the maximum height

        $pdf->Cell(30, $rowHeight, $field['field_name'], 1, 0, 'C');
        $pdf->MultiCell(50, $rowHeight, $field['field_label'], 1, 'L', 0, 0);
        $pdf->Cell(30, $rowHeight, $field['field_type'], 1, 0, 'C');
        $pdf->Cell(20, $rowHeight, $field['required'], 1, 0, 'C');
        $pdf->MultiCell(40, $rowHeight, $field['values'], 1, 'L', 0, 0);  // Wrap 'values' cell
        $pdf->Cell(20, $rowHeight, $field['units'], 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['range'], 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['format'], 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['decimal_points'], 1, 1, 'C');
    }

    // $pdf->Output('data_dictionary.pdf', 'I');


    // Save the PDF and display it in the browser
    $pdf->Output($_GET['table'] . ' Data Dictionary.pdf', 'I');

    exit;
} else {
    echo "Please access this page via a GET request.";
}
?>