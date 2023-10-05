@extends('layouts.admin')
@section('content')
<div class="content">
    {{-- @if (session()->has('message'))
        <p class="alert alert-success" id="successMessage">{{ session('message') }}</p>
    @endif --}}
    @can('employee_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">

                    <a class="buttonNew" href="{{ route('admin.employees.create') }}" style="color: white;">
                        Add Employee
                    </a>

            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="height: 53px;">
                    {{ trans('cruds.employee.title_singular') }} {{ trans('global.list') }}
                    <a style="float: right" type="button" class="btn btn-primary" href="{{ route('admin.employee-info.pdf') }}">Print Information <i class="fa fa-print" title="Print From Here"></i></a><hr>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-Employee">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.employee_manual_id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.first_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.last_name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.department') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.designation') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.email') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.employee.fields.contact_no') }}
                                    </th>

                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $key => $employee)
                                    <tr data-entry-id="{{ $employee->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $employee->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->employee_manual_id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->first_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->last_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->department->department_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->designation->designation_name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->email ?? '' }}
                                        </td>
                                        <td>
                                            {{ $employee->contact_no ?? '' }}
                                        </td>

                                        <td>
                                            @can('employee_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.employees.show', $employee->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('employee_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.employees.edit', $employee->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('employee_delete')
                                                <form action="{{ route('admin.employees.destroy', $employee->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if ($employees->hasPages())

                            {{ $employees->links() }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- printable area for asset code-->
            <div style="display: none;" class="table-responsive" id="printableArea">  
                <h5>All Employee Information</h5> 
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SL.</th>
                            <th scope="col">Employee Name</th>
                            <th scope="col">Employee Manual ID</th>
                            <th scope="col">Department</th>
                            <th scope="col">Contact No</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($employees as $employee)
                        <tr>
                            <td>{{ $employee->id ?? '' }}</td>
                            <td>{{ $employee->first_name ?? '' }} {{ $employee->last_name ?? '' }}</td>
                            <td>{{ $employee->employee_manual_id ?? '' }}</td>
                            <td>{{ $employee->department->department_name ?? '' }}</td>
                            <td>{{ $employee->contact_no ?? '' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
@can('employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employees.massDestroy') }}",
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
  let table = $('.datatable-Employee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

$(document).ready(function(){
    $("#successMessage").delay(3000).slideUp(200);
});

</script>
@endsection
@section('scripts')
<script type="text/javascript">
        function printPageArea(printableArea) {

            var printContents = document.getElementById("printableArea").innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();
            window.close();

            document.body.innerHTML = originalContents;
        }
    </script>
@endsection