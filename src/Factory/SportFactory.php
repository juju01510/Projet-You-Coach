<?php

namespace App\Factory;

use App\Entity\Sport;
use App\Repository\SportRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Sport>
 *
 * @method        Sport|Proxy create(array|callable $attributes = [])
 * @method static Sport|Proxy createOne(array $attributes = [])
 * @method static Sport|Proxy find(object|array|mixed $criteria)
 * @method static Sport|Proxy findOrCreate(array $attributes)
 * @method static Sport|Proxy first(string $sortedField = 'id')
 * @method static Sport|Proxy last(string $sortedField = 'id')
 * @method static Sport|Proxy random(array $attributes = [])
 * @method static Sport|Proxy randomOrCreate(array $attributes = [])
 * @method static SportRepository|RepositoryProxy repository()
 * @method static Sport[]|Proxy[] all()
 * @method static Sport[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Sport[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Sport[]|Proxy[] findBy(array $attributes)
 * @method static Sport[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Sport[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class SportFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Sport $sport): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Sport::class;
    }
}
