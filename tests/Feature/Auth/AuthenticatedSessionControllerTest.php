<?php

test('the login screen displays the LaraStock brand', function (): void {
    $this->get(route('login'))
        ->assertOk()
        ->assertSee('<title>LaraStock</title>', false);
});

test('failed login shows a French error message', function (): void {
    $this->from(route('login'))
        ->post(route('login'), ['email' => 'gerant@example.com', 'password' => 'incorrect'])
        ->assertSessionHasErrors([
            'email' => 'Ces identifiants ne correspondent à aucun compte.',
        ]);
});
