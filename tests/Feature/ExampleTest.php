<?php

test('guests are redirected to login from the home page', function (): void {
    $this->get('/')->assertRedirect(route('login'));
});
