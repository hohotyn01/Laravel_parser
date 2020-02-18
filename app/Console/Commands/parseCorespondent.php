<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Parser;

class parseCorespondent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:corespondent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command get parsing site corespondent';
    protected $parser;

    /**
     * Create a new command instance.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parser->getParsing();
    }
}
