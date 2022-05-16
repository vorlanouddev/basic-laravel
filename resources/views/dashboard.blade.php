<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ສະບາຍດີ : {{Auth::user()->name}}
            <b class="float-end">ຈຳນວນຜູ້ໃຊ້ລະບົບ {{count($users)}} ຄົນ</b>

        </h2>
    </x-slot>

    <div class="py-12">
        <div class="container">
            <div class="row">
                <table class="table table-dark table-hover">
  <thead>
    <tr>
      <th scope="col">ລຳດັບ</th>
      <th scope="col">ຊື່</th>
      <th scope="col">Email</th>
      <th scope="col">ເລີ່ມເຂົ້າສູ່ລະບົບ</th>
    </tr>
  </thead>
  <tbody>
      @php($i=1)
      @foreach ($users as $row)
          
     
    <tr>
      <th>{{$i++}}</th>
      <td>{{$row->name}}</td>
      <td>{{$row->email}}</td>
      <td>{{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</td>
    </tr>
    
     @endforeach 
  </tbody>
</table>
            </div>
        </div>
    </div>
</x-app-layout>
