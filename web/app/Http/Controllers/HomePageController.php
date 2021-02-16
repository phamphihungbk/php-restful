<?php

namespace App\Http\Controllers;

use TinnyApi\Mysql\ConnectionFactory as MysqlConnectionFactory;
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

    public function __construct(MysqlConnectionFactory $mysqlConnectionFactory, SqliteConnectionFactory $sqliteConnectionFactory)
    {
        $this->mysqlConnection = $mysqlConnectionFactory->create();
    }

    public function index(){
        $data = [];
        return view('homepage', $data);
    }
}
