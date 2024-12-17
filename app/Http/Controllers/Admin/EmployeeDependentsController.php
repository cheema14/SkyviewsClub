<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeDependentRequest;
use App\Http\Requests\UpdateEmployeeDependentRequest;
use App\Models\Employee;
use App\Models\EmployeeDependent;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmployeeDependentsController extends Controller
{
    public function index(Request $request,Employee $employee){
        
        abort_if(Gate::denies('employee_dependent_list'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        if ($request->ajax()) {
            $query = EmployeeDependent::query()->select(sprintf('%s.*', (new EmployeeDependent)->table))->where('employee_id', '=', $employee->id);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            // dd($employee);
            $table->editColumn('actions', function ($row) {
                $viewGate = 'employee_dependent_show';
                $editGate = 'employee_dependent_edit';
                $deleteGate = 'employee_dependent_delete';
                $crudRoutePart = 'employee.dependents';

                return view('partials.'.tenant()->id.'.datatableEmployeeDependentActions', compact(
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });

            $table->editColumn('relation', function ($row) {
                return $row->relation ? EmployeeDependent::RELATION_SELECT[$row->relation] : '';
            });
            $table->editColumn('profession', function ($row) {
                return $row->profession ? $row->profession : '';
            });
            $table->editColumn('nationality', function ($row) {
                return $row->nationality ? $row->nationality : '';
            });
            

            $table->rawColumns(['actions', 'placeholder', 'photo']);

            return $table->make(true);
        }

        return view('admin.employee_dependents.index');
    }

    public function create(Request $request){

        abort_if(Gate::denies('employee_dependent_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $employee = Employee::where('id',$request->id)->get()->first();

        return view('admin.employee_dependents.create', ['employee' => $employee]);
    }

    public function store(StoreEmployeeDependentRequest $request,$employee_id){
        
        $dependent = EmployeeDependent::create(array_merge($request->all(), ['employee_id' => $employee_id]));
        
        return redirect()->route('admin.employee.dependents.list', ['employee' => $dependent->employee_id])
        ->with('success', 'Dependent added successfully.');
        
    }

    public function delete(EmployeeDependent $employeedependent){

        abort_if(Gate::denies('employee_dependent_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeedependent->delete();

        return back();
    }

    public function edit(EmployeeDependent $employeedependent){

        abort_if(Gate::denies('employee_dependent_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.employee_dependents.edit', compact('employeedependent'));
    }

    public function update(UpdateEmployeeDependentRequest $request, EmployeeDependent $employeedependent){

        $employeedependent->update($request->all());

        return redirect()->route('admin.employee.dependents.list', ['employee' => $employeedependent->employee_id])
        ->with('success', 'Dependent updated successfully.');
        
    }
}
