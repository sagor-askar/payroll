@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      Salary Generate List
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="salaryGenerate" class=" table table-bordered table-striped table-hover datatable datatable-LeaveApplication">
                                <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>Employee ID</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Basic Salary</th>
                                    <th>Total Allowance</th>
                                    <th>Additional Allowance</th>
                                    <th>Mobile Allowance</th>
                                    <th>Marketing Allowance</th>
                                    <th>Overtime Salary</th>
                                    <th>Gross Salary</th>
                                    <th>Loan</th>
                                    <th>PF Loan</th>
                                    <th>Advance</th>
                                    <th>Deduction Amount</th>
                                    <th>Late Deduction</th>
                                    <th>Provident Fund</th>
                                    <th>Tax</th>
                                    <th>Total</th>
                                    <th>Net salary</th>
                                    <th>Generated Date</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($salary_generate_history as $key=> $salary)
                                    <tr data-entry-id="{{$salary->id}}">
                                        <td></td>
                                        <td>{{$salary->employee->employee_manual_id}}</td>
                                        <td>{{$salary->employee->first_name.' '.$salary->employee->last_name}}</td>
                                        <td>{{$salary->employee->designation->designation_name}}</td>
                                        <td>{{$salary->basic_amount}}</td>
                                        <td>{{$salary->allowance_amount}}</td>
                                        <td>{{$salary->additional_amount}}</td>

                                        <td>{{$salary->employee->mobile_bill}}</td>
                                        <td>{{$salary->employee->marketing_allowance}}</td>
                                        <td>{{$salary->ot_salary}}</td>
                                        <td>{{$salary->gross_salary}}</td>
                                        <td>{{$salary->loan_amount}}</td>
                                        <td>{{$salary->pf_loan_amount}}</td>
                                        <td>{{$salary->advance_amount}}</td>
                                        <td>{{$salary->deduction_amount}}</td>
                                        <td>{{$salary->late_deduction_amount}}</td>

                                        <td>{{$salary->employee->provident_fund}}</td>
                                        <td>{{$salary->employee->tax}}</td>

                                        <td>{{$salary->total_deduction}}</td>
                                        <td>{{$salary->net_salary}}</td>
                                        <td>{{$salary->generate_date}}</td>
                                        <td>{{$salary->user->name}}</td>
                                        @if($salary->status == 0)
                                            <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                        @else
                                            <td><strong style="color: darkgreen"> Completed</strong> </td>
                                        @endif

                                        <td>

                                            @can('leave_application_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.payroll.salary-generate.show', $salary->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan
                                            @if($salary->status == 1)
                                                <a class="btn btn-xs btn-success" href="{{ route('admin.payroll.payslip', $salary->id) }}">
                                                    Payslip
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                </tbody>
                            </table>
                            @if ($salary_generate_history->hasPages())

                                {{ $salary_generate_history->links() }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('leave_application_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.leave-applications.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: { ids: ids, _method: 'DELETE' }})
                            .done(function () { location.reload() })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan
            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[ 1, 'desc' ]],
                pageLength: 100,
            });
            let table = $('.datatable-LeaveApplication:not(.ajaxTable)').DataTable({ buttons: dtButtons })
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>

    <script>
        function rejectFunction() {
            if(!confirm("Are You Sure to Reject ?"))
                event.preventDefault();
        }
    </script>

    <script>
        function approveFunction() {
            if(!confirm("You are going to Approve !"))
                event.preventDefault();
        }
    </script>
@endsection
