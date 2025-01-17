<?php

namespace App\Http\Livewire\Backend\Update;

use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Auto extends Component {

    public $status = [
        'available' => false,
        'disabled' => false,
        'message' => 'No Update Available'
    ];
    public $progress = '';

    protected $listeners = ['apply'];

    public function mount() {
        $this->check();
    }

    public function apply($step = 0) {
        if ($this->status['available'] == false && $this->status['disabled'] == false) {
            $this->progress .= '<div class="text-white">No Update Available</div>';
        } else {
            if ($step === 0) {
                $this->progress .= '<div class="text-white">Fetching Files from Server</div>';
                $this->emit('apply', 1);
            } else if ($step === 1) {
                try {
                    $url = 'https://envato.harshitpeer.com/globaldns-php/update/get/?code=' . config('app.settings.license_key');
                    file_put_contents('files.zip', fopen($url, 'r'));
                    $zip = new \ZipArchive;
                    if ($zip->open('files.zip') === TRUE) {
                        $this->progress .= '<div class="text-green-500">Extracting Files</div>';
                        $zip->extractTo(base_path());
                        for ($i = 0; $i < $zip->numFiles; $i++) {
                            $item = $zip->getNameIndex($i);
                            $this->progress .= '<div class="text-white">/' . $item . '</div>';
                        }
                        $zip->close();
                    } else {
                        throw new Exception('Not able to Open ZIP file');
                    }
                    $this->progress .= '<div class="text-green-500">Files Received and Updated Successfully</div>';
                    $this->progress .= '<div class="text-white">Preparing Database Changes</div>';
                    unlink('files.zip');
                    $this->emit('apply', 2);
                } catch (Exception $e) {
                    $this->progress .= '<div class="text-red-600">Encountered Error' . $e->getMessage() . '</div>';
                }
            } else if ($step === 2) {
                try {
                    Artisan::call('migrate', ["--force" => true]);
                    Artisan::call('db:seed', ["--force" => true]);
                    Artisan::call('view:clear');
                    $this->progress .= '<div class="text-green-500">Database Changes Completed Successfully</div>';
                    $this->progress .= '<div class="text-white">Updating Available Vendor Files</div>';
                    $this->emit('apply', 3);
                } catch (Exception $e) {
                    Artisan::call('migrate:rollback', ["--step" => 1]);
                    $this->progress .= '<div class="text-red-600">Encountered Error' . $e->getMessage() . '</div>';
                }
            } else if ($step === 3) {
                try {
                    if (file_exists(base_path() . '/vendor_new')) {
                        File::deleteDirectory(base_path('vendor'));
                        rename(base_path('vendor_new'), base_path('vendor'));
                    }
                    Setting::put('version', $this->status['version']);
                    $this->progress .= '<br><div class="text-green-500 font-bold">Version Upgrade Completed</div>';
                    $this->status = [
                        'available' => false,
                        'disabled' => false,
                        'message' => 'No Update Available',
                    ];
                } catch (Exception $e) {
                    $this->progress .= '<div class="text-red-600">Encountered Error' . $e->getMessage() . '</div>';
                }
            }
        }
    }

    public function render() {
        return view('backend.update.auto');
    }

    /** Check for Update */
    private function check() {
        try {
            $request = Http::withoutVerifying()->get('https://envato.harshitpeer.com/globaldns-php/update/check/?type=json&code=' . config('app.settings.license_key'));
            $response = trim($request->body());
            if ($response == 'INVALID') {
                return false;
            }
            $response = json_decode($response);
            $php = floatval($response->php);
            $version = floatval($response->version);
            if ($version > floatval(config('app.settings.version'))) {
                if (floatval(phpversion()) < $php) {
                    $this->status = [
                        'available' => true,
                        'disabled' => true,
                        'message' => 'Version ' . $version . ' available. However, you need to upgrade your PHP version to ' . $php . ' or above to apply the Update.',
                        'version' => $version
                    ];
                    return false;
                }
                $this->status = [
                    'available' => true,
                    'disabled' => false,
                    'message' => 'Version ' . $version . ' available. You can apply this OTA Update by clicking on below Apply button.',
                    'version' => $version
                ];
                return true;
            }
            return false;
        } catch (Exception $e) {
            return false;
        }
    }
}
