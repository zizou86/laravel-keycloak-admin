<?php
namespace Scito\Keycloak\Admin\Tests;

use Scito\Keycloak\Admin\Representations\RepresentationCollectionInterface;
use Scito\Keycloak\Admin\Representations\UserRepresentationBuilder;
use Scito\Keycloak\Admin\Representations\UserRepresentationInterface;
use Scito\Keycloak\Admin\Resources\UsersResourceInterface;
use Scito\Keycloak\Admin\Tests\Traits\WithTemporaryRealm;

class UsersResourceTest extends TestCase
{
    use WithTemporaryRealm;

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
        $this->resource = $this->client->realm($this->temporaryRealm)->users();
        $this->builder = new UserRepresentationBuilder();
    }

    /**
     * @test
     */
    public function users_can_be_retrieved() {

        $username = $this->faker->userName;
        $email = $this->faker->email;
        $password = $this->faker->password;

        $this->resource
            ->create()
            ->username($username)
            ->email($email)
            ->password($password)
            ->save();

        $user = $this
            ->resource
            ->search()
            ->get()
            ->first(function(UserRepresentationInterface $user) use ($username) {
                return $username === $user->getUsername();
            });

        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals($username, $user->getUsername());
    }

    /**
     * @test
     */
    public function users_can_be_searched_using_an_option_array() {

        $username = $this->faker->userName;
        $email = $this->faker->email;
        $password = $this->faker->password;

        $this->resource
            ->create()
            ->username($username)
            ->email($email)
            ->password($password)
            ->save();

        $user = $this
            ->resource
            ->search([
                'username' => $username
            ])
            ->first();

        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals($username, $user->getUsername());
    }

    /**
     * @test
     */
    public function user_search_can_be_limited() {

        // Create multiple users for the test realm
        for($i=0;$i<5;$i++) {
            $this->createUser();
        }

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
        $username = $this->faker->userName;
        $email = $this->faker->email;
        $password = $this->faker->password;

        $this->resource
            ->create()
            ->username($username)
            ->email($email)
            ->password($password)
            ->save();

        $users = $this
            ->resource
            ->search()
            ->get()
            ->filter(function(UserRepresentationInterface $user) use ($username) {
               return $user->getUsername() === $username;
            });

        $this->assertInstanceOf(RepresentationCollectionInterface::class, $users);
        $this->assertCount(1, $users);
    }

    /**
     * @test
     */
    public function users_can_be_retrieved_by_username()
    {
        $username = $this->faker->userName;
        $email = $this->faker->email;
        $password = $this->faker->password;

        $this->resource
            ->create()
            ->username($username)
            ->email($email)
            ->password($password)
            ->save();

        $user = $this->resource->getByUsername($username);
        $this->assertInstanceOf(UserRepresentationInterface::class, $user);
        $this->assertEquals($username, $user->getUsername());
    }

    private function createUser($username = null, $email = null, $password = null)
    {
        if(null === $username) {
            $username = $this->faker->userName;
        }
        if(null === $email) {
            $email = $this->faker->email;
        }
        if(null === $password) {
            $password = $this->faker->password;
        }

        $this->resource->add(
            $this->builder
                ->withUsername($username)
                ->withPassword($password)
                ->withEmail($email)
                ->build()
        );
        return [$username, $email, $password];
    }

    /**
     * @test
     */
    public function users_can_be_searched_using_a_fluent_api()
    {
        [$username,] = $this->createUser();

        $users = $this->resource
            ->search()
            ->username($username)
            ->get();

        $this->assertIsArray($users->toArray());
        $this->assertInstanceOf(UserRepresentationInterface::class, $users[0]);
    }

    /**
     * @test
     */
    public function users_are_iterable_when_searched()
    {
        [$username,] = $this->createUser();

        $users = $this->resource
            ->search()
            ->username($username);

        $exists = false;
        foreach($users as $user) {
            if($user->getUsername() == $username) {
                $exists = true;
            }
        }
        $this->assertTrue($exists);
    }

    /**
     * @test
     */
    public function users_can_be_created() {

        [$username,$email] = $this->createUser();

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

        [$username,$email] = $this->createUser();

        $user = $this->resource
            ->search()
            ->username($username)
            ->first();

        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());

        $email = $this->faker->email;

        $this->resource
            ->get($user->getId())
            ->update()
            ->email($email)
            ->save();

        $user = $this->resource
            ->search()
            ->username($username)
            ->first();

        $this->assertEquals($username, $user->getUsername());
        $this->assertEquals($email, $user->getEmail());
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