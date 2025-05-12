<?php
function respond(mixed $response): void
{echo json_encode($response);}

function respondError(string $message): void
{respond(['error' => ['message' => $message, 'code' => 400]]);}
