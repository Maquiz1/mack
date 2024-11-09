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
            'field_name' => 'activity_grade',
            'field_label' => 'If Yes, What is your grade?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=High activity: Vigorous activity 3 times a week or more\n2=Medium activity:vigorous 1-2 times per week\n3=Low activity: moderate exercise 3 or more times per week with no regular weekly vigorous exercise\n4=Sedentary-moderate exercise less than 3 times per week with no regular vigorous exercise",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'alcohol',
            'field_label' => 'Do you Take Alcohol?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'drink_cont_alcoh',
            'field_label' => '1.How often do you have a drink containing alcohol? skip to question 9-10 if Never',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Monthly or less\n3=2 to 4 times a month\n4=2 to 3 times a week\n5=4 or more times a week",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'total_1only',
            'field_label' => 'Total for 1',
            'field_type' => 'number',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'howmany_drinks',
            'field_label' => '2. How many drinks containing alcohol do you have on a typical day when you are drinking?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=1 or 2\n2=3 or 4\n3=5 or 6\n4=7,8 or 9\n5=10 or More",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'drink_often',
            'field_label' => '3. How often do you have six or more drinks on one occassion?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Less than a monthly\n3=Monthly\n4=Weekly\n5=Daily or almost daily",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'drink_often',
            'field_label' => '4. How often during the last year have you found that you were not able to stop drinking once you had started?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Less than a monthly\n3=Monthly\n4=Weekly\n5=Daily or almost daily",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'failed_todo_normal',
            'field_label' => '5. How often during the last year have you failed to do what was normally expected from you because of drinking?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Less than a monthly\n3=Monthly\n4=Weekly\n5=Daily or almost daily",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'first_drink_morning',
            'field_label' => '6. How often during the last year have you needed a first drink in the morning to get yourself going after a heavy drinking session?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Less than a monthly\n3=Monthly\n4=Weekly\n5=Daily or almost daily",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'remorse_after_drink',
            'field_label' => '7. How often during the last year have you had a feeling of guilt or remorse after drinking?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Less than a monthly\n3=Monthly\n4=Weekly\n5=Daily or almost daily",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'cant_remember',
            'field_label' => '8. How often during the last year have you been unable to remember what happened the night before because you had been drinking?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=Never\n2=Less than a monthly\n3=Monthly\n4=Weekly\n5=Daily or almost daily",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'injure_someone',
            'field_label' => '9. Have you or someone else been injured as a result of your drinking?',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=No\n2=Yes, but not in last year\n3=Yes, but during last year",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'concern_about_drink',
            'field_label' => '10. Has a relative or friend or a doctor or another health worker been concerned about your drinking or suggested you cut down',
            'field_type' => 'select',
            'required' => 'No',
            'values' => "1=No\n2=Yes, but not in last year\n3=Yes, but during last year",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'overall_total_never',
            'field_label' => 'Overall total 1',
            'field_type' => 'number',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'overtotal',
            'field_label' => 'Overall total 2',
            'field_type' => 'number',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
                [
            'field_name' => 'treated_tb',
            'field_label' => '1.15 Have you ever been treated for TB??',
            'field_type' => 'checkbox',
            'required' => 'Yes',
            'values' => "1=Yes\n2=No",
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
                ],
        [
            'field_name' => 'date_treated_tb',
            'field_label' => '1.15 If yes when was it ( Year )?',
            'field_type' => 'number',
            'required' => 'No',
            'values' => '',
            'units' => '',
            'range' => '',
            'format' => '',
            'decimal_points' => ''
        ],
        [
            'field_name' => 'month_treated_tb',
            'field_label' => '1.15 If yes when was it ( Month ) ?',
            'field_type' => 'number',
            'required' => 'No',
            'values' => '',
            'units' => '(If Don’t remember month put ‘99’)',
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