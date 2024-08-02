<?php

namespace App\Enums;

enum BlogStatus: int
{
    case SapXuatBan = 2;
    case XuatBan = 1;
    case BanNhap = 0;

    public static function getStatusLabels(): array
    {
        return [
            self::XuatBan->value => 'Đã xuất bản',
            self::BanNhap->value => 'Bản nháp',
            self::SapXuatBan->value => 'Sắp xuất bản',
        ];
    }

    public function badgeColor(): string
    {
        return match ($this) {
            self::XuatBan => 'bg-success',
            self::BanNhap => 'bg-danger',
            self::SapXuatBan => 'bg-warning',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::XuatBan => 'Đã xuất bản',
            self::BanNhap => 'Bản nháp',
            self::SapXuatBan => 'Sắp xuất bản',
        };
    }
}
