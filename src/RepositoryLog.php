<?php

namespace Rhubarb\Scaffolds\RepositoryLog;

use Rhubarb\Crown\Logging\IndentedMessageLog;
use Rhubarb\Crown\Logging\Log;
use Rhubarb\Scaffolds\RepositoryLog\Model\RhubarbLogEntry;

class RepositoryLog extends IndentedMessageLog
{
    private $logEntryModelClassName;

    public function __construct($logLevel, $logEntryModelClassName = RhubarbLogEntry::class)
    {
        $this->logEntryModelClassName = $logEntryModelClassName;
        parent::__construct($logLevel);
    }

    /**
     * The logger should implement this method to perform the actual log committal.
     *
     * @param string $message The text message to log
     * @param string $category The category of log message
     * @param array $additionalData Any number of additional key value pairs which can be understood by specific
     *                                  logs (e.g. an API log might understand what AuthenticationToken means)
     * @return mixed
     */
    protected function writeFormattedEntry($message, $category = "", $additionalData)
    {
        // There are a number of occasions where this method can cause an infinite loop:
        //
        // 1) Writing a database entry could cause PDO log entries to be generated
        // 2) If any of the following lines should through warnings or notices AND these are set to report
        //    through this logger.
        //
        // For this reason we ask the log framework to suspend logging until this method is complete.

        Log::disableLogging();

        $logEntryModelClassName = $this->logEntryModelClassName;

        /** @var RhubarbLogEntry $logEntry */
        $logEntry = new $logEntryModelClassName();
        $logEntry->LogSession = $this->uniqueIdentifier;
        $logEntry->IpAddress = self::getRemoteIP();
        $logEntry->Category = ($category == "") ? "CORE" : $category;
        $logEntry->EntryDate = "now";
        $logEntry->ExecutionTime = $this->getExecutionTime();
        $logEntry->ExecutionGapTime = $this->getTimeSinceLastLog();
        $logEntry->Message = $message;

        if (is_array($additionalData) || is_object($additionalData)) {
            $additionalData = json_encode($additionalData, JSON_PRETTY_PRINT);
        }

        $logEntry->AdditionalData = $additionalData;
        $logEntry->save();

        Log::enableLogging();
    }
}