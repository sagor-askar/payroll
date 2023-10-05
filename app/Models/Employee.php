<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Employee extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public const GENDER_SELECT = [
        'male'   => 'Male',
        'female' => 'Female',
    ];

    // for marital status
    public const STATUS_SELECT = [
        'married' => 'married',
        'unmarried' => 'unmarried',
    ];

    public $table = 'employees';

    protected $appends = [
        'certificates',
        'noc',
        'resume',
        'photo',
    ];

    protected $dates = [
        'joining_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'employee_manual_id',
        'employee_device_id',
        'department_id',
        'employee_assign_to_id',
        'company_id',
        'sub_company_id',
        'designation_id',
        'emergency_address',
        'nid_no',
        'passport_no',
        'provident_fund',
        'marketing_allowance',
        'mobile_bill',
        'grade_id',
        'first_name',
        'last_name',
        'father_name',
        'mother_name',
        'address',
        'email',
        'contact_no',
        'gender',
        'marital_status',
        'spouse',
        'spouse_contact_no',
        'emergency_contact_no',
        'blood_group',
        'account_holder_name',
        'account_number',
        'bank_name',
        'branch_name',
        'joining_date',
        'promotion_date',
        'created_by_id',
        'salary',
        'tax',
        'is_attendence',
        'attendance_type',
        'shift_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'is_active',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function subcompany()
    {
        return $this->belongsTo(SubCompany::class, 'sub_company_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function getJoiningDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setJoiningDateAttribute($value)
    {
        $this->attributes['joining_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getCertificatesAttribute()
    {
        return $this->getMedia('certificates');
    }

    public function getNocAttribute()
    {
        return $this->getMedia('noc')->last();
    }

    public function getResumeAttribute()
    {
        return $this->getMedia('resume')->last();
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
