<?php

namespace App\Factory;

use App\Entity\Club;
use App\Repository\ClubRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Club>
 *
 * @method        Club|Proxy create(array|callable $attributes = [])
 * @method static Club|Proxy createOne(array $attributes = [])
 * @method static Club|Proxy find(object|array|mixed $criteria)
 * @method static Club|Proxy findOrCreate(array $attributes)
 * @method static Club|Proxy first(string $sortedField = 'id')
 * @method static Club|Proxy last(string $sortedField = 'id')
 * @method static Club|Proxy random(array $attributes = [])
 * @method static Club|Proxy randomOrCreate(array $attributes = [])
 * @method static ClubRepository|RepositoryProxy repository()
 * @method static Club[]|Proxy[] all()
 * @method static Club[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Club[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Club[]|Proxy[] findBy(array $attributes)
 * @method static Club[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Club[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ClubFactory extends ModelFactory
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
            'name' => self::faker()->city,
            'logo' => 'Logo-OL-645a4580def82.svg',
            'adress' => self::faker()->address,
            'phone' => self::faker()->phoneNumber,
            'manager' => ManagerFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Club $club): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Club::class;
    }
}
