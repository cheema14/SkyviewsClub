<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Employee;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class EmployeeController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::all();

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employees.create');
    }

    public function store(StoreEmployeeRequest $request)
    {
        $employee = Employee::create($request->all());
        $tenant_id = tenant()->id;
        tenancy()->central(function () use ($employee, $request,$tenant_id) {
            if ($request->input('employee_photo',false)) {
                $employee->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('employee_photo'))))->toMediaCollection('employee_photo', 'employees');
            }
        });

        $employee->load('media');


        return redirect()->route('admin.employees.index')->with('created', 'New Employee Added.');
    }

    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employees.edit', compact('employee'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        $employee->update($request->all());
        $tenant_id = tenant()->id;
        
        if ($request->input('employee_photo', false)) {
            if (! $employee->employee_photo || $request->input('employee_photo') !== $employee->employee_photo->file_name) {
                if ($employee->employee_photo) {
                    $employee->employee_photo->delete();
                }
                tenancy()->central(function () use ($employee, $request,$tenant_id) {
                    if ($request->input('employee_photo',false)) {
                        $employee->addMedia(storage_path('tenant'.$tenant_id.'/tmp/uploads/'.basename($request->input('employee_photo'))))->toMediaCollection('employee_photo', 'employees');
                    }
                });
            }
        } elseif ($employee->employee_photo) {
            $employee->employee_photo->delete();
        }
        return redirect()->route('admin.employees.index')->with('updated', 'Employee Updated.');
    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return view('admin.employees.show', compact('employee'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->delete();

        return back()->with('deleted', 'Employee Deleted.');
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        $employees = Employee::find(request('ids'));

        foreach ($employees as $employee) {
            $employee->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
