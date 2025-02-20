<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    use \Livewire\WithPagination;

    public $search;
    public $gender;
    public $proses;
    public $user;
    public $username;
    public $email;
    public $password;

    // hanya manggil data di awal saja
    public function mount()
    {
        $this->proses[] = 'sedang di mount';
    }

    public function with(): array
    {
        $data = User::where('name','like','%'.$this->search.'%')->latest()->paginate(10);
        return [
            'users' => $data
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            session()->flash('message', 'User berhasil dihapus.');
        } else {
            session()->flash('error', 'User tidak ditemukan.');
        }
    }

    public function create()
    {
        $this->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->reset(['username', 'email', 'password']);
    }
};
?>
<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li>Users</li>
        </ul>
    </div>
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">Users</h2>
            @if (session()->has('message'))
            <p>{{ session('message') }}</p>
        @endif
            <div class="flex justify-between">
                <input type="text" class="input input-bordered w-full max-w-xs"
                       wire:model.lazy="search" placeholder="Type name"/>
                <a href="{{ route('users.create') }}" class="btn btn-primary">Create</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table">
                    <!-- head -->
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <a href="{{ route('users.edit',$item->id) }}" class="btn btn-xs btn-warning">Edit</a>
                                <button wire:confirm="Are you sure?" wire:click="delete({{ $item->id }})"
                                        class="btn btn-xs btn-error">Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links() }}
        </div>
    </div>
</div>
