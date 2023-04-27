<?php

namespace App\Http\Livewire\Categories;

use App\Models\Category;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Categories extends Component
{
    public $categories, $title, $color, $category_id;
    public $isOpen = 0;

    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.categories.categories');
    }

    public function store()
    {
        if (!Auth::user() == null && Auth::user()->can('categories-create')){ 
            $this->validate([
                'title' => 'required',
                'color' => 'required',
            ]);

            Category::updateOrCreate(['id' => $this->category_id], [
                'title' => $this->title,
                'color' => $this->color
            ]);

            session()->flash(
                'message',
                $this->category_id ? 'Category Updated Successfully.' : 'Category Created Successfully.'
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
        if (!Auth::user() == null && Auth::user()->can('categories-delete')){ 
            Category::find($id)->delete();
            session()->flash('message', 'Category Deleted Successfully.');
        } else {
            session()->flash('message', 'You are not able to go through!');
            return redirect()->back();        
        }
    }

    public function edit($id)
    {
        if (!Auth::user() == null && Auth::user()->can('categories-edit')){ 
            $category = Category::findOrFail($id);
            $this->category_id = $id;
            $this->title = $category->title;
            $this->color = $category->color;

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
        $this->title = '';
        $this->color = '';
        $this->category_id = '';
    }
}
