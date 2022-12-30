<?php

namespace App\Ldap;

use LdapRecord\Models\Model;
use LdapRecord\Models\Concerns\CanAuthenticate;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use CanAuthenticate;

    public static $objectClasses = ['...'];

   

    protected $guidKey = 'uuid';
    /**
     * The object classes of the LDAP model.
     *
     * @var array
     */
    public function guardName(){
        return "web";
    }
    
}
