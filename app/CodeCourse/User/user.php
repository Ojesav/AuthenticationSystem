<?php
namespace CodeCourse\User;
use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent{
    protected $table ='users';
    protected $fillable = [
         'email',
         'username',
         'passwd',
         'first_name',
         'last_name',
         'active',
         'active_hash',
         'recover_hash',
         'remember_identifier',
         'remember_token', 
    ];

    public function getFullName()
    {
        if(!$this->first_name||!$this->last_name){
            return null;
        }
        return $this->first_name.' '.$this->last_name;
    }

    public function getFullNameorUsername(){
         if($this->getFullName()){
           return $this->getFullName();
           // echo $this->getFullName();
         }
       return $this->username;
    }
    public function activateAccount()
    {
        $this->update([
            'active'=>true,
            'active_hash'=>null
        ]);
    }

    public function getAvatarUrl
    ($options=[])
    {
        $size=isset($options['size']) ?
         $options['size']:45;
        return 'http://www.gravatar.com/avatar/'.md5($this->email).'?s='.$size;
    }

    public function updateRememberCredentials($identifier,$token)
    {
        $this->update([
            'remember_identifier'=>$identifier,
            'remember_token'=>$token
        ]);
    }

    public function removeRememberCredentials()
    {
        $this->updateRememberCredentials(null,null);
    }

    public function hasPermission($permission)
    {
        return (bool) $this->permissions->{$permission};
    }

    public function isAdmin()
    {
        return $this->hasPermission('is_admin');
    }

    public function permissions()
    {
        return $this->hasOne('CodeCourse\User\UserPermission','user_id');
    }
}