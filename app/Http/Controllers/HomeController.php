<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Models\Division;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
        $user = Auth::user();
        return view('dashboard.index', compact('employees', 'user'));
    }

    public function create()
    {
        $divisions = Division::withCount('employees')->having('employees_count', '<', 2)->get();
        return view('dashboard.create', compact('divisions'));
    }

    public function details($id)
    {
        $employee = Employee::find($id);
        $user = Auth::user();
        return view('dashboard.details', compact('employee','user'));
    }

    public function store(Request $request)
    {
    
        $image = $request->file('profile_image');
        $name= base64_encode(Carbon::now()).$image->getClientOriginalName();
        $image->move(public_path('images/'),$name);
            
        
        $employeeCreate = new Employee();
        $employeeCreate->firstName = $request->firstName;
        $employeeCreate->lastName = $request->lastName;
        $employeeCreate->email = $request->email;
        $employeeCreate->password = Hash::make($request->password);
        $employeeCreate->number = $request->number;
        $employeeCreate->department = $request->department;
        $employeeCreate->role = $request->role;
        $employeeCreate->division_id = $request->division;
        $employeeCreate->profile_image = $name;
        $employeeCreate->save();

        $createUser = new User();
        $createUser->name = $request->firstName;
        $createUser->email = $request->email;
        $createUser->roles = $request->role;
        $createUser->password = Hash::make($request->password);
        $createUser->save();

        return redirect()->to('/home');

    }

    public function edit($id)
    {
        $employee = Employee::find($id);
        $user = Auth::user();
        return view('dashboard.edit', compact('employee', 'id', 'user'));
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
        return redirect()->to('/home');
    }

    public function destroy(Request $request)
    {
        $deleteEmployee = Employee::find($request->id);
        $deleteEmployee->delete();
        return view('dashboard.index');
    }
}
