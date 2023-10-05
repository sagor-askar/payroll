<?php

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    return 'DONE'; //Return anything
});

use App\Http\Controllers\Admin\SalaryAllowanceController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\InterviewController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\settingController;
use App\Http\Controllers\Admin\TrainingController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }
    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::resource('terminations', 'TerminationController');
    Route::get('terminations/changeStatus/{id}', 'TerminationController@changeStatus')->name('terminations.changeStatus');

    // Company
    Route::delete('companies/destroy', 'CompanyController@massDestroy')->name('companies.massDestroy');
    Route::resource('companies', 'CompanyController');

    // Sub Company
    Route::delete('sub-companies/destroy', 'SubCompanyController@massDestroy')->name('sub-companies.massDestroy');
    Route::resource('sub-companies', 'SubCompanyController');


    // Branch
    Route::delete('branches/destroy', 'BranchController@massDestroy')->name('branches.massDestroy');
    Route::resource('branches', 'BranchController');

    // Rank
    Route::delete('shifts/destroy', 'ShiftController@massDestroy')->name('shifts.massDestroy');
    Route::resource('shifts', 'ShiftController');

    // Department
    Route::delete('departments/destroy', 'DepartmentController@massDestroy')->name('departments.massDestroy');
    Route::resource('departments', 'DepartmentController');

    // Designation
    Route::delete('designations/destroy', 'DesignationController@massDestroy')->name('designations.massDestroy');
    Route::resource('designations', 'DesignationController');

    // Grade
    Route::delete('grades/destroy', 'GradeController@massDestroy')->name('grades.massDestroy');
    Route::resource('grades', 'GradeController');

    // Rank
    Route::delete('ranks/destroy', 'RankController@massDestroy')->name('ranks.massDestroy');
    Route::resource('ranks', 'RankController');

    // Late Deduction
    Route::resource('late-deduction', 'lateDeductionController');

    // Grade
    Route::delete('grades/destroy', 'GradeController@massDestroy')->name('grades.massDestroy');
    Route::resource('jobs', 'JobController');
    Route::get('jobs/approve/{id}', 'JobController@jobApproved')->name('jobs.approve');
    Route::get('jobs/reject/{id}', 'JobController@jobReject')->name('jobs.reject');
    Route::get('jobs/cancel/{id}', 'JobController@jobCancel')->name('jobs.cancel');
    Route::get('jobs/circularActive/{id}', 'JobController@circularactive')->name('jobs.circularActive');
    Route::get('jobs/circularInActive/{id}', 'JobController@circularInactive')->name('jobs.circularInActive');
    Route::get('jobs/apply/{id}', 'JobController@jobApply')->name('jobs.apply');
    Route::post('jobs/jobApplicationStore', 'JobController@jobApplyStore')->name('jobs.jobApplyStore');

    // Panel
    Route::resource('panels', 'PanelController');

   // Candidate
    Route::resource('candidate', 'CandidateController');
    Route::get('candidate/resumeDownload/{id}', 'CandidateController@resumeDownload')->name('candidate.resumeDownload');
    Route::get('candidate/resumeOpen/{id}', 'CandidateController@resumeOpen')->name('candidate.resumeOpen');
    Route::get('candidate/coverLatterDownload/{id}', 'CandidateController@coverLatterDownload')->name('candidate.coverLatterDownload');
    Route::get('candidate/coverLatterOpen/{id}', 'CandidateController@coverLatterOpen')->name('candidate.coverLatterOpen');
    Route::get('candidate/createShortlist/{id}', 'CandidateController@createShortlist')->name('candidate.createShortlist');
    Route::get('candidate/cancel/{id}', 'CandidateController@candidateCancel')->name('candidate.cancel');

    //shortlist
    Route::resource('shortlist', 'ShortlistController');
    Route::get('shortlist/createInterview/{id}', 'ShortlistController@createInterview')->name('shortlist.createInterview');
    Route::get('shortlist/cancel/{id}', 'ShortlistController@createcancel')->name('shortlist.cancel');



    // Employee
    Route::delete('employees/destroy', 'EmployeeController@massDestroy')->name('employees.massDestroy');
    Route::post('employees/media', 'EmployeeController@storeMedia')->name('employees.storeMedia');
    Route::post('employees/ckmedia', 'EmployeeController@storeCKEditorImages')->name('employees.storeCKEditorImages');
    Route::resource('employees', 'EmployeeController');

    Route::get('employees/get_employee/department', 'EmployeeController@getSubCompanyDepartment')->name('get_employee.department');
    Route::get('employees/get_employee/gross_salary', 'EmployeeController@getEmployeeSalary')->name('get_employee.gross_salary');
    Route::get('employees/get_employee/sub_company', 'EmployeeController@getSubCompanyEmployee')->name('get_employee.sub_company');
    Route::get('employees/get_employee/department/update', 'EmployeeController@getSubCompanyDepartmentUpdate')->name('get_employee.department_edit');
    Route::get('employees/get_reporting_employee/employee', 'EmployeeController@getReportingEmployee')->name('get_reporting_employee.employee');
    Route::get('employees/get_increment_employee/employee', 'EmployeeController@getIncrementEmployee')->name('get_increment_employee.employee');
    Route::get('employees/get_advance_history/employee/', 'EmployeeController@getAdvanceHistory')->name('get_employee.advancehistory');
    Route::get('employees/get_loan_history/employee/', 'EmployeeController@getLoanHistory')->name('get_employee.loanhistory');
    Route::get('employees/get_candidate.find_job/employee/', 'EmployeeController@getCandidateJob')->name('get_candidate.find_job');

    // Attendance
    Route::delete('attendances/destroy', 'AttendanceController@massDestroy')->name('attendances.massDestroy');
    Route::resource('attendances', 'AttendanceController');
    Route::get('attendances/app', 'AttendanceController@appList')->name('admin.attendances.approve');
    Route::post('attendances/all/store/', 'AttendanceController@storeAll')->name('attendances.store_all');
    Route::post('missing/attendances/store/', 'AttendanceController@missAttenceStore')->name('miss_attendances.store');
    Route::post('late/early/attendances/search/', 'AttendanceController@lateEarlyAttendanceSearch')->name('late_early_attendances.search');

    // Roster
    Route::resource('rosters', 'RosterController');
    Route::get('file-download', 'RosterController@download')->name('rosters.download');
    Route::post('rosters/search', 'RosterController@search')->name('rosters.search');

    // custom=questions
    Route::resource('custom-questions', 'CustomQuestionController');
    Route::get('custom-questions/edit/{id}', 'CustomQuestionController@edit');
    Route::get('custom-questions/show/{id}', 'CustomQuestionController@show');

    // Checklist
    Route::resource('checklist', 'ChecklistController');
    Route::get('checklist/edit/{id}', 'ChecklistController@edit');
    Route::get('checklist/show/{id}', 'ChecklistController@show');

    // Appointment
    Route::resource('appointment', 'AppointmentController');

    // bonus
    Route::resource('bonus', 'BonusController');
    Route::post('bonus/search', 'BonusController@bonusSearch')->name('bonus.search');

    // requisition
    Route::resource('requisition', 'RequisitionController');
    Route::get('requisition/approve/{id}', 'RequisitionController@requisitionApproved')->name('requisition.approve');
    Route::get('requisition/reject/{id}', 'RequisitionController@requisitionReject')->name('requisition.reject');
    Route::get('requisition/cancel/{id}', 'RequisitionController@requisitionCancel')->name('requisition.cancel');

    // increment
    Route::resource('increment', 'IncrementController');

    // Promotion History
    Route::resource('promotion', 'PromotionController');
    Route::post('promotion/employee/search', 'PromotionController@promotionEmployeeSearch')->name('promotionEmployee.search');

    // assets
    Route::resource('assets', 'AssetsController');
    Route::post('assetsGroup/store', 'AssetsController@assetGroupStore')->name('assetGroup.store');


    // Holiday
    Route::delete('holidays/destroy', 'HolidayController@massDestroy')->name('holidays.massDestroy');
    Route::resource('holidays', 'HolidayController');


    // Weekly Holiday
    Route::delete('weekly-holidays/destroy', 'WeeklyHolidayController@massDestroy')->name('weekly-holidays.massDestroy');
    Route::resource('weekly-holidays', 'WeeklyHolidayController');

    // Leave Type
    Route::delete('leave-types/destroy', 'LeaveTypeController@massDestroy')->name('leave-types.massDestroy');
    Route::resource('leave-types', 'LeaveTypeController');
    Route::get('leave-types/get_totalleave_employee/totalleave', 'LeaveTypeController@getTotalLeaveEmployee')->name('get_totalleave_employee.totalleave');
    Route::get('leave-types/get_leftleave_employee/leftleave', 'LeaveTypeController@getLeftLeaveEmployee')->name('get_leftleave_employee.leftleave');

    // Leave Application
    Route::delete('leave-applications/destroy', 'LeaveApplicationController@massDestroy')->name('leave-applications.massDestroy');
    Route::post('leave-applications/media', 'LeaveApplicationController@storeMedia')->name('leave-applications.storeMedia');
    Route::post('leave-applications/ckmedia', 'LeaveApplicationController@storeCKEditorImages')->name('leave-applications.storeCKEditorImages');
    Route::resource('leave-applications', 'LeaveApplicationController');
    Route::get('leave-applications/approve/{id}', 'LeaveApplicationController@leaveApproved')->name('leave-applications.approve');
    Route::get('leave-applications/pdf/{id}', 'LeaveApplicationController@leaveApprovedPDF')->name('leave-applications.pdf');
    Route::get('leave-applications/reject/{id}', 'LeaveApplicationController@leaveReject')->name('leave-applications.reject');
    Route::get('leave-applications/cancel/{id}', 'LeaveApplicationController@leaveCancel')->name('leave-applications.cancel');


    // Trainer
    Route::resource('trainer', 'TrainerController');
    Route::delete('trainer/destroy', 'TrainerController@massDestroy')->name('trainer.massDestroy');
    Route::get('trainer/changeStatus/{id}', 'TrainerController@changeStatus')->name('trainer.changeStatus');

    // Training Type
    Route::resource('training_type', 'TrainingTypeController');
    Route::delete('training_type/destroy', 'TrainingTypeController@massDestroy')->name('training_type.massDestroy');
    Route::get('training_type/changeStatus/{id}', 'TrainingTypeController@changeStatus')->name('training_type.changeStatus');

    // Training Skill
    Route::resource('training_skill', 'TrainingSkillController');
    Route::delete('training_skill/destroy', 'TrainingSkillController@massDestroy')->name('training_skill.massDestroy');
    Route::get('training_skill/changeStatus/{id}', 'TrainingSkillController@changeStatus')->name('training_skill.changeStatus');

    // Training
    Route::resource('training', 'TrainingController');
    Route::delete('training/destroy', 'TrainingController@massDestroy')->name('training.massDestroy');
    Route::post('training/updateStatus/{id}', 'TrainingController@updateStatus')->name('training.updateStatus');
    Route::post('training/employeeStore', 'TrainingController@employeeStore')->name('training.employeeStore');

    // employee infomation print
    Route::get('employee-info/pdf', 'EmployeeController@employeeInformationPDF')->name('employee-info.pdf');

    // attendance approval
    Route::resource('approveattendance', 'ApproveAttendanceController');
    Route::get('approveattendance/approve/{id}', 'ApproveAttendanceController@attendanceApproved')->name('approveattendance.approve');
    Route::get('approveattendance/reject/{id}', 'ApproveAttendanceController@attendanceReject')->name('approveattendance.reject');
    Route::get('approveattendance/cancel/{id}', 'ApproveAttendanceController@attendanceCancel')->name('approveattendance.cancel');


    // attendance process
    Route::get('attendance-process', 'ApproveAttendanceController@attendanceProcessIndex')->name('attendanceProcess.index');
    Route::post('attendance-processing', 'ApproveAttendanceController@attendanceProcessing')->name('attendanceProcessing');

    // Late Consideration Setup
    Route::resource('late-consideration', 'LateConsiderationController');
    Route::get('late-consideration/approve/{id}', 'LateConsiderationController@lateApproved')->name('late-consideration.approve');
    Route::get('late-consideration/pdf/{id}', 'LateConsiderationController@lateApprovedPDF')->name('late-consideration.pdf');
    Route::get('late-consideration/reject/{id}', 'LateConsiderationController@lateReject')->name('late-consideration.reject');
    Route::get('late-consideration/cancel/{id}', 'LateConsiderationController@lateCancel')->name('late-consideration.cancel');

    // Salary Advance
    Route::resource('salary-advance', 'SalaryAdvanceController');
    Route::get('salary-advance/approve/{id}', 'SalaryAdvanceController@advanceApproved')->name('salary-advance.approve');
    Route::get('salary-advance/reject/{id}', 'SalaryAdvanceController@advanceReject')->name('salary-advance.reject');
    Route::get('salary-advance/cancel/{id}', 'SalaryAdvanceController@advanceCancel')->name('salary-advance.cancel');

    // Loan Application
    Route::resource('loan', 'LoanController');
    Route::get('loan/approve/{id}', 'LoanController@loanApproved')->name('loan.approve');
    Route::get('loan/reject/{id}', 'LoanController@loanReject')->name('loan.reject');
    Route::get('loan/cancel/{id}', 'LoanController@loanCancel')->name('loan.cancel');


    // Provident Loan
    Route::resource('provident_loan', 'ProvidentLoanController');
    Route::get('provident_loan/approve/{id}', 'ProvidentLoanController@loanApproved')->name('provident_loan.approve');
    Route::get('provident_loan/reject/{id}', 'ProvidentLoanController@loanReject')->name('provident_loan.reject');
    Route::get('loan/cancel/{id}', 'LoanController@loanCancel')->name('loan.cancel');


    // loan report
    Route::get('reports/loan_report', 'LoanController@loanReport')->name('loan_report.reports');
    Route::post('reports/loan_report/search', 'LoanController@loanReportSearch')->name('loan_report.search');

    // Training report
    Route::get('reports/training_report', 'TrainingController@trainingReport')->name('training_report.reports');
    Route::post('reports/training_report/search', 'TrainingController@trainingReportSearch')->name('training_report.search');


    // Additional allowance Setting
    Route::resource('additional-allowance', 'AdditionalAllowanceController');

    // Allowance Distribution Setting
    Route::resource('allowance-distribution', 'AllowanceDistributionController');

    // Conveyance Bill
    Route::resource('conveyance', 'ConveyanceController');
    Route::get('conveyance/pdf/{id}', 'ConveyanceController@conveyancePDF')->name('conveyance.pdf');
    Route::get('conveyance/approve/{id}', 'ConveyanceController@conveyanceApproved')->name('conveyance.approve');
    Route::get('conveyance/reject/{id}', 'ConveyanceController@conveyanceReject')->name('conveyance.reject');
    Route::get('conveyance/cancel/{id}', 'ConveyanceController@conveyanceCancel')->name('conveyance.cancel');
    Route::get('conveyance/forward/{id}', 'ConveyanceController@conveyanceForward')->name('conveyance.forward');

    // Interview
    Route::resource('interview', 'InterviewController');

    // Allowance Deduction Penalties Setting
    Route::resource('deduction-penalties', 'DeductionPenaltiesController');

    // Additional Deduction Setting
    Route::resource('additional-deduction', 'AdditionalDeductionController');

    // Salary Allowance
    Route::delete('salary-allowances/destroy', 'SalaryAllowanceController@massDestroy')->name('salary-allowances.massDestroy');
    Route::resource('salary-allowances', 'SalaryAllowanceController');

    // Rules
    Route::delete('rules/destroy', 'RuleController@massDestroy')->name('rules.massDestroy');
    Route::resource('rules', 'RuleController');
    Route::resource('rules', 'RuleController');

    // Notice Board
    Route::resource('noticeboards', 'NoticeBoardController');
    Route::get('get-notice/{notice_id}', 'NoticeBoardController@getSeenUsers');
    // Provident Fund
    Route::resource('providentfundsetting', 'ProvidentfundSettingController');
    Route::get('provident-fund', 'ProvidentfundSettingController@userProvidentFund')->name('providentfundsetting.userProvidentFund');
    Route::get('providentfundstatus/{value}/{id}', 'ProvidentfundSettingController@getStatusValue');
    Route::get('providentfundcompany/{value}/{id}', 'ProvidentfundSettingController@getCompanyValue');
    Route::get('provident-fund/history/{id}', 'ProvidentfundSettingController@providentFundHistory')->name('provident-fund.history');

});

