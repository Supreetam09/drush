<?php

declare(strict_types=1);

namespace Drush\Commands\sql\sanitize;

use Consolidation\AnnotatedCommand\CommandData;
use Consolidation\AnnotatedCommand\Hooks\HookManager;
use Drupal\Core\Database\Connection;
use Drush\Attributes as CLI;
use Drush\Commands\AutowireTrait;
use Drush\Commands\DrushCommands;
use Symfony\Component\Console\Input\InputInterface;

/**
 * This class is a good example of how to build a sql:sanitize plugin.
 */
final class SanitizeSessionsCommands extends DrushCommands implements SanitizePluginInterface
{
    use AutowireTrait;

    public function __construct(protected Connection $database)
    {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->database;
    }


    /**
     * Sanitize sessions from the DB.
     */
    #[CLI\Hook(type: HookManager::POST_COMMAND_HOOK, target: SanitizeCommands::SANITIZE)]
    public function sanitize($result, CommandData $commandData): void
    {
        $this->getDatabase()->truncate('sessions')->execute();
        $this->logger()->success(dt('Sessions table truncated.'));
    }

    #[CLI\Hook(type: HookManager::ON_EVENT, target: SanitizeCommands::CONFIRMS)]
    public function messages(&$messages, InputInterface $input): void
    {
        $messages[] = dt('Truncate sessions table.');
    }
}
