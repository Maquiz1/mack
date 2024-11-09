<?php
require 'vendor/autoload.php';

use TCPDF;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'illness',
            'field_label' => '4.1 Have you had any illness in the past three months ?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'illness_specify',
            'field_label' => 'If Yes,mention',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'sick',
            'field_label' => '4.2 Can you name what you were sick during that period ?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'sick_specify',
            'field_label' => 'If Yes,mention',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medicines',
            'field_label' => '4.3 Are there any other medicines you used apart form ART ?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medicines_specify',
            'field_label' => 'If Yes,mention',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medicines_years',
            'field_label' => '4.4 How long have you used those medicine? ( Years )',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'If Only Months And Days Put 0',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medicines_months',
            'field_label' => '4.4 How long have you used those medicine? ( Months )',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'If Only Years And Days Put 0',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medicines_days',
            'field_label' => '4.4 How long have you used those medicine? ( Days )',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'If Only Years And Months Put 0',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'medications_complete',
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