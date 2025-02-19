<?php

use function Livewire\Volt\{state};

use App\Models\Post;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use WithFileUploads;

    //id post
    public $postID;

    //image
    public $image;

    #[Rule('required', message: 'Masukkan Judul Post')]
    public $title;

    #[Rule('required', message: 'Masukkan Isi Post')]
    #[Rule('min:3', message: 'Isi Post Minimal 3 Karakter')]
    public $content;

    public function mount($id)
    {
        //get post
        $post = Post::find($id);

        //assign
        $this->postID   = $post->id;
        $this->title    = $post->title;
        $this->content  = $post->content;
    }

    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        //get post
        $post = Post::find($this->postID);

        //check if image
        if ($this->image) {

            //store image in storage/app/public/posts
            $this->image->storeAs('public/posts', $this->image->hashName());

            //update post
            $post->update([
                'image' => $this->image->hashName(),
                'title' => $this->title,
                'content' => $this->content,
            ]);
        } else {

            //update post
            $post->update([
                'title' => $this->title,
                'content' => $this->content,
            ]);
        }

        //flash message
        session()->flash('message', 'Data Berhasil Diupdate.');

        //redirect
        return redirect()->route('posts.index');
    }

    /**
     * render
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.posts.edit');
    }
}

?>

<div>
    @section('title')
        Edit Post - Belajar Livewire 3 di SantriKoding.com
    @endsection

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form wire:submit="update" enctype="multipart/form-data">

                            <div class="form-group mb-4">

                                <label class="fw-bold">GAMBAR</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" wire:model="image">

                                <!-- error message untuk title -->
                                @error('image')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="fw-bold">JUDUL</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" wire:model="title" placeholder="Masukkan Judul Post">

                                <!-- error message untuk title -->
                                @error('title')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group mb-4">
                                <label class="fw-bold">KONTEN</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" wire:model="content" rows="5" placeholder="Masukkan Konten Post"></textarea>

                                <!-- error message untuk content -->
                                @error('content')
                                <div class="alert alert-danger mt-2">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
