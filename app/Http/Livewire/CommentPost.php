<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comentario;
use App\Models\Post;
use session;

class CommentPost extends Component
{
    public $comentario;
    public $post_id;

    protected $rules = [
        'comentario' => 'required|max:255'
    ];

    public function saveComment()
    {
        $comentario = $this->validate();

        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $this->post_id,
            'comentario' => $this->comentario,
        ]);

        session()->flash('mensaje', 'Comentario realizado correctamente');

        return redirect()->back();
    }

    public function render()
    {
        $post = Post::find($this->post_id);

        return view('livewire.comment-post', [
            'post' => $post
        ]);
    }
}
