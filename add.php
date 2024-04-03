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
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
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
                            'accessLevel' => $accessLevel,
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
                'firstname' => array(
                    'required' => true,
                ),
                'middlename' => array(
                    'required' => true,
                ),
                'lastname' => array(
                    'required' => true,
                ),
                'lastname' => array(
                    'required' => true,
                ),
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
                // print_r($_POST);
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
                print_r($_POST);
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
                        'risk_factors_complete' => Input::get('risk_factors_complete'),
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
                        'risk_factors_complete' => Input::get('risk_factors_complete'),
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
        } elseif (Input::get('add_classification')) {
            $validate = $validate->check($_POST, array(
                'classification_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                if (count(Input::get('category')) == 1) {
                    foreach (Input::get('category') as $value) {
                        $visit_code = '';
                        $visit_name = '';

                        if ($value == 1) {
                            $visit_code = 'M12';
                            $visit_name = 'Month 12';
                            $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 2) {
                            $visit_code = 'M12';
                            $visit_name = 'Month 12';
                            $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 3) {
                            $visit_code = 'M06';
                            $visit_name = 'Month 6';
                            $expected_date = date('Y-m-d', strtotime('+6 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 4) {
                            $visit_code = 'M03';
                            $visit_name = 'Month 3';
                            $expected_date = date('Y-m-d', strtotime('+3 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 5) {
                            $visit_code = 'RFT';
                            $visit_name = 'Referred';
                            $expected_date = date('Y-m-d', strtotime('+2 month', strtotime(Input::get('classification_date'))));
                        }
                    }

                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                    $classification = $override->get3('classification', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                    if ($classification) {
                        $user->updateRecord('classification', array(
                            'classification_date' => Input::get('classification_date'),
                            'category' => $value,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $classification[0]['id']);
                        $successMessage = 'Classification  Successful Updated';
                    } else {
                        $user->createRecord('classification', array(
                            'classification_date' => Input::get('classification_date'),
                            'visit_code' => $_GET['visit_code'],
                            'study_id' => $_GET['study_id'],
                            'sequence' => $_GET['sequence'],
                            'category' => $value,
                            'status' => 1,
                            'patient_id' => $_GET['cid'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients['site_id'],
                        ));


                        $successMessage = 'Classification  Successful Added';
                    }

                    if ($_GET['sequence'] == 1) {
                        $visit_id = $override->getNews('visit', 'patient_id', $_GET['cid'], 'sequence', 2);
                        if ($visit_id) {
                            $user->updateRecord('visit', array(
                                'expected_date' => $expected_date,
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                            ), $visit_id[0]['id']);
                        } else {
                            $user->createRecord('visit', array(
                                'expected_date' => $expected_date,
                                'visit_date' => '',
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'study_id' => $_GET['study_id'],
                                'sequence' => 2,
                                'visit_status' => 0,
                                'status' => 1,
                                'patient_id' => $_GET['cid'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients['site_id'],
                            ));
                        }
                    }

                    Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                } else {
                    $errorMessage = 'Please chose only one Classification!';
                }
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
        } elseif (Input::get('add_economic')) {
            $validate = $validate->check($_POST, array(
                'economic_date' => array(
                    'required' => true,
                ),
                'income_household' => array(
                    'required' => true,
                ),
                'income_patient' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $economic = $override->get3('economic', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($economic) {
                    $user->updateRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'income_household' => Input::get('income_household'),
                        'income_household_other' => Input::get('income_household_other'),
                        'income_patient' => Input::get('income_patient'),
                        'income_patient_other' => Input::get('income_patient_other'),
                        'monthly_earn' => Input::get('monthly_earn'),
                        'member_earn' => Input::get('member_earn'),
                        'transport' => Input::get('transport'),
                        'support_earn' => Input::get('support_earn'),
                        'food_drinks' => Input::get('food_drinks'),
                        'other_cost' => Input::get('other_cost'),
                        'days' => Input::get('days'),
                        'hours' => Input::get('hours'),
                        'registration' => Input::get('registration'),
                        'consultation' => Input::get('consultation'),
                        'diagnostic' => Input::get('diagnostic'),
                        'medications' => Input::get('medications'),
                        'other_medical_cost' => Input::get('other_medical_cost'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $economic[0]['id']);
                    $successMessage = 'Economic  Successful Updated';
                } else {
                    $user->createRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'income_household' => Input::get('income_household'),
                        'income_household_other' => Input::get('income_household_other'),
                        'income_patient' => Input::get('income_patient'),
                        'income_patient_other' => Input::get('income_patient_other'),
                        'monthly_earn' => Input::get('monthly_earn'),
                        'member_earn' => Input::get('member_earn'),
                        'transport' => Input::get('transport'),
                        'support_earn' => Input::get('support_earn'),
                        'food_drinks' => Input::get('food_drinks'),
                        'other_cost' => Input::get('other_cost'),
                        'days' => Input::get('days'),
                        'hours' => Input::get('hours'),
                        'registration' => Input::get('registration'),
                        'consultation' => Input::get('consultation'),
                        'diagnostic' => Input::get('diagnostic'),
                        'medications' => Input::get('medications'),
                        'other_medical_cost' => Input::get('other_medical_cost'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));
                    $successMessage = 'Economic  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_outcome')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'diagnosis' => array(
                    'required' => true,
                ),
                'outcome' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $outcome = $override->get3('outcome', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($outcome) {
                    $user->updateRecord('outcome', array(
                        'visit_date' => Input::get('visit_date'),
                        'diagnosis' => Input::get('diagnosis'),
                        'outcome' => Input::get('outcome'),
                        'outcome_date' => Input::get('outcome_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $outcome[0]['id']);

                    $successMessage = 'Outcome  Successful Updated';
                } else {
                    $user->createRecord('outcome', array(
                        'visit_date' => Input::get('visit_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'diagnosis' => Input::get('diagnosis'),
                        'outcome' => Input::get('outcome'),
                        'outcome_date' => Input::get('outcome_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));
                    $successMessage = 'Outcome  Successful Added';
                }
                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
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
                                                                <?php foreach ($override->getData('sites') as $site) { ?>
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

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input class="form-control" type="number" value="<?php if ($clients['age']) {
                                                                                                                    print_r($clients['age']);
                                                                                                                }  ?>" readonly />
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
                                                <div class="col-sm-3">
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
                                                            <label>Specify other religion</label>
                                                            <textarea class="form-control" name="other_religion" rows="3" placeholder="Type other here...">
                                                                <?php if ($clients['other_religion']) {
                                                                    print_r($clients['other_religion']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

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
                                                <div class="col-sm-9">
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
                                            <input type="submit" name="add_client" value="Submit" class="btn btn-primary">
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
                                                            <label class="form-check-label">3.5 If No,Please name the regimen:</label>
                                                            <textarea class="form-control" name="name_regimen" id="name_regimen" rows="2" placeholder="Type here...">
                                                                <?php if ($hiv_history_and_medication['name_regimen']) {
                                                                    print_r($hiv_history_and_medication['name_regimen']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
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
                                                            <label class="form-check-label">3.7 If yes, What was the health problem</label>
                                                            <textarea class="form-control" name="what_health_problem" id="what_health_problem" rows="2" placeholder="Type here...">
                                                                <?php if ($hiv_history_and_medication['what_health_problem']) {
                                                                    print_r($hiv_history_and_medication['what_health_problem']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-9">
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
                                                <div class="col-sm-3">
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
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_hiv_history_and_medication" value="Submit" class="btn btn-primary">
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
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit date</label>
                                                        <input type="date" value="<?php if ($eligibility['visit_date']) {
                                                                                        print_r($eligibility['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

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
                                                <div class="col-sm-3" id="participant_id">
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
                                                <div class="col-sm-3" id="screen_failure">
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
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="form_completd_by" class="form-label">Form completed by:</label>
                                                        <input type="text" value="<?php if ($eligibility['form_completd_by']) {
                                                                                        print_r($eligibility['form_completd_by']);
                                                                                    } ?>" id="form_completd_by" name="form_completd_by" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                    <span>initials</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="date_form_comptn" class="form-label">Date of form completion</label>
                                                        <input type="date" value="<?php if ($eligibility['date_form_comptn']) {
                                                                                        print_r($eligibility['date_form_comptn']);
                                                                                    } ?>" id="date_form_comptn" name="date_form_comptn" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                    <span>dd /mmm/ yyyy</span>
                                                </div>
                                                <div class="col-sm-3">
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
                                            </div>

                                            <hr>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                                <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                                <input type="submit" name="add_eligibility_form" value="Submit" class="btn btn-primary">
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
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Visit</label>
                                                        <input type="date" value="<?php if ($risk_factors) {
                                                                                        print_r($risk_factors['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
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
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">COVID 19 & TB</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-3">
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
                                                <div class="col-sm-3">
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
                                                <div class="col-sm-2">
                                                    <label>1.18 Have you ever been treated for TB?</label>
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
                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="mb-2">
                                                                <label for="date_treated_tb" class="form-label">If yes when was it?</label>
                                                                <input type="number" value="<?php if ($risk_factors['date_treated_tb']) {
                                                                                                print_r($risk_factors['date_treated_tb']);
                                                                                            } ?>" id="date_treated_tb" name="date_treated_tb" min="0" class="form-control" placeholder="Enter Year" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
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
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_risk_factors" value="Submit" class="btn btn-primary">
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
            $classification = $override->get3('classification', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($classification) { ?>
                                    <h1>Add New LUNG- RADS CLASSIFICATION</h1>
                                <?php } else { ?>
                                    <h1>Update LUNG- RADS CLASSIFICATION</h1>
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
                                    <?php if ($classification) { ?>
                                        <li class="breadcrumb-item active">Add New LUNG- RADS CLASSIFICATION</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update LUNG- RADS CLASSIFICATION</li>
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
                                        <h3 class="card-title">LUNG- RADS CLASSIFICATION</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="classification_date" class="form-label">Clasification Date</label>
                                                        <input type="date" value="<?php if ($classification) {
                                                                                        print_r($classification['classification_date']);
                                                                                    } ?>" id="classification_date" name="classification_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter classification date" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="1" <?php if ($classification['category'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 1</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 1) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="2" <?php if ($classification['category'] == 2) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 2</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 2) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="3" <?php if ($classification['category'] == 3) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 3</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 3) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="4" <?php if ($classification['category'] == 4) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 4A</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 4) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="5" <?php if ($classification['category'] == 5) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 4B</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 5) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_classification" value="Submit" class="btn btn-primary">
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
            $economic = $override->get3('economic', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($history) { ?>
                                    <h1>Add New CRF3</h1>
                                <?php } else { ?>
                                    <h1>Update CRF3</h1>
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
                                    <?php if ($history) { ?>
                                        <li class="breadcrumb-item active">Add New CRF3</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update CRF3</li>
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
                                        <h3 class="card-title">CRF3: Taarifa za kiuchumi (Wakati wa screening)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="economic" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="economic_date" class="form-label">Tarehe</label>
                                                        <input type="date" value="<?php if ($economic['economic_date']) {
                                                                                        print_r($economic['economic_date']);
                                                                                    } ?>" max="<?= date('Y-m-d'); ?>" id="economic_date" name="economic_date" class="form-control" placeholder="Enter economic date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Chanzo kikuu cha kipato cha mkuu wa kaya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household1" value="1" <?php if ($economic['income_household'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Msharaha kwa mwezi</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household2" value="2" <?php if ($economic['income_household'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Posho kwa siku</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household3" value="3" <?php if ($economic['income_household'] == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya biashara</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household4" value="4" <?php if ($economic['income_household'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya mazao au mifugo</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household5" value="5" <?php if ($economic['income_household'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Hana kipato</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household6" value="6" <?php if ($economic['income_household'] == 6) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Mstaafu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household96" value="96" <?php if ($economic['income_household'] == 96) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nyingine, Taja</label>
                                                            </div>
                                                            <textarea class="form-control" name="income_household_other" id="income_household_other" rows="2" placeholder="Type other here...">
                                                                <?php if ($economic['income_household_other']) {
                                                                    print_r($economic['income_household_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>Chanzo kikuu cha mapato cha mgonjwa?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient1" value="1" <?php if ($economic['income_patient'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Msharaha kwa mwezi</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient2" value="2" <?php if ($economic['income_patient'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Posho kwa siku</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient3" value="3" <?php if ($economic['income_patient'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya biashara</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient4" value="4" <?php if ($economic['income_patient'] == 4) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya mazao au mifugo</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient5" value="5" <?php if ($economic['income_patient'] == 5) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Hana kipato</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient6" value="6" <?php if ($economic['income_patient'] == 6) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Mstaafu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient96" value="96" <?php if ($economic['income_patient'] == 96) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Nyingine, Taja</label>
                                                            </div>
                                                            <textarea class="form-control" name="income_patient_other" id="income_patient_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($economic['income_patient_other']) {
                                                                print_r($economic['income_patient_other']);
                                                            }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="monthly_earn" class="form-label">Je, unaingiza shilingi ngapi kwa mwezi kutoka kwenye vyanzo vyako vyote vya fedha? <br> ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['monthly_earn']) {
                                                                                        print_r($economic['monthly_earn']);
                                                                                    } ?>" min="0" max="100000000" id="monthly_earn" name="monthly_earn" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="member_earn" class="form-label">Kwa mwezi, ni kiasi gani wanakaya wenzako wanaingiza kutoka kwenye vyanzo vyote vya fedha? (kwa ujumla)?<br> ( TSHS ) </label>
                                                        <input type="text" value="<?php if ($economic['member_earn']) {
                                                                                        print_r($economic['member_earn']);
                                                                                    } ?>" min="0" max="100000000" id="member_earn" name="member_earn" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="transport" class="form-label">Ulilipa kiasi gani kwa ajili ya usafiri ulipoenda hospitali kwa ajili ya kufanyiwa uchunguzi wa saratani ya mapafu? <br> ( TSHS ) </label>
                                                        <input type="text" value="<?php if ($economic['transport']) {
                                                                                        print_r($economic['transport']);
                                                                                    } ?>" min="0" max="100000000" id="transport" name="transport" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="support_earn" class="form-label">Kama ulisindikizwa, alilipa fedha kiasi gani kwa ajili ya usafiri? <br>( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['support_earn']) {
                                                                                        print_r($economic['support_earn']);
                                                                                    } ?>" min="0" max="100000000" id="support_earn" name="support_earn" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="food_drinks" class="form-label">Ulilipa fedha kiasi gani kwa ajili ya chakula na vinywaji? <br>( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['food_drinks']) {
                                                                                        print_r($economic['food_drinks']);
                                                                                    } ?>" min="0" max="100000000" id="food_drinks" name="food_drinks" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="other_cost" class="form-label">Je, kuna gharama yoyote ambayo ulilipa tofauti na hizo ulizotaja hapo, kama ndio, ni shilingi ngapi? ( TSHS ) </label>
                                                        <input type="text" value="<?php if ($economic['other_cost']) {
                                                                                        print_r($economic['other_cost']);
                                                                                    } ?>" min="0" max="100000000" id="other_cost" name="other_cost" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Je, kwa mwezi, unapoteza muda kiasi gani unapotembelea kliniki?</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="days" class="form-label">Siku</label>
                                                        <input type="text" value="<?php if ($economic['days']) {
                                                                                        print_r($economic['days']);
                                                                                    } ?>" min="0" max="100" id="days" name="days" class="form-control" placeholder="Enter days" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="hours" class="form-label">Masaa</label>
                                                        <input type="text" value="<?php if ($economic['hours']) {
                                                                                        print_r($economic['hours']);
                                                                                    } ?>" min="0" max="100" id="hours" name="hours" class="form-control" placeholder="Enter hours" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title"> Je, ulilipa gharama kiasi gani kwa huduma zifuatazo?
                                                    </h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="registration" class="form-label">Usajili <br> ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['registration']) {
                                                                                        print_r($economic['registration']);
                                                                                    } ?>" min="0" max="100000000" id="registration" name="registration" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="consultation" class="form-label">Kumuona daktari (Consultation) ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['consultation']) {
                                                                                        print_r($economic['consultation']);
                                                                                    } ?>" min="0" max="100000000" id="consultation" name="consultation" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="diagnostic" class="form-label">Vipimo (Diagnostic tests) ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['diagnostic']) {
                                                                                        print_r($economic['diagnostic']);
                                                                                    } ?>" min="0" max="100000000" id="diagnostic" name="diagnostic" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="medications" class="form-label">Dawa (Medications) <br>( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['medications']) {
                                                                                        print_r($economic['medications']);
                                                                                    } ?>" min="0" max="100000000" id="medications" name="medications" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="other_medical_cost" class="form-label">Gharama zingine za ziada kwa ajili ya matibabu (Any other direct medical costs) ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['other_medical_cost']) {
                                                                                        print_r($economic['other_medical_cost']);
                                                                                    } ?>" min="0" max="100000000" id="other_medical_cost" name="other_medical_cost" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_economic" value="Submit" class="btn btn-primary">
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
            $outcome = $override->get3('outcome', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($outcome) { ?>
                                    <h1>Add New outcome results</h1>
                                <?php } else { ?>
                                    <h1>Update outcome results</h1>
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
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New outcome results</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update outcome results</li>
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
                                        <h3 class="card-title">CRF 3: FOLLOW UP ( PATIENT OUTCOME AFTER SCREENING )</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Entry Date</label>
                                                        <input type="date" value="<?php if ($outcome) {
                                                                                        print_r($outcome['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter visit date" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Patient Diagnosis if was scored Lung- RAD 4B</label>
                                                                <textarea class="form-control" name="diagnosis" rows="3" placeholder="Type diagnosis here...">
                                                                        <?php if ($outcome['diagnosis']) {
                                                                            print_r($outcome['diagnosis']);
                                                                        }  ?>
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Outcome</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome1" value="1" <?php if ($outcome['outcome'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Await another screening</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome2" value="2" <?php if ($outcome['outcome'] == 2) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">On treatment</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome3" value="3" <?php if ($outcome['outcome'] == 3) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Recovered</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome4" value="4" <?php if ($outcome['outcome'] == 4) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Died</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome5" value="5" <?php if ($outcome['outcome'] == 5) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Unknown/Loss to follow up</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2" id="outcome_date">
                                                    <div class="mb-2">
                                                        <label for="died" id="died" class="form-label">Date of Death</label>
                                                        <label for="ltf" id="ltf" class="form-label">Date Last known to be alive</label>
                                                        <input type="date" value="<?php if ($outcome) {
                                                                                        print_r($outcome['outcome_date']);
                                                                                    } ?>" name="outcome_date" class="form-control" max="<?= date('Y-m-d') ?>" placeholder="Enter outcome date" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_outcome" value="Submit" class="btn btn-primary">
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
        <?php } elseif ($_GET['id'] == 25) { ?>
        <?php } elseif ($_GET['id'] == 26) { ?>
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
    <script src="myjs/add/clients/occupation.js"></script>
    <!--  <script src="myjs/add/clients/insurance_name.js"></script>
    <script src="myjs/add/clients/relation_patient.js"></script>
    <script src="myjs/add/clients/validate_hidden_with_values.js"></script>
    <script src="myjs/add/clients/validate_required_attribute.js"></script>
    <script src="myjs/add/clients/validate_required_radio_checkboxes.js"></script> -->



    <!-- KAP Js -->
    <!-- <script src="myjs/add/kap/dalili_saratani.js"></script>
    <script src="myjs/add/kap/kundi.js"></script>
    <script src="myjs/add/kap/matibabu.js"></script>
    <script src="myjs/add/kap/matibabu_saratani.js"></script>
    <script src="myjs/add/kap/saratani_hatari.js"></script>
    <script src="myjs/add/kap/saratani_inatibika.js"></script>
    <script src="myjs/add/kap/saratani_vipimo.js"></script>
    <script src="myjs/add/kap/uchunguzi_faida.js"></script>
    <script src="myjs/add/kap/uchunguzi_hatari.js"></script>
    <script src="myjs/add/kap/uchunguzi_maana.js"></script>
    <script src="myjs/add/kap/ushawishi.js"></script>
    <script src="myjs/add/kap/vitu_hatarishi.js"></script>
    <script src="myjs/add/kap/wapi_matibabu.js"></script> -->






    <!-- HISTORY Js -->
    <!-- <script src="myjs/add/history/currently_smoking.js"></script> -->
    <script src="myjs/add/history/art_regimen.js"></script>
    <script src="myjs/add/history/enrolled_part.js"></script>

    <!-- economics Js -->
    <!-- <script src="myjs/add/economics/household.js"></script>
    <script src="myjs/add/economics/patient.js"></script> -->

    <!-- economics Js -->
    <!-- <script src="myjs/add/outcome/outcome.js"></script> -->

    <!-- economics radio requireds Js -->
    <!-- <script src="myjs/add/economics/format_required.js/format_radio.js"></script> -->



    <!-- economics format numbers Js -->
    <!-- <script src="myjs/add/economics/format_thousands/consultation.js"></script>
    <script src="myjs/add/economics/format_thousands/days.js"></script>
    <script src="myjs/add/economics/format_thousands/diagnostic.js"></script>
    <script src="myjs/add/economics/format_thousands/food_drinks.js"></script>
    <script src="myjs/add/economics/format_thousands/hours.js"></script>
    <script src="myjs/add/economics/format_thousands/medications.js"></script>
    <script src="myjs/add/economics/format_thousands/member_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/monthly_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/other_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/other_medical_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/support_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/transport.js"></script> -->





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