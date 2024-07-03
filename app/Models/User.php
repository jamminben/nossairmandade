<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use App\Constants\Constants;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function canEditHinario($hinarioId)
    {
        return $this->hasRole('superadmin') || Auth::user()->hasPermissionTo(Constants::EDIT_HINARIO."_".$hinarioId);
    }

    public function canEditPerson($personId)
    {
        return $this->hasRole('superadmin') || Auth::user()->hasPermissionTo(Constants::EDIT_PERSON."_".$personId);
    }

    public function canEditHymn($hymnId) {
        $hymn = Hymn::where('id', $hymnId)->first();
        $canEdit = false;
        if ($this->hasRole('superadmin')) {
            $canEdit = true;
        }

        foreach ($hymn->hinarios as $hinario)
        {
            if (Auth::user()->hasPermissionTo(Constants::EDIT_HINARIO."_".$hinario->id))
            {
                $canEdit = true;
            }
        }

        return $canEdit;
    }

}
