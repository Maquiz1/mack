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
            'field_name' => 'gender',
            'field_label' => 'Gender',
            'field_type' => 'radio',
            'required' => 'Yes',
            'values' => "1=Male\n2=Female",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'phone',
            'field_label' => '1.2 Phone number',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '0XXXXXXXXX',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'alternative_no',
            'field_label' => 'Alternative No',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '0XXXXXXXXX',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'informed_consent',
            'field_label' => '1.1 Did the Participant give informed consent ?',
            'field_type' => 'radio',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'date_informed_consent',
            'field_label' => 'Date of informed consent',
            'field_type' => 'date',
            'required' => 'Yes',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => 'YYYY-MM-DD',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'district',
            'field_label' => 'District',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "7=Ilala\n8=Kigamboni\n9=Kinondoni\n10=Temeke\n11=Ubungo\n44=ILALA\n45=Ubungo",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'sub_county',
            'field_label' => 'Ward ( Sub-county )',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "22=Bunju\n23=Hananasif\n24=Kawe\n25=Kigogo\n26=Kijitonyama\n27=Kinondoni\n28=Kunduchi\n29=Mabwepande\n30=Magomeni\n31=Makongo\n32=Kijitonyama\n36=Msasani\n37=Mwananyamala\n38=Mwananyamala\n41=Tandale\n42=Wazo\n43=Kivule\n44=Mbezi Luis\n45=Manzese\n46=Mbezi mwisho\n47=Mbezi mwisho\n48=Kijitonyama\n49=Yombo\n50=YOMBO\n51=Kijitonyama\n52=Tabata\n53=Tabata\n54=Mbezi Beach\n55=Bunju\n56=Chanika\n59=Sinza",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'weight',
            'field_label' => '1.4 Weight',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => 'kgs',
            'range' => '0-200',
            'format' => '',
            'decimal_points' => '0'
        ],
        [
            'field_name' => 'height',
            'field_label' => '1.5 Height',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => 'cm',
            'range' => '0-300',
            'format' => '',
            'decimal_points' => '0'
        ],
        [
            'field_name' => 'sys_bp',
            'field_label' => '1.6 Systolic blood Pressure',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => 'mm/Hg',
            'range' => '0-900',
            'format' => '',
            'decimal_points' => '0'
        ],
        [
            'field_name' => 'dias_bp',
            'field_label' => '1.7 Diastolic Blood Pressure',
            'field_type' => 'number',
            'required' => 'Yes',
            'values' => '',
            'units' => 'mm/Hg',
            'range' => '0-900',
            'format' => '',
            'decimal_points' => '0'
        ],
        [
            'field_name' => 'education',
            'field_label' => '1.8 What is the highest Education received?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Primary\n2=Secondary\n3=Tertiary\n4=University\n5=None at all",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'marital_status',
            'field_label' => '1.9 What is your Marital Status?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Single\n2=Married\n3=Separated",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'occupation',
            'field_label' => '1.10 Occupation',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Student\n2=Unemployed\n3=Unskilled worker\n4=Professianl worker\n5=Other",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'unskilled',
            'field_label' => 'specify why unskilled',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'profesional_worker',
            'field_label' => 'specify professional worker',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'other_religion',
            'field_label' => 'specify other occupation',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'religion',
            'field_label' => '1.11 Participant\'s religion',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Christian\n2=Muslim\n2=No\n3=Other",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'other_religion',
            'field_label' => 'Specify other religion',
            'field_type' => 'text',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'sociodemographics_complete',
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