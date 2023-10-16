<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Division;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $employees = Employee::all();
        return view('dashboard.index', compact('employees'));
    }

    public function create()
    {
        $divisions = Division::withCount('employees')->having('employees_count', '<', 2)->get();
        return view('dashboard.create', compact('divisions'));
    }

    public function details($id)
    {
        $employee = Employee::find($id);
        return view('dashboard.details', compact('employee'));
    }

    public function store(Request $request)
    {
         
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image');
            $name= base64_encode(Carbon::now()).$image->getClientOriginalName();
            $image->move(public_path('images/'),$name);
        }
        $employeeCreate = new Employee();
        $employeeCreate->firstName = $request->firstName;
        $employeeCreate->lastName = $request->lastName;
        $employeeCreate->email = $request->email;
        $employeeCreate->password = Hash::make($request->password);
        $employeeCreate->number = $request->number;
        $employeeCreate->department = $request->department;
        $employeeCreate->role = $request->role;
        $employeeCreate->division_id = $request->division;
        $employeeCreate->profile_image = '';
        $employeeCreate->save();
        return redirect()->to('/home');
    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        return view('dashboard.edit', compact('employee', 'id'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::find($id);
        $employee->firstName = $request->firstName;
        $employee->lastName = $request->lastName;
        $employee->email = $request->email;
        $employee->password = Hash::make($request->password);
        $employee->number = $request->number;
        $employee->department = $request->department;
        $employee->role = $request->role;
        $employee->update();
        return view('dashboard.index', compact('employee'));
    }

    public function destroy(Request $request)
    {
        $deleteEmployee = Employee::find($request->id);
        $deleteEmployee->delete();
        return view('dashboard.index');
    }
}
