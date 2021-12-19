<?php declare(strict_types=1);

namespace DeadCodeFinder\UpdServer\Persistence;

use DeadCodeFinder\UpdServer\CalledCodeDto;

interface Persistence
{
    public function persist(CalledCodeDto $calledCodeDto): void;
}
