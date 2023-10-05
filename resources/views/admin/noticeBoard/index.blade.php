@extends('layouts.admin')
@section('content')
<div class="content">
    @can('notice_board_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
               
                    <a class="buttonNew" href="{{ route('admin.noticeboards.create') }}" style="color: white;">Add Notice</a>
               
            </div>
        </div>
    @endcan
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Notice Board {{ trans('global.list') }}
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-noticeBoard">
                            <thead>
                                <tr>
                                    <th width="10">

                                    </th>
                                    <th>
                                        Serial No.
                                    </th>
                                    <th>
                                       Notice Title
                                    </th>
        
                                    <th>
                                        Notice Date
                                    </th>
                                    <th>
                                        Is Seen
                                    </th>
                                    
                                    <th>
                                        &nbsp;Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($noticeBoards as $key => $noticeBoard)
                                    <tr data-entry-id="{{ $noticeBoard->id }}">
                                        <td>

                                        </td>
                                        <td>
                                            {{ $noticeBoard->id ?? '' }}
                                            <input type="hidden" value="{{ $noticeBoard->id }}" id="noticeId">
                                        </td>
                                        <td>
                                            {{ $noticeBoard->notice_title ?? '' }}
                                        </td>
                                       
                                        <td>
                                            {{ $noticeBoard->notice_date ?? '' }}
                                        </td>
                                        <td>
                                            @if ($noticeBoard->is_seen)
                                            <span class="badge" style="background-color: green;">YES</span>
                                            @else
                                            <span class="badge" style="background-color: red;">NOT YET</span>
                                            @endif                                      
                                          
                                        </td>
                                       
                                        <td>
                                            @can('notice_board_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('admin.noticeboards.show', $noticeBoard->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('notice_board_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('admin.noticeboards.edit', $noticeBoard->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                                @if ($noticeBoard->is_seen)
                                                <a class="btn btn-xs btn-success"  id="getSeenUser" data-toggle="modal"  href="#exampleModal-{{ $noticeBoard->id }}" style="color: white;">
                                                    Seen User
                                                 </a>
                                                @endif
                                            @endcan

                                            @can('notice_board_delete')
                                                <form action="{{ route('admin.noticeboards.destroy', $noticeBoard->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                                </form>
                                            @endcan

                                        </td>

                                    </tr>
                                    @php
                                        $noticeBoard = \App\Models\NoticeBoard::find($noticeBoard->id);                                                                   
                                    @endphp
                                    @if( $noticeBoard->is_seen)
                                         {{-- modal start --}}
                                         <div class="modal fade" id="exampleModal-{{ $noticeBoard->id }}">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4>List seen employees</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>                                                            
                                                    <div class="modal-body">
                                                        <ul style="list-style: none;margin:0px;padding:0px;">
                                                            <li style="padding: 10px">
                                                                <span class="p-3" style="width: 150px;float:left">Sl No.</span>
                                                                <span class="p-3" style="width: 150px;float:center">Employee Name</span>
                                                                <span class="p-3" style="width: 150px;float:right">Department Name</span>
                                                            </li>
                                                            <hr>
                                                            @php
                                                                 $i = 1; 
                                                            @endphp
                                                            @foreach($noticeBoard->seen_users as $itemKey => $item)
                                                            @php
                                                                $employee = \App\Models\Employee::with('department')->find($item);   
                                                                                                                              
                                                            @endphp                         
                                                                <li style="padding: 10px">
                                                                    <span class="p-3" style="width: 150px;float:left">{{ $i++ }}</span>
                                                                    <span class="p-3" style="width: 150px;float:center">{{ $employee->first_name }}</span>
                                                                    <span class="p-3" style="width: 150px;float:right">{{ $employee->department->department_name ?? '' }}</span>
                                                                </li>   <hr>                                       
                                                            
                                                             @endforeach   
                                                          
                                                        </ul>
                                                        
                                                                                    
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     {{-- modal end --}}
                                    @endif
                                 
                                @endforeach
                            </tbody>
                        </table>
                        @if ($noticeBoards->hasPages())                            
                                {{ $noticeBoards->links() }}                            
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
    @can('leave_type_delete')
    let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
    let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leave-types.massDestroy') }}",
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
  let table = $('.datatable-noticeBoard:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})


</script>
@endsection
