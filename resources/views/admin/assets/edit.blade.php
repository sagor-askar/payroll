@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Edit Assets Particulars
                </div>
                <div class="panel-body">
                    <form action="{{ route("admin.assets.update", [$asset->id]) }}" method="POST" enctype="multiple/form-data">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                    <label class="required" for="name">Asset Name</label>
                                    <input class="form-control" type="text" name="name" id="name" value="{{ old('name',$asset->name) }}" placeholder="Assets Name" required>
                                    @if($errors->has('name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="required" for="date">Group</label>
                                    <select class="form-control" name="group_id" id="group_id">
                                        <option value="">Please Select</option>
                                        @foreach($assetGroups as $key => $value)
                                            <option value="{{ $value->id }}" {{ (old('group_id') ? old('group_id') : $asset->asset_group->id ?? '') == $value->id ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('qty') ? 'has-error' : '' }}">
                                    <label class="required" for="qty">Qty </label>
                                    <input class="form-control" type="number" name="qty" id="qty" value="{{ old('qty', $asset->qty) }}" placeholder="Qty " required>
                                    @if($errors->has('qty'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>




                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('unit_price') ? 'has-error' : '' }}">
                                    <label class="required" for="unit_price">Unit Price</label>
                                    <input class="form-control" type="text" name="unit_price" id="unit_price" value="{{ old('unit_price', $asset->unit_price) }}" placeholder="Unit Price" required>
                                    @if($errors->has('unit_price'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('supplier_name') ? 'has-error' : '' }}">
                                    <label class="required" for="supplier_name">Supplier Name</label>
                                    <input class="form-control" type="text" name="supplier_name" id="supplier_name" value="{{ old('supplier_name', $asset->supplier_name) }}" placeholder="Supplier Name" required>
                                    @if($errors->has('supplier_name'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('warranty_period') ? 'has-error' : '' }}">
                                    <label class="required" for="warranty_period">Warranty Period</label>
                                    <input class="form-control" type="text" name="warranty_period" id="warranty_period" value="{{ old('warranty_period',  $asset->warranty_period) }}" placeholder="Warranty Period" required>
                                    @if($errors->has('warranty_period'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('supplier_phone') ? 'has-error' : '' }}">
                                    <label class="required" for="supplier_phone">Supplier Phone</label>
                                    <input class="form-control" type="text" name="supplier_phone" id="supplier_phone" value="{{ old('supplier_phone', $asset->supplier_phone) }}" placeholder="Supplier Phone" required>
                                    @if($errors->has('supplier_phone'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('supplier_address') ? 'has-error' : '' }}">
                                    <label class="required" for="supplier_address">Supplier Address</label>
                                    <input class="form-control" type="text" name="supplier_address" id="supplier_address" value="{{ old('supplier_address',$asset->supplier_address) }}" placeholder="Supplier Address" required>
                                    @if($errors->has('supplier_address'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('purchase_date') ? 'has-error' : '' }}">
                                    <label class="required" for="purchase_date">Date of Purchase</label>
                                    <input class="form-control" type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $asset->purchase_date) }}" placeholder="Date of Purchase" required>
                                    @if($errors->has('date_of_purchase'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('employee') ? 'has-error' : '' }}">
                                    <label class="required" for="employee_id">Assign Employee</label>
                                    <select class="form-control select2" name="assigned_employee_id" id="employee_id" required>
                                        @foreach($employees as $id => $employee)
                                         <option value="{{ $employee->id }}" {{ (old('employee_id') ? old('employee_id'): $allowanceDistributionSetup->employee->id ?? '')  == $employee->id ? 'selected' : '' }}>{{ $employee->first_name. ' '.$employee->last_name }} ({{$employee->employee_manual_id}})</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('employee'))
                                        <span class="help-block" role="alert">{{ $errors->first('employee') }}</span>
                                    @endif
                                    <span class="help-block">{{ trans('cruds.leaveApplication.fields.employee_helper') }}</span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" name="description" id="description" cols="15" rows="10" value="" placeholder="Description">{!!  $asset->description !!}</textarea>
                                    @if($errors->has('description'))
                                        <span class="help-block" role="alert"></span>
                                    @endif
                                    <span class="help-block"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="button" type="submit">
                                        {{ trans('global.save') }}
                                    </button>
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent



@endsection
