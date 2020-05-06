<?php


Route::group(['prefix' => 'admin/student-information', 'middleware' => ['auth', 'userroles'], 'roles' => ['admin', 'root', 'registrar']], function() {
    Route::get('', 'Control_Panel\StudentController@index')->name('admin.student.information');
    Route::post('', 'Control_Panel\StudentController@index')->name('admin.student.information');
    Route::post('modal-data', 'Control_Panel\StudentController@modal_data')->name('admin.student.information.modal_data');
    Route::get('modal-data', 'Control_Panel\StudentController@modal_data')->name('admin.student.information.modal_data');
    Route::post('save-data', 'Control_Panel\StudentController@save_data')->name('admin.student.information.save_data');
    Route::post('deactivate-data', 'Control_Panel\StudentController@deactivate_data')->name('admin.student.information.deactivate_data');
    Route::post('print-student-grade-modal', 'Control_Panel\StudentController@print_student_grade_modal')->name('admin.student.information.print_student_grade_modal');
    
    Route::get('print-student-grades', 'Control_Panel\StudentController@print_student_grades')->name('admin.student.information.print_student_grades');
    Route::post('change-student-photo', 'Control_Panel\StudentController@change_my_photo')->name('admin.student.change_my_photo');
});

Route::group(['prefix' => 'admin/faculty-information', 'middleware' => ['auth', 'userroles'], 'roles' => ['admin', 'root', 'registrar']], function() {
    Route::get('', 'Control_Panel\FacultyController@index')->name('admin.faculty_information');
    Route::post('', 'Control_Panel\FacultyController@index')->name('admin.faculty_information');
    Route::post('modal-data', 'Control_Panel\FacultyController@modal_data')->name('admin.faculty_information.modal_data');
    Route::post('save-data', 'Control_Panel\FacultyController@save_data')->name('admin.faculty_information.save_data');
    Route::post('deactivate-data', 'Control_Panel\FacultyController@deactivate_data')->name('admin.faculty_information.deactivate_data');
    Route::post('additional-information', 'Control_Panel\FacultyController@additional_information')->name('admin.faculty_information.additional_information');

     Route::post('e-signature', 'Control_Panel\FacultyController@change_esignature')->name('admin.faculty.e_signature');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'userroles'], 'roles' => ['admin', 'root']], function() {
    Route::get('dashboard', 'Control_Panel\DashboardController@index')->name('admin.dashboard');

    Route::group(['prefix' => 'registrar-information'], function() {
        Route::get('', 'Control_Panel\RegistrarController@index')->name('admin.registrar_information');
        Route::post('', 'Control_Panel\RegistrarController@index')->name('admin.registrar_information');
        Route::post('modal-data', 'Control_Panel\RegistrarController@modal_data')->name('admin.registrar_information.modal_data');
        Route::post('save-data', 'Control_Panel\RegistrarController@save_data')->name('admin.registrar_information.save_data');
        Route::post('deactivate-data', 'Control_Panel\RegistrarController@deactivate_data')->name('admin.registrar_information.deactivate_data');
    });

    Route::group(['prefix' => 'finance-information'], function() {
        Route::get('', 'Control_Panel\FinanceController@index')->name('admin.finance_information');
        Route::post('', 'Control_Panel\FinanceController@index')->name('admin.finance_information');
        Route::post('modal-data', 'Control_Panel\FinanceController@modal_data')->name('admin.finance_information.modal_data');
        Route::post('save-data', 'Control_Panel\FinanceController@save_data')->name('admin.finance_information.save_data');
        Route::post('deactivate-data', 'Control_Panel\FinanceController@deactivate_data')->name('admin.finance_information.deactivate_data');
     });
    
    Route::group(['prefix' => 'transcript-of-record-archieve'], function() {
        Route::get('', 'Control_Panel\TranscriptArchiveController@index')->name('admin.transcript_archieve');
        Route::post('', 'Control_Panel\TranscriptArchiveController@index')->name('admin.transcript_archieve');
        Route::post('modal-data', 'Control_Panel\TranscriptArchiveController@modal_data')->name('admin.transcript_archieve.modal_data');
        Route::post('save-transcript', 'Control_Panel\TranscriptArchiveController@save_transcript')->name('admin.transcript_archieve.save_transcript');
        Route::post('delete-data', 'Control_Panel\TranscriptArchiveController@delete_data')->name('admin.transcript_archieve.delete_data');
        Route::post('download-tor', 'Control_Panel\TranscriptArchiveController@download_tor')->name('admin.transcript_archieve.download_tor');
    });
    
    Route::group(['prefix' => 'articles'], function() {
        Route::get('', 'Control_Panel\ArticlesController@index')->name('admin.articles');
        Route::post('', 'Control_Panel\ArticlesController@index')->name('admin.articles');
        Route::post('modal-data', 'Control_Panel\ArticlesController@modal_data')->name('admin.articles.modal_data');
        Route::post('save-data', 'Control_Panel\ArticlesController@save_data')->name('admin.articles.save_data');
    });
    
    Route::group(['prefix' => 'maintenance'], function() {
        Route::group(['prefix' => 'school-year'], function() {
            Route::get('', 'Control_Panel\Maintenance\SchoolYearController@index')->name('admin.maintenance.school_year');
            Route::post('', 'Control_Panel\Maintenance\SchoolYearController@index')->name('admin.maintenance.school_year');
            Route::post('modal-data', 'Control_Panel\Maintenance\SchoolYearController@modal_data')->name('admin.maintenance.school_year.modal_data');
            Route::post('save-data', 'Control_Panel\Maintenance\SchoolYearController@save_data')->name('admin.maintenance.school_year.save_data');
            Route::post('deactivate-data', 'Control_Panel\Maintenance\SchoolYearController@deactivate_data')->name('admin.maintenance.school_year.deactivate_data');
            Route::post('toggle-current-sy', 'Control_Panel\Maintenance\SchoolYearController@toggle_current_sy')->name('admin.maintenance.school_year.toggle_current_sy');
        });

        Route::group(['prefix' => 'semester'], function () {
            Route::get('', 'Control_Panel\Maintenance\SemesterController@index')->name('admin.maintenance.semester');
            Route::post('', 'Control_Panel\Maintenance\SemesterController@index')->name('admin.maintenance.semester');
            Route::post('toggle-current-sy', 'Control_Panel\Maintenance\SemesterController@toggle_current_sy')->name('admin.maintenance.semester.toggle_current_sy');
        });

        Route::group(['prefix' => 'subjects'], function() {
            Route::get('', 'Control_Panel\Maintenance\SubjectController@index')->name('admin.maintenance.subjects');
            Route::post('', 'Control_Panel\Maintenance\SubjectController@index')->name('admin.maintenance.subjects');
            Route::post('modal-data', 'Control_Panel\Maintenance\SubjectController@modal_data')->name('admin.maintenance.subjects.modal_data');
            Route::post('save-data', 'Control_Panel\Maintenance\SubjectController@save_data')->name('admin.maintenance.subjects.save_data');
            Route::post('deactivate-data', 'Control_Panel\Maintenance\SubjectController@deactivate_data')->name('admin.maintenance.subjects.deactivate_data');
        });
        
        Route::group(['prefix' => 'class-rooms'], function() {
            Route::get('', 'Control_Panel\Maintenance\RoomController@index')->name('admin.maintenance.classrooms');
            Route::post('', 'Control_Panel\Maintenance\RoomController@index')->name('admin.maintenance.classrooms');
            Route::post('modal-data', 'Control_Panel\Maintenance\RoomController@modal_data')->name('admin.maintenance.classrooms.modal_data');
            Route::post('save-data', 'Control_Panel\Maintenance\RoomController@save_data')->name('admin.maintenance.classrooms.save_data');
            Route::post('deactivate-data', 'Control_Panel\Maintenance\RoomController@deactivate_data')->name('admin.maintenance.classrooms.deactivate_data');
        });

        Route::group(['prefix' => 'section-details'], function() {
            Route::get('', 'Control_Panel\Maintenance\SectionController@index')->name('admin.maintenance.section_details');
            Route::post('', 'Control_Panel\Maintenance\SectionController@index')->name('admin.maintenance.section_details');
            Route::post('modal-data', 'Control_Panel\Maintenance\SectionController@modal_data')->name('admin.maintenance.section_details.modal_data');
            Route::post('save-data', 'Control_Panel\Maintenance\SectionController@save_data')->name('admin.maintenance.section_details.save_data');
            Route::post('deactivate-data', 'Control_Panel\Maintenance\SectionController@deactivate_data')->name('admin.maintenance.section_details.deactivate_data');
        });

        Route::group(['prefix' => 'date-remarks'], function () {
            Route::get('', 'Control_Panel\Maintenance\DateRemarkController@index')->name('admin.maintenance.date_remarks_for_class_card');
            Route::post('', 'Control_Panel\Maintenance\DateRemarkController@index')->name('admin.maintenance.date_remarks_for_class_card');
            Route::post('save-data', 'Control_Panel\Maintenance\DateRemarkController@save_data')->name('admin.maintenance.date_remarks_for_class.save_data');
            Route::post('modal-data', 'Control_Panel\Maintenance\DateRemarkController@modal_data')->name('admin.maintenance.date_remarks_for_class.modal_data');
        });

        Route::group(['prefix' => 'strand'], function () {
            Route::get('', 'Control_Panel\Maintenance\StrandController@index')->name('admin.maintenance.strand');
            Route::post('', 'Control_Panel\Maintenance\StrandController@index')->name('admin.maintenance.strand');
            Route::post('modal-data', 'Control_Panel\Maintenance\StrandController@modal_data')->name('admin.maintenance.strand.modal_data');
            Route::post('save-data', 'Control_Panel\Maintenance\StrandController@save_data')->name('admin.maintenance.strand.save_data');
        });
    });
    
    Route::group(['prefix' => 'my-account', 'middleware' => ['auth']], function() {
        Route::get('', 'Control_Panel\UserProfileController@view_my_profile')->name('my_account.index');
        // Route::post('change-my-password', 'Control_Panel\UserProfileController@change_my_password')->name('my_account.change_my_password');
        Route::post('update-profile', 'Control_Panel\UserProfileController@update_profile')->name('my_account.update_profile');
        Route::post('fetch-profile', 'Control_Panel\UserProfileController@fetch_profile')->name('my_account.fetch_profile');
        Route::post('change-my-photo', 'Control_Panel\UserProfileController@change_my_photo')->name('my_account.change_my_photo');
        Route::post('change-my-password', 'Control_Panel\UserProfileController@change_my_password')->name('my_account.change_my_password');
    });
    

});