<?php
namespace App\Http\Livewire\Posts;

use App\Models\Category;
use App\Models\Image;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException;
use Intervention\Image\ImageManagerStatic as Image2;
use League\Csv\Writer;
use Illuminate\Support\Facades\Storage;




class Posts extends Component
{
    use WithPagination;
    use WithFileUploads;
    

    public $title, $content, $category, $post_id;
    public $tagids = array();
    public $photos = [];
    public $isOpen = 0;

    public function render()
    {
        $posts = Post::withCount('likes', 'comments', 'views')->get();
        $csv = Writer::createFromString('');
        $csv->insertOne(['Post ID', 'Likes', 'Comments', 'Views']);

        foreach ($posts as $post) {
            $csv->insertOne([$post->id, $post->likes_count, $post->comments_count, $post->views_count]);
        }

        $filename = 'usersdata.csv';
        $filepath = 'public/' . $filename;
        Storage::put($filepath, $csv->__toString());


        $process = new Process(['python3', '/Users/akashchandradebnath/Sites/newsportal/storage/app/public/FLR.py']); 
        $process->run(); 
        // if (!$process->isSuccessful()) { 
        //     throw new ProcessFailedException($process);
        // } 
        $output = $process->getOutput();
        // $recommendedpost = Post::find($output);
        $outputArray = explode(' ', str_replace(['[', ']', '\n'], '', $output));
        $recommendedPosts = Post::whereIn('id', $outputArray)->get();


        return view('livewire.posts.posts', [
            'posts' => Post::orderBy('id', 'desc')->paginate(6),
            'categories' => Category::all(),
            'tags' => Tag::all(),
            'recommendedPosts' => $recommendedPosts
            // 'categories' => Category::paginate(),
            // 'tags' => Tag::paginate(),
        ]);
    }

    public function store()
    {
        if (!Auth::user() == null && Auth::user()->can('article-create')){
            $this->validate([
                'title' => 'required',
                'content' => 'required',
                'category' => 'required',
                'photos.*' => 'image|max:10240',
            ]);

            // Update or Insert Post
            $post = Post::updateOrCreate(['id' => $this->post_id], [
                'title' => $this->title,
                'content' => $this->content,
                'category_id' => intVal($this->category),
                'author_id' => Auth::user()->id,
            ]);

            // Image upload and store name in db
            if (count($this->photos) > 0) {
                Image::where('post_id', $post->id)->delete();
                $counter = 0;
                foreach ($this->photos as $photo) {

                    $storedImage = $photo->store('public/photos');

                    $featured = false;
                    if($counter == 0 ){
                        $featured = true;
                    }
                    Image::create([
                        'url' => url('storage'. Str::substr($storedImage, 6)),
                        'title' => '-',
                        'post_id' => $post->id,
                        'featured' => $featured
                    ]);
                    $counter++;
                }
            }

            // Post Tag mapping
            if (count($this->tagids) > 0) {
                DB::table('post_tag')->where('post_id', $post->id)->delete();

                foreach ($this->tagids as $tagid) {
                    DB::table('post_tag')->insert([
                        'post_id' => $post->id,
                        'tag_id' => intVal($tagid),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            session()->flash(
                'message',
                $this->post_id ? 'Post Updated Successfully.' : 'Post Created Successfully.'
            );

            $this->closeModal();
            $this->resetInputFields();
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    public function delete($id)
    {
        if (!Auth::user() == null && Auth::user()->can('article-delete')){
            Post::find($id)->delete();
            DB::table('post_tag')->where('post_id', $id)->delete();

            session()->flash('message', 'Post Deleted Successfully.');
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    public function edit($id)
    {
        if (!Auth::user() == null && Auth::user()->can('article-edit')){
            $post = Post::with('tags')->findOrFail($id);

            $this->post_id = $id;
            $this->title = $post->title;
            $this->content = $post->content;
            $this->category = $post->category_id;
            $this->tagids = $post->tags->pluck('id');

            $this->openModal();
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->title = null;
        $this->content = null;
        $this->category = null;
        $this->tagids = null;
        $this->photos = null;
        $this->post_id = null;
    }
}
