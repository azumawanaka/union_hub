<?php
use App\Actions\UpdateProfilePhotoAction;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

afterEach(function () {
    deleteAllUploadedFiles();
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

it('can get user by id', function() {
    $response = $this->get(route('users.info', $this->user->id));

    expect($response->json())->toBeArray();
    expect($response->json()['id'])->toBe($this->user->id);
});

it('cannot get user with un-existing id', function() {
    $response = $this->get(route('users.info', 'unidentified-id'));
    expect($response->json())->toBeEmpty();
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

    User::factory()->create(array_merge($payloads, [
        'first_name' => 'Jade Orpheus',
        'email' => 'jade@test.net',
    ]));

    $response = $this->post(route('users.store'), array_merge($payloads, [
        'first_name' => 'Filjumar',
        'email' => 'jade@test.net',
    ]));

    $response->assertSessionHasErrors('email');

    expect(session('errors')->getBag('default')->first('email'))
        ->toBe('The email has already been taken.');
});

it('can update a user with valid requests', function() {
    $payloads = [
        'u' => $this->user->id,
        'first_name' => 'Updated value',
        'last_name' => $this->user->last_name,
        'address' => $this->user->address,
        'mobile' => null,
        'gender' => 'male',
    ];

    $response = $this->put(route('users.update_user', $this->user->id), $payloads);

    expect($response->json()['status'])->toBe('success');
    expect($response->json()['message'])->toBe('User was successfully updated.');
});

it('cannot update a user if id is invalid', function() {
    $payloads = [
        'u' => $this->user->id,
        'first_name' => 'Updated value',
        'last_name' => $this->user->last_name,
        'address' => $this->user->address,
        'mobile' => null,
        'gender' => 'male',
    ];

    $response = $this->put(route('users.update_user', 'invalid-id'), $payloads);
    expect($response->json()['status'])->toBe('error');
});

it('can upload a profile photo', function () {
    // Create a fake image for testing
    $image = UploadedFile::fake()->image('profile.jpg');

    // Make a request to upload the profile picture
    $response = $this->postJson(route('upload.profile-photo'), [
        'profile_picture' => $image,
    ]);

    $response->assertSuccessful();
});

// it('fails to upload a profile photo when no file is provided', function () {
//     // Make a request to upload the profile picture without a file
//     $response = $this->postJson(route('upload.profile-photo'), []);

//     // Assert the response indicates failure
//     $response->assertJson(['message' => 'Failed to upload image.']);
// });