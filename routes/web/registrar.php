<?php

    Route::group(['prefix' => 'registrar', 'middleware' => ['auth', 'userroles'], 'roles' => ['registrar']], function() {
        Route::get('dashboard', 'Registrar\RegistrarDashboardController@index')->name('registrar.dashboard');

        Route::group(['prefix' => 'my-account', 'middleware' => ['auth']], function() {
            Route::get('', 'Registrar\UserProfileController@view_my_profile')->name('registrar.my_account.index');
            // Route::post('change-my-password', 'Registrar\UserProfileController@change_my_password')->name('my_account.change_my_password');
            Route::post('update-profile', 'Registrar\UserProfileController@update_profile')->name('registrar.my_account.update_profile');
            Route::post('fetch-profile', 'Registrar\UserProfileController@fetch_profile')->name('registrar.my_account.fetch_profile');
            Route::post('change-my-photo', 'Registrar\UserProfileController@change_my_photo')->name('registrar.my_account.change_my_photo');
            Route::post('change-my-password', 'Registrar\UserProfileController@change_my_password')->name('registrar.my_account.change_my_password');
        });

        
        Route::group(['prefix' => 'student-grade-sheet'], function() {
            Route::get('', 'Registrar\GradeSheetController@index')->name('registrar.student_grade_sheet');
            Route::post('list-class-subject-details', 'Registrar\GradeSheetController@list_class_subject_details')->name('registrar.student_grade_sheet.list_class_subject_details');
            Route::post('list-students-by-class', 'Registrar\GradeSheetController@list_students_by_class')->name('registrar.student_grade_sheet.list_students_by_class');
        });
        
    });

    Route::group(['prefix' => 'registrar/class-details', 'middleware' => 'auth', 'roles' => ['admin', 'root', 'registrar']], function() {
        Route::get('', 'Registrar\ClassListController@index')->name('registrar.class_details');
        Route::post('', 'Registrar\ClassListController@index')->name('registrar.class_details');
        Route::post('modal-data', 'Registrar\ClassListController@modal_data')->name('registrar.class_details.modal_data');
        Route::post('save-data', 'Registrar\ClassListController@save_data')->name('registrar.class_details.save_data');
        Route::post('deactivate-data', 'Registrar\ClassListController@deactivate_data')->name('registrar.class_details.deactivate_data');
        Route::post('fetch_section-by-grade-level', 'Registrar\ClassListController@fetch_section_by_grade_level')->name('registrar.class_details.fetch_section_by_grade_level');
    });

    Route::group(['prefix' => 'registrar/class-subjects/{class_id}', 'middleware' => 'auth'], function() {
        Route::get('', 'Registrar\ClassSubjectsController@index')->name('registrar.class_subjects');
        Route::post('', 'Registrar\ClassSubjectsController@index')->name('registrar.class_subjects');
        Route::post('modal-data', 'Registrar\ClassSubjectsController@modal_data')->name('registrar.class_subjects.modal_data');
        Route::post('save-data', 'Registrar\ClassSubjectsController@save_data')->name('registrar.class_subjects.save_data');
        Route::post('deactivate-data', 'Registrar\ClassSubjectsController@deactivate_data')->name('registrar.class_subjects.deactivate_data');
    });

    Route::group(['prefix' => 'registrar/student-enrollment/{id}', 'middleware' => ['auth'], 'roles' => ['admin', 'root', 'registrar']], function() {
        Route::get('', 'Registrar\StudentEnrollmentController@index')->name('registrar.student_enrollment');
        Route::post('', 'Registrar\StudentEnrollmentController@index')->name('registrar.student_enrollment');
        Route::post('modal-data', 'Registrar\StudentEnrollmentController@modal_data')->name('registrar.student_enrollment.modal_data');
        Route::post('save-data', 'Registrar\StudentEnrollmentController@save_data')->name('registrar.student_enrollment.save_data');
        Route::post('enroll-student', 'Registrar\StudentEnrollmentController@enroll_student')->name('registrar.student_enrollment.enroll_student');
        Route::post('re-enroll-student', 'Registrar\StudentEnrollmentController@re_enroll_student')->name('registrar.student_enrollment.re_enroll_student');
        Route::post('re-enroll-student-all', 'Registrar\StudentEnrollmentController@re_enroll_student_all')->name('registrar.student_enrollment.re_enroll_student_all');
        Route::post('enrolled-student', 'Registrar\StudentEnrollmentController@fetch_enrolled_student')->name('registrar.student_enrollment.fetch_enrolled_student');
        Route::post('cancel-enroll-student', 'Registrar\StudentEnrollmentController@cancel_enroll_student')->name('registrar.student_enrollment.cancel_enroll_student');
        Route::get('print-enrolled-students', 'Registrar\StudentEnrollmentController@print_enrolled_students')->name('registrar.student_enrollment.print_enrolled_students');
    });

    Route::group(['prefix' => 'shared/faculty-class-schedule', 'middleware' => ['auth', 'userroles'], 'roles' => ['admin', 'root', 'registrar']], function() {
        Route::get('', 'Control_Panel\ClassScheduleController@index')->name('shared.faculty_class_schedules.index');
        Route::post('', 'Control_Panel\ClassScheduleController@index')->name('shared.faculty_class_schedules.index');
        Route::post('get-faculty-class-schedule', 'Control_Panel\ClassScheduleController@get_faculty_class_schedule')->name('shared.faculty_class_schedules.get_faculty_class_schedule');
        Route::get('print-handled-subject', 'Control_Panel\ClassScheduleController@print_handled_subject')->name('shared.faculty_class_schedules.print_handled_subject');
        Route::get('print-handled-subject-all', 'Control_Panel\ClassScheduleController@print_handled_subject_all')->name('shared.faculty_class_schedules.print_handled_subject_all');
    });