<?php
use App\Actions\GetUserAction;
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Actions\SelectUserAction;
use Illuminate\Http\Request;

it('can_get_all_registered_users', function () {
    $user = createUser();
    $this->actingAs($user);

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
    $user = createUser();
    $this->actingAs($user);

    $getUserAction = app(GetUserAction::class);

    $controller = new UserController();
    $response = $controller->getUserById($user->id, $getUserAction);
    $responseData = json_decode($response->getContent(), true);

    expect($responseData['id'])->toBe($user->id);
});



