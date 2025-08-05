<?php

namespace App\Livewire;

use App\Enums\Gender;
use App\Enums\RelationshipIntent;
use App\Enums\SexualPreference;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    // Profile form properties
    public $full_name;

    public $email;

    public $whatsapp_number;

    public $age;

    public $gender;

    public $sexual_preference;

    public $relationship_intent;

    protected $rules = [
        'full_name' => ['required', 'string', 'max:255'],
        'whatsapp_number' => ['required', 'string', 'max:20'],
        'age' => ['required', 'integer', 'min:18', 'max:100'],
        'gender' => ['required'],
        'sexual_preference' => ['required'],
        'relationship_intent' => ['required'],
    ];

    public function mount()
    {
        $user = auth()->user();

        // Initialize form properties
        $this->full_name = $user->full_name;
        $this->email = $user->email;
        $this->whatsapp_number = $user->whatsapp_number;
        $this->age = $user->age;
        $this->gender = $user->gender?->value;
        $this->sexual_preference = $user->sexual_preference?->value;
        $this->relationship_intent = $user->relationship_intent?->value;
    }

    public function rules()
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'age' => ['required', 'integer', 'min:18', 'max:100'],
            'gender' => ['required', Rule::enum(Gender::class)],
            'sexual_preference' => ['required', Rule::enum(SexualPreference::class)],
            'relationship_intent' => ['required', Rule::enum(RelationshipIntent::class)],
        ];
    }

    public function save()
    {
        $this->validate();

        $user = auth()->user();

        // Update profile data
        $user->update([
            'full_name' => $this->full_name,
            'whatsapp_number' => $this->whatsapp_number,
            'age' => $this->age,
            'gender' => Gender::from($this->gender),
            'sexual_preference' => SexualPreference::from($this->sexual_preference),
            'relationship_intent' => RelationshipIntent::from($this->relationship_intent),
        ]);

        session()->flash('success', 'Profile updated successfully!');

        // Dispatch event to trigger image component refresh
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        return view('livewire.profile', [
            'relationshipIntents' => RelationshipIntent::cases(),
            'genders' => Gender::cases(),
            'sexualPreferences' => SexualPreference::cases(),
        ]);
    }
}
