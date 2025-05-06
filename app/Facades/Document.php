<?php
/**
 * Created by PhpStorm.
 * User: MarOleVik
 * Date: 16.01.2019
 * Time: 15:09
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Document extends Facade
{
    protected static function getFacadeAccessor(){
        return 'document';
    }
}