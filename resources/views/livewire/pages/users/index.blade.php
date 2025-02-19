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

<div class="p-5">
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <input type="text" wire:model.lazy="search">
    <a href="{{ route('users.create') }}">
        <button class="btn btn-primary">Create</button>
    </a>

    <h3>Tambah User</h3>
    <input type="text" wire:model="username" placeholder="Username">
    <input type="email" wire:model="email" placeholder="Email">
    <input type="password" wire:model="password" placeholder="Password">
    <button class="btn btn-success" wire:click="create">Tambah</button>

    <ul>
        @foreach($users as $item)
            <li>
                <a href="{{ route('users.edit',$item->id) }}">{{ $item->name }}</a>
                <button class="btn btn-danger" wire:click="delete({{ $item->id }})" wire:confirm="lol">Delete</button>
            </li>
        @endforeach
    </ul>
    {{ $users->links() }}
</div>
