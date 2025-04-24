<?php

declare(strict_types=1);

namespace App\Contracts;

interface ProblemDetails
{
    /** @return array{type:string,title:string,status:int,details:string|list<string>} **/
    public function toProblem(): array;
}
