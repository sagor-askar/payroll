<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'company_create',
            ],
            [
                'id'    => 18,
                'title' => 'company_edit',
            ],
            [
                'id'    => 19,
                'title' => 'company_show',
            ],
            [
                'id'    => 20,
                'title' => 'company_delete',
            ],
            [
                'id'    => 21,
                'title' => 'company_access',
            ],
            [
                'id'    => 22,
                'title' => 'sub_company_create',
            ],
            [
                'id'    => 23,
                'title' => 'sub_company_edit',
            ],
            [
                'id'    => 24,
                'title' => 'sub_company_show',
            ],
            [
                'id'    => 25,
                'title' => 'sub_company_delete',
            ],
            [
                'id'    => 26,
                'title' => 'sub_company_access',
            ],
            [
                'id'    => 27,
                'title' => 'branch_create',
            ],
            [
                'id'    => 28,
                'title' => 'branch_edit',
            ],
            [
                'id'    => 29,
                'title' => 'branch_show',
            ],
            [
                'id'    => 30,
                'title' => 'branch_delete',
            ],
            [
                'id'    => 31,
                'title' => 'branch_access',
            ],
            [
                'id'    => 32,
                'title' => 'department_create',
            ],
            [
                'id'    => 33,
                'title' => 'department_edit',
            ],
            [
                'id'    => 34,
                'title' => 'department_show',
            ],
            [
                'id'    => 35,
                'title' => 'department_delete',
            ],
            [
                'id'    => 36,
                'title' => 'department_access',
            ],
            [
                'id'    => 37,
                'title' => 'designation_create',
            ],
            [
                'id'    => 38,
                'title' => 'designation_edit',
            ],
            [
                'id'    => 39,
                'title' => 'designation_show',
            ],
            [
                'id'    => 40,
                'title' => 'designation_delete',
            ],
            [
                'id'    => 41,
                'title' => 'designation_access',
            ],
            [
                'id'    => 42,
                'title' => 'grade_create',
            ],
            [
                'id'    => 43,
                'title' => 'grade_edit',
            ],
            [
                'id'    => 44,
                'title' => 'grade_show',
            ],
            [
                'id'    => 45,
                'title' => 'grade_delete',
            ],
            [
                'id'    => 46,
                'title' => 'grade_access',
            ],
            [
                'id'    => 47,
                'title' => 'rank_create',
            ],
            [
                'id'    => 48,
                'title' => 'rank_edit',
            ],
            [
                'id'    => 49,
                'title' => 'rank_show',
            ],
            [
                'id'    => 50,
                'title' => 'rank_delete',
            ],
            [
                'id'    => 51,
                'title' => 'rank_access',
            ],
            [
                'id'    => 52,
                'title' => 'employee_create',
            ],
            [
                'id'    => 53,
                'title' => 'employee_edit',
            ],
            [
                'id'    => 54,
                'title' => 'employee_show',
            ],
            [
                'id'    => 55,
                'title' => 'employee_delete',
            ],
            [
                'id'    => 56,
                'title' => 'employee_access',
            ],
            [
                'id'    => 57,
                'title' => 'attendance_create',
            ],
            [
                'id'    => 58,
                'title' => 'attendance_edit',
            ],
            [
                'id'    => 59,
                'title' => 'attendance_show',
            ],
            [
                'id'    => 60,
                'title' => 'attendance_delete',
            ],
            [
                'id'    => 61,
                'title' => 'attendance_access',
            ],
            [
                'id'    => 62,
                'title' => 'holiday_create',
            ],
            [
                'id'    => 63,
                'title' => 'holiday_edit',
            ],
            [
                'id'    => 64,
                'title' => 'holiday_show',
            ],
            [
                'id'    => 65,
                'title' => 'holiday_delete',
            ],
            [
                'id'    => 66,
                'title' => 'holiday_access',
            ],
            [
                'id'    => 67,
                'title' => 'weekly_holiday_create',
            ],
            [
                'id'    => 68,
                'title' => 'weekly_holiday_edit',
            ],
            [
                'id'    => 69,
                'title' => 'weekly_holiday_show',
            ],
            [
                'id'    => 70,
                'title' => 'weekly_holiday_delete',
            ],
            [
                'id'    => 71,
                'title' => 'weekly_holiday_access',
            ],
            [
                'id'    => 72,
                'title' => 'leave_type_create',
            ],
            [
                'id'    => 73,
                'title' => 'leave_type_edit',
            ],
            [
                'id'    => 74,
                'title' => 'leave_type_show',
            ],
            [
                'id'    => 75,
                'title' => 'leave_type_delete',
            ],
            [
                'id'    => 76,
                'title' => 'leave_type_access',
            ],
            [
                'id'    => 77,
                'title' => 'leave_application_create',
            ],
            [
                'id'    => 78,
                'title' => 'leave_application_edit',
            ],
            [
                'id'    => 79,
                'title' => 'leave_application_show',
            ],
            [
                'id'    => 80,
                'title' => 'leave_application_delete',
            ],
            [
                'id'    => 81,
                'title' => 'leave_application_access',
            ],
            [
                'id'    => 82,
                'title' => 'salary_allowance_create',
            ],
            [
                'id'    => 83,
                'title' => 'salary_allowance_edit',
            ],
            [
                'id'    => 84,
                'title' => 'salary_allowance_show',
            ],
            [
                'id'    => 85,
                'title' => 'salary_allowance_delete',
            ],
            [
                'id'    => 86,
                'title' => 'salary_allowance_access',
            ],
            [
                'id'    => 87,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 88,
                'title' => 'hrm_system_setup',
            ],
            [
                'id'    => 89,
                'title' => 'monthly_attendance_access',
            ],
            [
                'id'    => 90,
                'title' => 'rules_access',
            ],
            [
                'id'    => 91,
                'title' => 'rule_show',
            ],
            [
                'id'    => 92,
                'title' => 'rule_edit',
            ],
            [
                'id'    => 93,
                'title' => 'rule_delete',
            ],
            [
                'id'    => 94,
                'title' => 'late_and_early_closing',
            ],
            [
                'id'    => 95,
                'title' => 'missingAttendance_access',
            ],
            [
                'id'    => 96,
                'title' => 'leave_access',
            ],
            [
                'id'    => 97,
                'title' => 'late_consideration_access',
            ],
            [
                'id'    => 98,
                'title' => 'late_consideration_create',
            ],
            [
                'id'    => 99,
                'title' => 'late_consideration_show',
            ],
            [
                'id'    => 100,
                'title' => 'late_consideration_edit',
            ],
            [
                'id'    => 101,
                'title' => 'late_consideration_delete',
            ],
            [
                'id'    => 102,
                'title' => 'additional_allowance_access',
            ],
            [
                'id'    => 103,
                'title' => 'additional_allowance_setup_access',
            ],
            [
                'id'    => 104,
                'title' => 'additional_allowance_setup_create',
            ],
            [
                'id'    => 105,
                'title' => 'additional_allowance_setup_show',
            ],
            [
                'id'    => 106,
                'title' => 'additional_allowance_setup_edit',
            ],
            [
                'id'    => 107,
                'title' => 'additional_allowance_setup_delete',
            ],
            [
                'id'    => 108,
                'title' => 'additional_allowance_distribution_access',
            ],
            [
                'id'    => 109,
                'title' => 'additional_allowance_distribution_create',
            ],
            [
                'id'    => 110,
                'title' => 'additional_allowance_distribution_show',
            ],
            [
                'id'    => 111,
                'title' => 'additional_allowance_distribution_edit',
            ],
            [
                'id'    => 112,
                'title' => 'additional_allowance_distribution_delete',
            ],
            [
                'id'    => 113,
                'title' => 'additional_allowance_report_access',
            ],
            [
                'id'    => 114,
                'title' => 'additional_deduction_access',
            ],
            [
                'id'    => 115,
                'title' => 'additional_deduction_setup_access',
            ],
            [
                'id'    => 116,
                'title' => 'additional_deduction_setup_create',
            ],
            [
                'id'    => 117,
                'title' => 'additional_deduction_setup_show',
            ],
            [
                'id'    => 118,
                'title' => 'additional_deduction_setup_edit',
            ],
            [
                'id'    => 119,
                'title' => 'additional_deduction_setup_delete',
            ],
            [
                'id'    => 120,
                'title' => 'additional_deduction_distribution_access',
            ],
            [
                'id'    => 121,
                'title' => 'additional_deduction_distribution_create',
            ],
            [
                'id'    => 122,
                'title' => 'additional_deduction_distribution_show',
            ],
            [
                'id'    => 123,
                'title' => 'additional_deduction_distribution_edit',
            ],
            [
                'id'    => 124,
                'title' => 'additional_deduction_distribution_delete',
            ],
            [
                'id'    => 125,
                'title' => 'additional_deduction_report_access',
            ],
            [
                'id'    => 126,
                'title' => 'reports_access',
            ],
            [
                'id'    => 127,
                'title' => 'attendance_reports_access',
            ],
            [
                'id'    => 128,
                'title' => 'leave_reports_access',
            ],
            [
                'id'    => 129,
                'title' => 'employee_reports_access',
            ],
            [
                'id'    => 130,
                'title' => 'payroll_access',
            ],
            [
                'id'    => 131,
                'title' => 'salary_advance_access',
            ],
            [
                'id'    => 132,
                'title' => 'salary_advance_create',
            ],
            [
                'id'    => 133,
                'title' => 'salary_advance_show',
            ],
            [
                'id'    => 134,
                'title' => 'salary_advance_edit',
            ],
            [
                'id'    => 135,
                'title' => 'salary_advance_delete',
            ],
            [
                'id'    => 136,
                'title' => 'loan_access',
            ],
            [
                'id'    => 137,
                'title' => 'loan_access_create',
            ],
            [
                'id'    => 138,
                'title' => 'loan_access_show',
            ],
            [
                'id'    => 139,
                'title' => 'loan_access_edit',
            ],
            [
                'id'    => 140,
                'title' => 'loan_access_delete',
            ],
            [
                'id'    => 141,
                'title' => 'setting_access',
            ],
            [
                'id'    => 142,
                'title' => 'salary_generate_access',
            ],
            [
                'id'    => 143,
                'title' => 'salary_generate_list_access',
            ],
            [
                'id'    => 144,
                'title' => 'roster_access',
            ],
            [
                'id'    => 145,
                'title' => 'roster_create',
            ],
            [
                'id'    => 146,
                'title' => 'roster_show',
            ],
            [
                'id'    => 147,
                'title' => 'roster_edit',
            ],
            [
                'id'    => 148,
                'title' => 'roster_delete',
            ],
            [
                'id'    => 149,
                'title' => 'performance_access',
            ],
            [
                'id'    => 150,
                'title' => 'bonus_access',
            ],
            [
                'id'    => 151,
                'title' => 'increment_access',
            ],
            [
                'id'    => 152,
                'title' => 'assets_access',
            ],
            [
                'id'    => 153,
                'title' => 'procurement_access',
            ],
            [
                'id'    => 154,
                'title' => 'assets_create',
            ],
            [
                'id'    => 155,
                'title' => 'recruitments_access',
            ],
            [
                'id'    => 156,
                'title' => 'custom_question_access',
            ],
            [
                'id'    => 157,
                'title' => 'jobs_access',
            ],
            [
                'id'    => 158,
                'title' => 'candidates_access',
            ],
            [
                'id'    => 159,
                'title' => 'interview_access',
            ],
            [
                'id'    => 160,
                'title' => 'career_access',
            ],
            [
                'id'    => 161,
                'title' => 'notice_board_access',
            ],
            [
                'id'    => 162,
                'title' => 'notice_board_create',
            ],
            [
                'id'    => 163,
                'title' => 'notice_board_show',
            ],
            [
                'id'    => 164,
                'title' => 'notice_board_edit',
            ],
            [
                'id'    => 165,
                'title' => 'notice_board_delete',
            ],
            [
                'id'    => 166,
                'title' => 'attendance_approve_access',
            ],
            [
                'id'    => 167,
                'title' => 'providentfundsetting_access',
            ],
            [
                'id'    => 168,
                'title' => 'provident_fund_access',
            ],
            [
                'id'    => 169,
                'title' => 'deboarding_access',
            ],
            [
                'id'    => 170,
                'title' => 'attendance_process_access',
            ],
            [
                'id'    => 171,
                'title' => 'training_access',
            ],
            [
                'id'    => 172,
                'title' => 'trainer_access',
            ],
            [
                'id'    => 173,
                'title' => 'trainer_create',
            ],
            [
                'id'    => 174,
                'title' => 'training_type_access',
            ],
            [
                'id'    => 175,
                'title' => 'training_skill_access',
            ],
            [
                'id'    => 176,
                'title' => 'training_list_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
