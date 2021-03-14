<?php

namespace App\Http\Controllers;

use TinnyApi\MySQL\ConnectionFactory as MysqlConnectionFactory;
use TinnyApi\SQLite\ConnectionFactory as SqliteConnectionFactory;
use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\MySqlConnection;

class HomePageController extends Controller
{
    /**
     * @var MySqlConnection
     */
    private $mysqlConnection;

    /**
     * @var SQLiteConnection
     */
    private $sqliteConnection;

    public function __construct(
        MysqlConnectionFactory $mysqlConnectionFactory,
        SqliteConnectionFactory $sqliteConnectionFactory
    ) {
        $this->mysqlConnection = $mysqlConnectionFactory->create();
    }

    public function index()
    {
        $data = [];
        $viewData = [
            'blade' => 'pages.homepage'
        ];
        return view($viewData['blade'], $data);
    }
}
