<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table = 'employee';
    protected $guarded = ['id'];

    public function JobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'id', 'job_title');
    }
    public function Subsidiary()
    {
        return $this->belongsTo(Subsidiary::class, 'id', 'company');
    }
    public function Department()
    {
        return $this->belongsTo(Departement::class, 'id', 'department');
    }
}
