@extends('layouts.admin')
@section('content')
<div class="content">

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
                <a class="buttonNew" href="{{ route('admin.panels.create') }}" style="color:white;">Add Panel</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Panel Details
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Panel Name
                                    </th>

                                    <th>
                                        Members
                                    </th>

                                    <th>
                                        Status
                                    </th>

                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($panel as $key=> $value) 
                                    @php
                                        $members = json_decode($value->members);
                                    @endphp
                                    <tr data-entry-id="{{$value->id}}">
                                        <td>

                                        </td>

                                        <td>
                                            {{ $value->id }}
                                        </td>

                                        <td>
                                            {{ $value->name }}
                                        </td>
                                       
                                        <td>
                                           @if(count($members) > 0 )
                                            <ul> @foreach($members as $key=> $val)
                                                   @php 
                                                    $employee =   App\Models\Employee::find($val);
                                                  @endphp

                                                <li>{{$employee->first_name .' '.$employee->last_name}}</li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </td>
                                        
                                        @if($value->status == 1)
                                            <td><strong style="color: green"> Active</strong> </td>
                                        @else
                                            <td><strong style="color: red"> Inactive</strong> </td>
                                        @endif
                                    
                                        <td>
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.panels.edit', $value->id) }}">
                                                {{ trans('global.edit') }}
                                            </a>

                                            <form action="{{ route('admin.panels.destroy', $value->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                            </form>

                                        </td>

                                    </tr>
                            
                                @endforeach

                            </tbody>
                        </table>
                        
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
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
    text: deleteButtonTrans,
    url: "#",
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


  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    //order: [[ '1', 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-lateConsideration:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
