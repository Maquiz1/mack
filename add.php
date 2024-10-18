<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;

$numRec = 12;

if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_user')) {
            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);
            if ($staff) {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                    'username' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'phone_number' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'email_address' => array(
                        'unique' => 'user'
                    ),
                ));
            }
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = '12345678';
                switch (Input::get('position')) {
                    case 1:
                        $accessLevel = 1;
                        break;
                    case 2:
                        $accessLevel = 1;
                        break;
                    case 3:
                        $accessLevel = 2;
                        break;
                    case 4:
                        $accessLevel = 3;
                        break;
                    case 5:
                        $accessLevel = 3;
                        break;
                }
                try {

                    // $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);

                    if ($staff) {
                        $user->updateRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => Input::get('accessLevel'),
                            'power' => Input::get('power'),
                            'site_id' => Input::get('site_id'),
                        ), $_GET['staff_id']);

                        $successMessage = 'Account Updated Successful';
                    } else {
                        $user->createRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => Input::get('accessLevel'),
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'create_on' => date('Y-m-d'),
                            'last_login' => '',
                            'status' => 1,
                            'user_id' => $user->data()->id,
                            'site_id' => Input::get('site_id'),
                            'count' => 0,
                            'pswd' => 0,
                        ));
                        $successMessage = 'Account Created Successful';
                    }

                    Redirect::to('info.php?id=1&status=1');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_position')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('position', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Position Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_site')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('site', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Site Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_client')) {
            $validate = $validate->check($_POST, array(
                // 'firstname' => array(
                //     'required' => true,
                // ),
                // 'middlename' => array(
                //     'required' => true,
                // ),
                // 'lastname' => array(
                //     'required' => true,
                // ),
                // 'age' => array(
                //     'required' => true,
                // ),
                'gender' => array(
                    'required' => true,
                ),
                // 'ctc' => array(
                //     'required' => true,
                //     // 'unique' => 'clients'
                // ),
                'informed_consent' => array(
                    'required' => true,
                ),
                'date_of_birth' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                try {

                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    $age = $user->dateDiffYears(Input::get('date_of_visit'), Input::get('date_of_birth'));

                    if ($clients) {
                        $user->updateRecord('clients', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'art_no' => Input::get('art_no'),
                            'date_of_visit' => Input::get('date_of_visit'),
                            'gender' => Input::get('gender'),
                            'date_of_birth' => Input::get('date_of_birth'),
                            'age' => $age,
                            'age2' => Input::get('age'),
                            'informed_consent' => Input::get('informed_consent'),
                            'date_informed_consent' => Input::get('date_informed_consent'),
                            'phone' => Input::get('phone'),
                            'alternative_no' => Input::get('alternative_no'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'sub_county' => Input::get('sub_county'),
                            'village' => Input::get('village'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'district' => Input::get('district'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'weight' => Input::get('weight'),
                            'height' => Input::get('height'),
                            'sys_bp' => Input::get('sys_bp'),
                            'dias_bp' => Input::get('dias_bp'),
                            'education' => Input::get('education'),
                            'marital_status' => Input::get('marital_status'),
                            'occupation' => Input::get('occupation'),
                            'unskilled' => Input::get('unskilled'),
                            'profesional_worker' => Input::get('profesional_worker'),
                            'other_occupation' => Input::get('other_occupation'),
                            'religion' => Input::get('religion'),
                            'other_religion' => Input::get('other_religion'),
                            'sociodemographics_complete' => Input::get('sociodemographics_complete'),
                            'comments' => Input::get('comments'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $successMessage = 'Client Updated Successful';
                    } else {

                        $std_id = $override->getNews('study_id', 'site_id', 2, 'status', 0)[0];

                        $user->createRecord('clients', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'study_id' => $std_id['study_id'],
                            'pid' => $std_id['study_id'],
                            'art_no' => Input::get('art_no'),
                            'site' => $user->data()->site_id,
                            'date_of_visit' => Input::get('date_of_visit'),
                            'gender' => Input::get('gender'),
                            'date_of_birth' => Input::get('date_of_birth'),
                            'age' => $age,
                            'age2' => Input::get('age'),
                            'informed_consent' => Input::get('informed_consent'),
                            'date_informed_consent' => Input::get('date_informed_consent'),
                            'phone' => Input::get('phone'),
                            'alternative_no' => Input::get('alternative_no'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'sub_county' => Input::get('sub_county'),
                            'village' => Input::get('village'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'district' => Input::get('district'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'weight' => Input::get('weight'),
                            'height' => Input::get('height'),
                            'sys_bp' => Input::get('sys_bp'),
                            'dias_bp' => Input::get('dias_bp'),
                            'education' => Input::get('education'),
                            'marital_status' => Input::get('marital_status'),
                            'occupation' => Input::get('occupation'),
                            'unskilled' => Input::get('unskilled'),
                            'profesional_worker' => Input::get('profesional_worker'),
                            'other_occupation' => Input::get('other_occupation'),
                            'religion' => Input::get('religion'),
                            'other_religion' => Input::get('other_religion'),
                            'sociodemographics_complete' => Input::get('sociodemographics_complete'),
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ));

                        $last_row = $override->lastRow('clients', 'id')[0];

                        $user->updateRecord('study_id', array(
                            'status' => 1,
                            'client_id' => $last_row['id'],
                        ), $std_id['id']);

                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'study_id' => $std_id['study_id'],
                            'pid' => $std_id['study_id'],
                            'visit_code' => 'RS',
                            'visit_name' => 'Registration & Screening',
                            'expected_date' => Input::get('date_of_visit'),
                            'visit_date' => '',
                            'visit_status' => 0,
                            'status' => 1,
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site' => $user->data()->site_id,
                        ));

                        $successMessage = 'Client  Added Successful';
                    }
                    Redirect::to('info.php?id=3&status=7&msg=' . $successMessage);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_hiv_history_and_medication')) {
            $validate = $validate->check($_POST, array(
                'date_diagnosis_hiv' => array(
                    'required' => true,
                ),
                'clinical_stage' => array(
                    'required' => true,
                ),
                'viral_load' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $hiv_history_and_medicationap = $override->getNews('hiv_history_and_medication', 'status', 1, 'patient_id', $_GET['cid']);
                if ($hiv_history_and_medicationap) {
                    $user->updateRecord('hiv_history_and_medication', array(
                        'date_diagnosis_hiv' => Input::get('date_diagnosis_hiv'),
                        'clinical_stage' => Input::get('clinical_stage'),
                        'viral_load' => Input::get('viral_load'),
                        'viral_load_sampledate' => Input::get('viral_load_sampledate'),
                        'date_art_treatment' => Input::get('date_art_treatment'),
                        'art_regimen' => Input::get('art_regimen'),
                        'art_regimen_other' => Input::get('art_regimen_other'),
                        'first_line' => Input::get('first_line'),
                        'other_first_line' => Input::get('other_first_line'),
                        'second_line' => Input::get('second_line'),
                        'other_second_line' => Input::get('other_second_line'),
                        'third_line' => Input::get('third_line'),
                        'other_third_line' => Input::get('other_third_line'),
                        'same_regimen' => Input::get('same_regimen'),
                        'name_regimen' => Input::get('name_regimen'),
                        'unwell' => Input::get('unwell'),
                        'what_health_problem' => Input::get('what_health_problem'),
                        'comments' => Input::get('comments'),
                        'hiv_history_and_medication_complete' => Input::get('hiv_history_and_medication_complete'),
                        'hiv_history_and_medication_complete_date' => Input::get('hiv_history_and_medication_complete_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $hiv_history_and_medicationap[0]['id']);

                    $successMessage = 'HIV History And Medication  Successful Updated';
                } else {
                    $user->createRecord('hiv_history_and_medication', array(
                        'date_diagnosis_hiv' => Input::get('date_diagnosis_hiv'),
                        'study_id' => $_GET['study_id'],
                        'pid' => $_GET['study_id'],
                        'clinical_stage' => Input::get('clinical_stage'),
                        'viral_load' => Input::get('viral_load'),
                        'viral_load_sampledate' => Input::get('viral_load_sampledate'),
                        'date_art_treatment' => Input::get('date_art_treatment'),
                        'art_regimen' => Input::get('art_regimen'),
                        'art_regimen_other' => Input::get('art_regimen_other'),
                        'first_line' => Input::get('first_line'),
                        'other_first_line' => Input::get('other_first_line'),
                        'second_line' => Input::get('second_line'),
                        'other_second_line' => Input::get('other_second_line'),
                        'third_line' => Input::get('third_line'),
                        'other_third_line' => Input::get('other_third_line'),
                        'same_regimen' => Input::get('same_regimen'),
                        'name_regimen' => Input::get('name_regimen'),
                        'unwell' => Input::get('unwell'),
                        'what_health_problem' => Input::get('what_health_problem'),
                        'comments' => Input::get('comments'),
                        'hiv_history_and_medication_complete' => Input::get('hiv_history_and_medication_complete'),
                        'hiv_history_and_medication_complete_date' => Input::get('hiv_history_and_medication_complete_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id
                    ));

                    $successMessage = 'HIV History And Medication  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_eligibility_form')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'hiv_infection' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $eligibility = $override->getNews('eligibility', 'status', 1, 'patient_id', $_GET['cid']);
                $eligible = '';
                if ((Input::get('hiv_infection') == 1 && Input::get('art_treatment') == 1 && Input::get('participant_age') == 1 && Input::get('understand_icf') == 1) && (Input::get('another_study') == 2 && Input::get('newly_diagnosed') == 2 && Input::get('medical_condtn') == 2)) {
                    $eligible = 1;
                } else {
                    $eligible = 2;
                }

                if ($eligibility) {
                    $user->updateRecord('eligibility', array(
                        'visit_date' => Input::get('visit_date'),
                        'hiv_infection' => Input::get('hiv_infection'),
                        'art_treatment' => Input::get('art_treatment'),
                        'participant_age' => Input::get('participant_age'),
                        'understand_icf' => Input::get('understand_icf'),
                        'another_study' => Input::get('another_study'),
                        'newly_diagnosed' => Input::get('newly_diagnosed'),
                        'medical_condtn' => Input::get('medical_condtn'),
                        'enrolled_part' => $eligible,
                        'screen_failure' => Input::get('screen_failure'),
                        'form_completd_by' => Input::get('form_completd_by'),
                        'date_form_comptn' => Input::get('date_form_comptn'),
                        'eligibility_form_complete' => Input::get('eligibility_form_complete'),
                        'eligible' => $eligible,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $eligibility[0]['id']);

                    if ($eligible) {
                        $user->visit_delete1($_GET['cid'], Input::get('visit_date'), $_GET['study_id'], $user->data()->id, $clients['site'], 1);
                    } else {
                        $user->visit_delete1($_GET['cid'], Input::get('visit_date'), $_GET['study_id'], $user->data()->id, $clients['site'], 0);
                    }

                    $user->updateRecord('clients', array(
                        'screened' => 1,
                        'eligible' => $eligible,
                    ), $_GET['cid']);

                    $successMessage = 'Eligibility Form  Successful Added';
                } else {
                    $user->createRecord('eligibility', array(
                        'visit_date' => Input::get('visit_date'),
                        'study_id' => $_GET['study_id'],
                        'pid' => $_GET['study_id'],
                        'hiv_infection' => Input::get('hiv_infection'),
                        'art_treatment' => Input::get('art_treatment'),
                        'participant_age' => Input::get('participant_age'),
                        'understand_icf' => Input::get('understand_icf'),
                        'another_study' => Input::get('another_study'),
                        'newly_diagnosed' => Input::get('newly_diagnosed'),
                        'medical_condtn' => Input::get('medical_condtn'),
                        'enrolled_part' => $eligible,
                        'participant_id' => $_GET['study_id'],
                        'screen_failure' => Input::get('screen_failure'),
                        'form_completd_by' => Input::get('form_completd_by'),
                        'date_form_comptn' => Input::get('date_form_comptn'),
                        'eligibility_form_complete' => Input::get('eligibility_form_complete'),
                        'eligible' => $eligible,
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id,
                    ));

                    if ($eligible) {
                        $user->visit_delete1($_GET['cid'], Input::get('visit_date'), $_GET['study_id'], $user->data()->id, $clients['site'], 1);
                    } else {
                        $user->visit_delete1($_GET['cid'], Input::get('visit_date'), $_GET['study_id'], $user->data()->id, $clients['site'], 0);
                    }
                }

                $user->updateRecord('clients', array(
                    'screened' => 1,
                    'eligible' => $eligible,
                ), $_GET['cid']);

                $successMessage = 'Eligibility Form  Successful Updated';

                // Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_risk_factors')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'smoke_stat' => array(
                    'required' => true,
                ),
                'alcohol' => array(
                    'required' => true,
                ),
                'risk_factors_complete' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $risk_factors = $override->get3('risk_factors', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);
                $smoking_yes = implode(',', Input::get('smoking_yes'));


                if ($risk_factors) {
                    $user->updateRecord('risk_factors', array(
                        'visit_date' => Input::get('visit_date'),
                        'smoke_stat' => Input::get('smoke_stat'),
                        'smoking_yes' => $smoking_yes,
                        'duration_smokeless' => Input::get('duration_smokeless'),
                        'frequence_smokeless' => Input::get('frequence_smokeless'),
                        'quantity_smokeless' => Input::get('quantity_smokeless'),
                        'duration_smoking' => Input::get('duration_smoking'),
                        'frequence_smoking' => Input::get('frequence_smoking'),
                        'quantity_smoking' => Input::get('quantity_smoking'),
                        'duration_ecigarette' => Input::get('duration_ecigarette'),
                        'frequence_ecigarette' => Input::get('frequence_ecigarette'),
                        'quantity_ecigarette' => Input::get('quantity_ecigarette'),
                        'other_tobacco' => Input::get('other_tobacco'),
                        'duration_other' => Input::get('duration_other'),
                        'frequence_other' => Input::get('frequence_other'),
                        'quantity_other' => Input::get('quantity_other'),
                        'physically_active' => Input::get('physically_active'),
                        'activity_grade' => Input::get('activity_grade'),
                        'alcohol' => Input::get('alcohol'),
                        'drink_cont_alcoh' => Input::get('drink_cont_alcoh'),
                        'total_1only' => Input::get('total_1only'),
                        'howmany_drinks' => Input::get('howmany_drinks'),
                        'drink_often' => Input::get('drink_often'),
                        'cant_stop_drink' => Input::get('cant_stop_drink'),
                        'failed_todo_normal' => Input::get('failed_todo_normal'),
                        'first_drink_morning' => Input::get('first_drink_morning'),
                        'remorse_after_drink' => Input::get('remorse_after_drink'),
                        'cant_remember' => Input::get('cant_remember'),
                        'injure_someone' => Input::get('injure_someone'),
                        'concern_about_drink' => Input::get('concern_about_drink'),
                        'overall_total_never' => Input::get('overall_total_never'),
                        'overtotal' => Input::get('overtotal'),
                        'covid19' => Input::get('covid19'),
                        'vaccine_covid19' => Input::get('vaccine_covid19'),
                        'treated_tb' => Input::get('treated_tb'),
                        'date_treated_tb' => Input::get('date_treated_tb'),
                        'month_treated_tb' => Input::get('month_treated_tb'),
                        'risk_factors_complete' => Input::get('risk_factors_complete'),
                        'risk_factors_complete_date' => Input::get('risk_factors_complete_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $risk_factors[0]['id']);
                    $successMessage = 'Risk Factors  Successful Updated';
                } else {
                    $user->createRecord('risk_factors', array(
                        'sequence' => 1,
                        'pid' => $_GET['study_id'],
                        'study_id' => $_GET['study_id'],
                        'visit_code' => 'EV',
                        'visit_date' => Input::get('visit_date'),
                        'smoke_stat' => Input::get('smoke_stat'),
                        'smoking_yes' => $smoking_yes,
                        'duration_smokeless' => Input::get('duration_smokeless'),
                        'frequence_smokeless' => Input::get('frequence_smokeless'),
                        'quantity_smokeless' => Input::get('quantity_smokeless'),
                        'duration_smoking' => Input::get('duration_smoking'),
                        'frequence_smoking' => Input::get('frequence_smoking'),
                        'quantity_smoking' => Input::get('quantity_smoking'),
                        'duration_ecigarette' => Input::get('duration_ecigarette'),
                        'frequence_ecigarette' => Input::get('frequence_ecigarette'),
                        'quantity_ecigarette' => Input::get('quantity_ecigarette'),
                        'other_tobacco' => Input::get('other_tobacco'),
                        'duration_other' => Input::get('duration_other'),
                        'frequence_other' => Input::get('frequence_other'),
                        'quantity_other' => Input::get('quantity_other'),
                        'physically_active' => Input::get('physically_active'),
                        'activity_grade' => Input::get('activity_grade'),
                        'alcohol' => Input::get('alcohol'),
                        'drink_cont_alcoh' => Input::get('drink_cont_alcoh'),
                        'total_1only' => Input::get('total_1only'),
                        'howmany_drinks' => Input::get('howmany_drinks'),
                        'drink_often' => Input::get('drink_often'),
                        'cant_stop_drink' => Input::get('cant_stop_drink'),
                        'failed_todo_normal' => Input::get('failed_todo_normal'),
                        'first_drink_morning' => Input::get('first_drink_morning'),
                        'remorse_after_drink' => Input::get('remorse_after_drink'),
                        'cant_remember' => Input::get('cant_remember'),
                        'injure_someone' => Input::get('injure_someone'),
                        'concern_about_drink' => Input::get('concern_about_drink'),
                        'overall_total_never' => Input::get('overall_total_never'),
                        'overtotal' => Input::get('overtotal'),
                        'covid19' => Input::get('covid19'),
                        'vaccine_covid19' => Input::get('vaccine_covid19'),
                        'treated_tb' => Input::get('treated_tb'),
                        'date_treated_tb' => Input::get('date_treated_tb'),
                        'month_treated_tb' => Input::get('month_treated_tb'),
                        'risk_factors_complete' => Input::get('risk_factors_complete'),
                        'risk_factors_complete_date' => Input::get('risk_factors_complete_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id,
                    ));

                    $user->updateRecord('clients', array(
                        'enrolled' => 1,
                    ), $_GET['cid']);

                    $successMessage = 'Risk Factors  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_medications')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $medications = $override->get3('medications', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($medications) {
                    $user->updateRecord('medications', array(
                        'visit_date' => Input::get('visit_date'),
                        'illness' => Input::get('illness'),
                        'illness_specify' => Input::get('illness_specify'),
                        'sick' => Input::get('sick'),
                        'sick_specify' => Input::get('sick_specify'),
                        'medicines' => Input::get('medicines'),
                        'medicines_specify' => Input::get('medicines_specify'),
                        'medicines_years' => Input::get('medicines_years'),
                        'medicines_months' => Input::get('medicines_months'),
                        'medicines_days' => Input::get('medicines_days'),
                        'medication_complete_date' => Input::get('medication_complete_date'),
                        'medications_complete' => Input::get('medications_complete'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $medications[0]['id']);
                    $successMessage = 'Medications  Successful Updated';
                } else {
                    $user->createRecord('medications', array(
                        'sequence' => 1,
                        'visit_code' => 'EV',
                        'study_id' => $_GET['study_id'],
                        'pid' => $_GET['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'illness' => Input::get('illness'),
                        'illness_specify' => Input::get('illness_specify'),
                        'sick' => Input::get('sick'),
                        'sick_specify' => Input::get('sick_specify'),
                        'medicines' => Input::get('medicines'),
                        'medicines_specify' => Input::get('medicines_specify'),
                        'medicines_years' => Input::get('medicines_years'),
                        'medicines_months' => Input::get('medicines_months'),
                        'medicines_days' => Input::get('medicines_days'),
                        'medication_complete_date' => Input::get('medication_complete_date'),
                        'medications_complete' => Input::get('medications_complete'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id,
                    ));

                    $successMessage = 'Medications  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_chronic_illnesses')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $chronic_illnesses = $override->get3('chronic_illnesses', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($chronic_illnesses) {
                    $user->updateRecord('chronic_illnesses', array(
                        'visit_date' => Input::get('visit_date'),
                        'ncd_screening' => Input::get('ncd_screening'),
                        'chronic_illness_type' => Input::get('chronic_illness_type'),
                        'start_date_chronic' => Input::get('start_date_chronic'),
                        'chronic_illnesses_specify_complete' => Input::get('chronic_illnesses_specify_complete'),
                        'chronic_illnesses_specify_complete_date' => Input::get('chronic_illnesses_specify_complete_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $chronic_illnesses[0]['id']);
                    $successMessage = 'Chronic Illnesses  Successful Updated';
                } else {
                    $user->createRecord('chronic_illnesses', array(
                        'sequence' => 1,
                        'visit_code' => 'EV',
                        'study_id' => $_GET['study_id'],
                        'pid' => $_GET['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'ncd_screening' => Input::get('ncd_screening'),
                        'chronic_illness_type' => Input::get('chronic_illness_type'),
                        'start_date_chronic' => Input::get('start_date_chronic'),
                        'chronic_illnesses_specify_complete' => Input::get('chronic_illnesses_specify_complete'),
                        'chronic_illnesses_specify_complete_date' => Input::get('chronic_illnesses_specify_complete_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id,
                    ));


                    $successMessage = 'Chronic Illnesses  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_laboratory_results')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'hema_done' => array(
                    'required' => true,
                ),
                'biochem_done' => array(
                    'required' => true,
                ),
                'urine_done' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $laboratory_results = $override->get3('laboratory_results', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($laboratory_results) {
                    $user->updateRecord('laboratory_results', array(
                        'hema_done' => Input::get('hema_done'),
                        'lab_date_hema' => Input::get('lab_date_hema'),
                        'lab_time_hema' => Input::get('lab_time_hema'),
                        'hemo' => Input::get('hemo'),
                        'hemo_type' => Input::get('hemo_type'),
                        'wbc' => Input::get('wbc'),
                        'wbc_type' => Input::get('wbc_type'),
                        'lymph' => Input::get('lymph'),
                        'neutro_count' => Input::get('neutro_count'),
                        'hematocrit' => Input::get('hematocrit'),
                        'platelettes' => Input::get('platelettes'),
                        'platelets_type' => Input::get('platelets_type'),
                        'biochem_done' => Input::get('biochem_done'),
                        'lab_date_bio' => Input::get('lab_date_bio'),
                        'lab_time_bio' => Input::get('lab_time_bio'),
                        'bun' => Input::get('bun'),
                        'bun_type' => Input::get('bun_type'),
                        'creat' => Input::get('creat'),
                        'creat_type' => Input::get('creat_type'),
                        'sodium' => Input::get('sodium'),
                        'sod_type' => Input::get('sod_type'),
                        'potass' => Input::get('potass'),
                        'potas_type' => Input::get('potas_type'),
                        'tot_choles' => Input::get('tot_choles'),
                        'trigly' => Input::get('trigly'),
                        'hdl' => Input::get('hdl'),
                        'ldl' => Input::get('ldl'),
                        'vldl' => Input::get('vldl'),
                        'coronary_risk' => Input::get('coronary_risk'),
                        'urine_done' => Input::get('urine_done'),
                        'lab_date_bio_2' => Input::get('lab_date_bio_2'),
                        'lab_time_bio_2' => Input::get('lab_time_bio_2'),
                        'color' => Input::get('color'),
                        'appearance' => Input::get('appearance'),
                        'labs_glucose' => Input::get('labs_glucose'),
                        'bilirubin' => Input::get('bilirubin'),
                        'ketone' => Input::get('ketone'),
                        'spec_grav' => Input::get('spec_grav'),
                        'urine_blood' => Input::get('urine_blood'),
                        'urine_ph' => Input::get('urine_ph'),
                        'urine_protein' => Input::get('urine_protein'),
                        'urobilonogen' => Input::get('urobilonogen'),
                        'nitrite' => Input::get('nitrite'),
                        'leukocytes' => Input::get('leukocytes'),
                        'laboratory_results_complete' => Input::get('laboratory_results_complete'),
                        'laboratory_results_complete_date' => Input::get('laboratory_results_complete_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $laboratory_results[0]['id']);
                    $successMessage = 'Laboratory Results  Successful Updated';
                } else {
                    $user->createRecord('laboratory_results', array(
                        'sequence' => 1,
                        'visit_code' => 'EV',
                        'study_id' => $_GET['study_id'],
                        'pid' => $_GET['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'hema_done' => Input::get('hema_done'),
                        'lab_date_hema' => Input::get('lab_date_hema'),
                        'lab_time_hema' => Input::get('lab_time_hema'),
                        'hemo' => Input::get('hemo'),
                        'hemo_type' => Input::get('hemo_type'),
                        'wbc' => Input::get('wbc'),
                        'wbc_type' => Input::get('wbc_type'),
                        'lymph' => Input::get('lymph'),
                        'neutro_count' => Input::get('neutro_count'),
                        'hematocrit' => Input::get('hematocrit'),
                        'platelettes' => Input::get('platelettes'),
                        'platelets_type' => Input::get('platelets_type'),
                        'biochem_done' => Input::get('biochem_done'),
                        'lab_date_bio' => Input::get('lab_date_bio'),
                        'lab_time_bio' => Input::get('lab_time_bio'),
                        'bun' => Input::get('bun'),
                        'bun_type' => Input::get('bun_type'),
                        'creat' => Input::get('creat'),
                        'creat_type' => Input::get('creat_type'),
                        'sodium' => Input::get('sodium'),
                        'sod_type' => Input::get('sod_type'),
                        'potass' => Input::get('potass'),
                        'potas_type' => Input::get('potas_type'),
                        'tot_choles' => Input::get('tot_choles'),
                        'trigly' => Input::get('trigly'),
                        'hdl' => Input::get('hdl'),
                        'ldl' => Input::get('ldl'),
                        'vldl' => Input::get('vldl'),
                        'coronary_risk' => Input::get('coronary_risk'),
                        'urine_done' => Input::get('urine_done'),
                        'lab_date_bio_2' => Input::get('lab_date_bio_2'),
                        'lab_time_bio_2' => Input::get('lab_time_bio_2'),
                        'color' => Input::get('color'),
                        'appearance' => Input::get('appearance'),
                        'labs_glucose' => Input::get('labs_glucose'),
                        'bilirubin' => Input::get('bilirubin'),
                        'ketone' => Input::get('ketone'),
                        'spec_grav' => Input::get('spec_grav'),
                        'urine_blood' => Input::get('urine_blood'),
                        'urine_ph' => Input::get('urine_ph'),
                        'urine_protein' => Input::get('urine_protein'),
                        'urobilonogen' => Input::get('urobilonogen'),
                        'nitrite' => Input::get('nitrite'),
                        'leukocytes' => Input::get('leukocytes'),
                        'laboratory_results_complete' => Input::get('laboratory_results_complete'),
                        'laboratory_results_complete_date' => Input::get('laboratory_results_complete_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id,
                    ));
                    $successMessage = 'Laboratory Results  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg= ' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_radiological_investigations')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'ecg' => array(
                    'required' => true,
                ),
                'echocardiogram' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $radiological_investigations = $override->get3('radiological_investigations', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', 1);

                if ($radiological_investigations) {
                    $user->updateRecord('radiological_investigations', array(
                        'visit_date' => Input::get('visit_date'),
                        'ecg' => Input::get('ecg'),
                        'ecg_date' => Input::get('ecg_date'),
                        'quality_ecg' => Input::get('quality_ecg'),
                        'heart_rate_ecg' => Input::get('heart_rate_ecg'),
                        'qualitative_ecg' => Input::get('qualitative_ecg'),
                        'regularity_ecg' => Input::get('regularity_ecg'),
                        'heart_rythm_ecg' => Input::get('heart_rythm_ecg'),
                        'other_heart_rhythm_ecg' => Input::get('other_heart_rhythm_ecg'),
                        'qrs_axis_state_ecg' => Input::get('qrs_axis_state_ecg'),
                        'qrs_axis_no_ecg' => Input::get('qrs_axis_no_ecg'),
                        'pr_interval_ecg' => Input::get('pr_interval_ecg'),
                        'pr_inter_specify_ecg' => Input::get('pr_inter_specify_ecg'),
                        'qtc_interval_ecg' => Input::get('qtc_interval_ecg'),
                        'qtc_inter_specify_ecg' => Input::get('qtc_inter_specify_ecg'),
                        'abnormal_waves_ecg' => Input::get('abnormal_waves_ecg'),
                        'repolarizatn_abno_ecg' => Input::get('repolarizatn_abno_ecg'),
                        'conclusion_ecg' => Input::get('conclusion_ecg'),
                        'abno_o_borderl_specify' => Input::get('abno_o_borderl_specify'),
                        'echocardiogram' => Input::get('echocardiogram'),
                        'quality_of_image_echo' => Input::get('quality_of_image_echo'),
                        'brief_exp_subopt_echo' => Input::get('brief_exp_subopt_echo'),
                        'situs_echo' => Input::get('situs_echo'),
                        'cardiac_axis_echo' => Input::get('cardiac_axis_echo'),
                        'syst_vein_connect_echo' => Input::get('syst_vein_connect_echo'),
                        'specify_ab_sysvein_con' => Input::get('specify_ab_sysvein_con'),
                        'pulmo_ven_conn_echo' => Input::get('pulmo_ven_conn_echo'),
                        'specfy_ab_pulven_con' => Input::get('specfy_ab_pulven_con'),
                        'atrioven_connec' => Input::get('atrioven_connec'),
                        'ventricular_loop' => Input::get('ventricular_loop'),
                        'ventriculoart_conn' => Input::get('ventriculoart_conn'),
                        'arrange_grt_arteries' => Input::get('arrange_grt_arteries'),
                        'structural_lesions' => Input::get('structural_lesions'),
                        'state_struc_lession' => Input::get('state_struc_lession'),
                        'size' => Input::get('size'),
                        'site_struc_lesion' => Input::get('site_struc_lesion'),
                        'hemodynamics_stru_lesio' => Input::get('hemodynamics_stru_lesio'),

                        'aortic_valve' => Input::get('aortic_valve'),
                        'mitral_vavlve' => Input::get('mitral_vavlve'),
                        'tricuspid_valve' => Input::get('tricuspid_valve'),
                        'pericardial_effusion' => Input::get('pericardial_effusion'),
                        'measure_deep_pool' => Input::get('measure_deep_pool'),
                        'left_atrium' => Input::get('left_atrium'),
                        'lf_atriu_parasternal' => Input::get('lf_atriu_parasternal'),
                        'lf_atrium_4chamb_long' => Input::get('lf_atrium_4chamb_long'),
                        'lf_atrium_4chamb_minor' => Input::get('lf_atrium_4chamb_minor'),
                        'right_atrium' => Input::get('right_atrium'),
                        'rt_4chamb_long' => Input::get('rt_4chamb_long'),
                        'rt_4chamb_transverse' => Input::get('rt_4chamb_transverse'),
                        'left_ventrical_mmode' => Input::get('left_ventrical_mmode'),
                        'free_wall_thickness' => Input::get('free_wall_thickness'),
                        'septal_thickness' => Input::get('septal_thickness'),
                        'free_wall_thickness_2' => Input::get('free_wall_thickness_2'),
                        'lt_2d_plax_view' => Input::get('lt_2d_plax_view'),
                        'd_freewall_thick_plax' => Input::get('d_freewall_thick_plax'),
                        'd_septal_thick_plax' => Input::get('d_septal_thick_plax'),
                        'd_freewall_thick_plax2' => Input::get('d_freewall_thick_plax2'),
                        'right_ven_chamber' => Input::get('right_ven_chamber'),
                        'rvot_plax_dia' => Input::get('rvot_plax_dia'),
                        'rvot_prox_dia' => Input::get('rvot_prox_dia'),
                        'rvot_distal_dia' => Input::get('rvot_distal_dia'),
                        'rv_wall_thickness' => Input::get('rv_wall_thickness'),
                        'lv_sys_func' => Input::get('lv_sys_func'),
                        'ef_echo' => Input::get('ef_echo'),
                        'fs_echo' => Input::get('fs_echo'),
                        'rv_sys_func' => Input::get('rv_sys_func'),
                        'tapse_echo' => Input::get('tapse_echo'),
                        'esti_rv_sbp' => Input::get('esti_rv_sbp'),
                        'estimate_rv_sbp' => Input::get('estimate_rv_sbp'),
                        'ivc_dimen_n_collapsi' => Input::get('ivc_dimen_n_collapsi'),
                        'inferior_venacava' => Input::get('inferior_venacava'),
                        'quali_asses_valvar_regurgi' => Input::get('quali_asses_valvar_regurgi'),
                        'cardiac_anatomy' => Input::get('cardiac_anatomy'),
                        'abnorm_cardiac_anatom' => Input::get('abnorm_cardiac_anatom'),
                        'cardiac_function' => Input::get('cardiac_function'),
                        'abnorm_cardia_func' => Input::get('abnorm_cardia_func'),
                        'renal_ultrasound' => Input::get('renal_ultrasound'),
                        'quality_renal' => Input::get('quality_renal'),
                        'rt_kidney_length' => Input::get('rt_kidney_length'),
                        'rt_kidney_width' => Input::get('rt_kidney_width'),
                        'rt_kidney_echoge' => Input::get('rt_kidney_echoge'),
                        'lt_kidney_length' => Input::get('lt_kidney_length'),
                        'lt_kidney_width' => Input::get('lt_kidney_width'),
                        'lt_kidney_echoge' => Input::get('lt_kidney_echoge'),
                        'hydronephrosis' => Input::get('hydronephrosis'),
                        'yes_hydronephrosis' => Input::get('yes_hydronephrosis'),
                        'kidney_stones' => Input::get('kidney_stones'),
                        'detail_kidneystones' => Input::get('detail_kidneystones'),
                        'structural_anomalies' => Input::get('structural_anomalies'),
                        'details_structural_anomali' => Input::get('details_structural_anomali'),
                        'comment_bladders' => Input::get('comment_bladders'),
                        'incidental_findings' => Input::get('incidental_findings'),
                        'conclusion_renal' => Input::get('conclusion_renal'),
                        'abnor_o_border_renal' => Input::get('abnor_o_border_renal'),
                        'radiological_investigations_complete' => Input::get('radiological_investigations_complete'),
                        'radiological_investigations_complete_date' => Input::get('radiological_investigations_complete_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $radiological_investigations[0]['id']);

                    $successMessage = 'Radiological Investigations  Successful Updated';
                } else {
                    $user->createRecord('radiological_investigations', array(
                        'sequence' => 1,
                        'visit_code' => 'EV',
                        'study_id' => $_GET['study_id'],
                        'pid' => $_GET['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'ecg' => Input::get('ecg'),
                        'ecg_date' => Input::get('ecg_date'),
                        'quality_ecg' => Input::get('quality_ecg'),
                        'heart_rate_ecg' => Input::get('heart_rate_ecg'),
                        'qualitative_ecg' => Input::get('qualitative_ecg'),
                        'regularity_ecg' => Input::get('regularity_ecg'),
                        'heart_rythm_ecg' => Input::get('heart_rythm_ecg'),
                        'other_heart_rhythm_ecg' => Input::get('other_heart_rhythm_ecg'),
                        'qrs_axis_state_ecg' => Input::get('qrs_axis_state_ecg'),
                        'qrs_axis_no_ecg' => Input::get('qrs_axis_no_ecg'),
                        'pr_interval_ecg' => Input::get('pr_interval_ecg'),
                        'pr_inter_specify_ecg' => Input::get('pr_inter_specify_ecg'),
                        'qtc_interval_ecg' => Input::get('qtc_interval_ecg'),
                        'qtc_inter_specify_ecg' => Input::get('qtc_inter_specify_ecg'),
                        'abnormal_waves_ecg' => Input::get('abnormal_waves_ecg'),
                        'repolarizatn_abno_ecg' => Input::get('repolarizatn_abno_ecg'),
                        'conclusion_ecg' => Input::get('conclusion_ecg'),
                        'abno_o_borderl_specify' => Input::get('abno_o_borderl_specify'),
                        'echocardiogram' => Input::get('echocardiogram'),
                        'quality_of_image_echo' => Input::get('quality_of_image_echo'),
                        'brief_exp_subopt_echo' => Input::get('brief_exp_subopt_echo'),
                        'situs_echo' => Input::get('situs_echo'),
                        'cardiac_axis_echo' => Input::get('cardiac_axis_echo'),
                        'syst_vein_connect_echo' => Input::get('syst_vein_connect_echo'),
                        'specify_ab_sysvein_con' => Input::get('specify_ab_sysvein_con'),
                        'pulmo_ven_conn_echo' => Input::get('pulmo_ven_conn_echo'),
                        'specfy_ab_pulven_con' => Input::get('specfy_ab_pulven_con'),
                        'atrioven_connec' => Input::get('atrioven_connec'),
                        'ventricular_loop' => Input::get('ventricular_loop'),
                        'ventriculoart_conn' => Input::get('ventriculoart_conn'),
                        'arrange_grt_arteries' => Input::get('arrange_grt_arteries'),
                        'structural_lesions' => Input::get('structural_lesions'),
                        'state_struc_lession' => Input::get('state_struc_lession'),
                        'size' => Input::get('size'),
                        'site_struc_lesion' => Input::get('site_struc_lesion'),
                        'hemodynamics_stru_lesio' => Input::get('hemodynamics_stru_lesio'),

                        'aortic_valve' => Input::get('aortic_valve'),
                        'mitral_vavlve' => Input::get('mitral_vavlve'),
                        'tricuspid_valve' => Input::get('tricuspid_valve'),
                        'pericardial_effusion' => Input::get('pericardial_effusion'),
                        'measure_deep_pool' => Input::get('measure_deep_pool'),
                        'left_atrium' => Input::get('left_atrium'),
                        'lf_atriu_parasternal' => Input::get('lf_atriu_parasternal'),
                        'lf_atrium_4chamb_long' => Input::get('lf_atrium_4chamb_long'),
                        'lf_atrium_4chamb_minor' => Input::get('lf_atrium_4chamb_minor'),
                        'right_atrium' => Input::get('right_atrium'),
                        'rt_4chamb_long' => Input::get('rt_4chamb_long'),
                        'rt_4chamb_transverse' => Input::get('rt_4chamb_transverse'),
                        'left_ventrical_mmode' => Input::get('left_ventrical_mmode'),
                        'free_wall_thickness' => Input::get('free_wall_thickness'),
                        'septal_thickness' => Input::get('septal_thickness'),
                        'free_wall_thickness_2' => Input::get('free_wall_thickness_2'),
                        'lt_2d_plax_view' => Input::get('lt_2d_plax_view'),
                        'd_freewall_thick_plax' => Input::get('d_freewall_thick_plax'),
                        'd_septal_thick_plax' => Input::get('d_septal_thick_plax'),
                        'd_freewall_thick_plax2' => Input::get('d_freewall_thick_plax2'),
                        'right_ven_chamber' => Input::get('right_ven_chamber'),
                        'rvot_plax_dia' => Input::get('rvot_plax_dia'),
                        'rvot_prox_dia' => Input::get('rvot_prox_dia'),
                        'rvot_distal_dia' => Input::get('rvot_distal_dia'),
                        'rv_wall_thickness' => Input::get('rv_wall_thickness'),
                        'lv_sys_func' => Input::get('lv_sys_func'),
                        'ef_echo' => Input::get('ef_echo'),
                        'fs_echo' => Input::get('fs_echo'),
                        'rv_sys_func' => Input::get('rv_sys_func'),
                        'tapse_echo' => Input::get('tapse_echo'),
                        'esti_rv_sbp' => Input::get('esti_rv_sbp'),
                        'estimate_rv_sbp' => Input::get('estimate_rv_sbp'),
                        'ivc_dimen_n_collapsi' => Input::get('ivc_dimen_n_collapsi'),
                        'inferior_venacava' => Input::get('inferior_venacava'),
                        'quali_asses_valvar_regurgi' => Input::get('quali_asses_valvar_regurgi'),
                        'cardiac_anatomy' => Input::get('cardiac_anatomy'),
                        'abnorm_cardiac_anatom' => Input::get('abnorm_cardiac_anatom'),
                        'cardiac_function' => Input::get('cardiac_function'),
                        'abnorm_cardia_func' => Input::get('abnorm_cardia_func'),
                        'renal_ultrasound' => Input::get('renal_ultrasound'),
                        'quality_renal' => Input::get('quality_renal'),
                        'rt_kidney_length' => Input::get('rt_kidney_length'),
                        'rt_kidney_width' => Input::get('rt_kidney_width'),
                        'rt_kidney_echoge' => Input::get('rt_kidney_echoge'),
                        'lt_kidney_length' => Input::get('lt_kidney_length'),
                        'lt_kidney_width' => Input::get('lt_kidney_width'),
                        'lt_kidney_echoge' => Input::get('lt_kidney_echoge'),
                        'hydronephrosis' => Input::get('hydronephrosis'),
                        'yes_hydronephrosis' => Input::get('yes_hydronephrosis'),
                        'kidney_stones' => Input::get('kidney_stones'),
                        'detail_kidneystones' => Input::get('detail_kidneystones'),
                        'structural_anomalies' => Input::get('structural_anomalies'),
                        'details_structural_anomali' => Input::get('details_structural_anomali'),
                        'comment_bladders' => Input::get('comment_bladders'),
                        'incidental_findings' => Input::get('incidental_findings'),
                        'conclusion_renal' => Input::get('conclusion_renal'),
                        'abnor_o_border_renal' => Input::get('abnor_o_border_renal'),
                        'radiological_investigations_complete' => Input::get('radiological_investigations_complete'),
                        'radiological_investigations_complete_date' => Input::get('radiological_investigations_complete_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site' => $user->data()->site_id,
                    ));
                    $successMessage = 'Radiological Investigations  Successful Added';
                }
                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status'] . '&msg=' . $successMessage);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_region')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $regions = $override->get('regions', 'id', $_GET['region_id']);
                    if ($regions) {
                        $user->updateRecord('regions', array(
                            'name' => Input::get('name'),
                        ), $_GET['region_id']);
                        $successMessage = 'Region Successful Updated';
                    } else {
                        $user->createRecord('regions', array(
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Region Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('delete_region')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('regions', array(
                        'status' => 0,
                    ), Input::get('id'));
                    $successMessage = 'Region Successful Deeleted';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('restore_region')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('regions', array(
                        'status' => 1,
                    ), Input::get('id'));
                    $successMessage = 'Region Successful Restored';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_district')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $districts = $override->get('districts', 'id', $_GET['district_id']);
                    if ($districts) {
                        $user->updateRecord('districts', array(
                            'region_id' => $_GET['region_id'],
                            'name' => Input::get('name'),
                        ), $_GET['district_id']);
                        $successMessage = 'District Successful Updated';
                    } else {
                        $user->createRecord('districts', array(
                            'region_id' => Input::get('region_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'District Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('delete_district')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('districts', array(
                        'status' => 0,
                    ), Input::get('id'));
                    $successMessage = 'district Successful Deeleted';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('restore_district')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('districts', array(
                        'status' => 1,
                    ), Input::get('id'));
                    $successMessage = 'District Successful Deeleted';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_ward')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'district_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $wards = $override->get('wards', 'id', $_GET['ward_id']);
                    if ($wards) {
                        $user->updateRecord('wards', array(
                            'region_id' => $_GET['region_id'],
                            'district_id' => $_GET['district_id'],
                            'name' => Input::get('name'),
                        ), $_GET['ward_id']);
                        $successMessage = 'Ward Successful Updated';
                    } else {
                        $user->createRecord('wards', array(
                            'region_id' => Input::get('region_id'),
                            'district_id' => Input::get('district_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Ward Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('delete_ward')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('wards', array(
                        'status' => 0,
                    ), Input::get('id'));
                    $successMessage = 'Ward Successful Deeleted';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('restore_ward')) {
            $validate = $validate->check($_POST, array());
            if ($validate->passed()) {
                try {
                    $user->updateRecord('wards', array(
                        'status' => 1,
                    ), Input::get('id'));
                    $successMessage = 'ward Successful Deeleted';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
    }
} else {
    Redirect::to('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mack Database | Add Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        #medication_table {
            border-collapse: collapse;
        }

        #medication_table th,
        #medication_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #medication_table {
            border-collapse: collapse;
        }

        #medication_list th,
        #medication_list td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_list th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .remove-row {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .remove-row:hover {
            background-color: #da190b;
        }

        .edit-row {
            background-color: #3FF22F;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .edit-row:hover {
            background-color: #da190b;
        }

        #hospitalization_details_table {
            border-collapse: collapse;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #sickle_cell_table {
            border-collapse: collapse;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .hidden {
            display: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= $errorMessage ?>
            </div>
        <?php } elseif ($pageError) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?php foreach ($pageError as $error) {
                    echo $error . ' , ';
                } ?>
            </div>
        <?php } elseif ($successMessage) { ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $successMessage ?>
            </div>
        <?php } ?>

        <?php if ($_GET['id'] == 1 && ($user->data()->position == 1 || $user->data()->position == 2)) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Staff</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            < Back </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            Go to staff list >
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Staff</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id'])[0];
                            $site = $override->get('sites', 'id', $staff['site_id'])[0];
                            $position = $override->get('position', 'id', $staff['position'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" value="<?php if ($staff['firstname']) {
                                                                                                                                                print_r($staff['firstname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" value="<?php if ($staff['middlename']) {
                                                                                                                                                    print_r($staff['middlename']);
                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" value="<?php if ($staff['lastname']) {
                                                                                                                                                print_r($staff['lastname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>User Name</label>
                                                            <input class="form-control" type="text" name="username" id="username" value="<?php if ($staff['username']) {
                                                                                                                                                print_r($staff['username']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Contacts</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number" id="phone_number" value="<?php if ($staff['phone_number']) {
                                                                                                                                                                                                            print_r($staff['phone_number']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number 2</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number2" id="phone_number2" value="<?php if ($staff['phone_number2']) {
                                                                                                                                                                                                            print_r($staff['phone_number2']);
                                                                                                                                                                                                        }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>E-mail Address</label>
                                                            <input class="form-control" type="email" name="email_address" id="email_address" value="<?php if ($staff['email_address']) {
                                                                                                                                                        print_r($staff['email_address']);
                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>SEX</label>
                                                            <select class="form-control" name="sex" style="width: 100%;" required>
                                                                <option value="<?= $staff['sex'] ?>"><?php if ($staff['sex']) {
                                                                                                            if ($staff['sex'] == 1) {
                                                                                                                echo 'Male';
                                                                                                            } elseif ($staff['sex'] == 2) {
                                                                                                                echo 'Female';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?></option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Location And Access Levels</h3>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Site</label>
                                                            <select class="form-control" name="site_id" style="width: 100%;" required>
                                                                <option value="<?= $site['id'] ?>"><?php if ($staff['site_id']) {
                                                                                                        print_r($site['name']);
                                                                                                    } else {
                                                                                                        echo 'Select';
                                                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->get('sites', 'status', 1) as $site) { ?>
                                                                    <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Position</label>
                                                            <select class="form-control" name="position" style="width: 100%;" required>
                                                                <option value="<?= $position['id'] ?>"><?php if ($staff['position']) {
                                                                                                            print_r($position['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('position', 'status', 1) as $position) { ?>
                                                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Access Level</label>
                                                            <input class="form-control" type="number" min="0" max="3" name="accessLevel" id="accessLevel" value="<?php if ($staff['accessLevel']) {
                                                                                                                                                                        print_r($staff['accessLevel']);
                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Power</label>
                                                            <input class="form-control" type="number" min="0" max="2" name="power" id="power" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=1" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_user" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 2) { ?>
        <?php } elseif ($_GET['id'] == 3) { ?>
        <?php } elseif ($_GET['id'] == 4) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Client</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=3&&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            <?php if ($_GET['status'] == 1) { ?>
                                                Go to screening list >
                                            <?php } elseif ($_GET['status'] == 2) { ?>
                                                Go to eligible list >
                                            <?php } elseif ($_GET['status'] == 3) { ?>
                                                Go to enrollment list >
                                            <?php } elseif ($_GET['status'] == 4) { ?>
                                                Go to terminated / end study list >
                                            <?php } elseif ($_GET['status'] == 5) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 6) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 7) { ?>
                                                Go to registered list >
                                            <?php } ?>
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Client</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                            $region = $override->get('regions', 'id', $clients['region'])[0];
                            $district = $override->get('districts', 'id', $clients['district'])[0];
                            $ward = $override->get('wards', 'id', $clients['sub_county'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="clients" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of visit:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="date_of_visit" id="date_of_visit" value="<?php if ($clients['date_of_visit']) {
                                                                                                                                                                                    print_r($clients['date_of_visit']);
                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-sm-3">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <label>First Name</label>
                                                                <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Type firstname..." onkeyup="fetchData()" value="<?php if ($clients['firstname']) {
                                                                                                                                                                                                            print_r($clients['firstname']);
                                                                                                                                                                                                        }  ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <label>Middle Name</label>
                                                                <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Type middlename..." onkeyup="fetchData()" value="<?php if ($clients['middlename']) {
                                                                                                                                                                                                            print_r($clients['middlename']);
                                                                                                                                                                                                        }  ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <label>Last Name</label>
                                                                <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['lastname']) {
                                                                                                                                                                                                        print_r($clients['lastname']);
                                                                                                                                                                                                    }  ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of birth:</label>
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="date_of_birth" id="date_of_birth" style="width: 100%;" value="<?php if ($clients['date_of_birth']) {
                                                                                                                                                                                                        print_r($clients['date_of_birth']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input class="form-control" type="number" value="<?php if ($clients['age']) {
                                                                                                                    print_r($clients['age']);
                                                                                                                }  ?>" readonly />
                                                        </div>
                                                    </div>
                                                </div> -->

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input class="form-control" type="number" name="age" id="age" min="0" value="<?php if ($clients['age']) {
                                                                                                                                                print_r($clients['age']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>ART No ( CTC ID )</label>
                                                            <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="art_no" id="art_no" placeholder="Type art_ no..." value="<?php if ($clients['art_no']) {
                                                                                                                                                                                                                                        print_r($clients['art_no']);
                                                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <label>Gender</label>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gender" id="gender1" value="1" <?php if ($clients['gender'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?> required>
                                                                <label class="form-check-label">Male</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="gender" id="gender2" value="2" <?php if ($clients['gender'] == 2) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>1.2 Phone number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone" id="phone" value="<?php if ($clients['phone']) {
                                                                                                                                                                                            print_r($clients['phone']);
                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Alternative No</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="alternative_no" id="alternative_no" value="<?php if ($clients['alternative_no']) {
                                                                                                                                                                                                                print_r($clients['alternative_no']);
                                                                                                                                                                                                            }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <label>1.1 Did the Participant give informed consent ?</label>
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="informed_consent" id="informed_consent1" value="1" <?php if ($clients['informed_consent'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="informed_consent" id="informed_consent2" value="2" <?php if ($clients['informed_consent'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="date_informed_consent0">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of informed consent:</label>
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="date_informed_consent" id="date_informed_consent" style="width: 100%;" value="<?php if ($clients['date_informed_consent']) {
                                                                                                                                                                                                                        print_r($clients['date_informed_consent']);
                                                                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">1.3 Place of Residence</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-sm-2">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <label>Region</label>
                                                                <select id="region" name="region" class="form-control" required>
                                                                    <option value="<?= $region['id'] ?>">
                                                                        <?php if ($clients['region']) {
                                                                            print_r($region['name']);
                                                                        } else {
                                                                            echo 'Select region';
                                                                        } ?>
                                                                    </option>
                                                                    <?php foreach ($override->get('regions', 'status', 1) as $value) { ?>
                                                                        <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $district['id'] ?>">
                                                                    <?php if ($clients['district']) {
                                                                        print_r($district['name']);
                                                                    } else {
                                                                        echo 'Select district';
                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->get('districts', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward ( Sub-county )</label>
                                                            <select id="sub_county" name="sub_county" class="form-control" required>
                                                                <option value="<?= $ward['id'] ?>">
                                                                    <?php if ($clients['sub_county']) {
                                                                        print_r($ward['name']);
                                                                    } else {
                                                                        echo 'Select ward';
                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->get('wards', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-sm-2">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Residence street ( Village )</label>
                                                                <input class="form-control" type="text" name="village" id="village" value="<?php if ($clients['village']) {
                                                                                                                                                print_r($clients['village']);
                                                                                                                                            }  ?>" required />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>House number, if any</label>
                                                                <input class="form-control" type="text" name="house_number" id="house_number" value="<?php if ($clients['house_number']) {
                                                                                                                                                            print_r($clients['house_number']);
                                                                                                                                                        }  ?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Location:</label>
                                                                <textarea class="form-control" name="location" rows="3" placeholder="Type location here..." required>
                                                                <?php if ($clients['location']) {
                                                                    print_r($clients['location']);
                                                                }  ?>
                                                            </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>


                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Vital Signs </h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>1.4 Weight</label>
                                                            <input class="form-control" type="number" min="0" max="200" name="weight" id="weight" value="<?php if ($clients['weight']) {
                                                                                                                                                                print_r($clients['weight']);
                                                                                                                                                            }  ?>" required />
                                                            <spnan>kgs</spnan>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>1.5 Height</label>
                                                            <input class="form-control" type="number" min="0" max="300" name="height" id="height" value="<?php if ($clients['height']) {
                                                                                                                                                                print_r($clients['height']);
                                                                                                                                                            }  ?>" required />
                                                            <spnan>cm</spnan>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>1.6 Systolic blood Pressure</label>
                                                            <input class="form-control" type="number" min="0" max="900" name="sys_bp" id="sys_bp" value="<?php if ($clients['sys_bp']) {
                                                                                                                                                                print_r($clients['sys_bp']);
                                                                                                                                                            }  ?>" />
                                                            <spnan>mm/Hg</spnan>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>1.7 Diastolic Blood Pressure</label>
                                                            <input class="form-control" type="number" min="0" max="900" name="dias_bp" id="dias_bp" value="<?php if ($clients['dias_bp']) {
                                                                                                                                                                print_r($clients['dias_bp']);
                                                                                                                                                            }  ?>" />
                                                            <spnan>mm/Hg</spnan>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Other Details </h3>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>1.8 What is the highest Education received?</label>
                                                            <?php foreach ($override->get('education', 'status', 1) as $education) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="education" id="education<?= $education['id'] ?>" value="<?= $education['id'] ?>" <?php if ($clients['education'] == $education['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $education['name'] ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-sm-3">
                                                    <label>1.9 What is your Marital Status?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="marital_status" id="marital_status1" value="1" <?php if ($clients['marital_status'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Single</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="marital_status" id="marital_status2" value="2" <?php if ($clients['marital_status'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Married</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="marital_status" id="marital_status3" value="3" <?php if ($clients['marital_status'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Separated</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>1.10 Occupation</label>
                                                            <?php foreach ($override->get('occupation', 'status', 1) as $occupation) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="occupation" id="occupation<?= $occupation['id'] ?>" value="<?= $occupation['id'] ?>" <?php if ($clients['occupation'] == $occupation['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $occupation['name'] ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label id="unskilled1">specify why unskilled:</label>
                                                            <textarea class="form-control" name="unskilled" id="unskilled" rows="3" placeholder="Type reasons here...">
                                                                <?php if ($clients['unskilled']) {
                                                                    print_r($clients['unskilled']);
                                                                }  ?>
                                                            </textarea>
                                                            <label id="profesional_worker1">specify professional worker:</label>
                                                            <textarea class="form-control" name="profesional_worker" id="profesional_worker" rows="3" placeholder="Type other professional worker here...">
                                                                <?php if ($clients['profesional_worker']) {
                                                                    print_r($clients['profesional_worker']);
                                                                }  ?>
                                                            </textarea>
                                                            <label id="other_occupation1">specify other occupation</label>
                                                            <textarea class="form-control" name="other_occupation" id="other_occupation" rows="3" placeholder="Type other here...">
                                                                <?php if ($clients['other_occupation']) {
                                                                    print_r($clients['other_occupation']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>1.11 Participant's religion</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="religion" id="religion1" value="1" <?php if ($clients['religion'] == 1) {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Christian</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="religion" id="religion2" value="2" <?php if ($clients['religion'] == 2) {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Muslim</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="religion" id="religion3" value="3" <?php if ($clients['religion'] == 3) {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Other</label>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <label id="other_religion0">Specify other religion</label>
                                                        <textarea class="form-control" id="other_religion" name="other_religion" rows="3" placeholder="Type other here...">
                                                                <?php if ($clients['other_religion']) {
                                                                    print_r($clients['other_religion']);
                                                                }  ?>
                                                            </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="card card-warning">
                                                            <div class="card-header">
                                                                <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Remarks / Comments:</label>
                                                                <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here...">
                                                                <?php if ($clients['comments']) {
                                                                    print_r($clients['comments']);
                                                                }  ?>
                                                            </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php } ?>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="sociodemographics_complete" name="sociodemographics_complete" class="form-control" required>
                                                                <option value="<?= $clients['sociodemographics_complete'] ?>">
                                                                    <?php if ($clients['sociodemographics_complete']) {
                                                                        if ($clients['sociodemographics_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($clients['sociodemographics_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($clients['sociodemographics_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=3&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_client" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 5) { ?>
            <?php
            $hiv_history_and_medication = $override->getNews('hiv_history_and_medication', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$hiv_history_and_medication) { ?>
                                    <h1>Add New HIV History And Medication</h1>
                                <?php } else { ?>
                                    <h1>Update HIV History And Medication</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$hiv_history_and_medication) { ?>
                                        <li class="breadcrumb-item active">Add New HIV History And Medication</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update HIV History And Medication</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">HIV HISTORY</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="date_diagnosis_hiv" class="form-label">2.1 When were you first diagnosed with HIV?</label>
                                                        <input type="date" value="<?php if ($hiv_history_and_medication['date_diagnosis_hiv']) {
                                                                                        print_r($hiv_history_and_medication['date_diagnosis_hiv']);
                                                                                    } ?>" id="date_diagnosis_hiv" name="date_diagnosis_hiv" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="clinical_stage" class="form-label">2.2 What was you WHO Clinical Stage at ART initiation?</label>
                                                        <select name="clinical_stage" id="clinical_stage" class="form-control" required>
                                                            <option value="<?= $hiv_history_and_medication['clinical_stage'] ?>"><?php if ($hiv_history_and_medication['clinical_stage']) {
                                                                                                                                        if ($hiv_history_and_medication['clinical_stage'] == 1) {
                                                                                                                                            echo 'Stage 1';
                                                                                                                                        } elseif ($hiv_history_and_medication['clinical_stage'] == 2) {
                                                                                                                                            echo 'Stage 2';
                                                                                                                                        } elseif ($hiv_history_and_medication['clinical_stage'] == 3) {
                                                                                                                                            echo 'Stage 3';
                                                                                                                                        } elseif ($hiv_history_and_medication['clinical_stage'] == 4) {
                                                                                                                                            echo 'Stage 4';
                                                                                                                                        }
                                                                                                                                    } else {
                                                                                                                                        echo 'Select';
                                                                                                                                    } ?>
                                                            </option>
                                                            <option value="1">Stage 1</option>
                                                            <option value="2">Stage 2</option>
                                                            <option value="3">Stage 3</option>
                                                            <option value="4">Stage 4</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="viral_load" class="form-label">2.3 What is the most recent Viral load?</label>
                                                        <input type="number" value="<?php if ($hiv_history_and_medication['viral_load']) {
                                                                                        print_r($hiv_history_and_medication['viral_load']);
                                                                                    } ?>" id="viral_load" name="viral_load" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter viral load" required />
                                                        <span>copies/ul</span>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="viral_load_sampledate" class="form-label">2.4 Date samples were taken of:</label>
                                                        <input type="date" value="<?php if ($hiv_history_and_medication['viral_load_sampledate']) {
                                                                                        print_r($hiv_history_and_medication['viral_load_sampledate']);
                                                                                    } ?>" id="viral_load_sampledate" name="viral_load_sampledate" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter viral date" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">3.0 ANTIRETROVIRAL TREATMENT</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="date_art_treatment" class="form-label">3.1 When did you begin taking ART-Treatment?</label>
                                                        <input type="date" value="<?php if ($hiv_history_and_medication['date_art_treatment']) {
                                                                                        print_r($hiv_history_and_medication['date_art_treatment']);
                                                                                    } ?>" id="date_art_treatment" name="date_art_treatment" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date art treatment" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <label>3.2 Which ART regimen was the participant taking?</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen1" value="1" <?php if ($hiv_history_and_medication['art_regimen'] == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">First line</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen2" value="2" <?php if ($hiv_history_and_medication['art_regimen'] == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Second line</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen3" value="3" <?php if ($hiv_history_and_medication['art_regimen'] == 3) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Third line</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen4" value="4" <?php if ($hiv_history_and_medication['art_regimen'] == 4) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Salvage therapy</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_regimen" id="art_regimen5" value="5" <?php if ($hiv_history_and_medication['art_regimen'] == 5) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">other</label>
                                                            </div>
                                                            <button type="button" onclick="unsetRadio('art_regimen')">Unset</button>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="art_regimen_other" id="art_regimen_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($hiv_history_and_medication['art_regimen_other']) {
                                                                print_r($hiv_history_and_medication['art_regimen_other']);
                                                            }  ?>
                                                        </textarea>
                                                </div>

                                                <div class="col-4" id="first_line">
                                                    <label>3.3 What are the specific drugs in the partipant's current regimen?</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line1" value="1" <?php if ($hiv_history_and_medication['first_line'] == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">ABC+3TC+DTG</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line2" value="2" <?php if ($hiv_history_and_medication['first_line'] == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">TDF+3TC+DTG</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line3" value="3" <?php if ($hiv_history_and_medication['first_line'] == 3) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">AZT+3TC+DTG</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line4" value="4" <?php if ($hiv_history_and_medication['first_line'] == 4) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">TDF+FTC+DTG</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line5" value="5" <?php if ($hiv_history_and_medication['first_line'] == 5) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">ABC+3TC+LPV/r</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line6" value="6" <?php if ($hiv_history_and_medication['first_line'] == 6) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">AZT+3TC+LPV/r</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line7" value="7" <?php if ($hiv_history_and_medication['first_line'] == 7) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">AZT+3TC+EFV</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line8" value="8" <?php if ($hiv_history_and_medication['first_line'] == 8) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">ABC+3TC+EFV</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line9" value="9" <?php if ($hiv_history_and_medication['first_line'] == 9) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">TDF+3TC+EFV</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line10" value="10" <?php if ($hiv_history_and_medication['first_line'] == 10) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">AZT+3TC+NVP</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="first_line" id="first_line11" value="11" <?php if ($hiv_history_and_medication['first_line'] == 11) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Other 1st line</label>
                                                            </div>
                                                            <button type="button" onclick="unsetRadio('first_line')">Unset</button>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="other_first_line" id="other_first_line" rows="2" placeholder="Type other here...">
                                                        <?php if ($hiv_history_and_medication['other_first_line']) {
                                                            print_r($hiv_history_and_medication['other_first_line']);
                                                        }  ?>
                                                    </textarea>
                                                </div>

                                                <div class="col-4" id="second_line">
                                                    <label>Second Line</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="second_line" id="second_line1" value="1" <?php if ($hiv_history_and_medication['second_line'] == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">AZT+3TC+LPV/r</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="second_line" id="second_line2" value="2" <?php if ($hiv_history_and_medication['second_line'] == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">ABC+3TC+LPV/r</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="second_line" id="second_line3" value="3" <?php if ($hiv_history_and_medication['second_line'] == 3) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">ABC+3TC+LPV/r</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="second_line" id="second_line4" value="4" <?php if ($hiv_history_and_medication['second_line'] == 4) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">ABC+3TC+ATV/r</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="second_line" id="second_line11" value="5" <?php if ($hiv_history_and_medication['second_line'] == 5) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Other 2nd line</label>
                                                            </div>
                                                            <button type="button" onclick="unsetRadio('second_line')">Unset</button>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="other_second_line" id="other_second_line" rows="2" placeholder="Type other here...">
                                                        <?php if ($hiv_history_and_medication['other_second_line']) {
                                                            print_r($hiv_history_and_medication['other_second_line']);
                                                        }  ?>
                                                    </textarea>
                                                </div>
                                                <div class="col-4" id="third_line">
                                                    <label>Third line</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line1" value="1" <?php if ($hiv_history_and_medication['third_line'] == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">DTG+DRV/r+AZT+3TC</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line2" value="2" <?php if ($hiv_history_and_medication['third_line'] == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">DTG+LPV/r+AZT+3TC</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line3" value="3" <?php if ($hiv_history_and_medication['third_line'] == 3) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">RAL+DRV/r+AZT+3TC</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line4" value="4" <?php if ($hiv_history_and_medication['third_line'] == 4) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">RAL+LPV/r+AZT+3TC</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="third_line" id="third_line5" value="5" <?php if ($hiv_history_and_medication['third_line'] == 5) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Other 3rd line</label>
                                                            </div>
                                                            <button type="button" onclick="unsetRadio('third_line')">Unset</button>
                                                        </div>
                                                    </div>
                                                    <textarea class="form-control" name="other_third_line" id="other_third_line" rows="2" placeholder="Type other here...">
                                                        <?php if ($hiv_history_and_medication['other_third_line']) {
                                                            print_r($hiv_history_and_medication['other_third_line']);
                                                        }  ?>
                                                    </textarea>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-6">
                                                    <label>3.4 Were you given the same Regimen today ?</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="same_regimen" id="same_regimen2" value="1" <?php if ($hiv_history_and_medication['same_regimen'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="same_regimen" id="same_regimen2" value="2" <?php if ($hiv_history_and_medication['same_regimen'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                        <button type="button" onclick="unsetRadio('same_regimen')">Unset</button>
                                                    </div>
                                                    <label class="form-check-label" id="name_regimen0">3.5 If No,Please name the regimen:</label>
                                                    <textarea class="form-control" name="name_regimen" id="name_regimen" rows="2" placeholder="Type here...">
                                                                <?php if ($hiv_history_and_medication['name_regimen']) {
                                                                    print_r($hiv_history_and_medication['name_regimen']);
                                                                }  ?>
                                                            </textarea>
                                                </div>
                                                <div class="col-6">
                                                    <label>3.6 Has the participant been unwell since the last visit?</label>
                                                    <!-- checkbox -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="unwell" id="unwell1" value="1" <?php if ($hiv_history_and_medication['unwell'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="unwell" id="unwell2" value="2" <?php if ($hiv_history_and_medication['unwell'] == 2) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label class="form-check-label" id="what_health_problem0">3.7 If yes, What was the health problem</label>
                                                    <textarea class="form-control" name="what_health_problem" id="what_health_problem" rows="2" placeholder="Type here...">
                                                                <?php if ($hiv_history_and_medication['what_health_problem']) {
                                                                    print_r($hiv_history_and_medication['what_health_problem']);
                                                                }  ?>
                                                            </textarea>
                                                </div>
                                            </div>

                                            <hr>
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <div class="card card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title">ANY COMENT ( REMARKS )</h3>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Remarks / Comments:</label>
                                                                <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($hiv_history_and_medication['comments']) {
                                                                                                                                                                print_r($hiv_history_and_medication['comments']);
                                                                                                                                                            }  ?>
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            <?php } ?>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="hiv_history_and_medication_complete" name="hiv_history_and_medication_complete" class="form-control" required>
                                                                <option value="<?= $hiv_history_and_medication['hiv_history_and_medication_complete'] ?>">
                                                                    <?php if ($hiv_history_and_medication['hiv_history_and_medication_complete']) {
                                                                        if ($hiv_history_and_medication['hiv_history_and_medication_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($hiv_history_and_medication['hiv_history_and_medication_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($hiv_history_and_medication['hiv_history_and_medication_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="hiv_history_and_medication_complete_date" class="form-label">Date Form Completed</label>
                                                            <input type="date" value="<?php if ($hiv_history_and_medication['hiv_history_and_medication_complete_date']) {
                                                                                            print_r($hiv_history_and_medication['hiv_history_and_medication_complete_date']);
                                                                                        } ?>" id="hiv_history_and_medication_complete_date" name="hiv_history_and_medication_complete_date" class="form-control" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_hiv_history_and_medication" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 6) { ?>
            <?php
            $eligibility = $override->getNews('eligibility', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$eligibility) { ?>
                                    <h1>Add New Eligibility Form</h1>
                                <?php } else { ?>
                                    <h1>Update Eligibility Form</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$eligibility) { ?>
                                        <li class="breadcrumb-item active">Add New Eligibility Form</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Eligibility Form</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">INCLUSION CRITERIA (all must be Yes for participant to
                                            be Eligible)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-2">
                                                        <div class="mb-2">
                                                            <label for="visit_date" class="form-label">Visit date</label>
                                                            <input type="date" value="<?php if ($eligibility['visit_date']) {
                                                                                            print_r($eligibility['visit_date']);
                                                                                        } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-sm-2">
                                                    <label>Confirmed and Documented HIV Infection?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="hiv_infection" id="hiv_infection1" value="1" <?php if ($eligibility['hiv_infection'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?> required>
                                                                <label class=" form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="hiv_infection" id="hiv_infection2" value="2" <?php if ($eligibility['hiv_infection'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="currently_smoking">
                                                    <label>Has the Participant been on ART treatment for HIV for
                                                        more than 6months?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_treatment" id="art_treatment1" value="1" <?php if ($eligibility['art_treatment'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="art_treatment" id="art_treatment2" value="2" <?php if ($eligibility['art_treatment'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2" id="currently_smoking">
                                                    <label>Is the Participant aged between 10 - 24?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="participant_age" id="participant_age1" value="1" <?php if ($eligibility['participant_age'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="participant_age" id="participant_age2" value="2" <?php if ($eligibility['participant_age'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="currently_smoking">
                                                    <label>Is the Participant able to understand and willing to sign the
                                                        informed consent document?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="understand_icf" id="understand_icf1" value="1" <?php if ($eligibility['understand_icf'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="understand_icf" id="understand_icf2" value="2" <?php if ($eligibility['understand_icf'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">EXCLUSION CRITERIA (All must be NO for participant to
                                                        be eligible)</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="currently_smoking">
                                                    <label>Is the participant already enrolled in another study that
                                                        may interfere with the study outcome</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="another_study" id="another_study1" value="1" <?php if ($eligibility['another_study'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="another_study" id="another_study2" value="2" <?php if ($eligibility['another_study'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="currently_smoking">
                                                    <label>Newly diagnosed with HIV?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="newly_diagnosed" id="newly_diagnosed1" value="1" <?php if ($eligibility['newly_diagnosed'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="newly_diagnosed" id="newly_diagnosed2" value="2" <?php if ($eligibility['newly_diagnosed'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="currently_smoking">
                                                    <label>Any medical or other condition in the potential participant
                                                        or their guardian that preludes the provision of informed
                                                        consent/ assent?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="medical_condtn" id="medical_condtn1" value="1" <?php if ($eligibility['medical_condtn'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?> required>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="medical_condtn" id="medical_condtn2" value="2" <?php if ($eligibility['medical_condtn'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Is the volunteer eligible to be enrolled?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="enrolled_part" id="enrolled_part1" value="1" <?php if ($eligibility['enrolled_part'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?> disabled>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="enrolled_part" id="enrolled_part2" value="2" <?php if ($eligibility['enrolled_part'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?> disabled>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-12" id="participant_id">
                                                    <label>If YES, indicate the Participant ID:</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="participant_id" rows="2" placeholder="Type other here...">
                                                                <?php if ($eligibility['participant_id']) {
                                                                    print_r($eligibility['participant_id']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12" id="screen_failure">
                                                    <label>If NO, give reason for screening failure?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="screen_failure" rows="2" placeholder="Type other here...">
                                                                <?php if ($eligibility['screen_failure']) {
                                                                    print_r($eligibility['screen_failure']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="eligibility_form_complete" name="eligibility_form_complete" class="form-control" required>
                                                                <option value="<?= $eligibility['eligibility_form_complete'] ?>">
                                                                    <?php if ($eligibility['eligibility_form_complete']) {
                                                                        if ($eligibility['eligibility_form_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($eligibility['eligibility_form_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($eligibility['eligibility_form_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="form_completd_by" class="form-label">Form completed by:</label>
                                                        <input type="text" value="<?php if ($eligibility['form_completd_by']) {
                                                                                        print_r($eligibility['form_completd_by']);
                                                                                    } ?>" id="form_completd_by" name="form_completd_by" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                    <span>initials</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="date_form_comptn" class="form-label">Date of form completion</label>
                                                        <input type="date" value="<?php if ($eligibility['date_form_comptn']) {
                                                                                        print_r($eligibility['date_form_comptn']);
                                                                                    } ?>" id="date_form_comptn" name="date_form_comptn" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                    <span>dd /mmm/ yyyy</span>
                                                </div>
                                            </div>

                                            <hr>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                                <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <input type="submit" name="add_eligibility_form" value="Submit" class="btn btn-primary">
                                                <?php } ?>
                                            </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 7) { ?>
            <?php
            $risk_factors = $override->get3('risk_factors', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($risk_factors) { ?>
                                    <h1>Add New Risk Factors</h1>
                                <?php } else { ?>
                                    <h1>Update Risk Factors</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New Risk Factors</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Risk Factors</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Smoking History</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-4">
                                                        <div class="mb-2">
                                                            <label for="test_date" class="form-label">Date of Visit</label>
                                                            <input type="date" value="<?php if ($risk_factors) {
                                                                                            print_r($risk_factors['visit_date']);
                                                                                        } ?>" id="visit_date" name="visit_date" class="form-control" placeholder="Enter date" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <div class="col-sm-4">
                                                    <label>1.13 Do you Smoke?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="smoke_stat" id="smoke_stat1" value="1" <?php if ($risk_factors['smoke_stat'] == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class=" form-check-label">Yes (within past 12months)</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="smoke_stat" id="smoke_stat2" value="2" <?php if ($risk_factors['smoke_stat'] == 0) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Never smoked</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="smoke_stat" id="smoke_stat2" value="2" <?php if ($risk_factors['smoke_stat'] == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Former smoker (more than 12 months ago)</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>If yes to smoking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="smoking_yes[]" id="smoking_yes1" value="1" <?php foreach (explode(',', $risk_factors['smoking_yes']) as $value) {
                                                                                                                                                                        if ($value == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">Smokeless</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="smoking_yes[]" id="smoking_yes2" value="2" <?php foreach (explode(',', $risk_factors['smoking_yes']) as $value) {
                                                                                                                                                                        if ($value == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Smoking</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="smoking_yes[]" id="smoking_yes3" value="3" <?php foreach (explode(',', $risk_factors['smoking_yes']) as $value) {
                                                                                                                                                                        if ($value == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">E-Cigarette</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="smoking_yes[]" id="smoking_yes4" value="4" <?php foreach (explode(',', $risk_factors['smoking_yes']) as $value) {
                                                                                                                                                                        if ($value == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Other forms of tobacco</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Smokeless</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="duration_smokeless" class="form-label">Duration (smokeless)</label>
                                                        <input type="number" value="<?php if ($risk_factors['duration_smokeless']) {
                                                                                        print_r($risk_factors['duration_smokeless']);
                                                                                    } ?>" id="duration_smokeless" name="duration_smokeless" min="0" class="form-control" placeholder="Enter Duration" />
                                                    </div>
                                                    <span>months</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="frequence_smokeless" class="form-label">Frequency (smokeless)</label>
                                                        <input type="number" value="<?php if ($risk_factors['frequence_smokeless']) {
                                                                                        print_r($risk_factors['frequence_smokeless']);
                                                                                    } ?>" id="frequence_smokeless" name="frequence_smokeless" min="0" class="form-control" placeholder="Enter Frequence" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="quantity_smokeless" class="form-label">Quantity (smokeless)</label>
                                                        <input type="number" value="<?php if ($risk_factors['quantity_smokeless']) {
                                                                                        print_r($risk_factors['quantity_smokeless']);
                                                                                    } ?>" id="quantity_smokeless" name="quantity_smokeless" min="0" class="form-control" placeholder="Enter Quantity" />
                                                    </div>
                                                    <span>number per day</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Smoking</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="duration_smoking" class="form-label">Duration (smoking)</label>
                                                        <input type="number" value="<?php if ($risk_factors['duration_smoking']) {
                                                                                        print_r($risk_factors['duration_smoking']);
                                                                                    } ?>" id="duration_smoking" name="duration_smoking" min="0" class="form-control" placeholder="Enter Duration" />
                                                    </div>
                                                    <span>months</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="frequence_smoking" class="form-label">Frequency (smoking)</label>
                                                        <input type="number" value="<?php if ($risk_factors['frequence_smoking']) {
                                                                                        print_r($risk_factors['frequence_smoking']);
                                                                                    } ?>" id="frequence_smoking" name="frequence_smoking" min="0" class="form-control" placeholder="Enter Frequence" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="quantity_smoking" class="form-label">Quantity (smoking)</label>
                                                        <input type="number" value="<?php if ($risk_factors['quantity_smoking']) {
                                                                                        print_r($risk_factors['quantity_smoking']);
                                                                                    } ?>" id="quantity_smoking" name="quantity_smoking" min="0" class="form-control" placeholder="Enter Quantity" />
                                                    </div>
                                                    <span>number per day</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">E-cigarette</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="duration_ecigarette" class="form-label">Duration (E-cigarette)</label>
                                                        <input type="number" value="<?php if ($risk_factors['duration_ecigarette']) {
                                                                                        print_r($risk_factors['duration_ecigarette']);
                                                                                    } ?>" id="duration_ecigarette" name="duration_ecigarette" min="0" class="form-control" placeholder="Enter Duration" />
                                                    </div>
                                                    <span>months</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="frequence_ecigarette" class="form-label">Frequency (E-cigarette)</label>
                                                        <input type="number" value="<?php if ($risk_factors['frequence_ecigarette']) {
                                                                                        print_r($risk_factors['frequence_ecigarette']);
                                                                                    } ?>" id="frequence_ecigarette" name="frequence_ecigarette" min="0" class="form-control" placeholder="Enter Frequence" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="quantity_ecigarette" class="form-label">Quantity (E-cigarette)</label>
                                                        <input type="number" value="<?php if ($risk_factors['quantity_ecigarette']) {
                                                                                        print_r($risk_factors['quantity_ecigarette']);
                                                                                    } ?>" id="quantity_ecigarette" name="quantity_ecigarette" min="0" class="form-control" placeholder="Enter Quantity" />
                                                    </div>
                                                    <span>number per day</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Other Forms of Tobacco</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="other_tobacco" class="form-label">Other forms of tobacco, specify</label>
                                                        <input type="text" value="<?php if ($risk_factors['other_tobacco']) {
                                                                                        print_r($risk_factors['other_tobacco']);
                                                                                    } ?>" id="other_tobacco" name="other_tobacco" min="0" class="form-control" placeholder="Enter Duration" />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="duration_other" class="form-label">Duration (other forms of tobacco)</label>
                                                        <input type="number" value="<?php if ($risk_factors['duration_other']) {
                                                                                        print_r($risk_factors['duration_other']);
                                                                                    } ?>" id="duration_other" name="duration_other" min="0" class="form-control" placeholder="Enter Duration" />
                                                    </div>
                                                    <span>months</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="frequence_other" class="form-label">Frequency (other forms of tobacco)</label>
                                                        <input type="number" value="<?php if ($risk_factors['frequence_other']) {
                                                                                        print_r($risk_factors['frequence_other']);
                                                                                    } ?>" id="frequence_other" name="frequence_other" min="0" class="form-control" placeholder="Enter Frequence" />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="quantity_other" class="form-label">Quantity (other forms of tobacco)</label>
                                                        <input type="number" value="<?php if ($risk_factors['quantity_other']) {
                                                                                        print_r($risk_factors['quantity_other']);
                                                                                    } ?>" id="quantity_other" name="quantity_other" min="0" class="form-control" placeholder="Enter Quantity" />
                                                    </div>
                                                    <span>number per day</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Alcohol</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>1.14 Are you Physically active?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="physically_active" id="physically_active1" value="1" <?php if ($risk_factors['physically_active'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> required>
                                                                <label class=" form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="physically_active" id="physically_active2" value="2" <?php if ($risk_factors['physically_active'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>If Yes, What is your grade?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="activity_grade" id="activity_grade1" value="1" <?php if ($risk_factors['activity_grade'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">High activity: Vigorous activity 3 times a week or
                                                                    more</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="activity_grade" id="activity_grade2" value="2" <?php if ($risk_factors['activity_grade'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Medium activity:vigorous 1-2 times per week</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="activity_grade" id="activity_grade3" value="3" <?php if ($risk_factors['activity_grade'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Low activity: moderate exercise 3 or more times
                                                                    per week with no regular weekly vigorous
                                                                    exercise</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="activity_grade" id="activity_grade4" value="4" <?php if ($risk_factors['activity_grade'] == 4) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Sedentary-moderate exercise less than 3 times
                                                                    per week with no regular vigorous exercise</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Do you Take Alcohol?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol1" value="1" <?php if ($risk_factors['alcohol'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?> required>
                                                                <label class=" form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol2" value="2" <?php if ($risk_factors['alcohol'] == 2) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>1.How often do you have a drink containing alcohol?
                                                        skip to question 9-10 if Never</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="drink_cont_alcoh" id="drink_cont_alcoh1" value="1" <?php if ($risk_factors['drink_cont_alcoh'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> required>
                                                                <label class=" form-check-label">Never</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="drink_cont_alcoh" id="drink_cont_alcoh2" value="2" <?php if ($risk_factors['drink_cont_alcoh'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Monthly or less</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="drink_cont_alcoh" id="drink_cont_alcoh3" value="3" <?php if ($risk_factors['drink_cont_alcoh'] == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">2 to 4 times a month</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="drink_cont_alcoh" id="drink_cont_alcoh4" value="4" <?php if ($risk_factors['drink_cont_alcoh'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">2 to 3 times a week</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="drink_cont_alcoh" id="drink_cont_alcoh5" value="5" <?php if ($risk_factors['drink_cont_alcoh'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">4 or more times a week</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="total_1only" class="form-label">Total for 1</label>
                                                        <input type="number" value="<?php if ($risk_factors['total_1only']) {
                                                                                        print_r($risk_factors['total_1only']);
                                                                                    } ?>" id="total_1only" name="total_1only" min="0" class="form-control" placeholder="Enter Total" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>2. How many drinks containing alcohol do you have on a
                                                        typical day when you are drinking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="howmany_drinks" id="howmany_drinks1" value="1" <?php if ($risk_factors['howmany_drinks'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">1 or 2</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="howmany_drinks" id="howmany_drinks2" value="2" <?php if ($risk_factors['howmany_drinks'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">3 or 4</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="howmany_drinks" id="howmany_drinks3" value="3" <?php if ($risk_factors['howmany_drinks'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">5 or 6</label>

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="howmany_drinks" id="howmany_drinks4" value="4" <?php if ($risk_factors['howmany_drinks'] == 4) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">7,8 or 9</label>

                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="howmany_drinks" id="howmany_drinks5" value="5" <?php if ($risk_factors['howmany_drinks'] == 5) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class=" form-check-label">10 or More</label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>3. How often do you have six or more drinks on one
                                                        occassion?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occassions', 'status', 1) as $occassion) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="drink_often" id="drink_often<?= $occassion['id']; ?>" value="<?= $occassion['id']; ?>" <?php if ($risk_factors['drink_often'] == $occassion['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $occassion['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>4. How often during the last year have you found that you
                                                        were not able to stop drinking once you had started?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occassions', 'status', 1) as $occassion) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="cant_stop_drink" id="cant_stop_drink<?= $occassion['id']; ?>" value="<?= $occassion['id']; ?>" <?php if ($risk_factors['cant_stop_drink'] == $occassion['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $occassion['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>5. How often during the last year have you failed to do
                                                        what was normally expected from you because of
                                                        drinking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occassions', 'status', 1) as $occassion) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="failed_todo_normal" id="failed_todo_normal<?= $occassion['id']; ?>" value="<?= $occassion['id']; ?>" <?php if ($risk_factors['failed_todo_normal'] == $occassion['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $occassion['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>6. How often during the last year have you needed a first
                                                        drink in the morning to get yourself going after a heavy
                                                        drinking session?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occassions', 'status', 1) as $occassion) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="first_drink_morning" id="first_drink_morning<?= $occassion['id']; ?>" value="<?= $occassion['id']; ?>" <?php if ($risk_factors['first_drink_morning'] == $occassion['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $occassion['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>7. How often during the last year have you had a feeling of
                                                        guilt or remorse after drinking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occassions', 'status', 1) as $occassion) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="remorse_after_drink" id="remorse_after_drink<?= $occassion['id']; ?>" value="<?= $occassion['id']; ?>" <?php if ($risk_factors['remorse_after_drink'] == $occassion['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $occassion['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>8. How often during the last year have you been unable to
                                                        remember what happened the night before because you
                                                        had been drinking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('occassions', 'status', 1) as $occassion) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="cant_remember" id="cant_remember<?= $occassion['id']; ?>" value="<?= $occassion['id']; ?>" <?php if ($risk_factors['cant_remember'] == $occassion['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $occassion['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>9. Have you or someone else been injured as a result of
                                                        your drinking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_but', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="injure_someone" id="injure_someone<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($risk_factors['injure_someone'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>10. Has a relative or friend or a doctor or another health
                                                        worker been concerned about your drinking or suggested
                                                        you cut down</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_but', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="concern_about_drink" id="concern_about_drink<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($risk_factors['concern_about_drink'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="mb-2">
                                                                <label for="overall_total_never" class="form-label">Overall total 1</label>
                                                                <input type="number" value="<?php if ($risk_factors['overall_total_never']) {
                                                                                                print_r($risk_factors['overall_total_never']);
                                                                                            } ?>" id="overall_total_never" name="overall_total_never" min="0" class="form-control" placeholder="Enter Total" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="mb-2">
                                                                <label for="overtotal" class="form-label">Overall total 2</label>
                                                                <input type="number" value="<?php if ($risk_factors['overtotal']) {
                                                                                                print_r($risk_factors['overtotal']);
                                                                                            } ?>" id="overtotal" name="overtotal" min="0" class="form-control" placeholder="Enter Total" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <hr>
                                                <div class="card card-warning">
                                                    <div class="card-header">
                                                        <h3 class="card-title">COVID 19</h3>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>1.16 Have you ever suffered from COVID-19?</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="covid19" id="covid19<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($risk_factors['covid19'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>1.17 Were you vaccinated against COVID_19?</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="vaccine_covid19" id="vaccine_covid19<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($risk_factors['vaccine_covid19'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">TB</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>1.15 Have you ever been treated for TB?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="treated_tb" id="treated_tb<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($risk_factors['treated_tb'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="mb-2">
                                                                <label for="date_treated_tb" class="form-label">1.15 If yes when was it ( Year )?</label>
                                                                <input type="number" value="<?php if ($risk_factors['date_treated_tb']) {
                                                                                                print_r($risk_factors['date_treated_tb']);
                                                                                            } ?>" id="date_treated_tb" name="date_treated_tb" min="1900" max="2024" class="form-control" placeholder="Enter Year" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="mb-2">
                                                                <label for="month_treated_tb" class="form-label">1.15 If yes when was it ( Month ) ?</label>
                                                                <input type="number" value="<?php if ($risk_factors['month_treated_tb']) {
                                                                                                print_r($risk_factors['month_treated_tb']);
                                                                                            } ?>" id="month_treated_tb" name="month_treated_tb" min="0" max="99" class="form-control" placeholder="Enter Month" />
                                                            </div>
                                                            <span>(If Don’t remember month put ‘99’)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Form Status</h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="risk_factors_complete" name="risk_factors_complete" class="form-control" required>
                                                                <option value="<?= $risk_factors['risk_factors_complete'] ?>">
                                                                    <?php if ($risk_factors['risk_factors_complete']) {
                                                                        if ($risk_factors['risk_factors_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($risk_factors['risk_factors_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($risk_factors['risk_factors_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="risk_factors_complete_date" class="form-label">Date Form Completed</label>
                                                            <input type="date" value="<?php if ($risk_factors['risk_factors_complete_date']) {
                                                                                            print_r($risk_factors['risk_factors_complete_date']);
                                                                                        } ?>" id="risk_factors_complete_date" name="risk_factors_complete_date" class="form-control" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_risk_factors" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 8) { ?>
            <?php
            $chronic_illnesses = $override->get3('chronic_illnesses', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($chronic_illnesses) { ?>
                                    <h1>Add New Chronic Illnesses</h1>
                                <?php } else { ?>
                                    <h1>Update Chronic Illnesses</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($chronic_illnesses) { ?>
                                        <li class="breadcrumb-item active">Add New Chronic Illnesses</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Chronic Illnesses</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Chronic Illnesses</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-3">
                                                        <div class="mb-2">
                                                            <label for="visit_date" class="form-label">Visit Date</label>
                                                            <input type="date" value="<?php if ($chronic_illnesses['visit_date']) {
                                                                                            print_r($chronic_illnesses['visit_date']);
                                                                                        } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-sm-3">
                                                    <label>4.1 Have you ever been screened for non-communicable
                                                        diseases?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ncd_screening" id="ncd_screening<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($chronic_illnesses['ncd_screening'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="chronic_illness_type" class="form-label">Name of chronic illness</label>
                                                        <input type="text" value="<?php if ($chronic_illnesses['chronic_illness_type']) {
                                                                                        print_r($chronic_illnesses['chronic_illness_type']);
                                                                                    } ?>" id="chronic_illness_type" name="chronic_illness_type" min="0" class="form-control" placeholder="Enter name" />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="start_date_chronic" class="form-label">Start date</label>
                                                        <input type="date" value="<?php if ($chronic_illnesses['start_date_chronic']) {
                                                                                        print_r($chronic_illnesses['start_date_chronic']);
                                                                                    } ?>" id="start_date_chronic" name="start_date_chronic" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Form Status</h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="chronic_illnesses_specify_complete" name="chronic_illnesses_specify_complete" class="form-control" required>
                                                                <option value="<?= $chronic_illnesses['chronic_illnesses_specify_complete'] ?>">
                                                                    <?php if ($chronic_illnesses['chronic_illnesses_specify_complete']) {
                                                                        if ($chronic_illnesses['chronic_illnesses_specify_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($chronic_illnesses['chronic_illnesses_specify_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($chronic_illnesses['chronic_illnesses_specify_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="chronic_illnesses_specify_complete_date" class="form-label">Date Form Completed</label>
                                                            <input type="date" value="<?php if ($chronic_illnesses['chronic_illnesses_specify_complete_date']) {
                                                                                            print_r($chronic_illnesses['chronic_illnesses_specify_complete_date']);
                                                                                        } ?>" id="chronic_illnesses_specify_complete_date" name="chronic_illnesses_specify_complete_date" class="form-control" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_chronic_illnesses" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 9) { ?>
            <?php
            $laboratory_results = $override->get3('laboratory_results', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($laboratory_results) { ?>
                                    <h1>Add New Laboratory Results</h1>
                                <?php } else { ?>
                                    <h1>Update Laboratory Results</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($laboratory_results) { ?>
                                        <li class="breadcrumb-item active">Add New Laboratory Results</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Laboratory Results</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">HAEMATOLOGY</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-3">
                                                        <div class="mb-2">
                                                            <label for="visit_date" class="form-label">Visit Date</label>
                                                            <input type="date" value="<?php if ($laboratory_results['visit_date']) {
                                                                                            print_r($laboratory_results['visit_date']);
                                                                                        } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-sm-3">
                                                    <label>Has haematology been done today?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="hema_done" id="hema_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['hema_done'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lab_date_hema" class="form-label">Date of sampling</label>
                                                        <input type="date" value="<?php if ($laboratory_results['lab_date_hema']) {
                                                                                        print_r($laboratory_results['lab_date_hema']);
                                                                                    } ?>" id="lab_date_hema" name="lab_date_hema" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lab_time_hema" class="form-label">Time of sampling</label>
                                                        <input type="text" value="<?php if ($laboratory_results['lab_time_hema']) {
                                                                                        print_r($laboratory_results['lab_time_hema']);
                                                                                    } ?>" id="lab_time_hema" name="lab_time_hema" min="0" class="form-control" placeholder="Enter Time" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="hemo" class="form-label">Haemoglobin</label>
                                                        <input type="number" min="0" value="<?php if ($laboratory_results['hemo']) {
                                                                                                print_r($laboratory_results['hemo']);
                                                                                            } ?>" id="hemo" name="hemo" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Haemoglobin Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('gl_gdl', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="hemo_type" id="hemo_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['hemo_type'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="wbc" class="form-label">WBC count</label>
                                                        <input type="number" min="0" value="<?php if ($laboratory_results['wbc']) {
                                                                                                print_r($laboratory_results['wbc']);
                                                                                            } ?>" id="wbc" name="wbc" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Wbc Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('_109_103', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="wbc_type" id="wbc_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['wbc_type'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="mb-2">
                                                        <label for="lymph" class="form-label">Lymphocyte count</label>
                                                        <input type="number" min="0" value="<?php if ($laboratory_results['lymph']) {
                                                                                                print_r($laboratory_results['lymph']);
                                                                                            } ?>" id="lymph" name="lymph" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>cells/uL</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="mb-2">
                                                        <label for="neutro_count" class="form-label">Neutrophil count</label>
                                                        <input type="number" min="0" value="<?php if ($laboratory_results['neutro_count']) {
                                                                                                print_r($laboratory_results['neutro_count']);
                                                                                            } ?>" id="neutro_count" name="neutro_count" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>cells/uL</span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="mb-2">
                                                        <label for="hematocrit" class="form-label">Hematocrit</label>
                                                        <input type="number" min="0" value="<?php if ($laboratory_results['hematocrit']) {
                                                                                                print_r($laboratory_results['hematocrit']);
                                                                                            } ?>" id="hematocrit" name="hematocrit" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>%</span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="mb-2">
                                                        <label for="platelettes" class="form-label">Platelets</label>
                                                        <input type="number" min="0" value="<?php if ($laboratory_results['platelettes']) {
                                                                                                print_r($laboratory_results['platelettes']);
                                                                                            } ?>" id="platelettes" name="platelettes" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Platelets Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('_109_103', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="platelets_type" id="platelets_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['platelets_type'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">BIOCHEMISTRY</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <label>Has biochemistry tests been done today?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="biochem_done" id="biochem_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['biochem_done'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="lab_date_bio" class="form-label">Date of sampling</label>
                                                        <input type="date" value="<?php if ($laboratory_results['lab_date_bio']) {
                                                                                        print_r($laboratory_results['lab_date_bio']);
                                                                                    } ?>" id="lab_date_bio" name="lab_date_bio" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="lab_time_bio" class="form-label">Time of sampling</label>
                                                        <input type="text" value="<?php if ($laboratory_results['lab_time_bio']) {
                                                                                        print_r($laboratory_results['lab_time_bio']);
                                                                                    } ?>" id="lab_time_bio" name="lab_time_bio" min="0" class="form-control" placeholder="Enter Time" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="bun" class="form-label">Blood Urea Nitrogen (urea)</label>
                                                        <input type="text" value="<?php if ($laboratory_results['bun']) {
                                                                                        print_r($laboratory_results['bun']);
                                                                                    } ?>" id="bun" name="bun" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Bun Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('mmol_l_mg_dL', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="bun_type" id="bun_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['bun_type'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="creat" class="form-label">Creatinine</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['creat']) {
                                                                                                    print_r($laboratory_results['creat']);
                                                                                                } ?>" id="creat" name="creat" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Creatinine Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('umol_l_mg_dL', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="creat_type" id="creat_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['creat_type'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="sodium" class="form-label">Sodium</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['sodium']) {
                                                                                                    print_r($laboratory_results['sodium']);
                                                                                                } ?>" id="sodium" name="sodium" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Sodium Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('mmol_l_meq_dL', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="sod_type" id="sod_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['sod_type'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="potass" class="form-label">Potassium</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['potass']) {
                                                                                                    print_r($laboratory_results['potass']);
                                                                                                } ?>" id="potass" name="potass" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Potassium Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('mmol_l_meq_dL', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="potas_type" id="potas_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['potas_type'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="tot_choles" class="form-label">Total Cholesterol</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['tot_choles']) {
                                                                                                    print_r($laboratory_results['tot_choles']);
                                                                                                } ?>" id="tot_choles" name="tot_choles" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mmol/L</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="trigly" class="form-label">Triglycerides</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['trigly']) {
                                                                                                    print_r($laboratory_results['trigly']);
                                                                                                } ?>" id="trigly" name="trigly" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mmol/L</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="hdl" class="form-label">HDL</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['hdl']) {
                                                                                                    print_r($laboratory_results['hdl']);
                                                                                                } ?>" id="hdl" name="hdl" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mmol/L</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="ldl" class="form-label">LDL</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['ldl']) {
                                                                                                    print_r($laboratory_results['ldl']);
                                                                                                } ?>" id="ldl" name="ldl" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mmol/L</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="vldl" class="form-label">VLDL</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['vldl']) {
                                                                                                    print_r($laboratory_results['vldl']);
                                                                                                } ?>" id="vldl" name="vldl" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mmol/L</span>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="coronary_risk" class="form-label">Coronary Risk</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['coronary_risk']) {
                                                                                                    print_r($laboratory_results['coronary_risk']);
                                                                                                } ?>" id="coronary_risk" name="coronary_risk" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>number</span>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Urine R/E</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <label>Has urine R/E been done today?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="urine_done" id="urine_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['urine_done'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="lab_date_bio_2" class="form-label">Date of sampling</label>
                                                        <input type="date" value="<?php if ($laboratory_results['lab_date_bio_2']) {
                                                                                        print_r($laboratory_results['lab_date_bio_2']);
                                                                                    } ?>" id="lab_date_bio_2" name="lab_date_bio_2" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="lab_time_bio_2" class="form-label">Time of sampling</label>
                                                        <input type="text" value="<?php if ($laboratory_results['lab_time_bio_2']) {
                                                                                        print_r($laboratory_results['lab_time_bio_2']);
                                                                                    } ?>" id="lab_time_bio_2" name="lab_time_bio_2" min="0" class="form-control" placeholder="Enter Time" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <label>Color</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('color', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="color" id="color<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['color'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Appearance</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('appearance', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="appearance" id="appearance<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['appearance'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Glucose</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="labs_glucose" id="labs_glucose<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['labs_glucose'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Bilirubin</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="bilirubin" id="bilirubin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['bilirubin'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <label>Ketone</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ketone" id="ketone<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['ketone'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="spec_grav" class="form-label">Specific Gravity</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['spec_grav']) {
                                                                                                    print_r($laboratory_results['spec_grav']);
                                                                                                } ?>" id="spec_grav" name="spec_grav" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>number</span>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Blood</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="urine_blood" id="urine_blood<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['urine_blood'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="urine_ph" class="form-label">pH</label>
                                                        <input type="number" step="any" value="<?php if ($laboratory_results['urine_ph']) {
                                                                                                    print_r($laboratory_results['urine_ph']);
                                                                                                } ?>" id="urine_ph" name="urine_ph" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <label>Protein</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="urine_protein" id="urine_protein<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['urine_protein'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Urobilinogen</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="urobilonogen" id="urobilonogen<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['urobilonogen'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Nitrite</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="nitrite" id="nitrite<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['nitrite'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Leukocytes</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('positive_negative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="leukocytes" id="leukocytes<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($laboratory_results['leukocytes'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>


                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Form Status</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="laboratory_results_complete" name="laboratory_results_complete" class="form-control" required>
                                                                <option value="<?= $laboratory_results['laboratory_results_complete'] ?>">
                                                                    <?php if ($laboratory_results['laboratory_results_complete']) {
                                                                        if ($laboratory_results['laboratory_results_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($laboratory_results['laboratory_results_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($laboratory_results['laboratory_results_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="laboratory_results_complete_date" class="form-label">Date Form Completed</label>
                                                            <input type="date" value="<?php if ($laboratory_results['laboratory_results_complete_date']) {
                                                                                            print_r($laboratory_results['laboratory_results_complete_date']);
                                                                                        } ?>" id="laboratory_results_complete_date" name="laboratory_results_complete_date" class="form-control" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_laboratory_results" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 10) { ?>
            <?php
            $radiological_investigations = $override->get3('radiological_investigations', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($radiological_investigations) { ?>
                                    <h1>Add New Radiological Investigations</h1>
                                <?php } else { ?>
                                    <h1>Update Radiological Investigations</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($radiological_investigations) { ?>
                                        <li class="breadcrumb-item active">Add New Radiological Investigations</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Radiological Investigations</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Electrocardiogram</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">

                                            <hr>

                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-3">
                                                        <div class="mb-2">
                                                            <label for="visit_date" class="form-label">Visit Date</label>
                                                            <input type="date" value="<?php if ($radiological_investigations['visit_date']) {
                                                                                            print_r($radiological_investigations['visit_date']);
                                                                                        } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                                <div class="col-sm-3">
                                                    <label>Electrocardiogram (ECG)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ecg" id="ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['ecg'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                                <span>Remarks</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="ecg_date" class="form-label">Date of ECG</label>
                                                        <input type="date" value="<?php if ($radiological_investigations['ecg_date']) {
                                                                                        print_r($radiological_investigations['ecg_date']);
                                                                                    } ?>" id="ecg_date" name="ecg_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>What is the Quality of ECG?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('ecg_quality', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="quality_ecg" id="quality_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['quality_ecg'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>NOTE:if ECG quality is assessed as poor quality/not acceptable, then dont report on it.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="heart_rate_ecg" class="form-label">1. Heart Rate</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['heart_rate_ecg']) {
                                                                                        print_r($radiological_investigations['heart_rate_ecg']);
                                                                                    } ?>" id="heart_rate_ecg" name="heart_rate_ecg" min="0" class="form-control" placeholder="Enter here" />
                                                        <span>bpm (Quatitative)</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Qualitative</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('qualitative', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="qualitative_ecg" id="qualitative_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['qualitative_ecg'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>Based on reference</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="regularity_ecg" class="form-label">Regularity</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['regularity_ecg']) {
                                                                                        print_r($radiological_investigations['regularity_ecg']);
                                                                                    } ?>" id="regularity_ecg" name="regularity_ecg" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Heart Rhythm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('rhythm', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="heart_rythm_ecg" id="heart_rythm_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['heart_rythm_ecg'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                                <label for="other_heart_rhythm_ecg" class="form-label">Other heart Rhythm</label>
                                                                <input type="text" value="<?php if ($radiological_investigations['other_heart_rhythm_ecg']) {
                                                                                                print_r($radiological_investigations['other_heart_rhythm_ecg']);
                                                                                            } ?>" id="other_heart_rhythm_ecg" name="other_heart_rhythm_ecg" min="0" class="form-control" placeholder="Enter here" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>5. QRS Axis is;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('axis', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="qrs_axis_state_ecg" id="qrs_axis_state_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['qrs_axis_state_ecg'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>state whether QRS axis is normal or not</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="qrs_axis_no_ecg" class="form-label">5. Specify number </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['qrs_axis_no_ecg']) {
                                                                                        print_r($radiological_investigations['qrs_axis_no_ecg']);
                                                                                    } ?>" id="qrs_axis_no_ecg" name="qrs_axis_no_ecg" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="pr_interval_ecg" class="form-label">6. PR interval </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['pr_interval_ecg']) {
                                                                                        print_r($radiological_investigations['pr_interval_ecg']);
                                                                                    } ?>" id="pr_interval_ecg" name="pr_interval_ecg" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>6. PR interval specify;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('intervals', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="pr_inter_specify_ecg" id="pr_inter_specify_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['pr_inter_specify_ecg'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>state whether QRS axis is normal or not</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="qtc_interval_ecg" class="form-label">Qtc Interval </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['qtc_interval_ecg']) {
                                                                                        print_r($radiological_investigations['qtc_interval_ecg']);
                                                                                    } ?>" id="qtc_interval_ecg" name="qtc_interval_ecg" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Qtc Interval specify</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('intervals', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="qtc_inter_specify_ecg" id="qtc_inter_specify_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['qtc_inter_specify_ecg'] == $value['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="abnormal_waves_ecg" class="form-label">7. Abnomalities of waves noted:assess P, QRS, T-waves,
                                                            Q-waves and report any abnormalities, if any, of the waves
                                                            eg tall p-waves; wide QRS complex; RBBB/LBBB pattern </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['abnormal_waves_ecg']) {
                                                                                        print_r($radiological_investigations['abnormal_waves_ecg']);
                                                                                    } ?>" id="abnormal_waves_ecg" name="abnormal_waves_ecg" min="0" class="form-control" placeholder="Enter Here" />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="repolarizatn_abno_ecg" class="form-label">8.Repolarization abnormalities if any eg ST-segment depression, elevation, etc</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['repolarizatn_abno_ecg']) {
                                                                                        print_r($radiological_investigations['repolarizatn_abno_ecg']);
                                                                                    } ?>" id="repolarizatn_abno_ecg" name="repolarizatn_abno_ecg" min="0" class="form-control" placeholder="Enter Here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Summary statement: In conclusion the ECG is?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normality', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="conclusion_ecg" id="conclusion_ecg<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['conclusion_ecg'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>state whether QRS axis is normal or not</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="abno_o_borderl_specify" class="form-label">if abnormal or borderline specify </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['abno_o_borderl_specify']) {
                                                                                        print_r($radiological_investigations['abno_o_borderl_specify']);
                                                                                    } ?>" id="abno_o_borderl_specify" name="abno_o_borderl_specify" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Echocardiogram</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Echocardiogram;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="echocardiogram" id="echocardiogram<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['echocardiogram'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>Remarks</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>What is quality of the Image?;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('quality', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="quality_of_image_echo" id="quality_of_image_echo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['quality_of_image_echo'] == $value['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="brief_exp_subopt_echo" class="form-label">Brief explanation why suboptimal </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['brief_exp_subopt_echo']) {
                                                                                        print_r($radiological_investigations['brief_exp_subopt_echo']);
                                                                                    } ?>" id="brief_exp_subopt_echo" name="brief_exp_subopt_echo" min="0" class="form-control" placeholder="Enter Time" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Situs;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('situs', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="situs_echo" id="situs_echo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['situs_echo'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Cardiac axis</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('cardiac_axis', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cardiac_axis_echo" id="cardiac_axis_echo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['cardiac_axis_echo'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Systemic veinous connections</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normal_abnamal', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="syst_vein_connect_echo" id="syst_vein_connect_echo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['syst_vein_connect_echo'] == $value['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="specify_ab_sysvein_con" class="form-label">Specify abnormal Systemic veinous connections </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['specify_ab_sysvein_con']) {
                                                                                        print_r($radiological_investigations['specify_ab_sysvein_con']);
                                                                                    } ?>" id="specify_ab_sysvein_con" name="specify_ab_sysvein_con" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Pulmonary venous connections;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normal_abnamal', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="pulmo_ven_conn_echo" id="pulmo_ven_conn_echo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['pulmo_ven_conn_echo'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="specfy_ab_pulven_con" class="form-label">Specify abnormal Pulmonary venous connections </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['specfy_ab_pulven_con']) {
                                                                                        print_r($radiological_investigations['specfy_ab_pulven_con']);
                                                                                    } ?>" id="specfy_ab_pulven_con" name="specfy_ab_pulven_con" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Atrioventricular connections</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('connections', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="atrioven_connec" id="atrioven_connec<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['atrioven_connec'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Ventricular looping</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('looping', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ventricular_loop" id="ventricular_loop<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['ventricular_loop'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Ventriculoarterial connections</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('connections', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ventriculoart_conn" id="ventriculoart_conn<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['ventriculoart_conn'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Arrangement of great arteries</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('arrangement', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="arrange_grt_arteries" id="arrange_grt_arteries<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['arrange_grt_arteries'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Structural lesions [ASD, VSD, PDA]</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('seen_not_seen', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="structural_lesions" id="structural_lesions<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['structural_lesions'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="state_struc_lession" class="form-label">State structural lesion </label>
                                                        <input type="text" value="<?php if ($radiological_investigations['state_struc_lession']) {
                                                                                        print_r($radiological_investigations['state_struc_lession']);
                                                                                    } ?>" id="state_struc_lession" name="state_struc_lession" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="size" class="form-label">Size of structural lesion</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['size']) {
                                                                                        print_r($radiological_investigations['size']);
                                                                                    } ?>" id="size" name="size" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="site_struc_lesion" class="form-label">Site of structural lesion</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['site_struc_lesion']) {
                                                                                        print_r($radiological_investigations['site_struc_lesion']);
                                                                                    } ?>" id="site_struc_lesion" name="site_struc_lesion" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="hemodynamics_stru_lesio" class="form-label">Hemodynamics of structural lesions</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['hemodynamics_stru_lesio']) {
                                                                                        print_r($radiological_investigations['hemodynamics_stru_lesio']);
                                                                                    } ?>" id="hemodynamics_stru_lesio" name="hemodynamics_stru_lesio" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Valve Function</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="aortic_valve" class="form-label">Aortic valve</label>
                                                        <input type="number" step="any" value="<?php if ($radiological_investigations['aortic_valve']) {
                                                                                                    print_r($radiological_investigations['aortic_valve']);
                                                                                                } ?>" id="aortic_valve" name="aortic_valve" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="mitral_vavlve" class="form-label">Mitral Valve</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['mitral_vavlve']) {
                                                                                        print_r($radiological_investigations['mitral_vavlve']);
                                                                                    } ?>" id="mitral_vavlve" name="mitral_vavlve" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="tricuspid_valve" class="form-label">Tricuspid Valve</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['tricuspid_valve']) {
                                                                                        print_r($radiological_investigations['tricuspid_valve']);
                                                                                    } ?>" id="tricuspid_valve" name="tricuspid_valve" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Pericardial effusion</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('none_present', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="pericardial_effusion" id="pericardial_effusion<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['pericardial_effusion'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="measure_deep_pool" class="form-label">measurement of Pericardial effusion (measure deepest
                                                            pool)</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['measure_deep_pool']) {
                                                                                        print_r($radiological_investigations['measure_deep_pool']);
                                                                                    } ?>" id="measure_deep_pool" name="measure_deep_pool" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Chamber Dimesnions</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Left Atrium</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="left_atrium" id="left_atrium<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['left_atrium'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lf_atriu_parasternal" class="form-label">2D LA parasternal long axis anteroposterior dimension</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['lf_atriu_parasternal']) {
                                                                                        print_r($radiological_investigations['lf_atriu_parasternal']);
                                                                                    } ?>" id="lf_atriu_parasternal" name="lf_atriu_parasternal" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lf_atrium_4chamb_long" class="form-label">2D LA apical 4-chamber long axis dimension</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['lf_atrium_4chamb_long']) {
                                                                                        print_r($radiological_investigations['lf_atrium_4chamb_long']);
                                                                                    } ?>" id="lf_atrium_4chamb_long" name="lf_atrium_4chamb_long" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lf_atrium_4chamb_minor" class="form-label">2D LA apical 4-chamber minor axis (transverse) dimension</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['lf_atrium_4chamb_minor']) {
                                                                                        print_r($radiological_investigations['lf_atrium_4chamb_minor']);
                                                                                    } ?>" id="lf_atrium_4chamb_minor" name="lf_atrium_4chamb_minor" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Right Atrium</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="right_atrium" id="right_atrium<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['right_atrium'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="rt_4chamb_long" class="form-label">2D RA apical 4-chamber long axis dimension</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rt_4chamb_long']) {
                                                                                        print_r($radiological_investigations['rt_4chamb_long']);
                                                                                    } ?>" id="rt_4chamb_long" name="rt_4chamb_long" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="rt_4chamb_transverse" class="form-label">2D RA apical 4-chamber transverse dimension</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rt_4chamb_transverse']) {
                                                                                        print_r($radiological_investigations['rt_4chamb_transverse']);
                                                                                    } ?>" id="rt_4chamb_transverse" name="rt_4chamb_transverse" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lf_atrium_4chamb_minor" class="form-label">2D LA apical 4-chamber minor axis (transverse) dimension</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['lf_atrium_4chamb_minor']) {
                                                                                        print_r($radiological_investigations['lf_atrium_4chamb_minor']);
                                                                                    } ?>" id="lf_atrium_4chamb_minor" name="lf_atrium_4chamb_minor" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Left ventricle M-Mode (LV dimensions obtained from PLAX
                                                        view)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="left_ventrical_mmode" id="left_ventrical_mmode<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['left_ventrical_mmode'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="free_wall_thickness" class="form-label">MM LV end-diastolic free wall thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['free_wall_thickness']) {
                                                                                        print_r($radiological_investigations['free_wall_thickness']);
                                                                                    } ?>" id="free_wall_thickness" name="free_wall_thickness" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="septal_thickness" class="form-label">MM LV end-diastolic septal thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['septal_thickness']) {
                                                                                        print_r($radiological_investigations['septal_thickness']);
                                                                                    } ?>" id="septal_thickness" name="septal_thickness" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="free_wall_thickness_2" class="form-label">MM LV end-diastolic free wall thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['free_wall_thickness_2']) {
                                                                                        print_r($radiological_investigations['free_wall_thickness_2']);
                                                                                    } ?>" id="free_wall_thickness_2" name="free_wall_thickness_2" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Left ventricle 2D dimensions obtained from PLAX view</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="lt_2d_plax_view" id="lt_2d_plax_view<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['lt_2d_plax_view'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="d_freewall_thick_plax" class="form-label">2D LV end-diastolic free wall thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['d_freewall_thick_plax']) {
                                                                                        print_r($radiological_investigations['d_freewall_thick_plax']);
                                                                                    } ?>" id="d_freewall_thick_plax" name="d_freewall_thick_plax" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="d_septal_thick_plax" class="form-label">2D LV end-diastolic septal thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['d_septal_thick_plax']) {
                                                                                        print_r($radiological_investigations['d_septal_thick_plax']);
                                                                                    } ?>" id="d_septal_thick_plax" name="d_septal_thick_plax" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="d_freewall_thick_plax2" class="form-label">2D LV end-diastolic free wall thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['d_freewall_thick_plax2']) {
                                                                                        print_r($radiological_investigations['d_freewall_thick_plax2']);
                                                                                    } ?>" id="d_freewall_thick_plax2" name="d_freewall_thick_plax2" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Right ventricle chamber size measurement obtained from
                                                        a number of views</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="right_ven_chamber" id="right_ven_chamber<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['right_ven_chamber'] == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="rvot_plax_dia" class="form-label">RVOT PLAX diameter</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rvot_plax_dia']) {
                                                                                        print_r($radiological_investigations['rvot_plax_dia']);
                                                                                    } ?>" id="rvot_plax_dia" name="rvot_plax_dia" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="rvot_prox_dia" class="form-label">RVOT proximal diameter</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rvot_prox_dia']) {
                                                                                        print_r($radiological_investigations['rvot_prox_dia']);
                                                                                    } ?>" id="rvot_prox_dia" name="rvot_prox_dia" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="rvot_distal_dia" class="form-label">RVOT distal diameter</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rvot_distal_dia']) {
                                                                                        print_r($radiological_investigations['rvot_distal_dia']);
                                                                                    } ?>" id="rvot_distal_dia" name="rvot_distal_dia" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="rv_wall_thickness" class="form-label">RV wall thickness</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rv_wall_thickness']) {
                                                                                        print_r($radiological_investigations['rv_wall_thickness']);
                                                                                    } ?>" id="rv_wall_thickness" name="rv_wall_thickness" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Systolic Function</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>LV systolic function as assessed using ejection fraction (EF)
                                                        and shortening fraction (SF) obtained from M-mode
                                                        measurement</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="lv_sys_func" id="lv_sys_func<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['lv_sys_func'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="ef_echo" class="form-label">EF</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['ef_echo']) {
                                                                                        print_r($radiological_investigations['ef_echo']);
                                                                                    } ?>" id="ef_echo" name="ef_echo" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>%</span>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="fs_echo" class="form-label">FS</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['fs_echo']) {
                                                                                        print_r($radiological_investigations['fs_echo']);
                                                                                    } ?>" id="fs_echo" name="fs_echo" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>%</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="rv_sys_func" class="form-label">RV systolic function as assessed by measuring RV fractional area change (FAC) and TAPSE (tricuspid annular plane systolic excursion)</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rv_sys_func']) {
                                                                                        print_r($radiological_investigations['rv_sys_func']);
                                                                                    } ?>" id="rv_sys_func" name="rv_sys_func" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="tapse_echo" class="form-label">Tapse</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['tapse_echo']) {
                                                                                        print_r($radiological_investigations['tapse_echo']);
                                                                                    } ?>" id="tapse_echo" name="tapse_echo" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Other Measurements</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Estimated RV systolic pressure should be reported when a
                                                        complete TR jet is present</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="esti_rv_sbp" id="esti_rv_sbp<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['lv_sys_func'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="estimate_rv_sbp" class="form-label">Estimated RV systolic pressure</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['estimate_rv_sbp']) {
                                                                                        print_r($radiological_investigations['estimate_rv_sbp']);
                                                                                    } ?>" id="estimate_rv_sbp" name="estimate_rv_sbp" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mmHg</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Inferior vena cava (IVC) dimension and collapsibility to
                                                        estimate right atrial pressure in adults for whom RV
                                                        pressure is measured</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('done_not_done', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ivc_dimen_n_collapsi" id="ivc_dimen_n_collapsi<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['ivc_dimen_n_collapsi'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="inferior_venacava" class="form-label">Inferior vena cava (IVC)</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['inferior_venacava']) {
                                                                                        print_r($radiological_investigations['inferior_venacava']);
                                                                                    } ?>" id="inferior_venacava" name="inferior_venacava" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm/Hg</span>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Qualitative assessment of valvar regurgitation</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('assessment', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="quali_asses_valvar_regurgi" id="quali_asses_valvar_regurgi<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['quali_asses_valvar_regurgi'] == $value['id']) {
                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Summary statement: In conclusion the Echo findings
                                                        are? (if abnormal specify)</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Cardiac Anatomy</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normal_abnamal', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cardiac_anatomy" id="cardiac_anatomy<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['cardiac_anatomy'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="abnorm_cardiac_anatom" class="form-label">Specify why cardiac anatomy is abnormal</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['abnorm_cardiac_anatom']) {
                                                                                        print_r($radiological_investigations['abnorm_cardiac_anatom']);
                                                                                    } ?>" id="abnorm_cardiac_anatom" name="abnorm_cardiac_anatom" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Cardiac Function</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normal_abnamal', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cardiac_function" id="cardiac_function<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['cardiac_function'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="abnorm_cardia_func" class="form-label">Specify why cardiac function is abnormal</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['abnorm_cardia_func']) {
                                                                                        print_r($radiological_investigations['abnorm_cardia_func']);
                                                                                    } ?>" id="abnorm_cardia_func" name="abnorm_cardia_func" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Renal Function</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Renal Ultrasound</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="renal_ultrasound" id="renal_ultrasound<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['renal_ultrasound'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>Remarks</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>What is the quality of Renal u/s?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('ecg_quality', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="quality_renal" id="quality_renal<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['quality_renal'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>Note: If scan quality is assessed as poor quality, then do not proceed to
                                                                report on it.</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Kidney sizes; length of each kidney.</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="rt_kidney_length" class="form-label">Right Kidney length</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rt_kidney_length']) {
                                                                                        print_r($radiological_investigations['rt_kidney_length']);
                                                                                    } ?>" id="rt_kidney_length" name="rt_kidney_length" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="rt_kidney_width" class="form-label">Right Kidney width</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['rt_kidney_width']) {
                                                                                        print_r($radiological_investigations['rt_kidney_width']);
                                                                                    } ?>" id="rt_kidney_width" name="rt_kidney_width" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Right kidney echogenicity</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normal_abnamal', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="rt_kidney_echoge" id="rt_kidney_echoge<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['rt_kidney_echoge'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <span>mm</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lt_kidney_length" class="form-label">Left Kidney length</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['lt_kidney_length']) {
                                                                                        print_r($radiological_investigations['lt_kidney_length']);
                                                                                    } ?>" id="lt_kidney_length" name="lt_kidney_length" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lt_kidney_width" class="form-label">Left kidney width</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['lt_kidney_width']) {
                                                                                        print_r($radiological_investigations['lt_kidney_width']);
                                                                                    } ?>" id="lt_kidney_width" name="lt_kidney_width" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Left kidney echogenicity</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normal_abnamal', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="lt_kidney_echoge" id="lt_kidney_echoge<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['lt_kidney_echoge'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Is hydronephrosis present?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="hydronephrosis" id="hydronephrosis<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['hydronephrosis'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="yes_hydronephrosis" class="form-label">If yes, provide details and measurements.</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['yes_hydronephrosis']) {
                                                                                        print_r($radiological_investigations['yes_hydronephrosis']);
                                                                                    } ?>" id="yes_hydronephrosis" name="yes_hydronephrosis" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mm</span>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>Presence of Kidney stones?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="kidney_stones" id="kidney_stones<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['kidney_stones'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="detail_kidneystones" class="form-label">If yes, provide details:</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['detail_kidneystones']) {
                                                                                        print_r($radiological_investigations['detail_kidneystones']);
                                                                                    } ?>" id="detail_kidneystones" name="detail_kidneystones" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Presence of other structural anomalies?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="structural_anomalies" id="structural_anomalies<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['structural_anomalies'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="details_structural_anomali" class="form-label">If yes, provide details:</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['details_structural_anomali']) {
                                                                                        print_r($radiological_investigations['details_structural_anomali']);
                                                                                    } ?>" id="details_structural_anomali" name="details_structural_anomali" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="comment_bladders" class="form-label">Comment on the bladder</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['comment_bladders']) {
                                                                                        print_r($radiological_investigations['comment_bladders']);
                                                                                    } ?>" id="comment_bladders" name="comment_bladders" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="incidental_findings" class="form-label">Other incidental findings</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['incidental_findings']) {
                                                                                        print_r($radiological_investigations['incidental_findings']);
                                                                                    } ?>" id="incidental_findings" name="incidental_findings" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Summary statement: In conclusion the scan is?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('normality', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="conclusion_renal" id="conclusion_renal<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($radiological_investigations['conclusion_renal'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="abnor_o_border_renal" class="form-label">If abnormal or borderline specify</label>
                                                        <input type="text" value="<?php if ($radiological_investigations['abnor_o_border_renal']) {
                                                                                        print_r($radiological_investigations['abnor_o_border_renal']);
                                                                                    } ?>" id="abnor_o_border_renal" name="abnor_o_border_renal" min="0" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Form Status.</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="radiological_investigations_complete" name="radiological_investigations_complete" class="form-control" required>
                                                                <option value="<?= $radiological_investigations['radiological_investigations_complete'] ?>">
                                                                    <?php if ($radiological_investigations['radiological_investigations_complete']) {
                                                                        if ($radiological_investigations['radiological_investigations_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($radiological_investigations['radiological_investigations_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($radiological_investigations['radiological_investigations_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="radiological_investigations_complete_date" class="form-label">Date Form Completed</label>
                                                            <input type="date" value="<?php if ($radiological_investigations['radiological_investigations_complete_date']) {
                                                                                            print_r($radiological_investigations['radiological_investigations_complete_date']);
                                                                                        } ?>" id="radiological_investigations_complete_date" name="radiological_investigations_complete_date" class="form-control" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>

                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_radiological_investigations" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 11) { ?>
            <?php
            $medications = $override->get3('medications', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($medications) { ?>
                                    <h1>Add New medications</h1>
                                <?php } else { ?>
                                    <h1>Update medications</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($medications) { ?>
                                        <li class="breadcrumb-item active">Add New medications</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update medications</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">4.0 Medications / Short-term illness</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-4">
                                                        <div class="mb-2">
                                                            <label for="visit_date" class="form-label">Visit Date</label>
                                                            <input type="date" value="<?php if ($medications['visit_date']) {
                                                                                            print_r($medications['visit_date']);
                                                                                        } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                                <div class="col-sm-4">
                                                    <label>4.1 Have you had any illness in the past three months ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="illness" id="illness<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($medications['illness'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="illness_specify" class="form-label">If Yes, mention</label>
                                                        <input type="text" value="<?php if ($medications['illness_specify']) {
                                                                                        print_r($medications['illness_specify']);
                                                                                    } ?>" id="illness_specify" name="illness_specify" class="form-control" placeholder="Enter name" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>4.2 Can you name what you were sick during that period ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="sick" id="sick<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($medications['sick'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="sick_specify" class="form-label">If Yes, mention</label>
                                                        <input type="text" value="<?php if ($medications['sick_specify']) {
                                                                                        print_r($medications['sick_specify']);
                                                                                    } ?>" id="sick_specify" name="sick_specify" class="form-control" placeholder="Enter name" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>4.3 Are there any other medicines you used apart form ART ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="medicines" id="medicines<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($medications['medicines'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="medicines_specify" class="form-label">If Yes, mention</label>
                                                        <input type="text" value="<?php if ($medications['medicines_specify']) {
                                                                                        print_r($medications['medicines_specify']);
                                                                                    } ?>" id="medicines_specify" name="medicines_specify" class="form-control" placeholder="Enter name" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <label>4.4 How long have you used those medicine?</label>
                                            <hr>


                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="medicines_years" class="form-label">Years</label>
                                                        <input type="text" value="<?php if ($medications['medicines_years']) {
                                                                                        print_r($medications['medicines_years']);
                                                                                    } ?>" id="medicines_years" name="medicines_years" class="form-control" min="0" max="100" placeholder="Enter here" />
                                                    </div>
                                                    <span>If Only Months And Days Put '0'</span>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="medicines_months" class="form-label">Months</label>
                                                        <input type="text" value="<?php if ($medications['medicines_months']) {
                                                                                        print_r($medications['medicines_months']);
                                                                                    } ?>" id="medicines_months" name="medicines_months" class="form-control" min="0" max="100" placeholder="Enter here" />
                                                    </div>
                                                    <span>If Only Years And Days Put '0'</span>

                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="medicines_days" class="form-label">Days</label>
                                                        <input type="text" value="<?php if ($medications['medicines_days']) {
                                                                                        print_r($medications['medicines_days']);
                                                                                    } ?>" id="medicines_days" name="medicines_days" class="form-control" min="0" max="100" placeholder="Enter here" />
                                                    </div>
                                                    <span>If Only Years and Months Put '0'</span>

                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Form Status</h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Complete?</label>
                                                            <select id="medications_complete" name="medications_complete" class="form-control" required>
                                                                <option value="<?= $medications['medications_complete'] ?>">
                                                                    <?php if ($medications['medications_complete']) {
                                                                        if ($medications['medications_complete'] == 0) {
                                                                            echo 'Incomplete';
                                                                        } elseif ($medications['medications_complete'] == 1) {
                                                                            echo 'Unverified';
                                                                        } elseif ($medications['medications_complete'] == 2) {
                                                                            echo 'Complete';
                                                                        }
                                                                    } else {
                                                                        echo 'Select';
                                                                    } ?>
                                                                </option>
                                                                <option value="0">Incomplete</option>
                                                                <option value="1">Unverified</option>
                                                                <option value="2">Complete</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->position != 5) {
                                                ?>
                                                    <div class="col-6">
                                                        <div class="mb-2">
                                                            <label for="medication_complete_date" class="form-label">Date Form Completed</label>
                                                            <input type="date" value="<?php if ($medications['medication_complete_date']) {
                                                                                            print_r($medications['medication_complete_date']);
                                                                                        } ?>" id="medication_complete_date" name="medication_complete_date" class="form-control" required />
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <?php
                                            if ($user->data()->position != 5) {
                                            ?>
                                                <input type="submit" name="add_medications" value="Submit" class="btn btn-primary">
                                            <?php } ?>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 12) { ?>

        <?php } elseif ($_GET['id'] == 13) { ?>

        <?php } elseif ($_GET['id'] == 14) { ?>


        <?php } elseif ($_GET['id'] == 15) { ?>

        <?php } elseif ($_GET['id'] == 16) { ?>


        <?php } elseif ($_GET['id'] == 17) { ?>

        <?php } elseif ($_GET['id'] == 18) { ?>

        <?php } elseif ($_GET['id'] == 19) { ?>

        <?php } elseif ($_GET['id'] == 20) { ?>

        <?php } elseif ($_GET['id'] == 21) { ?>

        <?php } elseif ($_GET['id'] == 22) { ?>

        <?php } elseif ($_GET['id'] == 23) { ?>
        <?php } elseif ($_GET['id'] == 24) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Region Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Region Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php $regions = $override->get('regions', 'id', $_GET['region_id']); ?>
                            <!-- right column -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Region</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type region..." onkeyup="fetchData()" value="<?php if ($regions['0']['name']) {
                                                                                                                                                                                        print_r($regions['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="hidden" name="region_id" value="<?= $regions['0']['id'] ?>">
                                            <input type="submit" name="add_region" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Regions
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('regions', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $regions = $override->getWithLimit('regions', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($regions as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=24&region_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $value['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $value['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                        <input type="submit" name="delete_region" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                        <input type="submit" name="restore_region" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=24&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->


                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 25) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>District Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">District Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->get('districts', 'id', $_GET['district_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">District</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type district..." onkeyup="fetchData()" value="<?php if ($districts['0']['name']) {
                                                                                                                                                                                            print_r($districts['0']['name']);
                                                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_district" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Districts
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('districts', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $districts = $override->getWithLimit('districts', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($districts as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=25&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $value['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $value['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                        <input type="submit" name="delete_district" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                        <input type="submit" name="restore_district" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=25&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 26) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Wards Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Wards Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
                            $wards = $override->get('wards', 'id', $_GET['ward_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Ward</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="regions_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="districts_id" name="district_id" class="form-control" required <?php if ($_GET['district_id']) {
                                                                                                                                            echo 'disabled';
                                                                                                                                        } ?>>
                                                                <option value="<?= $districts[0]['id'] ?>"><?php if ($districts[0]['name']) {
                                                                                                                print_r($districts[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select District';
                                                                                                            } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type ward..." onkeyup="fetchData()" value="<?php if ($wards['0']['name']) {
                                                                                                                                                                                        print_r($wards['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_ward" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Wards
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('wards', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $ward = $override->getWithLimit('wards', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="search-results" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($ward as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                    $districts = $override->get('districts', 'id', $value['district_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $districts['name']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=26&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['district_id'] ?>&ward_id=<?= $value['id'] ?>" class="btn btn-info">Update</a> <br><br>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $value['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $value['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                        <input type="submit" name="delete_ward" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $value['id'] ?>">
                                                                        <input type="submit" name="restore_ward" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=26&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 27) { ?>
        <?php } elseif ($_GET['id'] == 27) { ?>
        <?php } elseif ($_GET['id'] == 28) { ?>

        <?php } ?>

        <?php include 'footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../../dist/js/demo.js"></script> -->
    <!-- Page specific script -->




    <!-- clients Js -->
    <script src="myjs/clients/occupation.js"></script>
    <script src="myjs/clients/informed_consent.js"></script>
    <script src="myjs/clients/religion.js"></script>


    <!-- HISTORY Js -->
    <script src="myjs/history/art_regimen.js"></script>
    <script src="myjs/history/first_line.js"></script>


    <script src="myjs/radio.js"></script>

    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            $('#regions_id').change(function() {
                var region_id = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#districts_id').html(data);
                    }
                });
            });

            $('#region').change(function() {
                var region = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });

            $('#district').change(function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "process.php?content=district_id",
                    method: "GET",
                    data: {
                        district_id: district_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#sub_county').html(data);
                    }
                });
            });

        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End


        // $("#packs_per_day, #packs_per_day").on("input", function() {
        //     setTimeout(function() {
        //         var weight = $("#packs_per_day").val();
        //         var height = $("#packs_per_day").val() / 100; // Convert cm to m
        //         var bmi = weight / (height * height);
        //         $("#packs_per_year").text(bmi.toFixed(2));
        //     }, 1);
        // });
    </script>

</body>

</html>