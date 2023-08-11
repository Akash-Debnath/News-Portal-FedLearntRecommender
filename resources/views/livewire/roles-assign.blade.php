<x-app-layout>
<x-slot name="header">
    <h5 class="font-semibold text-xl text-gray-800 leading-tight">
        <b>Role Assign</b>
    </h5>
</x-slot>
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-2">
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

            @if (!Auth::user() == null && Auth::user()->can('roleAndPermission-create'))
                <a href="{{ route('roles-assign.create') }}">
                    <button class="inline-flex items-center px-4 py-2 my-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Assign New Role
                    </button>
                </a>
            @endif
            {{-- @if($isOpen)
                @include('livewire.tags.create')
            @endif --}}



            <table class="table-fixed w-full">
                <thead>
                    <tr class="bg-gray-100">
                        {{-- <th class="px-4 py-2 w-10">SL.</th> --}}
                        <th class="px-4 py-2 w-10 text-center">UID</th>
                        <th class="px-2 py-2 w-40 text-center">Name</th>
                        <th class="px-4 py-2 w-20 text-center">Role</th>
                        <th class="px-4 py-2 w-20 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $count = 1; ?>
                    <?php $i = $users->currentPage() == 1 ? 0 : ($users->currentPage() - 1) * 15 ?>
                    @foreach($users as $user)
                        <tr>
                            {{-- <td class="border px-4 py-2"> echo ++$i; </td> --}}
                            <td class="border px-2 py-2 text-center">{{ $user->id }}</td>
                            <td class="border px-2 py-2">{{ ucfirst($user->first_name." ".$user->last_name) }}</td>
                            <td class="border px-4 py-2">
                                {{-- @foreach ($role->permissions as $perm)
                                    <span class="badge badge-info mr-1">
                                        {{ $perm->name }}
                                    </span>
                                @endforeach --}}
                                @foreach ($user->roles as $role)
                                    <span class="badge badge-info mr-1">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="border px-4 py-2 text-center">
                            {{-- <button
                                wire:click="edit({{ $role->id }})"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Edit
                            </button> --}}
                            @if (!Auth::user() == null && Auth::user()->can('roleAndPermission-edit'))
                                <a href="{{ route('roles-assign.edit', $user->id) }}" class="btn btn-sm btn-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </a>
                            @endif

                            @if (!Auth::user() == null && Auth::user()->can('roleAndPermission-delete'))
                                <form action="{{ route('roles-assign.destroy', $user->id) }}" method="post" style="display:unset;" class="ml-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure want to delete role : {{ $user->first_name }}?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16">
                                        <path d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1V2zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5H2zm13-3H1v2h14V2zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                                    </svg></button>
                                </form>
                            @endif
                            {{-- <a href="{{ url('dashboard/tags/'. $role->id .'/posts') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                Show All Posts
                            </a> --}}
                            {{-- <button
                                wire:click="delete({{ $role->id }})"
                                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150">
                                Delete
                            </button> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="py-4">
                {{ $users->links() }}
            </div>




            {{-- <form action="{{ route('roles-assign.store') }}" method="POST" enctype="multipart/form-data">
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


                <div class="col-md-6 mx-auto">
                    <label for="role"><strong>Role</strong></label>
                    <select id="role" name="roles[]" class="form-control" multiple="multiple" required>
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
            </form> --}}
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
