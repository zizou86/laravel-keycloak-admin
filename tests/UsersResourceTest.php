<?php
namespace Keycloak\Admin\Tests;

use Keycloak\Admin\Hydrator\Hydrator;
use Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Keycloak\Admin\Representations\UserRepresentationBuilder;
use Keycloak\Admin\Representations\UserRepresentationInterface;
use Keycloak\Admin\Resources\UsersResourceInterface;
use Keycloak\Admin\Tests\Traits\WithFaker;
use Keycloak\Admin\Tests\Traits\WithTestClient;
use RuntimeException;

class UsersResourceTest extends TestCase
{
    use WithFaker, WithTestClient;

    /**
     * @var UsersResourceInterface
     */
    private $resource;
    /**
     * @var UserRepresentationBuilder
     */
    private $builder;

    public function setUp(): void
    {
        parent::setUp();
        $this->resource = $this->client->realm('master')->users();
        $this->builder = new UserRepresentationBuilder();
    }

    /**
     * @test
     */
    public function users_can_be_retrieved() {

        $users = $this
            ->resource
            ->search();

        $exists = false;
        foreach($users as $user) {
            if($user->getUsername() === 'admin') {
                $exists = true;
                break;
            }
        }
        $this->assertTrue($exists);
    }

    /**
     * @test
     */
    public function users_can_be_searched_using_an_option_array() {
        $users = $this
            ->resource
            ->search([
                'username' => 'admin'
            ]);

        $exists = false;
        foreach($users as $user) {
            if($user->getUsername() === 'admin') {
                $exists = true;
                break;
            }
        }
        $this->assertTrue($exists);
    }

    /**
     * @test
     */
    public function user_search_can_be_limited() {
        $users = $this
            ->resource
            ->search()
            ->limit(1)
            ->get();

        $this->assertCount(1, $users);
    }

    /**
     * @test
     */
    public function user_search_results_can_be_filtered()
    {
        $users = $this
            ->resource
            ->search()
            ->get()
            ->filter(function(UserRepresentationInterface $user) {
               return $user->getUsername() === 'admin';
            });

        $this->assertInstanceOf(RepresentationCollectionInterface::class, $users);
        $this->assertCount(1, $users);
    }

    /**
     * @test
     */
    public function users_can_be_retrieved_by_username()
    {
        $user = $this->resource->getByUsername('admin');
        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals('admin', $user->getUsername());
    }

    private function createUser($username, $email, $password)
    {
        $this->resource->add(
            $this->builder
                ->withUsername($username)
                ->withPassword($password)
                ->withEmail($email)
                ->build()
        );
    }

    /**
     * @test
     */
    public function users_can_be_searched_using_a_fluent_api()
    {
        $users = $this->resource
            ->search()
            ->username('admin')
            ->get();

        $this->assertIsArray($users->toArray());
        $this->assertInstanceOf(UserRepresentationInterface::class, $users[0]);
    }

    /**
     * @test
     */
    public function users_are_iterable_when_searched()
    {
        $users = $this->resource
            ->search()
            ->username('admin');

        $exists = false;
        foreach($users as $user) {
            if($user->getUsername() == 'admin') {
                $exists = true;
            }
        }
        $this->assertTrue($exists);
    }

    /**
     * @test
     */
    public function users_can_be_created() {

        $email = $this->faker->email;
        $username = $this->faker->userName;
        $password = $this->faker->password;

        $this->createUser($username, $email, $password);


        $user = $this->resource->getByUsername($username);

        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());

    }

    /**
     * @test
     */
    public function users_can_be_created_using_a_fluent_api()
    {
        $username = $this->faker->userName;
        $password = $this->faker->password;

        $this->resource
            ->create()
            ->username($username)
            ->password($password)
            ->enabled(true)
            ->save();

        $user = $this->resource
            ->search()
            ->username($username)
            ->first();

        $this->assertEquals($username, $user->getUsername());
    }
    
    /**
     * @test
     */
    public function users_can_be_updated_using_the_fluent_api() {
        $username = $this->faker->userName;
        $password = $this->faker->password;

        $this->resource
            ->create()
            ->username($username)
            ->password($password)
            ->enabled(true)
            ->save();

        $user = $this->resource
            ->search()
            ->username($username)
            ->first();

        $this->assertEquals($username, $user->getUsername());
    }

    /**
     * @test
     */
    public function users_can_be_retrieved_by_email() {

        $email = $this->faker->email;
        $username = $this->faker->userName;
        $password = $this->faker->password;

        $this->createUser($username, $email, $password);

        $user = $this->resource->getByEmail($email);

        $this->assertInstanceOf(UserRepresentationInterface::class, $user);

        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
    }

    /**
     * @test
     */
    public function users_can_be_updated()
    {
        $email = $this->faker->email;
        $username = $this->faker->userName;
        $password = $this->faker->password;

        $this->createUser($username, $email, $password);

        $user = $this->resource->getByUsername($username);

        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());

        $newEmail = $this->faker->email;
        $this->resource->update(
            $this->builder
                ->withId($user->getId())
                ->withEmail($newEmail)
                ->build()
        );

        $user = $this->resource->getByUsername($username);

        $this->assertEquals($newEmail, $user->getEmail());
    }

    /**
     * @test
     */
    public function users_can_be_deleted_by_id()
    {
        $username = $this->faker->userName;
        $email = $this->faker->email;
        $password = $this->faker->password;

        $this->createUser($username, $email, $password);

        $user = $this->resource->getByEmail($email);

        $this->resource->deleteById($user->getId());

        $users = $this
            ->resource
            ->search()
            ->username($username)
            ->get();

        $this->assertCount(0, $users);
    }

    /**
     * @test
     */
    public function user_representations_can_be_retrieved()
    {
        $username = $this->faker->userName;
        $email = $this->faker->email;
        $password = $this->faker->password;
        $this->createUser($username, $email, $password);

        $id = $this->resource
            ->search()
            ->username($username)
            ->get()
            ->first()
            ->getId();

        $user = $this->resource->get($id)->toRepresentation();

        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
    }
}