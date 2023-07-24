<?php

namespace App\Http\Livewire;

use File;
use Artisan;
use Closure;
use DateTimeZone;
use Livewire\Component;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Filament\Forms\Concerns\InteractsWithForms;

class ManageEnvironment extends Component implements HasForms
{
    use InteractsWithForms;

    use LivewireAlert;

    public $APP_TIMEZONE;
    public $FACEBOOK_ENABLE, $FACEBOOK_CLIENT_ID, $FACEBOOK_CLIENT_SECRET;
    public $TWITTER_ENABLE, $TWITTER_CLIENT_ID, $TWITTER_CLIENT_SECRET;
    public $GOOGLE_ENABLE, $GOOGLE_CLIENT_ID, $GOOGLE_CLIENT_SECRET;
    public $DB_CONNECTION;

    public function render()
    {
        return view('livewire.manage-environment');
    }

    public function mount()
    {
        $this->appForm->fill([
            'APP_TIMEZONE' => config('app.timezone'),
        ]);

        $this->googleForm->fill([
            'GOOGLE_ENABLE' => config('services.google.enable'),
            'GOOGLE_CLIENT_ID' => config('services.google.client_id'),
            'GOOGLE_CLIENT_SECRET' => config('services.google.client_secret'),
        ]);

        $this->openaiform->fill([
            'OPENAI_ENABLE' => config('services.openai.enable'),
            'OPENAI_API_KEY' => config('services.openai.key'),
            'OPENAI_ORGANIZATION' => config('services.openai.organization'),
        ]);
    }

    protected function getForms(): array
    {
        return [
            'appForm' => $this->makeForm()
                ->schema($this->getAppFormSchema()),
            'googleForm' => $this->makeForm()
                ->schema($this->getGoogleFormSchema()),
            'openaiform' => $this->makeForm()
                ->schema($this->getOpenAIFormSchema())
        ];
    }

    public function getAppFormSchema()
    {
        return [
            TextInput::make('APP_TIMEZONE')
                ->label('APP_TIMEZONE')
                ->hint('View the list of [timezones](https://www.php.net/manual/en/timezones.php)')
                ->helperText("As an example: UTC or Asia/Singapore, for more format please refer to the PHP list of timezones."),
        ];
    }

    public function getGoogleFormSchema()
    {
        return [
            Toggle::make('GOOGLE_ENABLE')->label('Enable')->reactive(),
            TextInput::make('GOOGLE_CLIENT_ID')->label('GOOGLE_CLIENT_ID')->disabled(fn (Closure $get) => !$get('GOOGLE_ENABLE')),
            TextInput::make('GOOGLE_CLIENT_SECRET')->label('GOOGLE_CLIENT_SECRET')->disabled(fn (Closure $get) => !$get('GOOGLE_ENABLE'))
        ];
    }

    public function getOpenAIFormSchema()
    {
        return [
            Toggle::make('OPENAI_ENABLE')->label('Enable')->reactive(),
            TextInput::make('OPENAI_API_KEY')->label('OPENAI_API_KEY')->disabled(fn (Closure $get) => !$get('OPENAI_ENABLE')),
            TextInput::make('OPENAI_API_ORGANIZATION')->label('OPENAI_API_ORGANIZATION')
                ->disabled(fn (Closure $get) => !$get('OPENAI_ENABLE'))
                ->helperText("Only fill if your OpenAI account belongs to multiple organizations. This will ensure which organization is used for an API request to OpenAI."),
        ];
    }

    public function updateEnv($env, $value, $config = null)
    {
        $envFilePath = base_path('.env');

        if (File::exists($envFilePath)) {
            $envContent = File::get($envFilePath);

            // replace the value of the config variable
            $envContent = preg_replace('/^' . $env . '=.*/m', $env . '=' . $value, $envContent);

            // write the updated content to the .env file
            try {
                File::put($envFilePath, $envContent);
                Artisan::call('config:cache');

                $this->alert('success', "Success! The {$env} environment variable has been updated. Please note that changes may not be reflected immediately. If you do not see the new value, please wait a few minutes and refresh the page.");

                $this->$env = config($config);

                # Hard Refresh
                //return redirect(request()->header('Referer'));

            } catch (\Throwable $th) {
                throw $th;
            }

        }
    }

    public function saveAppForm()
    {
        $data = $this->appForm->getState();

        $this->updateEnv('APP_TIMEZONE', $data['APP_TIMEZONE'], 'app.timezone' );
    }
}
