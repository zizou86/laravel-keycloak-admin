<?php
namespace Scito\Keycloak\Admin\Tests\Traits;

use Faker\Factory;
use Faker\Generator;

trait WithFaker
{
    /**
     * @var Generator
     */
    protected $faker;
    /**
     * @before
     */
    public function setupFakerClass()
    {
        $this->faker = $this->makeFaker();
    }
    /**
     * @after
     */
    public function teardownFakerClass()
    {
        $this->faker = null;
    }

    protected function makeFaker($locale = null)
    {
        return Factory::create($locale ?? Factory::DEFAULT_LOCALE);
    }
}