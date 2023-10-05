<?php

namespace App\Http\Requests;

use App\Models\Branch;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreBranchRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('branch_create');
    }

    public function rules()
    {
        return [
            'branch_name' => [
                'string',
                'required',
            ],
            'branch_address' => [
                'string',
                'nullable',
            ],
            'created_by_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
