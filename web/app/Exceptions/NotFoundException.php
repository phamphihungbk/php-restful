<?php

namespace App\Exceptions;

use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\View\View;

class NotFoundException extends Exception
{
    /**
     * @var View
     */
    private $view;

    /**
     * @var int
     */
    private $statusCode;

    /**
     * NotFoundException constructor.
     * @param View $view
     * @param int $statusCode
     */
    public function __construct(View $view, $statusCode = 404)
    {
        $this->view = $view;
        $view->with(['is404' => true]);
        $this->statusCode = $statusCode;
    }

    public function index()
    {
        $data = [];
        $viewData = [
            'blade' => '404'
        ];
        return Response::view($viewData['blade'], $data, $this->statusCode);
    }
}
