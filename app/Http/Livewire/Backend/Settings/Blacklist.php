<?php

namespace App\Http\Livewire\Backend\Settings;

use Livewire\Component;
use App\Models\Setting;

class Blacklist extends Component {

    /**
     * Components State
     */
    public $state = [
        'blacklist' => [
            'servers' => []
        ]
    ];

    public function mount() {
        $this->state['blacklist']['servers'] = config('app.settings.blacklist.servers');
    }

    public function add() {
        array_push($this->state['blacklist']['servers'], '');
    }

    public function remove($key) {
        unset($this->state['blacklist']['servers'][$key]);
        $this->state['blacklist']['servers'] = array_values($this->state['blacklist']['servers']);
    }

    public function update() {
        $this->validate(
            [
                'state.blacklist.servers.*' => 'required'
            ],
            [
                'state.blacklist.servers.*.required' => 'Blacklist server field is required. Delete the empty field if you don\'t need it'
            ]
        );
        $setting = Setting::where('key', 'blacklist')->first();
        $setting->value = serialize($this->state['blacklist']);
        $setting->save();
        $this->emit('saved');
    }

    public function render() {
        return view('backend.settings.blacklist');
    }
}
