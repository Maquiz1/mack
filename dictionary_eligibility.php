<?php
require 'vendor/autoload.php';

use TCPDF;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'hiv_infection',
            'field_label' => 'Confirmed and Documented HIV Infection?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'art_treatment',
            'field_label' => 'Has the Participant been on ART treatment for HIV for more than 6months?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'participant_age',
            'field_label' => 'Is the Participant aged between 10 - 24?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'understand_icf',
            'field_label' => 'Is the Participant able to understand and willing to sign the informed consent document?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'another_study',
            'field_label' => 'Is the participant already enrolled in another study that may interfere with the study outcome',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'newly_diagnosed',
            'field_label' => 'Newly diagnosed with HIV?',
            'field_type' => 'select',
            'required' => 'Yes',
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
            'required' => 'Yes',
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
            'required' => 'Yes',
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