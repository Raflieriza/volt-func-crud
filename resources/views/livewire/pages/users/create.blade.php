<?php

use Livewire\Volt\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public $name;
    public $email;
    public $password;

    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'User berhasil ditambahkan.');
        $this->reset(['name', 'email', 'password']);
    }
};
?>

<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li>Create</li>
        </ul>
    </div>
    <div class="card bg-base-100 shadow">
        <div class="card-body">
            <div class="card-title">Tambah User</div>
            <form wire:submit="create">
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Name</span>
                    </div>
                    <input type="text" wire:model="name" placeholder="Type here" class="input input-bordered w-full"/>
                    @error('name')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Email</span>
                    </div>
                    <input type="text" wire:model="email" placeholder="Type here" class="input input-bordered w-full"/>
                    @error('email')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                    @enderror
                </label>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text">Password</span>
                    </div>
                    <input type="password" wire:model="password" placeholder="Type here"
                           class="input input-bordered w-full"/>
                    @error('password')
                    <div class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </div>
                    @enderror
                </label>
                <button type="submit" class="btn btn-primary mt-4">Submit</button>
            </form>
            @if (session()->has('message'))
            <p>{{ session('message') }}</p>
        @endif
        </div>
    </div>
</div>
