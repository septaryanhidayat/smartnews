<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_EDITOR = 'editor';
    public const ROLE_AUTHOR = 'author';

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
        ];
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Check if user is Super Admin
     */
    public function isAdmin(): bool
    {
        return empty($this->role) || $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is Editor or Admin
     */
    public function isEditor(): bool
    {
        return empty($this->role) || in_array($this->role, [self::ROLE_ADMIN, self::ROLE_EDITOR], true);
    }

    /**
     * Check if user is Author/Journalist
     */
    public function isAuthor(): bool
    {
        return $this->role === self::ROLE_AUTHOR;
    }

    /**
     * Check if user has any of the specified roles
     */
    public function hasRole(string|array $roles): bool
    {
        if (is_string($roles)) {
            $roles = explode(',', $roles);
        }

        return in_array($this->role, $roles, true);
    }

    /**
     * Human readable role label
     */
    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => 'Super Admin',
            self::ROLE_EDITOR => 'Editor / Redaktur',
            self::ROLE_AUTHOR => 'Wartawan / Penulis',
            default => ucfirst($this->role ?? 'Pengguna'),
        };
    }

    /**
     * HTML Badge for Role
     */
    public function getRoleBadgeHtmlAttribute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => '<span style="background-color: #fee2e2; color: #991b1b; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-shield-alt"></i> Super Admin</span>',
            self::ROLE_EDITOR => '<span style="background-color: #e0e7ff; color: #3730a3; padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-edit"></i> Editor</span>',
            default => '<span style="background-color: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 11.5px; display: inline-flex; align-items: center; gap: 4px;"><i class="fas fa-pen-nib"></i> Wartawan</span>',
        };
    }
}
