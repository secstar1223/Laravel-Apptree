<?php

namespace App\Http\Livewire\Courses;

use Closure;
use App\Models\Module;
use Livewire\Component;
use App\Enums\ActionType;
use App\Models\ModuleItem;
use App\Enums\ContentLayout;
use App\Enums\ModuleItemType;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Textarea;
use App\Forms\Components\SimpleFieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;

class ContentEditor extends Component implements HasForms
{
    use InteractsWithForms;

    public $module_id, $module_item_id;

    public $type, $layout, $title, $image, $content, $video, $document, $order;

    public $action = 'create';

    protected $listeners = ['setContentType' => 'setContent', 'editContent', 'renderComponent' => '$refresh'];
    
    public function render()
    {
        return view('livewire.courses.content-editor');
    }

    public function mount($moduleId = null)
    {
        $this->type = ModuleItemType::Content;

        if($moduleId){
            $this->setModule($moduleId);
        }
        
    }

    protected function getFormSchema(): array
    {
        return [
            Grid::make(2)
                ->reactive()
                ->schema([
                    Hidden::make('type'),
                    TextInput::make('title')->required(),
                    Select::make('layout')
                        ->required()
                        ->reactive()
                        ->options(ContentLayout::asSelectArray())
                        ->afterStateUpdated(function (Closure $set, Closure $get, $state) {
                            $this->getContentForm();
                        }),
                ]),
            $this->getContentForm()->reactive()
        ];
    }

    public function getContentForm()
    {
        if($this->layout == ContentLayout::LeftImageRightText)
        {
            return SimpleFieldset::make('content')
                ->columns(2)
                ->label('Image & Text')
                ->schema([
                    FileUpload::make('image')
                        ->disk('do')
                        ->directory('modules')
                        ->visibility('public')
                        ->preserveFilenames()
                        ->panelAspectRatio('2:1')
                        ->panelLayout('integrated'),
                    RichEditor::make('content')
                        ->label('')
                        ->placeholder('Enter description here')
                        ->toolbarButtons([
                            'blockquote',
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'h2',
                            'italic',
                            'link',
                            'orderedList',
                            'redo',
                            'strike',
                            'undo',
                        ])
                        ->disableAllToolbarButtons()
                        ->enableToolbarButtons([
                            'bold',
                            'bulletList',
                            'codeBlock',
                            'italic',
                            'strike',
                        ])
                        ->required(),
                ]);
        }

        if($this->layout == ContentLayout::LeftTextRightImage)
        {
            return SimpleFieldset::make('content')
                ->columns(2)
                ->label('Text & Image')
                ->schema([
                    Textarea::make('content')->placeholder('Enter description here')->required(),
                    FileUpload::make('image')->disk('do')->directory('modules')->visibility('public')->preserveFilenames(),
                ]);
        }

        if($this->layout == ContentLayout::TextOnly)
        {
            return SimpleFieldset::make('content')
                ->columns(2)
                ->label('Text Only')
                ->schema([
                    Textarea::make('content')->placeholder('Enter description here')->columnSpan('full')->required(),
                ]);
        }

        if($this->layout == ContentLayout::ImageOnly)
        {
            return SimpleFieldset::make('image')
                ->label('Image Only')
                ->schema([
                    $this->getFieldFileUpload()->columnSpan('full')
                    ->required(function(){
                        return $this->action == ActionType::Update ? false : true;
                    })
                ]);
        }

        return SimpleFieldset::make('default');
    }

    public function getFieldFileUpload()
    {
        return FileUpload::make('image')
                ->image()
                ->directory('modules')
                ->visibility('public')
                ->imagePreviewHeight('100')
                ->loadingIndicatorPosition('left')
                ->panelAspectRatio('4:1')
                ->panelLayout('integrated')
                ->removeUploadedFileButtonPosition('right')
                ->uploadButtonPosition('left')
                ->uploadProgressIndicatorPosition('left');
    }

    public function setModule($id)
    {
        $this->module_id = $id;
        $this->module = Module::find($id);
    }

    public function setContent($params)
    {
        $this->reset('layout');

        $this->module_id = $params['module_id'];
        $layout = $params['layout'];

        switch ($layout) {
            case 'image-text':
                $this->layout = ContentLayout::LeftImageRightText;
                break;

            case 'text-image':
                $this->layout = ContentLayout::LeftTextRightImage;
                break;

            case 'text':
                $this->layout = ContentLayout::TextOnly;
                break;

            case 'image':
                $this->layout = ContentLayout::ImageOnly;
                break;
            
            default:
                $this->layout = ContentLayout::LeftImageRightText;
                break;
        }

        if($this->layout){

            $this->getContentForm();

            $this->dispatchBrowserEvent('openmodal-content');
        }
        
        
    }

    public function submit()
    {
        $this->validate();

        $data = $this->form->getState();

        if($this->action == ActionType::Update)
        {
            if(empty($data['image'])){
                unset($data['image']);
            }
            
            $module_item = ModuleItem::find($this->module_item_id);
            $module_item->update($data);

        }else{
            $module = Module::find($this->module_id);

            $module->items()->create($data);
        }
        

        return redirect(request()->header('Referer'));
        
    }

    public function editContent($module_item_id)
    {
        $this->module_item_id = $module_item_id;

        $data = ModuleItem::find($module_item_id);

        $this->action = ActionType::Update;

        $this->form->fill([
            'title' => $data->title,
            'type' => $data->type->value,
            'layout' => $data->layout,
            'content' => $data->content,
            'image' => $data->image
        ]);

        $this->getContentForm();

        $this->dispatchBrowserEvent('openmodal-content');
    }
}
