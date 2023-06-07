<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             <a href="{{ route('dashboard') }}" class="btn btn-primary"> {{ __('Dashboard') }} </a>    

            <a href="{{ route('user.index') }}" class="btn btn-primary"> {{ __('User List') }}</a>
        </h2>
    </x-slot>
    @if (Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error') }}
        </div>
    @endif
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">

                    @csrf
                    
                    <div class="form-group">
                      <label for="first_name">First Name:</label>
                      <input type="text" class="form-control" id="first_name" placeholder="Enter first name" name="first_name" value="{{ old('first_name') }}">
                      @error("first_name")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>

                     <div class="form-group">
                      <label for="last_name">Last Name:</label>
                      <input type="text" class="form-control" id="last_name" placeholder="Enter last name" name="last_name" value="{{ old('last_name') }}">
                      @error("last_name")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" value="{{ old('email') }}">
                      @error("email")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>


                    <div class="form-group">
                      <label for="country">Country:</label>
                      <select name="country_id" id="country" class="form-control">
                          <option value="">--Select Country--</option>
                          @foreach ($countries as $country)
                              <option value="{{ $country->id }}" {{ old('country_id') == $country->id?'selected':'' }} >{{ $country->name ?? '' }}</option>
                          @endforeach
                      </select>
                      
                      @error("country_id")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="state">State:</label>
                      <select name="state_id" id="state" class="form-control">
                          <option value="">--Select State--</option>
                      </select>
                      
                      @error("state_id")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="city">City:</label>
                      <select name="city_id" id="city" class="form-control">
                          <option value="">--Select City--</option>
                      </select>
                      
                      @error("city_id")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>

                    <div class="form-group">
                      <label for="photo">Photo:</label>
                      
                      <input type="file" class="form-control" id="phot" placeholder="Upload Image" name="photo">
                      @error("photo")
                        <span class="text-danger"> {{ $message }}</span>
                      @enderror
                    </div>

                    
                  
                  <button type="submit" class="btn btn-default">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>

<script>
    $(document).ready(function(){

        var url = "{{ url('api') }}"

        $("#country").change(function(){

            $.get(`${url}/state/${this.value}`, function(data) {
                
                $("#state").empty().append('<option value="">--Select State--</option>');
                data.data.map(function(state){
                    $("#state").append(`<option value="${state.id}">${state.name}</option>`)
                })
            });
        });

        $("#state").change(function(){

            $.get(`${url}/city/${this.value}`, function(data) {
                
                 $("#city").empty().append('<option value="">--Select City--</option>');
                data.data.map(function(city){
                    $("#city").append(`<option value="${city.id}">${city.name}</option>`)
                })
            });
        });
    })
</script>
</x-app-layout>
