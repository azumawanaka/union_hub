<?php

const TEST_EMAIL = 'filjumar@test.com';

it('can_create_new_user', function() {
    $user = createUser([
        'email' => TEST_EMAIL,
    ]);

    $this->assertNotEmpty($user);
    $this->assertEquals($user->email, TEST_EMAIL);
});

it('cannot_create_new_user_if_already_exists', function() {
    $existingUser = createUser([
        'email' => TEST_EMAIL,
    ]);
    try {
        // Attempt to create a new user with the same email
        createUser([
            'email' => TEST_EMAIL,
        ]);

        // Fail the test if the above line doesn't throw an exception
        $this->fail('Expected exception not thrown');
    } catch (\Illuminate\Database\QueryException $exception) {
        // Check if the exception is related to a unique constraint violation
        $this->assertStringContainsString('UNIQUE constraint', $exception->getMessage());
    } finally {
        // Clean up: Delete the existing user
        $existingUser->delete();
    }
});