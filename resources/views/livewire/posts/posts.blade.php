<x-slot name="header">
    {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        News
    </h2> --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-item nav-link active px-6" href="#"><b>News</b><span class="sr-only">(current)</span></a>
                @foreach($categories as $category)
                    <a class="nav-item nav-link px-3 {{ ($category->id) ==  ($currentCategoryId ?? '') ? 'active' : '' }}" href="{{ url('dashboard/categories/'. $category->id .'/posts') }}">{{ $category->title }}</a>
                @endforeach
            </div>
        </div>
    </nav>
</x-slot>


<div class="py-2">
    <div class="">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-black-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                    role="alert">
                    <div class="flex">
                        <div>
                            <p class="text-sm">{{ session('message') }}</p>
                        </div>
                    </div>
                </div>
            @endif

  
            @if (!Auth::user() == null && Auth::user()->can('article-create'))
                @if (Request::getPathInfo() == '/dashboard/posts')
                    <button wire:click="create()"
                        class="inline-flex items-center ml-4 px-4 py-2 my-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                        Create New Post
                    </button>
                @endif
            @endif
            
            @if ($isOpen)
                @include('livewire.posts.create')
            @endif
            @if (Request::getPathInfo() == '/dashboard/posts')
            <div class="card-body">
                <table class="table table-borderless table-success">
                    <tr class="bg-gradient-olive">
                        <td colspan="2">
                            <div class="py-2 h6 m-0 text-center"><b>Popular Articles</b> </div>
                        </td>
                    </tr>
                </table>
                <div class="row">
                    @foreach($recommendedPosts as $recommendedpost)
                        <div class="col-md-4">
                            <div class="card rounded overflow-hidden shadow-lg">
                                {{-- <img class="card-img-top" src="" alt="Card image cap"> --}}
                                @foreach($recommendedpost->images as $key => $image)
                                    @if($key == 0)
                                        <div class="px-6 py-4">
                                            <img src="{{ $image->url }}" alt="{{ $image->description }}" width="300" height="200" class="rounded-sm">
                                        </div>
                                    @endif
                                @endforeach
                                <div class="card-body">
                                    <h5 class="card-title font-bold text-xl">{{ $recommendedpost->title ?? '' }}</h5>
                                    <p class="card-text">{{ Str::words($recommendedpost->content ?? '', 10, '...') }}</p>
                                    @php
                                        $start = $recommendedpost->created_at;
                                        $date1 = new DateTime($start);
                                        $date2 = new DateTime('today');
                                        $diff = $date2->diff($date1);
                                        $years = $diff->y; // Get the number of years
                                        $months = $diff->m; // Get the number of months
                                        $hours = $diff->h + ($diff->days * 24); // Calculate total hours
                                        $days = $diff->days; // Get the number of days
                                    @endphp
    
                                @if($days != 0 && $days < 30)
                                    <p class="text-muted">
                                        {{ $days }} days ago
                                    </p>
                                @elseif($months != 0 && $months < 12)
                                    <p class="text-muted pb-4">{{ $months }} month ago</p>
                                @else
                                    <p class="text-muted pb-4">{{ $hours }} hours ago</p>
                                @endif
                                    {{-- <a href="#" class="btn btn-primary">Go somewhere</a> --}}
                                    <form method="POST" action="{{ url('posts/views') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $recommendedpost->id ?? '' }}" />
                                        <button type="submit" class="btn btn-primary">Read</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>        
            </div> 
            @endif
            
            <table class="table table-borderless table-info">
                <tr class="bg-gradient-olive">
                    <td colspan="2">
                        <div class="py-2 h6 m-0 text-center"><b>Articles</b> </div>
                    </td>
                </tr>
            </table>
            <div class="grid grid-flow-row grid-cols-3">
                @foreach ($posts as $post)
                    <div class="overflow-hidden mx-2">
                        <div class="px-6 py-4">
                            @foreach($post->images as $key => $image)
                                @if($key == 0)
                                    <div class="px-2 py-4">
                                        <img src="{{ $image->url }}" alt="{{ $image->description }}" width="300" height="200" class="rounded-sm">
                                    </div>
                                @endif
                            @endforeach

                            <div class="">
                                <a href="{{ url('dashboard/posts', $post->id) }}"
                                    class="">
                                    <form method="POST" action="{{ url('posts/views') }}">
                                        @csrf
                                        <div class="font-bold text-xl mb-2 ">{{ $post->title }}</div>
                                        <input type="hidden" name="id" value="{{ $post->id }}" />
                                        {{-- <button type="submit">READ</button> --}}
                                    </form>
                                </a>

                                <p class="text-gray-700 text-base">
                                    {{ Str::words($post->content, 10, '...') }}
                                </p>
                                @php
                                    $start = $post->created_at;
                                    $date1 = new DateTime($start);
                                    $date2 = new DateTime('today');
                                    $diff = $date2->diff($date1);
                                    $years = $diff->y; // Get the number of years
                                    $months = $diff->m; // Get the number of months
                                    $hours = $diff->h + ($diff->days * 24); // Calculate total hours
                                    $days = $diff->days; // Get the number of days
                                @endphp

                                @if($days != 0 && $days < 30)
                                    <p class="text-muted">
                                        {{ $days }} days ago
                                    </p>
                                @elseif($months != 0 && $months < 12)
                                    <p class="text-muted">{{ $months }} month ago</p>
                                @else
                                    <p class="text-muted">{{ $hours }} hours ago</p>
                                @endif
                            </div>
                            <div class="flex pt-2 justify-end">
                                @if (!Auth::user() == null && Auth::user()->can('article-edit'))
                                    <button wire:click="edit({{ $post->id }})"
                                        class="inline-flex items-center px-2 py-2 rounded-md  text-xs  tracking-widest focus:outline-none focus:border-yellow-900 focus:shadow-outline-yellow disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" height="28" width="28"><path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" fill="#c29d4f"/></svg>
                                    </button>
                                @endif

                                @if (!Auth::user() == null && Auth::user()->can('article-delete'))
                                    <button onclick="return confirm('Are you sure want to delete the article?')" wire:click="delete({{ $post->id }})"
                                        class="inline-flex items-center justify-center px-2 py-2 focus:shadow-outline-red">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" height="28" width="28"><path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" fill="red"/></svg>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="border-b border-black-900 mx-2"></div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="py-4">
            {{ $posts->links() }}
        </div>
    </div>
</div>
