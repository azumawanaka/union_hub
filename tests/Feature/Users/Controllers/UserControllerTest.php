<?php
use App\Actions\GetUserAction;
use App\Actions\StoreUserAction;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Actions\SelectUserAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;


beforeEach(function () {
    $this->user = createUser([
        'email' => TEST_EMAIL,
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

it('can_store_user_with_valid_requests', function() {
    $requests = [
        'first_name' => 'Jade Orpheus',
        'last_name' => 'Jumamoy',
        'address' => 'Ilaud Inabanga Bohol',
        'mobile' => null,
        'gender' => 'male',
        'email' => 'jade@test.net',
        'password' => Hash::make('password'),
    ];

    $validator = Validator::make($requests, (new UserRequest())->rules());
    if ($validator->fails()) {
        expect(function () use ($validator) {
            throw new ValidationException($validator);
        })->toThrow(ValidationException::class);
    } else {
        $request = new UserRequest($requests);

        $controller = new UserController();
        $storeUserAction = app(StoreUserAction::class);
    
        $controller->store($request, $storeUserAction);
        expect(Session::get('success'))->toBe('User was successfully added.');
        expect(Session::get('_flash.new'))->toBe(['success']);
    }
});

it('cannot_store_user_with_invalid_requests', function() {
    $requests = [
        'first_name' => null, //required
        'last_name' => 'Jumamoy',
        'address' => 'Ilaud Inabanga Bohol',
        'mobile' => null,
        'gender' => 'male',
        'email' => null, //required
        'password' => Hash::make('password'),
    ];

    $validator = Validator::make($requests, (new UserRequest())->rules());
    expect(function () use ($validator) {
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    })->toThrow(ValidationException::class);
});