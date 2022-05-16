<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::paginate(5);
        $trashDepartments = Department::onlyTrashed()->paginate(3);

        return view('admin.department.index', compact('departments', 'trashDepartments'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "ກະລຸນາປ້ອນຊື່ຜະແຫນກ",
                'department_name.max' => "ຫ້າມປ້ອນເກີນ 10 ໂຕອັກສອນ",
                'department_name.unique' => "ມີຂໍ້ມູນຊື່ຜະແໜກໃນຖານຂໍ້ມູນແລ້ວ"
            ]
        );
        $data = array();
        $data["department_name"] = $request->department_name;
        $data["user_id"] = Auth::user()->id;
        DB::table('departments')->insert($data);
        return redirect()->back()->with('success', "ບັນທຶກຮຽບຮ້ອຍ");
    }
    public function edit($id)
    {
        $department = Department::find($id);
        return view('admin.department.edit', compact('department'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => "ກະລຸນາປ້ອນຊື່ຜະແຫນກ",
                'department_name.max' => "ຫ້າມປ້ອນເກີນ 10 ໂຕອັກສອນ",
                'department_name.unique' => "ມີຂໍ້ມູນຊື່ຜະແໜກໃນຖານຂໍ້ມູນແລ້ວ"
            ]
        );
        $update = Department::find($id)->update([
            'department_name' => $request->department_name,
            'user_id' => Auth::user()->id

        ]);
        return redirect()->route('department')->with('success', "ອັບເດດຂໍ້ມູນຮຽບຮ້ອຍ");
    }
    public function softdelete($id)
    {
        $delete = Department::find($id)->delete();
        return redirect()->back()->with('success', "ລົບຂໍ້ມູນຮຽບຮ້ອຍ");
    }
    public function restore($id)
    {
        $restore = Department::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success', "ກູ້ຄືນຂໍ້ມູນຮຽບຮ້ອຍ");
    }
}
