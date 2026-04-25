<?php

namespace App\Policies;

use App\Models\Report;
use App\Models\User;

class ReportPolicy
{
    public function delete(User $user, Report $report): bool
    {
        // Только суперадмин и panel_user могут удалять любые отчёты
        return $user->hasAnyRole(['super_admin', 'panel_user']);
    }

    // Если хотите также запретить редактирование – добавьте метод update
    public function update(User $user, Report $report): bool
    {
        return $user->hasAnyRole(['super_admin', 'panel_user']);
    }

    // Если хотите контролировать просмотр – можете добавить view, viewAny и т.д.
}
