<?php

namespace App\Exports;

use App\Models\Master\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeExport implements FromCollection, WithHeadings
{
    // constructor
    public function __construct($job_title = null, $department = null, $company = null)
    {
        $this->job_title = $job_title;
        $this->department = $department;
        $this->company = $company;
    }
    public function collection()
    {
        $query = Employee::select([
            'employee.id',
            'employee.name',
            'employee.contact',
            'employee.email',
            'employee.address',
            'employee.nik',
            'employee.employee_code',
            'employee.created_at',

            'jt.job_name as job_title',
            'd.department_name as department',
            's.type as company',
        ])
            ->leftJoin('job_title as jt', 'jt.id', '=', 'employee.job_title')
            ->leftJoin('department as d', 'd.id', '=', 'employee.department')
            ->leftJoin('subsidiary as s', 's.id', '=', 'employee.company')
            ->whereNull('employee.deleted');

        // TERAPKAN FILTER
        if ($this->job_title) {
            $query->where('employee.job_title', $this->job_title);
        }

        if ($this->department) {
            $query->where('employee.department', $this->department);
        }

        if ($this->company) {
            $query->where('employee.company', $this->company);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'NAME',
            'CONTACT',
            'EMAIL',
            'ADDRESS',
            'NIK',
            'EMPLOYEE CODE',
            'CREATED AT',
            'JOB TITLE',
            'DEPARTMENT',
            'COMPANY',
        ];
    }
}
