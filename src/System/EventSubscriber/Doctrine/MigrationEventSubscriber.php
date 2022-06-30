<?php

namespace App\System\EventSubscriber\Doctrine;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Schema\PostgreSqlSchemaManager;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

use function in_array;

/**
 * Class MigrationEventSubscriber
 * @package App\System\EventSubscriber\Doctrine
 */
class MigrationEventSubscriber implements EventSubscriber
{
    /**
     * @var string
     */
    private string $environment;

    /**
     * MigrationEventSubscriber constructor.
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            ToolEvents::postGenerateSchema,
        ];
    }

    /**
     * @param GenerateSchemaEventArgs $args
     * @throws SchemaException
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schemaManager = $args->getEntityManager()
            ->getConnection()
            ->getSchemaManager();

        if (!$schemaManager instanceof PostgreSqlSchemaManager) {
            return;
        }

        $schema = $args->getSchema();

        if (in_array($this->environment, ['dev', 'test'])) {
            foreach ($schemaManager->getExistingSchemaSearchPaths() as $namespace) {
                if (!$schema->hasNamespace($namespace)) {
                    $schema->createNamespace($namespace);
                }
            }
        }
    }
}
