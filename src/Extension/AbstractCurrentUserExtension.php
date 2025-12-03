<?php
declare(strict_types=1);

namespace App\Extension;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\SecurityBundle\Security;

abstract class AbstractCurrentUserExtension implements
    QueryCollectionExtensionInterface, QueryItemExtensionInterface
{
    public const FIRST_ELEMENT_ARRAY = 0;

    protected Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @param QueryBuilder $queryBuilder
     */
    abstract protected function buildQuery(QueryBuilder $queryBuilder, string $rootAlias): void;

    /**
     * @return string
     */
    abstract protected function getResourceClass(): string;

    /**
     * @param Operation|null $operation
     */
    public function applyToCollection(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        Operation $operation = null,
        array $context = []
    ): void {
        if ($this->shouldApply($resourceClass)) {
            $rootAlias = $queryBuilder->getRootAliases()[self::FIRST_ELEMENT_ARRAY];
            $this->buildQuery($queryBuilder, $rootAlias);
        }
    }

    /**
     * @param array $identifiers
     * @param Operation|null $operation
     */
    public function applyToItem(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        array $identifiers,
        Operation $operation = null,
        array $context = []
    ): void {
        if ($this->shouldApply($resourceClass)) {
            $rootAlias = $queryBuilder->getRootAliases()[self::FIRST_ELEMENT_ARRAY];
            $this->buildQuery($queryBuilder, $rootAlias);
        }
    }

    protected function shouldApply(string $resourceClass): bool
    {
        if ($resourceClass !== $this->getResourceClass()) {
            return false;
        }
        if ($this->security->isGranted('ROLE_ADMIN')) {
            return false;
        }
        if (!$this->security->getUser()) {
            return false;
        }

        return true;
    }
}