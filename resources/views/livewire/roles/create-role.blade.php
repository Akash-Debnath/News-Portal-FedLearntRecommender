<x-app-layout>
<x-slot name="header">
    <h5 class="font-semibold text-xl text-gray-800 leading-tight">
        <b>Create Role</b>
    </h5>
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
            {{-- <a href="{{ route('roles.create') }}">
                <button class="inline-flex items-center px-4 py-2 my-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                    Create New Role
                </button>
            </a> --}}
            {{-- @if($isOpen)
                @include('livewire.roles.create')
            @endif --}}
            <div class="row d-flex justify-content-center ">
                <div class="col-12">
                    <div class="card">
                        {{-- <div class="card-header">
                            <div class="col-12">
                                <h1 class="mb-0"><b>Add New Role</b></h1>
                            </div>
                        </div> --}}
                        <div class="card-body">
                            <div class="col-12 ">
                                <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-12"><label for="name"><strong>Role Name:</strong></label>
                                            <input type="text" name="name" id="name" class="form-control">
                                        </div>
                                    </div>
        
                                    <br><br>
                                    <div class="row">
                                        <div class="col-md-4 ">
                                            <h5 class="mb-0"> <strong>Permissions</strong> </h5>
                                        </div>
                                    </div><br>
        
                                    
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                        <label class="form-check-label" for="checkPermissionAll">All</label>
                                    </div>
                                    <hr/><br>
        
                                    {{-- <div class="row "> --}}
                                        {{-- @foreach ($permissions as $permission)
                                            <div class="col-md-4 mb-4">
                                                <label for="permissions{{$permission->id}}" class="font-weight-normal">
                                                    <input type="checkbox" class="mr-1" name="permissions[]" value="{{ $permission->id }}" id="permissions{{$permission->id}}">{{ $permission->name}}
                                                </label>
                                            </div>
                                        @endforeach --}}
        
                                        @php $i = 1; @endphp
                                        @foreach ($permission_groups as $group)
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="form-check">
                                                        <input type="checkbox" class="form-check-input" id="{{ $i }}Management" value="{{ $group->name }}" wire:click="checkPermissionByGroup('role-{{ $i }}-management-checkbox', this)">
                                                        <label class="form-check-label create-role-form-check" for="checkPermission">{{ strtoupper($group->name) }}</label>
                                                    </div>
                                                </div>
            
                                                <div class="col-9 role-{{ $i }}-management-checkbox">
                                                    @php
                                                        $permissions = App\Models\User::getpermissionsByGroupName($group->name);
                                                        $j = 1;
                                                    @endphp
                                                    @foreach ($permissions as $permission)
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" name="permissions[]" id="checkPermission{{ $permission->id }}" value="{{ $permission->name }}">
                                                            <label class="form-check-label create-role-form-check" for="checkPermission{{ $permission->id }}">{{ $permission->name }}</label>
                                                        </div>
                                                        @php  $j++; @endphp
                                                    @endforeach
                                                    <br>
                                                </div>
            
                                            </div>
                                            @php  $i++; @endphp
                                        @endforeach
                                    {{-- </div> --}}
                                    <div class="row">
                                        <div class="col-md-2 ml-auto">
                                            <button type="submit" class="btn btn-sm btn-info btn-block">Save Role</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
{{-- <script src="{{ asset('vendor/livewire/livewire.js') }}"></script> --}}
    <script>
        // setTimeout(function() {
        //     $('#successMsg').fadeOut('slow');
        //     $('#failMsg').fadeOut('slow');
        // }, 3000);

        /**
         * Check all the permissions
        */
        $("#checkPermissionAll").click(function(){
            if($(this).is(':checked')){
                // check all the checkbox
                $('input[type=checkbox]').prop('checked', true);
            }else{
                // un check all the checkbox
                $('input[type=checkbox]').prop('checked', false);
            }
        });
        function checkPermissionByGroup(className, checkThis){
            const groupIdName = $("#"+checkThis.id);
            const classCheckBox = $('.'+className+' input');
            if(groupIdName.is(':checked')){
                classCheckBox.prop('checked', true);
            }else{
                classCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }
        function checkSinglePermission(groupClassName, groupID, countTotalPermission) {
            const classCheckbox = $('.'+groupClassName+ ' input');
            const groupIDCheckBox = $("#"+groupID);
            // if there is any occurance where something is not selected then make selected = false
            if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
                groupIDCheckBox.prop('checked', true);
            }else{
                groupIDCheckBox.prop('checked', false);
            }
            implementAllChecked();
        }
        function implementAllChecked() {
            const countPermissions = {{ count($all_permissions) }};
            const countPermissionGroups = {{ count($permission_groups) }};
            //  console.log((countPermissions + countPermissionGroups));
            //  console.log($('input[type="checkbox"]:checked').length);
            if($('input[type="checkbox"]:checked').length >= (countPermissions + countPermissionGroups)){
                $("#checkPermissionAll").prop('checked', true);
            }else{
                $("#checkPermissionAll").prop('checked', false);
            }
        }
    </script>
@endpush
</x-app-layout>
          
