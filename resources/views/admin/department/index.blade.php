<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ສະບາຍດີ : {{Auth::user()->name}}
            

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
               <div class="col-md-8">
                   @if (session("success"))

                       
                   <div class="alert alert-success">{{session('success')}}</div>
                       
                   @endif

                   <div class="card">
                       <div class="card-header">
                           ຕະລາງຂໍ້ມູນພະແນກ
                       </div>
                       

                        <table class="table  table-bordered">
  <thead>
    <tr>
      <th scope="col">ລຳດັບ</th>
      <th scope="col">ຊື່</th>
      <th scope="col">User ID</th>
      <th scope="col">Created_At</th>
      <th scope="col">Edit</th>
      <th scope="col">delete</th>
     
    </tr>
  </thead>
  <tbody>
     
      @foreach ($departments as $row)
          
     
    <tr>
      <th>{{$departments->firstItem()+$loop->index}}</th>
      <td>{{$row->department_name}}</td>
      <td>{{$row->user->name}}</td>
      <td>
          @if($row->created_at == NULL)
          ບໍ່ຖືກນິຍາມ
              
          @else
              {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
          @endif
      </td>
     <td>
         <a href="{{url('/department/edit/'.$row->id)}}"class="btn btn-primary">ແກ້ໄຂ
     </td>
      <td>
         <a href="{{url('/department/softdelete/'.$row->id)}}"class="btn btn-warning">ລຶບຂໍ້ມູນ</a>
     </td>
    </tr>
    
     @endforeach 
  </tbody>
</table>
{{$departments->links()}}
</div>
@if(count($trashDepartments)>0)
<div class="card my-2">
    
    <div class="card-header">
                           ຖັງຂີ້ເຍຶ່ອ
                       </div>
                       

                        <table class="table  table-bordered">
  <thead>
    <tr>
      <th scope="col">ລຳດັບ</th>
      <th scope="col">ຊື່</th>
      <th scope="col">User ID</th>
      <th scope="col">Created_At</th>
      <th scope="col">ກຼ້ຄຶນຂໍ້ມູນ</th>
      <th scope="col">ລົບຖາວອນ</th>
     
    </tr>
  </thead>
  <tbody>
     
      @foreach ($trashDepartments as $row)
          
     
    <tr>
      <th>{{$departments->firstItem()+$loop->index}}</th>
      <td>{{$row->department_name}}</td>
      <td>{{$row->user->name}}</td>
      <td>
          @if($row->created_at == NULL)
          ບໍ່ຖືກນິຍາມ
              
          @else
              {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
          @endif
      </td>
     <td>
         <a href="{{url('/department/restore/'.$row->id)}}"class="btn btn-primary">ກຼ້ຄຶນຂໍ້ມູນ</a>
     </td>
      <td>
         <a href="{{url('/department/delete/'.$row->id)}}"class="btn btn-danger">ລຶບຂໍ້ມູນຖາວອນ
     </td>
    </tr>
    
     @endforeach 
  </tbody>
  
</table>
{{$departments->links()}}
</div>
@endif
                   </div>
               </div>
                <div class="col-md-4">
                    <div class="card">
                       <div class="card-header">
                           ແບບຟອມ</div>
                       <div class="card-body">
                           <form action="{{route('addDepartment')}}" method="post">
                       @csrf 
                               <div class="form-group">
                                <label for="department_name">ຊື່ຕຳແຫນ່ງງານ</label>
                               <input type="text" class="form-control" name="department_name">
                               </div>
                               @error('department_name')

                              <div class="my-2">
                                   <span class="text-danger my-2">{{$message}}</span>
                              </div>
                                   
                               @enderror
                            
                                <br>
                               <input type="submit" value="ບັນທຶກ" class="btn btn-primary">

                           </form>
                       </div>
                   </div></div>
               
            </div>
        </div>
    </div>
</x-app-layout>
