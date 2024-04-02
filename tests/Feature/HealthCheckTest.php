<?php

test('health check', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});
