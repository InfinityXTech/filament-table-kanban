<?php

namespace App\Livewire;

use App\Enums\UserStatus;
use Livewire\Component;
use Mokhosh\FilamentKanban\Concerns\HasStatusChange;
use UnitEnum;
use App\Models\User;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class Kanban extends Component
{
    use HasStatusChange;
    use WithPagination;
    protected $records;
    protected $statuses;

    protected static string $recordTitleAttribute = 'name';

    protected static string $recordStatusAttribute = 'status';

    protected static string $view = 'filament-kanban::kanban-board';

    protected static string $headerView = 'filament-kanban::kanban-header';

    protected static string $recordView = 'filament-kanban::kanban-record';

    protected static string $statusView = 'filament-kanban::kanban-status';

    protected static string $scriptsView = 'filament-kanban::kanban-scripts';
    public bool $disableEditModal = true;

    protected static string $statusEnum = UserStatus::class;
    protected static string $model = User::class;

    public function mount($records)
    {
        $this->records = $records;
        $this->statuses = $this->statuses()
            ->map(function ($status) use ($records) {
                $status['records'] = $this->filterRecordsByStatus($records, $status);

                return $status;
            });
    }

    public function render()
    {
        return view('livewire.kanban', [
            'statuses' => $this->statuses
        ]);
    }

    protected function statuses()
    {
        return static::$statusEnum::statuses();
    }

    protected function filterRecordsByStatus($records, array $status): array
    {
        $statusIsCastToEnum = $records->first()?->getAttribute(static::$recordStatusAttribute) instanceof UnitEnum;

        $filter = $statusIsCastToEnum
            ? static::$statusEnum::from($status['id'])
            : $status['id'];

        return $records->where(static::$recordStatusAttribute, $filter)->all();
    }
    

    protected function getEloquentQuery(): Builder
    {
        return static::$model::query();
    }
}
