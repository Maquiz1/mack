<?php
require 'vendor/autoload.php';

use TCPDF;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'date_diagnosis_hiv',
            'field_label' => '2.1 When were you first diagnosed with HIV?',
            'field_type' => 'date',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'clinical_stage',
            'field_label' => '2.2 What was you WHO Clinical Stage at ART initiation?',
            'field_type' => 'radio',
            'required' => 'Yes',
            'values' => "1=Stage 1\n2=Stage 2\n3=Stage 3\n4=Stage 4",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'viral_load',
            'field_label' => '2.3 What is the most recent Viral load?',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => "",
            'units' => 'copies/ul',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'viral_load_sampledate',
            'field_label' => '2.4 Date samples were taken of',
            'field_type' => 'date',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'date_art_treatment',
            'field_label' => '3.1 When did you begin taking ART-Treatment?',
            'field_type' => 'date',
            'required' => 'Yes',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'art_regimen',
            'field_label' => '3.2 Which ART regimen was the participant taking?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=First line\n2=Second line\n3=Third line\n4=Salvage therapy\n5=Other",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'art_regimen_other',
            'field_label' => 'If Other Regime',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'first_line',
            'field_label' => 'First line',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=ABC+3TC+DTG\n2=TDF+3TC+DTG\n3=AZT+3TC+DTG\n4=TDF+FTC+DTG\n5=ABC+3TC+LPV/r\n6=AZT+3TC+LPV/r\n7=AZT+3TC+EFV\n8=ABC+3TC+EFV\n9=TDF+3TC+EFV\n10=AZT+3TC+NVP\n11=Other 1st line",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'other_first_line',
            'field_label' => 'If Other First line',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'second_line',
            'field_label' => 'Second line',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=AZT+3TC+LPV/r\n2=ABC+3TC+LPV/r\n3=ABC+3TC+LPV/r\n4=ABC+3TC+ATV/r\n5=Other 2nd line",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'other_second_line',
            'field_label' => 'If Other second line',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'third_line',
            'field_label' => 'Third line',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=DTG+DRV/r+AZT+3TC\n2=DTG+LPV/r+AZT+3TC\n3=RAL+DRV/r+AZT+3TC\n4=RAL+LPV/r+AZT+3TC\n5=Other 3rd line",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'same_regimen',
            'field_label' => '3.4 Were you given the same Regimen today ?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'name_regimen',
            'field_label' => '3.5 If No,Please name the regimen',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'unwell',
            'field_label' => '3.6 Has the participant been unwell since the last visit?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'what_health_problem',
            'field_label' => '3.7 If yes, What was the health problem',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],       
        [
            'field_name' => 'hiv_history_and_medication_complete',
            'field_label' => 'Complete?',
            'field_type' => 'checkbox',
            'required' => 'No',
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