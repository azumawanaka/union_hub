<?php

const TEST_EMAIL = 'admin@test.com';

beforeEach(function () {
    $this->user = createUser([
        'email' => TEST_EMAIL,
    ]);
});

it('can_register_new_user', function() {
    expect($this->user)->toBeObject($this->user);
    expect($this->user->email)->toBe(TEST_EMAIL);
});

it('cannot_register_new_user_if_already_exists', function() {
    try {
        // Attempt to create a new user with the same email
        createUser([
            'email' => TEST_EMAIL,
        ]);

        // Fail the test if the above line doesn't throw an exception
        $this->fail('Expected exception not thrown');
    } catch (\Illuminate\Database\QueryException $exception) {
        // Check if the exception is related to a unique constraint violation
        expect($exception->getMessage())->toContain('UNIQUE constraint');
    } finally {
        // Clean up: Delete the existing user
        $this->user->delete();
    }
});
