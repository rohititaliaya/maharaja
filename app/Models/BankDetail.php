<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'agent_id',
        'account_number',
        'banificary_name',
        'ifsc_code',
        'bank_name',
        'city_name'
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id' , 'id');
    }
    
    public function getAccountNumberAttribute($value)
    {
        $key ='maharaja@atul#cn';
        $iv=   'encryptionIntVec';          
        $res2=base64_decode($value);
        $res  =   openssl_decrypt($res2, 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
        return $res;
    }
    
    public function getBanificaryNameAttribute($value)
    {
        $key ='maharaja@atul#cn';
        $iv=   'encryptionIntVec';          
        $res2=base64_decode($value);
        $res  =   openssl_decrypt($res2, 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
        return $res;
    }
    
    public function getIfscCodeAttribute($value)
    {
        $key ='maharaja@atul#cn';
        $iv=   'encryptionIntVec';          
        $res2=base64_decode($value);
        $res  =   openssl_decrypt($res2, 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
        return $res;
    }
    
    public function getBankNameAttribute($value)
    {
        $key ='maharaja@atul#cn';
        $iv=   'encryptionIntVec';          
        $res2=base64_decode($value);
        $res  =   openssl_decrypt($res2, 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
        return $res;
    }
    
    public function getCityNameAttribute($value)
    {
        $key ='maharaja@atul#cn';
        $iv=   'encryptionIntVec';          
        $res2=base64_decode($value);
        $res  =   openssl_decrypt($res2, 'AES-128-CBC', $key, $options=OPENSSL_RAW_DATA, $iv);
        return $res;
    }
    
}
