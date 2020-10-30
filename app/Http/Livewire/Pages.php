<?php

namespace App\Http\Livewire;

use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Pages extends Component
{
    public $modalFormVisible = false;
    public $slug;
    public $title;
    public $content;

    public function render()
    {
        return view('livewire.pages');
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'slug' => ['required', Rule::unique('pages', 'slug')],
            'content' => 'required',
        ];
    }

    /**
     * createShowModal
     * show the form modal
     * of the create function
     * @return void
     */
    public function createShowModal(){
        $this->modalFormVisible = true;
    }

    public function create(){
        $this->validate();
        Page::create($this->modelData());
        $this->modalFormVisible = false;
        $this->resetVars();
    }

    public function modelData()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ];
    }

    public function resetVars()
    {
        $this->title = null;
        $this->slug = null;
        $this->content = null;
    }

    public function updatedTitle($value)
    {
        $this->generateSlug($value);
    }

    private function generateSlug($value)
    {
        $process1 = str_replace(' ', '-', $value);
        $process2 = strtolower($process1);
        $this->slug = $process2;
    }
}
