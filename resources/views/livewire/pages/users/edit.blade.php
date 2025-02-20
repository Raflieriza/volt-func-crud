<?php

use Livewire\Volt\Component;
use App\Models\User;

new class extends Component {
    public $id;
    public $data;
    public $name;
    public $email;

    public function mount($id)
    {
        $this->id = $id;
        $this->data = User::find($id);


        $this->name = $this->data->name;
        $this->email = $this->data->email;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,'.$this->id,
        ]);

        // Memperbarui model dengan data yang baru
        $this->data->name = $this->name;
        $this->data->email = $this->email;
        $this->data->save();

        session()->flash('message', 'Data updated successfully.');
    }
};
?>
<div class="p-4">
    <div class="breadcrumbs text-sm">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="{{ route('users.index') }}">Users</a></li>
            <li>Edit</li>
        </ul>
    </div>
<div class="card bg-base-100 shadow">
    <div class="card-body">
        <div class="card-title">Edit User</div>
        <form wire:submit.prevent="update">
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">Name</span>
                </div>
                <input type="text" wire:model="name" class="input input-bordered w-full max-w-xs" />
                <div class="label">
                        <span class="label-text-alt">
                            @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </span>
                </div>
            </label>
            <label class="form-control w-full max-w-xs">
                <div class="label">
                    <span class="label-text">Email</span>
                </div>
                <input type="text" wire:model="email" class="input input-bordered w-full max-w-xs" />
                <div class="label">
                        <span class="label-text-alt">
                            @error('email')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </span>
                </div>
            </label>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        @if (session()->has('message'))
            <p>{{ session('message') }}</p>
        @endif
    </div>
</div>

</div>
