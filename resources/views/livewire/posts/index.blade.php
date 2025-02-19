<?php

use function Livewire\Volt\{state};

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $cari = '';

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //destroy
        Post::destroy($id);

        //flash message
        session()->flash('message', 'Data Berhasil Dihapus.');

        //redirect
        return redirect()->route('posts.index');
    }

    public function render()
    {
        return view('livewire.posts.index', [
            'posts' => Post::where('title', 'like', '%' . $this->cari . '%')->latest()->paginate(5)
        ]);
    }
}

?>

@section('title')
    Data Posts - Belajar Livewire 3 di SantriKoding.com
@endsection

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">

            <!-- flash message -->
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <!-- end flash message -->

            <a href="{{ route('posts.create') }}" wire:navigate class="btn btn-md btn-success rounded shadow-sm border-0 mb-3">ADD NEW POST</a>
            <input type="text" wire:model.lazy="cari">
            <div class="card border-0 rounded shadow-sm">
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Image</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content</th>
                            <th scope="col" style="width: 15%">Actions</th>
                        </tr>
                        </thead>
                        <tbody>

                        @empty
                            <div class="alert alert-danger">
                                Data Post belum Tersedia.
                            </div>

                        </tbody>
                    </table>
                    {{ $posts->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

