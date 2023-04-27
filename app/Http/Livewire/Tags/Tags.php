<?php


namespace App\Http\Livewire\Tags;

use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

use App\Models\Tag;
use Livewire\Component;

class Tags extends Component
{
    use WithPagination;

    // public $tags, $title, $tag_id;
    public $title, $tag_id;
    public $isOpen = 0;

    public function render()
    {
        // $this->tags = Tag::all();
        return view('livewire.tags.tags',['tags' => Tag::paginate()]);
    }

    public function store()
    {
        if (!Auth::user() == null && Auth::user()->can('tag-create')){ 
            $this->validate([
                'title' => 'required',
            ]);

            Tag::updateOrCreate(['id' => $this->tag_id], [
                'title' => $this->title,
            ]);

            session()->flash('message',
                $this->tag_id ? 'Tag Updated Successfully.' : 'Tag Created Successfully.');

            $this->closeModal();
            $this->resetInputFields();
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    public function delete($id)
    {
        if (!Auth::user() == null && Auth::user()->can('tag-delete')){ 
            Tag::find($id)->delete();
            session()->flash('message', 'Tag Deleted Successfully.');
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    public function edit($id)
    {
        if (!Auth::user() == null && Auth::user()->can('tag-edit')){ 
            $tag = Tag::findOrFail($id);
            $this->tag_id = $id;
            $this->title = $tag->title;

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

    private function resetInputFields(){
        $this->title = '';
        $this->tag_id = '';
    }
}
