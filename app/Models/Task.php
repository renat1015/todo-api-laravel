<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Enums\TaskStatus;

class Task extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => TaskStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => TaskStatus::NEW,
    ];

    public function isNew(): bool
    {
        return $this->status === TaskStatus::NEW;
    }

    public function isInProgress(): bool
    {
        return $this->status === TaskStatus::IN_PROGRESS;
    }

    public function isCompleted(): bool
    {
        return $this->status === TaskStatus::COMPLETED;
    }

    public function start(): void
    {
        $this->status = TaskStatus::IN_PROGRESS;
        $this->save();
    }

    public function complete(): void
    {
        $this->status = TaskStatus::COMPLETED;
        $this->save();
    }

    public static function validationRules($taskId = null): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:' . implode(',', TaskStatus::values()),
        ];
    }

    public static function validationMessages(): array
    {
        return [
            'title.required' => 'Заголовок задачи обязателен для заполнения',
            'title.max' => 'Заголовок не может превышать 255 символов',
            'status.in' => 'Недопустимый статус задачи',
        ];
    }
}