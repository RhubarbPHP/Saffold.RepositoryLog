<?php

namespace Rhubarb\Scaffolds\RepositoryLog\Model;

use Rhubarb\Stem\Models\Model;
use Rhubarb\Stem\Repositories\MySql\Schema\Columns\MySqlMediumTextColumn;
use Rhubarb\Stem\Schema\Columns\AutoIncrementColumn;
use Rhubarb\Stem\Schema\Columns\DateTimeColumn;
use Rhubarb\Stem\Schema\Columns\DecimalColumn;
use Rhubarb\Stem\Schema\Columns\StringColumn;
use Rhubarb\Stem\Schema\Index;
use Rhubarb\Stem\Schema\ModelSchema;

class RhubarbLogEntry extends Model
{
    public function createSchema()
    {
        $schema = new ModelSchema("tblRhubarbLogEntry");

        $schema->addColumn(
            new AutoIncrementColumn("RhubarbLogEntryID"),
            new StringColumn("LogSession", "30"),
            new DateTimeColumn("EntryDate"),
            new StringColumn("Category", 50),
            new MySqlMediumTextColumn("Message"),
            new MySqlMediumTextColumn("AdditionalData"),
            new StringColumn("IpAddress", 15),
            new DecimalColumn("ExecutionTime", 12, 4),
            new DecimalColumn("ExecutionGapTime", 12, 4)
        );

        $schema->labelColumnName = "Message";

        $schema->addIndex(new Index("EntryDate", Index::INDEX));
        $schema->addIndex(new Index("Category", Index::INDEX));

        return $schema;
    }
}
