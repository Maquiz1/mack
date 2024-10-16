<?php
require 'vendor/autoload.php';

use TCPDF;

// if ($_GET["table"]) {

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'name',
            'field_label' => 'Name',
            'field_type' => 'text',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => 'Alphabetical only',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'email',
            'field_label' => 'Email',
            'field_type' => 'email',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => 'example@domain.com',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'age',
            'field_label' => 'Age',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => 'years',
            'range' => '18-99', // Range for age
            'format' => '',
            'decimal_points' => '0' // No decimal points for age
        ],
        [
            'field_name' => 'gender',
            'field_label' => 'Gender',
            'field_type' => 'radio',
            'required' => 'Yes',
            'values' => '1=Male, 2=Female',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'height',
            'field_label' => 'Height',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => 'cm',
            'range' => '100-250', // Range for height in cm
            'format' => '',
            'decimal_points' => '1' // Allow 1 decimal point for height
        ],
        [
            'field_name' => 'subscribe',
            'field_label' => 'Subscribe to newsletter?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => '1=Yes, 2=No',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'hobbies',
            'field_label' => 'Hobbies',
            'field_type' => 'checkbox',
            'required' => 'No',
            'values' => '1=Reading, 2=Sports, 3=Music',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ]
    ];

    // Generate PDF in landscape mode
    $pdf = new TCPDF('L', 'mm', 'A4'); // 'L' for Landscape orientation
    $pdf->AddPage();

    // Set document title and headings
    $pdf->SetFont('helvetica', 'B', 16);
    $pdf->Cell(0, 10, 'Data Dictionary', 0, 1, 'C');

    // Create table headings for all field types
    $pdf->Ln(10); // New line
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(30, 10, 'Field Name', 1, 0, 'C');
    $pdf->Cell(50, 10, 'Field Label', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Field Type', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Required', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Values', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Units', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Range', 1, 0, 'C'); // Column for range
    $pdf->Cell(30, 10, 'Format', 1, 0, 'C'); // Column for format
    $pdf->Cell(30, 10, 'Decimals', 1, 1, 'C'); // Column for decimal points

    // Fill table with data dictionary values
    $pdf->SetFont('helvetica', '', 10); // Set font to normal for data rows
    foreach ($dataDictionary as $field) {
        // Set cell heights based on content
        $rowHeight = 10; // Default height

        // Field name
        $pdf->Cell(30, $rowHeight, $field['field_name'] ?: ' ', 1, 0, 'C');
        // Field label
        $pdf->Cell(50, $rowHeight, $field['field_label'] ?: ' ', 1, 0, 'C');
        // Field type
        $pdf->Cell(30, $rowHeight, $field['field_type'] ?: ' ', 1, 0, 'C');
        // Required
        $pdf->Cell(20, $rowHeight, $field['required'] ?: ' ', 1, 0, 'C');

        // Handle values for select, radio, and checkbox fields
        if (in_array($field['field_type'], ['select', 'radio', 'checkbox']) && !empty($field['values'])) {
            $values = explode(', ', $field['values']);
            $valueText = implode("\n", $values); // Separate values by new lines
            $pdf->MultiCell(40, 10, $valueText ?: ' ', 1, 'C'); // Multicell for vertical display of values
            $pdf->Ln(-10); // Move back up to keep row height consistent
        } else {
            $pdf->Cell(40, $rowHeight, $field['values'] ?: ' ', 1, 0, 'C'); // Empty or predefined values for other field types
        }

        // Add units column
        $pdf->Cell(20, $rowHeight, $field['units'] ?: ' ', 1, 0, 'C');

        // Add range, format, and decimal points columns
        $pdf->Cell(30, $rowHeight, $field['range'] ?: ' ', 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['format'] ?: ' ', 1, 0, 'C');
        $pdf->Cell(30, $rowHeight, $field['decimal_points'] ?: ' ', 1, 1, 'C');
    }

    // Save the PDF and send it to the browser
    $pdf->Output('data_dictionary.pdf', 'D'); // Force download

    exit;
}
// }
