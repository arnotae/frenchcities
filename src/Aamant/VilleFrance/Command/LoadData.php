<?php namespace Aamant\VilleFrance\Command;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

use Illuminate\Support\Str;

class LoadData extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'ville:load';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Charge les données dans la table "villes"';

	protected $max_per_request = null;

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
	 * @return mixed
	 */
	public function fire()
	{
		$this->max_per_request = $this->option('max-per-request');

		\DB::table('villes')->truncate();

		$filename = realpath(dirname(__FILE__) . '/../../../data/france.csv');
		$this->info('Filename: ' . $filename);

		$fs = new Filesystem();
		if (!$fs->exists($filename)){
			$this->error("Data file not found", 1);
			return;
		}

		$resource = @fopen($filename, 'r');
		if (!$resource){
			$this->error(error_get_last(), 1);
			return;
		}

		$headers = fgets($resource);
		$csv = array();

		$now = \Carbon\Carbon::now();

		while (null != ($line = fgets($resource))){
			$line = preg_replace('/"/', '', $line);
			$line = explode(',' ,$line);

			$csv[] = [
				'postcode'			=> $line[0],
				'insee'				=> $line[1],
				'name'				=> $line[3],
				'slug'				=> Str::lower($line[5]),
				'region'			=> Str::lower($line[8]),
				'region_code'		=> $line[7],
				'department'		=> Str::lower($line[10]),
				'department_code'	=> $line[9],
				'longitude'			=> $line[12],
				'latitude'			=> $line[11],
				'created_at'		=> $now,
				'updated_at'		=> $now,
			];
		}

		$this->info('Nombre de villes a importer: ' . count($csv));

		do {
			$max = count($csv)> $this->max_per_request ? $this->max_per_request: count($csv);
			$slice = array_splice($csv, 0, $max);

			\DB::table('villes')->insert($slice);

		} while (count($csv));
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('max-per-request', null, InputOption::VALUE_OPTIONAL, 'Nombre de ligne maximum part requete', 2000),
		);
	}

}
