<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class General extends Component {

    use WithFileUploads;

    /**
     * Components State
     */
    public $state = [
        'name' => '',
        'colors' => [
            'primary' => '#000000',
            'secondary' => '#000000',
            'tertiary' => '#000000'
        ],
        'cookie' => [],
        'custom_logo' => '',
        'custom_favicon' => '',
    ];

    public $logo, $favicon;

    public function mount() {
        foreach ($this->state as $key => $value) {
            $this->state[$key] = config('app.settings.' . $key);
        }
        if (Storage::exists('public/images/custom-logo.png')) {
            $this->state['custom_logo'] = Storage::url('public/images/custom-logo.png');
        }
        if (Storage::exists('public/images/custom-favicon.png')) {
            $this->state['custom_favicon'] = Storage::url('public/images/custom-favicon.png');
        }
    }

    public function update() {
        $this->validate(
            [
                'state.name' => 'required',
                'state.logo' => 'image|max:1024',
                'state.favicon' => 'image|max:1024'
            ],
            [
                'state.name.required' => 'App Name is Required',
                'state.logo.image' => 'Invalid Logo file',
                'state.logo.max' => 'Max Size is 1MB',
                'state.favicon.image' => 'Invalid Logo file',
                'state.favicon.max' => 'Max Size is 1MB'
            ]
        );
        if ($this->logo) {
            $this->logo->storeAs('public/images', 'custom-logo.png');
        }
        if ($this->favicon) {
            $this->favicon->storeAs('public/images', 'custom-favicon.png');
        }
        $settings = Setting::whereIn('key', ['name', 'colors', 'cookie'])->get();
        foreach ($settings as $setting) {
            $setting->value = serialize($this->state[$setting->key]);
            $setting->save();
        }
        $this->emit('saved');
    }

    public function render() {
        return view('backend.settings.general');
    }
}