Route::group(['namespace' => 'Admin', 'middleware' => ['auth']], function () {

    // attendance modified
    Route::get('attendances/missingAttendance', 'AttendanceController@missingAttendance')->name('missingAttendance.attendances');
    Route::get('attendances/late_and_early/', 'AttendanceController@lateAndEarlyAttendance')->name('late_and_early_closing.attendances');
    Route::get('attendances/user_attendance_details/{employee_id}/{start_date}/{end_date}', 'AttendanceController@user_attendance_details')->name('attendances.user_attendance_details');

    Route::get('attendances/monthly-manual-attendance', 'AttendanceController@monthlyAttendanceView')->name('monthly.attendances');
    Route::get('attendances/att-log-report', 'AttendanceController@attendanceLogReport')->name('attendances.logs');
    Route::post('attendances/att-log-search', 'AttendanceController@attendanceLogSearch')->name('admin.attendances.log_search');
    Route::post('attendances/setup', 'AttendanceController@attendanceSetup')->name('admin.attendances.setup');
    Route::post('missing/attendances/setup', 'AttendanceController@missingAttendanceSetup')->name('admin.missing.attendances.setup');
    // Route::get('attendances/overtime_request/', 'AttendanceController@overtimeRequest')->name('overtime_request.attendances');


    // overtime_request
    Route::resource('overtime_request', 'OvertimeRequestController');
    Route::get('overtime_request/approve/{id}', 'OvertimeRequestController@oTApproved')->name('overtime_request.approve');
    Route::get('overtime_request/reject/{id}', 'OvertimeRequestController@oTReject')->name('overtime_request.reject');
    Route::get('overtime_request/cancel/{id}', 'OvertimeRequestController@oTCancel')->name('overtime_request.cancel');

    // reports
    Route::get('reports/daily_presents', 'ReportController@dailyPresents')->name('daily_presents.reports');
    Route::get('reports/monthly_presents', 'ReportController@monthlyPresents')->name('monthly_presents.reports');
    Route::get('reports/daily_absents', 'ReportController@dailyAbsents')->name('daily_absents.reports');
    Route::get('reports/monthly_absents', 'ReportController@monthlyAbsents')->name('monthly_absents.reports');

    Route::get('reports/employee_on_leave', 'ReportController@employeeOnLeave')->name('employee_on_leave.reports');
    Route::post('employee/leave/report/search', 'ReportController@leaveReportSearch')->name('admin.employee.leave.report');
    Route::get('reports/leave_log_history', 'ReportController@leaveLogHistory')->name('leave_log_history.reports');
    Route::post('reports/leave_log_history/search/report', 'ReportController@leaveLogHistorySearch')->name('leave_log_history.search.repoer');

    Route::get('reports/demographical_report', 'ReportController@demographicalReport')->name('demographical_report.reports');
    Route::get('reports/positional_report', 'ReportController@positionalReport')->name('positional_report.reports');



    // allowance distribution report
    Route::get('report/allowance-distribution', 'AllowanceDistributionController@allowanceDistirbutionReport')->name('allowance-distribution.report');
    Route::get('report/deduction-penalties', 'DeductionPenaltiesController@deductionDistributionReport')->name('deduction-penalties.report');
    Route::post('report/allowance-distribution/search', 'AllowanceDistributionController@allowanceDistributionSearch')->name('admin.allowance-distribution.search');
    Route::post('report/deduction-penalties/report/search', 'DeductionPenaltiesController@deductionDistributionReportSearch')->name('admin.deduction-penalties.report.search');


    // software settings
    Route::get('settings/edit', 'settingController@edit')->name('edit.settings');
    Route::post('settings/store', 'settingController@store')->name('admin.settings.store');
    Route::post('settings/media', 'settingController@storeMedia')->name('admin.settings.storeMedia');

    Route::post('attendances/att-log-search', 'AttendanceController@attendanceLogSearch')->name('admin.attendances.log_search');
    Route::post('attendances/setup', 'AttendanceController@attendanceSetup')->name('admin.attendances.setup');
    Route::post('missing/attendances/setup', 'AttendanceController@missingAttendanceSetup')->name('admin.missing.attendances.setup');

    // reports
    Route::get('reports/daily_presents', 'ReportController@dailyPresents')->name('daily_presents.reports');
    Route::post('report/attendances/daily/presents', 'ReportController@daily_presents_report')->name('admin.attendances.daily.presents');
    Route::post('report/attendances/daily/absents', 'ReportController@daily_absents_report')->name('admin.attendances.daily.absents');
    Route::post('report/attendances/monthly/presents', 'ReportController@monthly_presents_report')->name('admin.monthly.attendances.report');
    Route::post('report/attendances/monthly/absents', 'ReportController@monthly_absents_report')->name('admin.monthly.absents_attendances.report');
    Route::get('report/monthly-attendance-pdf/{employee_id}/{year}/{month}', 'ReportController@monthly_attendance_pdf')->name('monthly-attendance-pdf');
    Route::get('reports/monthly_presents', 'ReportController@monthlyPresents')->name('monthly_presents.reports');
    Route::get('reports/daily_absents', 'ReportController@dailyAbsents')->name('daily_absents.reports');
    Route::get('reports/monthly_absents', 'ReportController@monthlyAbsents')->name('monthly_absents.reports');
    Route::get('reports/demographical_report', 'ReportController@demographicalReport')->name('demographical_report.reports');
    Route::get('reports/positional_report', 'ReportController@positionalReport')->name('positional_report.reports');

    // payroll
    Route::get('payroll/salary-advance', 'payrollController@salaryAdvance')->name('admin.payroll.salary-advance');
    Route::get('payroll/salary-generate-list', 'payrollController@salaryGenerateList')->name('admin.payroll.salary-generate-list');
    Route::get('payroll/salary-generate-show/{id}', 'payrollController@salaryGenerateShow')->name('admin.payroll.salary-generate.show');
    Route::get('payroll/salary-generate-pdf/{id}', 'payrollController@salaryGeneratePDF')->name('admin.payroll.salary-generate.pdf');
    Route::get('payroll/salary-generate', 'payrollController@salaryGenerate')->name('admin.payroll.salary-generate');
    Route::post('payroll/salary-generate/search', 'payrollController@salaryGenerateSearch')->name('payroll-salary-generate.search');
    Route::post('payroll/salary-generate/store', 'payrollController@salaryGenerateStore')->name('payroll-salary-generate.store');
    Route::get('payroll/salary-generate/confirm/{id}', 'payrollController@salaryGenerateConfirm')->name('payroll-salary-generate.confirm');
    Route::get('payroll/salary/payslip/{id}', 'payrollController@payslip')->name('admin.payroll.payslip');
    
    // payroll payslip
    Route::get('payroll/payslipDetails', 'payrollController@payslipDetails')->name('admin.payroll.payslipDetails');
    Route::get('payroll/salary-chart/{date}', 'payrollController@salaryChart')->name('admin.payroll.salaryChart');
    Route::get('payroll/salary-chart-pdf/{date}', 'payrollController@salaryChartPDF')->name('admin.payroll.salary-chart-pdf');
    Route::get('payroll/bank-payslip/{date}', 'payrollController@bankPayslip')->name('admin.payroll.bankPayslip');
    Route::get('payroll/bank-payslip-pdf/{date}', 'payrollController@bankPayslipPDF')->name('admin.payroll.bankPayslip-pdf');

    // notification
    Route::get('markasread/{id}', 'HolidayController@markasread')->name('markasread');
});

Route::get('admin/salary/disbersment/{salary}', [\App\Http\Controllers\Admin\EmployeeController::class, 'getSalaryDisbersments']);
Route::get('admin/salary-allowances/check_percentage/{percent}', [\App\Http\Controllers\Admin\SalaryAllowanceController::class, 'checkPercentage']);
Route::get('admin/salary-allowances/check_percentage/edit/{percent}/{hidden_percent}', [\App\Http\Controllers\Admin\SalaryAllowanceController::class, 'editCheckPercentage']);
Route::get('admin/reports/loan/loanHistory/', [\App\Http\Controllers\Admin\LoanController::class, 'getLoanHistory']);
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});

// public URL for career
Route::resource('career', 'CareerController');

