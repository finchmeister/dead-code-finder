<?php declare(strict_types=1);

namespace DeadCodeFinder\AnalysisServer\Persistence;

use DeadCodeFinder\AnalysisServer\CalledCodeDto;

interface PersistenceInterface
{
    public function persist(CalledCodeDto $calledCodeDto): void;
}
