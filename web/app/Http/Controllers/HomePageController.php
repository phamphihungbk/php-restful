<?php

namespace App\Http\Controllers;

use TinnyApi\MySQL\MYSQLConnectionFactory as MysqlConnectionFactory;
use TinnyApi\SQLite\SQLiteConnectionFactory as SqliteConnectionFactory;
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
        return view('homepage', $data);
    }
}
