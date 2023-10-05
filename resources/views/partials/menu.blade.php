<aside class="main-sidebar">
    <section class="sidebar" style="height: auto;">
        <ul class="sidebar-menu tree" data-widget="tree">
            <li>
                <a href="{{ route("admin.home") }}">
                    <i class="fas fa-fw fa-tachometer-alt">

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            @can('user_management_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">

                        </i>
                        <span>{{ trans('cruds.userManagement.title') }}</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('permission_access')
                            <li class="{{ request()->is("admin/permissions") || request()->is("admin/permissions/*") ? "active" : "" }}">
                                <a href="{{ route("admin.permissions.index") }}">
                                    <i class="fa-fw fas fa-unlock-alt">

                                    </i>
                                    <span>{{ trans('cruds.permission.title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="{{ request()->is("admin/roles") || request()->is("admin/roles/*") ? "active" : "" }}">
                                <a href="{{ route("admin.roles.index") }}">
                                    <i class="fa-fw fas fa-briefcase">

                                    </i>
                                    <span>{{ trans('cruds.role.title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="{{ request()->is("admin/users") || request()->is("admin/users/*") ? "active" : "" }}">
                                <a href="{{ route("admin.users.index") }}">
                                    <i class="fa-fw fas fa-user">

                                    </i>
                                    <span>{{ trans('cruds.user.title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('deboarding_access')
                            <li class="{{ request()->is("admin/terminations") || request()->is("admin/terminations/*") ? "active" : "" }}">
                                <a href="{{ route("admin.terminations.index") }}">
                                    <i class="fa-fw fas fa-user">

                                    </i>
                                    <span>User Deboarding</span>

                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan
        @can('employee_access')
                <li class="{{ request()->is("admin/employees") || request()->is("admin/employees/*") ? "active" : "" }}">
                    <a href="{{ route("admin.employees.index") }}">
                        <i class="fa-fw fas fa-cogs">

                        </i>
                        <span>{{ trans('cruds.employee.title') }}</span>

                    </a>
                </li>
            @endcan

            @can('attendance_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-users">

                        </i>
                        <span>Attendance</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('attendance_access')
                        <li class="{{ request()->is("admin/attendances") || request()->is("admin/attendances/*") ? "active" : "" }}">
                            <a href="{{ route("admin.attendances.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Attendance Form</span>

                            </a>
                        </li>
                        @endcan
                        @can('attendance_approve_access')
                        <li class="{{ request()->is("admin/approveattendance") || request()->is("admin/approveattendance/*") ? "active" : "" }}">
                            <a href="{{ route('admin.approveattendance.index') }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Approve Attendance</span>

                            </a>
                        </li>
                        @endcan
                        @can('attendance_process_access')
                        <li class="{{ request()->is("admin/attendance-process") || request()->is("admin/attendance-process/*") ? "active" : "" }}">
                            <a href="{{ route('admin.attendanceProcess.index') }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Attendance Process</span>

                            </a>
                        </li>
                        @endcan
                        @can('monthly_attendance_access')
                        <li class="{{ request()->is("attendances/monthly-manual-attendance") || request()->is("attendances/setup") ? "active" : "" }}">
                            <a href="{{ route("monthly.attendances") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Monthly Attendance</span>

                            </a>
                        </li>
                        @endcan

                        @can('missingAttendance_access')
                        <li class="{{ request()->is("attendances/missingAttendance") || request()->is("missing/attendances/setup") ? "active" : "" }}">
                            <a href="{{ route("missingAttendance.attendances") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Missing Attendance</span>

                            </a>
                        </li>
                        @endcan

                        @can('late_and_early_closing')
                        <li class="{{ request()->is("attendances/late_and_early") || request()->is("admin/late/early/attendances/search") ? "active" : "" }}">
                            <a href="{{ route("late_and_early_closing.attendances") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Lateness and early closing</span>
                            </a>
                        </li>
                        @endcan
                        @can('attendance_access')
                        <li class="{{ request()->is("attendances/att-log-report") || request()->is("attendances/att-log-search") || request()->is("attendances/user_attendance_details/*") ? "active" : "" }}">
                            <a href="{{ route("attendances.logs") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Attendance Log</span>

                            </a>
                        </li>
                        @endcan

                        <li class="{{ request()->is("overtime_request") || request()->is("overtime_request/*") ? "active" : "" }}">
                            <a href="{{ route("overtime_request.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Overtime Request</span>

                            </a>
                        </li>
                        @can('roster_access')
                            <li class="{{ request()->is("admin/rosters") || request()->is("admin/rosters/*") ? "active" : "" }}">
                                <a href="{{ route("admin.rosters.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>Roster Upload</span>

                                </a>
                            </li>
                        @endcan



                    </ul>
                </li>
            @endcan

            @can('late_consideration_access')
              <!-- Late Consideration -->
            <li class="{{ request()->is("admin/late-consideration") || request()->is("admin/late-consideration/*") ? "active" : "" }}">
                <a href="{{ route('admin.late-consideration.index') }}">
                    <i class="fa fa-adjust">
                    </i>
                    Late Consideration
                </a>
            </li>

            @endcan

            @can('leave_access')
                <li class="treeview">
                    <a href="#">
                        <i class="fa-fw fas fa-sign-out-alt">
                        </i>
                        <span>Leave</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('holiday_access')
                            <li class="{{ request()->is("admin/holidays") || request()->is("admin/holidays/*") ? "active" : "" }}">
                                <a href="{{ route("admin.holidays.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>{{ trans('cruds.holiday.title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('weekly_holiday_access')
                            <li class="{{ request()->is("admin/weekly-holidays") || request()->is("admin/weekly-holidays/*") ? "active" : "" }}">
                                <a href="{{ route("admin.weekly-holidays.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>{{ trans('cruds.weeklyHoliday.title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('leave_type_access')
                            <li class="{{ request()->is("admin/leave-types") || request()->is("admin/leave-types/*") ? "active" : "" }}">
                                <a href="{{ route("admin.leave-types.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>{{ trans('cruds.leaveType.title') }}</span>

                                </a>
                            </li>
                        @endcan
                        @can('leave_application_access')
                            <li class="{{ request()->is("admin/leave-applications") || request()->is("admin/leave-applications/*") ? "active" : "" }}">
                                <a href="{{ route("admin.leave-applications.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>{{ trans('cruds.leaveApplication.title') }}</span>

                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan


            <!-- Allowance Setups -->
            @can('additional_allowance_access')
            <li class="treeview">
                <a href="">
                    <i class="fa fa-check" aria-hidden="true">
                    </i>
                    <span>Additional Allowance</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        @can('additional_allowance_setup_access')
                        <li class="{{ request()->is("admin/additional-allowance") || request()->is("admin/additional-allowance/*") ? "active" : "" }}">
                            <a href="{{ route("admin.additional-allowance.index") }}">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>Allowance Setup</span>
                            </a>
                        </li>
                        @endcan
                        @can('additional_allowance_distribution_access')
                        <li class="{{ request()->is("admin/allowance-distribution") || request()->is("admin/allowance-distribution/*") ? "active" : "" }}">
                            <a href="{{ route("admin.allowance-distribution.index") }}">
                                <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                <span>Allowance Distribution</span>
                            </a>
                        </li>
                        @endcan
                        @can('additional_allowance_report_access')
                        <li class="{{ request()->is("report/allowance-distribution") || request()->is("report/allowance-distribution/*") ? "active" : "" }}">
                            <a href="{{ route("allowance-distribution.report") }}">
                                <i class="fa fa-file-text-o" aria-hidden="true">
                                </i>
                                <span>Allowance Reports</span>
                            </a>
                        </li>
                        @endcan

                    </li>
                </ul>
            </li>
            @endcan


            <!-- Deduction Setups -->
            @can('additional_deduction_access')
            <li class="treeview">
                <a href="">
                    <i class="fa fa-calculator" aria-hidden="true">
                    </i>
                    <span>Additional Deduction</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li class="treeview">
                        @can('additional_deduction_setup_access')
                        <li class="{{ request()->is("admin/additional-deduction") || request()->is("admin/additional-deduction/*") ? "active" : "" }}">
                            <a href="{{ route("admin.additional-deduction.index") }}">
                                <i class="fa fa-tasks" aria-hidden="true"></i>
                                <span>Deduction Setup</span>
                            </a>
                        </li>
                        @endcan
                        @can('additional_deduction_distribution_access')
                        <li class="{{ request()->is("admin/deduction-penalties") || request()->is("admin/deduction-penalties/*") ? "active" : "" }}">
                            <a href="{{ route("admin.deduction-penalties.index") }}">
                                <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                <span>Deduction Distribution</span>
                            </a>
                        </li>
                        @endcan
                        @can('additional_deduction_report_access')
                        <li class="{{ request()->is("report/deduction-penalties") || request()->is("report/deduction-penalties/*") ? "active" : "" }}">
                            <a href="{{ route("deduction-penalties.report") }}">
                                <i class="fa fa-file-text-o" aria-hidden="true">
                                </i>
                                <span>Deduction Reports</span>
                            </a>
                        </li>
                        @endcan
                    </li>
                </ul>
            </li>
            @endcan

               <!-- payroll -->
               @can('payroll_access')
               <li class="treeview">
                   <a href="#">
                       <i class="fa fa-credit-card">

                       </i>
                       <span>Payroll</span>
                       <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                   </a>
                   <ul class="treeview-menu">
                           <li class="{{ request()->is("payroll/salary-advance") || request()->is("admin/payroll/*") ? "active" : "" }}">
                               <a href="{{ route("admin.payroll.salary-advance") }}">

                                   {{-- <span>Salary Advance Test</span> --}}

                               </a>
                           </li>
                       @can('salary_advance_access')
                       <li class="{{ request()->is("admin/salary-advance") || request()->is("admin/salary-advance/*") ? "active" : "" }}">
                           <a href="{{ route("admin.salary-advance.index") }}">
                               <i class="fa fa-money">
                               </i>
                               <span>Salary Advance</span>
                           </a>
                       </li>
                       @endcan

                       @can('loan_access')
                       <li class="{{ request()->is("admin/loan") || request()->is("admin/loan/*") ? "active" : "" }}">
                           <a href="{{ route("admin.loan.index") }}">
                               <i class="fa fa-money">
                               </i>
                               <span>Loan Application</span>
                           </a>
                       </li>
                       @endcan

                       @can('salary_generate_access')
                       <li class="{{ request()->is("payroll/salary-generate") || request()->is("admin/payroll/*") ? "active" : "" }}">
                           <a href="{{ route("admin.payroll.salary-generate") }}">
                               <i class="fa fa-money">
                               </i>
                               <span>Salary Generate</span>
                           </a>
                       </li>
                       @endcan

                       @can('salary_generate_list_access')
                       <li class="{{ request()->is("payroll/salary-generate-list") || request()->is("admin/payroll/*") ? "active" : "" }}">
                           <a href="{{ route("admin.payroll.salary-generate-list") }}">
                               <i class="fa fa-money">

                               </i>
                               <span>Salary Generate List</span>

                           </a>
                       </li>
                       @endcan

                       
                       <li class="{{ request()->is("payroll/payslipDetails") || request()->is("admin/payroll/*") ? "active" : "" }}">
                           <a href="{{ route("admin.payroll.payslipDetails") }}">
                               <i class="fa fa-money">

                               </i>
                               <span>Salary Generate List 2</span>

                           </a>
                       </li>
                       
                       <!-- conveyance bill -->
                       <li class="{{ request()->is("admin/conveyance") || request()->is("admin/conveyance/*") ? "active" : "" }}">
                            <a href="{{ route("admin.conveyance.index") }}">
                                <i class="fa-fw fas fa-users">
                                </i>
                            <span>Conveyance Bill</span>
                            </a>
                        </li>

                   </ul>
            </li>
            @endcan





            <!-- Provident Fund -->
            @php
             $providentFundActive =   \App\Models\ProvidentfundSetting::where('status',1)->first();
            @endphp
            @if($providentFundActive)
            <li class="treeview">
                <a href="#">
                    <i class="fa-fw fas fa-users">

                    </i>
                    <span>Provident Fund</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('provident_fund_access')
                        <li class="{{ request()->is("providentfundsetting") || request()->is("admin/providentfundsetting/*") ? "active" : "" }}">
                            <a href="{{ route("admin.providentfundsetting.userProvidentFund") }}">
                                <i class="fa fa-money">

                                </i>
                                <span>Provident Fund</span>

                            </a>
                        </li>
                    @endcan

                    <li class="{{ request()->is("providentfundsetting") || request()->is("admin/providentfundsetting/*") ? "active" : "" }}">
                        <a href="{{ route("admin.provident_loan.index") }}">
                            <i class="fa fa-money">

                            </i>
                            <span>Provident Loan</span>

                        </a>
                    </li>
                </ul>
            </li>
            @endif



            <!-- recruitment process -->
            @can('recruitments_access')
            <li class="treeview">
                <a href="">
                    <i class="fa fa-tasks">
                    </i>
                    <span>Recruitments</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('custom_question_access')
                    <li class="{{ request()->is("admin/custom-questions") ? "active" : "" }}">
                        <a href="{{ route("admin.custom-questions.index") }}">
                            <i class='fas fa-arrow-circle-right'></i>
                            <span>Custom Questions</span>
                        </a>
                    </li>
                    @endcan
                    @can('jobs_access')
                    <li class="{{ request()->is("admin/jobs") || request()->is("admin/jobs/*") ? "active" : "" }}">
                        <a href="{{ route("admin.jobs.index") }}">
                            <i class='fas fa-arrow-circle-right'></i>
                            <span>Jobs</span>
                        </a>
                    </li>
                    @endcan
                    <!-- panel -->
                    <li class="{{ request()->is("admin/panels") || request()->is("admin/panels/*") ? "active" : "" }}">
                        <a href="{{ route("admin.panels.index") }}">
                            <i class='fas fa-arrow-circle-right'></i>
                            <span>Panels</span>
                        </a>
                    </li>
                    <!-- panel ends-->
                    @can('candidates_access')
                    <li class="treeview">
                        <a href="" >
                            <i class='fas fa-arrow-circle-right'></i>
                            <span>Candidates</span>
                            <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-left"></i></span>
                        </a>

                        <ul class="treeview-menu">
                            <li class="{{ request()->is("admin/candidate") || request()->is("admin/candidate/*") ? "active" : "" }}">
                                <a href="{{ route("admin.candidate.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>Manage Candidates</span>
                                </a>
                            </li>

                            <li class="{{ request()->is("admin/shortlist") || request()->is("admin/shortlist/*") ? "active" : "" }}">
                                <a href="{{ route("admin.shortlist.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>Short List</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endcan
                    @can('interview_access')
                    <li class="{{ request()->is("admin/interview") || request()->is("admin/interview/*") ? "active" : "" }}">
                        <a href="{{ route("admin.interview.index") }}">
                            <i class='fas fa-arrow-circle-right'></i>
                            </i>
                        <span>Interview</span>
                        </a>
                    </li>
                    @endcan

                   @can('candidate_selection_access')
                   <li class="treeview">
                        <a href="" >
                            <i class='fas fa-arrow-circle-right'></i>
                            <span>Candidate Selection</span>
                            <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-left"></i></span>
                        </a>

                        <ul class="treeview-menu">
                            <li class="">
                                <a href="">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>Prerequisites</span>
                                </a>
                            </li>

                            <li class="">
                                <a href="">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>Confirmation</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                   @endcan


                        <li class="{{ request()->is("admin/checklist") || request()->is("admin/checklist/*") ? "active" : "" }}">
                            <a href="{{ route("admin.checklist.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                </i>
                                <span>Appointment Checklist</span>
                            </a>
                        </li>

                        <li class="{{ request()->is("admin/appointment") || request()->is("admin/appointment/*") ? "active" : "" }}">
                            <a href="{{ route("admin.appointment.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                </i>
                                <span>Appointment</span>
                            </a>
                        </li>




                   @can('career_access')
                   <li class="{{ request()->is("/career") || request()->is("career/*") ? "active" : "" }}">
                        <a href="{{ route("career.index") }}" target="_blank">
                            <i class="fas fa-arrow-circle-right" aria-hidden="true">
                            </i>
                        <span>Career</span>
                        </a>
                    </li>
                   @endcan
                </ul>
            </li>
            @endcan

        {{-- training  --}}
            @can('training_access')
            <li class="treeview">
                <a href="">
                    <i class="fa fa-tasks">
                    </i>
                    <span>Training</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                        @can('trainer_access')
                        <li class="{{ request()->is("admin/trainer") || request()->is("admin/trainer/*") ? "active" : "" }}">
                            <a href="{{ route("admin.trainer.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span> Trainer</span>
                            </a>
                        </li>
                        @endcan
                        @can('training_type_access')
                        <li class="{{ request()->is("admin/training_type") || request()->is("admin/training_type/*") ? "active" : "" }}">
                            <a href="{{ route("admin.training_type.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span> Training Type</span>
                            </a>
                        </li>
                        @endcan
                        @can('training_skill_access')
                        <li class="{{ request()->is("admin/training_skill") || request()->is("admin/training_skill/*") ? "active" : "" }}">
                            <a href="{{ route("admin.training_skill.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span> Training Skill</span>
                            </a>
                        </li> 
                        @endcan
                        @can('training_list_access')
                        <li class="{{ request()->is("admin/training") || request()->is("admin/training/*") ? "active" : "" }}">
                            <a href="{{ route("admin.training.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span> Training List</span>
                            </a>
                        </li>
                        @endcan

                </ul>
            </li>
            @endcan       

            @can('performance_access')
                <!-- performance evaluation -->
                <li class="treeview">
                    <a href="">
                        <i class="fa-fw fas fa-users">
                        </i>
                        <span>Performance</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('bonus_access')
                            <li class="{{ request()->is("admin/bonus") || request()->is("admin/bonus/*") ? "active" : "" }}">
                                <a href="{{ route("admin.bonus.index") }}">
                                    <i class='fas fa-arrow-circle-right'></i>
                                    <span>Bonus</span>
                                </a>
                            </li>
                        @endcan
                        @can('increment_access')
                        <li class="{{ request()->is("admin/increment") || request()->is("admin/increment/*") ? "active" : "" }}">
                            <a href="{{ route("admin.increment.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Increment</span>
                            </a>
                        </li>
                        @endcan

                        <li class="{{ request()->is("admin/promotion") || request()->is("admin/promotion/*") ? "active" : "" }}">
                            <a href="{{ route("admin.promotion.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>Promotion</span>
                            </a>
                        </li>

                    </ul>
                </li>
            @endcan
            @can('assets_access')
            <li class="{{ request()->is("admin/assets") || request()->is("admin/assets/*") ? "active" : "" }}">
                <a href="{{ route('admin.assets.index') }}">
                    <i class="fa fa-adjust">
                    </i>
                    Assets
                </a>
            </li>
            @endcan
           <!-- procurement -->
           @can('procurement_access')
           <li class="treeview">
                    <a href="#">
                        <i class="fa fa-credit-card">

                        </i>
                        <span>Procurement</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                            <li class="{{ request()->is("admin/requisition") || request()->is("admin/requisition/*") ? "active" : "" }}">
                                <a href="{{ route("admin.requisition.index") }}">
                                    <i class="fa-fw fas fa-users">
                                    </i>
                                <span>Requisition</span>
                                </a>
                            </li>
                    </ul>
            </li>
           @endcan
           @can('notice_board_access')
           <li class="treeview">
                    <a href="#">
                        <i class="fa fa-credit-card">

                        </i>
                        <span>Notice Board</span>
                        <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                            <li class="{{ request()->is("admin/noticeboards") || request()->is("admin/noticeboards/*") ? "active" : "" }}">
                                <a href="{{ route("admin.noticeboards.index") }}">
                                    <i class="fa-fw fas fa-users">
                                    </i>
                                <span>Notice Board</span>
                                </a>
                            </li>
                    </ul>
            </li>
           @endcan
             <!-- reports -->
             @can('reports_access')
             <li class="treeview">
                 <a href="">
                     <i class="fa fa-file">
                     </i>
                     <span>Reports</span>
                     <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                 </a>
                 <ul class="treeview-menu">
                     @can('attendance_reports_access')
                     <li class="treeview">
                         <a href="">
                             <i class='fas fa-arrow-circle-right'></i>
                             <span>Attendance Report</span>
                             <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-left"></i></span>
                         </a>

                         <ul class="treeview-menu">
                             <li class="{{ request()->is("reports/daily_presents") ? "active" : "" }}">
                                 <a href="{{ route("daily_presents.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Daily Presents</span>
                                 </a>
                             </li>

                             <li class="{{ request()->is("reports/monthly_presents ") ? "active" : "" }}">
                                 <a href="{{ route("monthly_presents.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Monthly Presents</span>
                                 </a>
                             </li>

                             <li class="{{ request()->is("reports/daily_absents") ? "active" : "" }}">
                                 <a href="{{ route("daily_absents.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Daily Absents</span>
                                 </a>
                             </li>

                             <li class="{{ request()->is("reports/monthly_absents") ? "active" : "" }}">
                                 <a href="{{ route("monthly_absents.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Monthly Absents</span>
                                 </a>
                             </li>

                         </ul>
                     </li>
                     @endcan

                     @can('leave_reports_access')
                     <li class="treeview">
                         <a href="" >
                             <i class='fas fa-arrow-circle-right'></i>
                             <span>Leave Report</span>
                             <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-left"></i></span>
                         </a>

                         <ul class="treeview-menu">
                             <li class="{{ request()->is("reports/employee_on_leave") ? "active" : "" }}">
                                 <a href="{{ route("employee_on_leave.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Employee on leave</span>
                                 </a>
                             </li>

                             <li class="{{ request()->is("reports/leave_log_history") || request()->is("reports/leave_log_history/*") ? "active" : "" }}">
                                 <a href="{{ route("leave_log_history.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Leave Log History</span>
                                 </a>
                             </li>

                         </ul>
                     </li>
                     @endcan

                     @can('employee_reports_access')
                     <!-- <li class="treeview">
                         <a href="">
                             <i class='fas fa-arrow-circle-right'></i>
                             <span>Employee Reports</span>
                             <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-left"></i></span>
                         </a>
                         <ul class="treeview-menu">
                             <li class="{{ request()->is("reports/demographical_report") ? "active" : "" }}">
                                 <a href="{{ route("demographical_report.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Demoghraphic Report</span>
                                 </a>
                             </li>
                             <li class="{{ request()->is("reports/positional_report") ? "active" : "" }}">
                                 <a href="{{ route("positional_report.reports") }}">
                                     <i class='fas fa-arrow-circle-right'></i>
                                     <span>Positional Report</span>
                                 </a>
                             </li>
                         </ul>
                     </li> -->
                     <li class="{{ request()->is("admin/reports/loan_report") ? "active" : "" }}">
                         <a href="{{ route("admin.loan_report.reports") }}">
                             <i class='fas fa-arrow-circle-right'></i>
                             <span>Loan Report</span>
                         </a>
                     </li>
                     @endcan

                         <li class="{{ request()->is("admin/reports/loan_report") ? "active" : "" }}">
                             <a href="{{ route("admin.training_report.reports") }}">
                                 <i class='fas fa-arrow-circle-right'></i>
                                 <span>Training Report</span>
                             </a>
                         </li>

                 </ul>
             </li>
             @endcan

            {{-- HRM SYSTEM SETUP START  --}}
            @can('hrm_system_setup')
            <li class="treeview">
                <a href="#">
                    <i class="fa-fw fas fa-users">

                    </i>
                    <span>{{ trans('cruds.userManagement.hrm_system_management') }}</span>
                    <span class="pull-right-container"><i class="fa fa-fw fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('company_access_off')
                        <li class="{{ request()->is("admin/companies") || request()->is("admin/companies/*") ? "active" : "" }}">
                            <a href="{{ route("admin.companies.index") }}">
                                <i class='fas fa-arrow-circle-right'></i>
                                <span>{{ trans('cruds.company.title') }}</span>

                            </a>
                        </li>
                    @endcan
                    @can('sub_company_access')
                    <li class="{{ request()->is("admin/sub-companies") || request()->is("admin/sub-companies/*") ? "active" : "" }}">
                        <a href="{{ route("admin.sub-companies.index") }}">
                            <i class='fas fa-arrow-circle-right'></i>
                            <span>{{ trans('cruds.subCompany.title') }}</span>

                        </a>
                    </li>
                @endcan
                @can('branch_access')
                <li class="{{ request()->is("admin/branches") || request()->is("admin/branches/*") ? "active" : "" }}">
                    <a href="{{ route("admin.branches.index") }}">
                        <i class='fas fa-arrow-circle-right'></i>
                        <span>{{ trans('cruds.branch.title') }}</span>

                    </a>
                </li>
            @endcan

            <!-- shift -->
            <li class="{{ request()->is("admin/shifts") || request()->is("admin/shifts/*") ? "active" : "" }}">
                <a href="{{ route("admin.shifts.index") }}">
                    <i class='fas fa-arrow-circle-right'></i>
                    <span>Shift</span>
                </a>
            </li>

            @can('department_access')
            <li class="{{ request()->is("admin/departments") || request()->is("admin/departments/*") ? "active" : "" }}">
                <a href="{{ route("admin.departments.index") }}">
                    <i class='fas fa-arrow-circle-right'></i>
                    <span>{{ trans('cruds.department.title') }}</span>

                </a>
            </li>
            @endcan

            @can('designation_access')
                <li class="{{ request()->is("admin/designations") || request()->is("admin/designations/*") ? "active" : "" }}">
                    <a href="{{ route("admin.designations.index") }}">
                        <i class='fas fa-arrow-circle-right'></i>
                        <span>{{ trans('cruds.designation.title') }}</span>

                    </a>
                </li>
            @endcan

            @can('grade_access')
                <li class="{{ request()->is("admin/grades") || request()->is("admin/grades/*") ? "active" : "" }}">
                    <a href="{{ route("admin.grades.index") }}">
                        <i class='fas fa-arrow-circle-right'></i>
                        <span>{{ trans('cruds.grade.title') }}</span>

                    </a>
                </li>
            @endcan

            @can('rank_access')
                <li class="{{ request()->is("admin/ranks") || request()->is("admin/ranks/*") ? "active" : "" }}">
                    <a href="{{ route("admin.ranks.index") }}">
                        <i class='fas fa-arrow-circle-right'></i>
                        <span>{{ trans('cruds.rank.title') }}</span>

                    </a>
                </li>
            @endcan

            @can('salary_allowance_access')
            <li class="{{ request()->is("admin/salary-allowances") || request()->is("admin/salary-allowances/*") ? "active" : "" }}">
                <a href="{{ route("admin.salary-allowances.index") }}">
                    <i class='fas fa-arrow-circle-right'></i>
                    <span>{{ trans('cruds.salaryAllowance.title') }}</span>

                    </a>
                </li>
            @endcan

            <!-- late deduction -->
            <li class="{{ request()->is("admin/late-deduction") || request()->is("admin/late-deduction/*") ? "active" : "" }}">
                <a href="{{ route("admin.late-deduction.index") }}">
                    <i class='fas fa-arrow-circle-right'></i>
                    <span>Late Deduction Rules</span>
                </a>
            </li>

            @can('rules_access')
            <li class="{{ request()->is("admin/rules") || request()->is("admin/rules/*") ? "active" : "" }}">
                <a href="{{ route("admin.rules.index") }}">
                    <i class='fas fa-arrow-circle-right'></i>
                    <span> Rules Setup</span>

                    </a>
                </li>
            @endcan
            @can('providentfundsetting_access')
            <li class="{{ request()->is("admin/providentfundsetting") || request()->is("admin/providentfundsetting/*") ? "active" : "" }}">
                <a href="{{ route("admin.providentfundsetting.index") }}">
                    <i class='fas fa-arrow-circle-right'></i>
                    <span>Provident Fund Setup</span>

                    </a>
                </li>
            @endcan
                </ul>
            </li>
            @endcan
            {{-- HRM SYSTEM SETUP END --}}


            @if(file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php')))
            @can('profile_password_edit')
                <li class="{{ request()->is('profile/password') || request()->is('profile/password/*') ? 'active' : '' }}">
                    <a href="{{ route('profile.password.edit') }}">
                        <i class="fa-fw fas fa-key">
                        </i>
                        {{ trans('global.change_password') }}
                    </a>
                </li>
            @endcan
            @endif

            @can('setting_access')
                <!-- Settings -->
                <li class="{{ request()->is("settings/edit") || request()->is("admin/settings/*") ? "active" : "" }}">
                    <a href="{{ route("edit.settings") }}">
                        <i class="fa fa-cog">
                        </i>
                        Settings
                    </a>
                </li>
            @endcan


            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="fas fa-fw fa-sign-out-alt">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>
    </section>
</aside>
