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

<div>
    <form wire:submit.prevent="update">
        <label>Name:</label>
        <input type="text" wire:model="name">
        @error('name')
        <p class="text-red-500">{{ $message }}</p>
        @enderror

        <label>Email:</label>
        <input type="text" wire:model="email">
        @error('email')
        <p class="text-red-500">{{ $message }}</p>
        @enderror

        <button type="submit">Update</button>
    </form>

    @if (session()->has('message'))
        <p>{{ session('message') }}</p>
    @endif
</div>
