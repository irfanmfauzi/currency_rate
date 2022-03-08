<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class synchCurrencyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:currency';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Rate';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $response=Http::get('https://free.currconv.com/api/v7/currencies?apiKey=1cd68292df42d982146a')->json('results');
        foreach ($response as $index => $element) {
            $from_currency = $index;
            $currency_name = $element['currencyName'];
            $query =  "{$from_currency}_USD";
            $response_rate = Http::get("https://free.currconv.com/api/v7/convert?q={$query}&compact=ultra&apiKey=1cd68292df42d982146a")->json($query);
            Currency::updateOrCreate(['code' => $from_currency], ['name' => $currency_name, 'rate' => $response_rate, 'date' => now()->format('Y-m-d')]);
        }
    }
}
