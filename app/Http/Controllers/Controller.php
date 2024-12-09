<?php

namespace App\Http\Controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Laravel API",
 *     description="Laravel API",
 *     @OA\Contact(
 *         email="QHs4o@example.com"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="config API Server"
 * )
 *
 * @OA\Server(
 *     url="http://localhost",
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     in="header",
 *     name="Authorization",
 *     description="Bearer token",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\PathItem(
 *     path="/",
 * )
 */
abstract class Controller
{
    protected $service;

    protected $repo;
}
