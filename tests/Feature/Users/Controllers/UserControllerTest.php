<?php
use App\Actions\GetUserAction;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Actions\SelectUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


beforeEach(function () {
    $this->user = createUser([
        'email' => TEST_EMAIL,
        'role' => 1,
    ]);
    $this->actingAs($this->user);
});

it('can_get_all_registered_users', function () {
    User::factory()->count(10)->create();

    $request = new Request([
        'draw' => 1,
        'start' => 0,
        'length' => 10,
        'order' => [
            [
                'column' => 'email',
                'dir' => 'desc',
            ]
        ],
        'search' => 'email',
    ]);

    $selectUserAction = app(SelectUserAction::class);

    $controller = new UserController();
    $response = $controller->getAllUsers($request, $selectUserAction);

    $responseData = json_decode($response->getContent(), true);

    // Use PHPUnit assertions for relevant parts of the JSON structure
    expect($responseData['draw'])->toBe(1);
    expect($responseData['recordsTotal'])->toBe(11);
    expect($responseData['recordsFiltered'])->toBe(11);

    // Ensure 'data' key exists in the response
    expect($responseData)->toHaveKey('data');

    // Additional assertions based on the actual structure of your 'data'
    // For example, you might want to check the count of items in 'data'
    expect($responseData['data'])->toHaveCount(10);

    expect($response->status())->toBe(200);
});

it('can_get_user_by_id', function() {
    $getUserAction = app(GetUserAction::class);

    $controller = new UserController();
    $response = $controller->getUserById($this->user->id, $getUserAction);
    $responseData = json_decode($response->getContent(), true);

    expect($responseData['id'])->toBe($this->user->id);
});

it('can store user with valid requests', function () {
    $payloads = [
        'first_name' => 'Jade Orpheus',
        'last_name' => 'Jumamoy',
        'mobile' => null,
        'email' => 'jade@test.net',
        'password' => Hash::make('password'),
    ];

    $response = $this->post(route('register'), $payloads);

    $response
        ->assertStatus(302)
        ->assertRedirect(route('dashboard'));

    $responseRequest = $response->getRequest()->request;
    expect($responseRequest)->toBeObject();
    expect($responseRequest->all())->toMatchArray($payloads);
});

it('cannot store user with invalid email', function () {
    $payloads = [
        'first_name' => 'Jade Orpheus',
        'last_name' => 'Jumamoy',
        'address' => 'Ilaud Inabanga Bohol',
        'mobile' => null,
        'gender' => 'male',
        'email' => 'invalid-email-address',
        'password' => Hash::make('password'),
    ];

    $response = $this->post(route('users.store'), $payloads);

    $response->assertSessionHasErrors('email');

    expect(session('errors')->getBag('default')->first('email'))
        ->toBe('The email field must be a valid email address.');
});

it('cannot store user if email already exists', function () {
    $payloads = [
        'last_name' => 'Jumamoy',
        'address' => 'Ilaud Inabanga Bohol',
        'mobile' => null,
        'gender' => 'male',
        'password' => Hash::make('password'),
    ];

    $response = $this->post(route('users.store'), array_merge($payloads, [
        'first_name' => 'Jade Orpheus',
        'email' => 'jade@test.net',
    ]));

    $response->assertSessionDoesntHaveErrors();

    $response = $this->post(route('users.store'), array_merge($payloads, [
        'first_name' => 'Filjumar',
        'email' => 'jade@test.net',
    ]));

    $response->assertSessionHasErrors('email');

    expect(session('errors')->getBag('default')->first('email'))
        ->toBe('The email has already been taken.');
});