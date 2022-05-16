<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ສະບາຍດີ , {{Auth::user()->name}}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                <div class="card">
                        <div class="card-header">ແບບັອມແກ້ໄຂຂໍ້ມູນ</div>
                        <div class="card-body">
                            <form action="{{url('/service/update/'.$service->id)}}" method="post" enctype="multipart/form-data">
                                @csrf
                                 <div class="form-group">
                                    <label for="service_name">ຊື່ບໍລິການ</label>
                                    <input type="text" class="form-control" name="service_name" value="{{$services->service_name}}">
                                </div>
                                @error('service_name')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                
                                <div class="form-group">
                                    <label for="service_image">ຮູບປະກອບ</label>
                                    <input type="file" class="form-control" name="service_image" value="{{$service->service_image}}">
                                </div>
                                @error('service_image')
                                    <div class="my-2">
                                        <span class="text-danger">{{$message}}</span>
                                    </div>
                                @enderror
                                <br>
                                <input type="hidden" name="old_image" value="{{$service->service_image}}">
                                <div class="form-group">
                                    <img src="{{asset($service->service_image)}}" alt="" width="400px" height="400px">
                                </div>

                                <br>
                                <input type="submit" value="ອັບເດດ" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>