<?php namespace App\GraphQL;


/*
Needs klaravel for helper methods.
composer require ksoft/klaravel
*/


/**
* Trait ResolveLogTrait.
*/
trait ResolveLogTrait
{
    protected function log()
    {
        dbDump();
        logi('');
        // logi($this->obj);
        // dd($this->info);
        logi('OBJ____::: ' . json_encode($this->obj));
        logi('ARGS___::: ' . json_encode($this->args));
        logi('CONTEXT::: ' . json_encode($this->context));
        logi('C-USER_::: ' . json_encode($this->context->user));
        logi('HEADERS::: ' . json_encode($this->context->request->headers));
        logi('INFO___::: ' . json_encode($this->info));
        logi('HEADERS___' . json_encode(request()->headers->all()));
    }
}
