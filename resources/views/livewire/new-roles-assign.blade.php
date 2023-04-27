<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Role Assign
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                      <div class="flex">
                        <div>
                          <p class="text-sm">{{ session('message') }}</p>
                        </div>
                      </div>
                    </div>
                @endif
                {{-- @if($isOpen)
                    @include('livewire.tags.create')
                @endif --}}

                <form action="{{ route('roles-assign.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
    
                    <div class="col-md-6 col-12 mx-auto">
                        <label for="role"><strong>Employee</strong></label>
                        <select id="employee" name="uid" class="form-control" style="width: 100%;" required>
                            <option value="" selected hidden> Search by ID or Name</option>
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{ $user->id." - ".$user->first_name ." ". $user->last_name  }} </option>
                            @endforeach
                        </select>
                    </div><br>
    
                    {{-- <div class="col-12 ">
                        <label>Select Staff</label><span> *</span>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <select class="select2 select2-info" id="staff" multiple="multiple"
                                    data-placeholder="Select Staff" style="width: 100%;">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->emp_id }}">{{ $employee->emp_id }} - {{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div> --}}
    
                    <div class="col-md-6 mx-auto">
                        <label for="role"><strong>Role</strong></label>
                        <select id="role" name="roles[]" class="form-control" multiple="multiple" required>
                            {{-- <option value="" selected hidden> Role</option> --}}
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-2 ml-auto">
                            <button type="submit" class="btn btn-sm btn-info btn-block">Save Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function () {
                $('.select2').select2()      
                $('.select2bs4').select2({         
                    theme: 'bootstrap4'
                })
            })
        </script>
    @endpush
    </x-app-layout>
    