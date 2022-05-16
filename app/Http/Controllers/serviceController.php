<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5);
        return view('admin.service.index', compact('services'));
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('admin.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        //ກວດສອບຂໍ້ມູນ
        $request->validate(
            [
                'service_name' => 'required|max:255',
            ],
            [
                'service_name.required' => "ກະລຸນາປ້ອນຊື່",
                'service_name.max' => "ຫ້າມປ້ອນເກີນ 255 ໂຕອັກສອນ",
            ]
        );

        $service_image = $request->file('service_image');
        //ອັບເດເພາບແລະຊື່
        if ($service_image) {

            //Generate ຊື່ຮູບ
            $name_gen = hexdec(uniqid());
            // ດຶງນາມສະກຸນຟາຍພາບ
            $img_ext = strtolower($service_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;


            //ອັບໂຫຼດແລະອັບເດດຂໍ້ມູນ
            $upload_location = 'image/services/';
            $full_path = $upload_location . $img_name;


            //ອັບເດດຂໍ້ມູນ
            Service::find($id)->update([
                'service_name' => $request->service_name,
                'service_image' => $full_path,
            ]);

            //ລົບພາບເກົ່າແລະອັບເດດຮູບໄຫມ່ແທນທີ່
            $old_image = $request->old_image;
            unlink($old_image);
            $service_image->move($upload_location, $img_name);

            return redirect()->route('services')->with('success', "ອັບເດດຮູບພາບຮຽບຮ້ອຍ");
        } else {
            //ອັບເດດຊື່ຢ່າງດຽວ
            Service::find($id)->update([
                'service_name' => $request->service_name,
            ]);
            return redirect()->route('services')->with('success', "ອັບເດດຊື່ບໍລິການຮຽບຮ້ອຍ");
        }
    }

    public function store(Request $request)
    {
        //ກວດສອບຂໍ່ມູນ
        $request->validate(
            [
                'service_name' => 'required|unique:services|max:255',
                'service_image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'service_name.required' => "ກະລຸນາປ້ອນຊື່ບໍລິການ",
                'service_name.max' => "ຫ້າມເກີນ 255 ໂຕອັກສອນ",
                'service_name.unique' => "ມີຂໍ້ມູນຊື່ບໍລິການນີ້ໃນຖານຂໍ້ມູນແລ້ວ",
                'service_image.required' => "ກະລຸນາໃສ່ຮູບພາບປຣະກອບການບໍລິການ",
            ]
        );

        //ການເຂົ້າລະຫັດຮູບພາບ
        $service_image = $request->file('service_image');

        //Generate ຊື່ຮູບ
        $name_gen = hexdec(uniqid());
        // ດຶງນາມສະກຸນFlineພາບ
        $img_ext = strtolower($service_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;


        //ອັບໂຫຼດແລະບັນທຶກຂໍ້ມູນ
        $upload_location = 'image/service/';
        $full_path = $upload_location . $img_name;

        Service::insert([
            'service_name' => $request->service_name,
            'service_image' => $full_path,
            'created_at' => Carbon::now()
        ]);
        $service_image->move($upload_location, $img_name);
        return redirect()->back()->with('success', "ບັນທິກຂໍ້ມູນຮຽບຮ້ອຍ");
    }

    public function delete($id)
    {
        // ລົບຮູບ
        $img = Service::find($id)->service_image;
        unlink($img);

        //ລົບຂໍ້ມູນຈາກຖານຂໍ້ມູນ
        $delete = Service::find($id)->delete();
        return redirect()->back()->with('success', "ລົບຂໍ້ມູນຮຽບຮ້ອຍແລ້ວ");
    }
}
