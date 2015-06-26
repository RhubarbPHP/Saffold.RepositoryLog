<?php

namespace Rhubarb\Scaffolds\RepositoryLog\Model;

use Rhubarb\Stem\Schema\SolutionSchema;

class RepositoryLogSchema extends SolutionSchema
{
    public function __construct()
    {
        parent::__construct(0.1);

        $this->addModel("RhubarbLogEntry", RhubarbLogEntry::class);
    }
}