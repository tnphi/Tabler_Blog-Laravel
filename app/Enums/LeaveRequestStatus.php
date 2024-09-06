<?php

namespace App\Enums;

enum LeaveRequestStatus: int
{
    case PENDING = 0;
    case APPROVED = 1;
    case REJECTED = 2;

    public static function getStatusLabels(): array
    {
        return [
            self::PENDING->value => 'Chờ phê duyệt',
            self::APPROVED->value => 'Đã phê duyệt',
            self::REJECTED->value => 'Đã từ chối',
        ];
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::PENDING => 'bg-warning',
            self::APPROVED => 'bg-success',
            self::REJECTED => 'bg-danger',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Chờ phê duyệt',
            self::APPROVED => 'Đã phê duyệt',
            self::REJECTED => 'Đã Từ chối',
        };
    }
}
