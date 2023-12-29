<?php
use App\Models\User;
use App\Http\Controllers\UserController;
use App\Actions\SelectUserAction;
use Illuminate\Http\Request;

it('can_get_all_registered_users', function () {
    $user = User::factory()->create();
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
    $this->assertSame(1, $responseData['draw']);
    $this->assertSame(11, $responseData['recordsTotal']);
    $this->assertSame(11, $responseData['recordsFiltered']);

    // Ensure 'data' key exists in the response
    $this->assertArrayHasKey('data', $responseData);

    // Additional assertions based on the actual structure of your 'data'
    // For example, you might want to check the count of items in 'data'
    $this->assertCount(10, $responseData['data']);

    $this->assertSame(200, $response->status());
});





