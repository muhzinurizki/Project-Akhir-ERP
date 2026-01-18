<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'username',
        'phone',
        'password',
        'is_active'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // --- RELASI TRANSKASIONAL ---

    /**
     * Mendapatkan daftar Sales Order yang dibuat oleh user ini.
     */
    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    /**
     * Mendapatkan daftar pengiriman yang diproses oleh user ini.
     */
    public function deliveryOrders()
    {
        return $this->hasMany(DeliveryOrder::class);
    }

    // --- AUTOMATION LOGIC ---

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->employee_code)) {
                $user->employee_code = self::generateEmployeeCode();
            }
        });
    }

    public static function generateEmployeeCode()
    {
        $year = date('Y');
        $prefix = "EMP-" . $year . "-";

        $lastUser = self::where('employee_code', 'like', $prefix . '%')
            ->orderBy('employee_code', 'desc')
            ->first();

        if (!$lastUser) {
            $number = 1;
        } else {
            // Mengambil angka setelah prefix (format tetap terjaga meski tahun berganti)
            $lastNumber = (int) Str::afterLast($lastUser->employee_code, '-');
            $number = $lastNumber + 1;
        }

        return $prefix . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    // --- SCOPES & HELPERS ---

    /**
     * Scope untuk hanya mengambil user yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}