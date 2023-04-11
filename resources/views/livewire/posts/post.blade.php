<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Post
    </h2>
</x-slot>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="grid gap-4">
                <div class="font-bold text-xl mb-2">{{ $post->title }}</div>
                <div class="flex">
                    by&nbsp;<span class="italic">{{ $post->author->first_name . ' ' . $post->author->last_name }}</span>
                    &nbsp;in&nbsp;<a href="{{ url('dashboard/categories/' . $post->category->id . '/posts') }}"
                        class="underline">{{ $post->category->title }}</a>
                    &nbsp;on&nbsp;{{ $post->updated_at->format('F, d Y') }}
                </div>
                <div class="grid grid-flow-col">
                    @foreach ($post->images as $image)
                        <div class="px-6 py-4">
                            <img src="{{ $image->url }}" alt="{{ $image->description }}" width="300" height="200">
                        </div>
                    @endforeach
                </div>
                <div class="grid grid-flow-col">
                    @foreach ($post->videos as $video)
                        <div class="px-6 py-4">
                            <img src="{{ $video->url }}" alt="{{ $video->title }}" width="300" height="200">
                        </div>
                    @endforeach
                </div>
                <div class="text-gray-700 text-base">
                    {!! $post->content !!}
                </div>
                <div class="flex">
                    @php
                    $tags=$post->tags->pluck('id', 'title');
                    @endphp
                    @if (count($tags) > 0)
                        Tags:
                        @foreach ($tags as $key => $tag)
                            <a href="{{ url('dashboard/tags/' . $tag . '/posts') }}"
                                class="underline px-1">{{ $key }}</a>
                        @endforeach
                    @endif
                </div>


                <!-- like button -->
                <div class="btn-group">
                    <form method="POST" action="{{ url('likes/posts') }}">
                    @csrf
                    <input type="hidden" name="id" value="{{ $post->id }}" />
                        <button type="submit" class="btn btn-link">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                            {{ $post->likes->count() }} Likes 
                        </button>
                    </form>

                    <!-- unlike button -->
                    <form method="POST" action="{{ url('unlikes/posts') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}" />
                        <button type="submit" class="btn btn-link">
                            <i  class="far fa-thumbs-down"></i> 
                            {{ $post->unlikes->count() }} unlike
                        </button>
                    </form>
                </div>
                {{-- LIKe Unlike SEction End --}}


                @if ($post->comments->count())
                    <div class="text-base">
                        <p class="text-gray-900 pt-2 pb-4">{{ $post->comments->count() }}
                        @if ($post->comments->count() > 1) Comments @else Comment
                            @endif
                        </p>
                        <div class="bg-gray-100 overflow-hidden shadow-xl px-6 pt-4">
                            @foreach ($post->comments as $comment)
                                <div>
                                    <p class="text-gray-500 font-bold">
                                        {{ $comment->author->first_name . ' ' . $comment->author->last_name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $comment->created_at->format('F, d Y g:i a') }}
                                    </p>
                                    <p class="text-gray-500 pb-4">{{ $comment->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <h4>Add comment</h4>
                <form method="post" action="{{ url('comments/posts') }}">
                    @csrf
                    <div class="form-group">
                        <textarea class="form-control border border-dark" rows="3" cols="50" name="comment"></textarea>
                        <input type="hidden" name="id" value="{{ $post->id }}" />
                    </div>
                    <div class="col-md-2 mt-2 mt-md-0">
                        {{-- <input type="submit" class="btn btn-sm btn-info btn-block" value="Send"/> --}}
                        <button type="submit" class="btn btn-success">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- https://www.php.net/manual/en/datetime.format.php --}}
