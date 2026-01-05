<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'username',
        'phone',
        'password',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Boot function untuk menangani logic otomatis saat model berinteraksi dengan DB.
     */
    protected static function boot()
    {
        parent::boot();

        // Trigger otomatis sebelum data User baru disimpan
        static::creating(function ($user) {
            if (empty($user->employee_code)) {
                $user->employee_code = self::generateEmployeeCode();
            }
        });
    }

    /**
     * Logika untuk menghasilkan kode karyawan otomatis.
     * Format: EMP-2026-0001
     */
    public static function generateEmployeeCode()
    {
        $year = date('Y');
        $prefix = "EMP-" . $year . "-";

        // Mengambil user terakhir yang memiliki kode dengan prefix tahun ini
        $lastUser = self::where('employee_code', 'like', $prefix . '%')
            ->orderBy('employee_code', 'desc')
            ->first();

        if (!$lastUser) {
            $number = 1;
        } else {
            // Mengambil 4 digit angka terakhir dari kode terakhir
            $lastCode = $lastUser->employee_code;
            $lastNumber = (int) substr($lastCode, -4);
            $number = $lastNumber + 1;
        }

        // Contoh hasil: EMP-2026-0001
        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}