<?php
require 'vendor/autoload.php';

use TCPDF;

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Updated data dictionary array with 'units', 'range', 'format', and 'decimal_points' fields
    $dataDictionary = [
        [
            'field_name' => 'hema_done',
            'field_label' => 'Has haematology been done today?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lab_date_hema',
            'field_label' => 'Date of sampling',
            'field_type' => 'date',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lab_time_hema',
            'field_label' => 'Time of sampling',
            'field_type' => 'time',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'HH:MM',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'hemo',
            'field_label' => 'Haemoglobin',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'hemo_type',
            'field_label' => 'Haemoglobin Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=g/L\n2=g/dL",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'wbc',
            'field_label' => 'WBC count',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'wbc_type',
            'field_label' => 'Wbc Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=x109/L\n2=x103/L",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lymph',
            'field_label' => 'Lymphocyte count',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'cells/uL',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'neutro_count',
            'field_label' => 'Neutrophil count',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'cells/uL',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'hematocrit',
            'field_label' => 'Hematocrit',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '%',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'platelettes',
            'field_label' => 'Platelets',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'platelets_type',
            'field_label' => 'Platelets Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=x109/L\n2=x103/L",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'biochem_done',
            'field_label' => 'Has biochemistry tests been done today?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lab_date_bio',
            'field_label' => 'Date of sampling',
            'field_type' => 'date',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lab_time_bio',
            'field_label' => 'Time of sampling',
            'field_type' => 'time',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'HH:MM',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'bun',
            'field_label' => 'Blood Urea Nitrogen (urea)',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'bun_type',
            'field_label' => 'Bun Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=mmol/L\n2=mg/dL",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'creat',
            'field_label' => 'Creatinine',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'creat_type',
            'field_label' => 'Creatinine Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=mmol/L\n2=mg/dL",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'sodium',
            'field_label' => 'Sodium',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'sod_type',
            'field_label' => 'Sodium Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=mmol/L\n2=mEq/L",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'potass',
            'field_label' => 'Potassium',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'potas_type',
            'field_label' => 'Potassium Type',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=mmol/L\n2=mEq/L",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'tot_choles',
            'field_label' => 'Total Cholesterol',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'mmol/L',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'trigly',
            'field_label' => 'Triglycerides',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'mmol/L',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'hdl',
            'field_label' => 'HDL',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'mmol/L',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'ldl',
            'field_label' => 'LDL',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'mmol/L',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'vldl',
            'field_label' => 'VLDL',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => 'mmol/L',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'coronary_risk',
            'field_label' => 'Coronary Risk',
            'field_type' => 'number',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'urine_done',
            'field_label' => 'Has urine R/E been done today?',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lab_date_bio_2',
            'field_label' => 'Date of sampling',
            'field_type' => 'date',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'lab_time_bio_2',
            'field_label' => 'Time of sampling',
            'field_type' => 'time',
            'required' => 'No',
            'values' => "",
            'units' => '',
            'range' => '',
            'format' => 'HH:MM',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'color',
            'field_label' => 'Color',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Clear\n2=Light Yellow\n3=Yellow\n4=Dark Yellow\n5=Brown\n6=Red",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'appearance',
            'field_label' => 'Appearance',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Clear\n2=Cloudy\n3=Blood Stained\n4=Frank Blood",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'labs_glucose',
            'field_label' => 'Glucose',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Positive\n2=Negative",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'bilirubin',
            'field_label' => 'Bilirubin',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Positive\n2=Negative",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'ketone',
            'field_label' => 'Ketone',
            'field_type' => 'select',
            'required' => 'Yes',
            'values' => "1=Positive\n2=Negative",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'risk_factors_complete',
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