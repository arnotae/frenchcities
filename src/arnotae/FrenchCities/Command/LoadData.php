<?php namespace arnotae\FrenchCities\Command;

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
	protected $name = 'city:load';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Load datas in table "cities", "departments" and "regions"';

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

		$this->fireCity();
		$this->fireDepartement();
		$this->fireRegion();

	}

	/**
	 * Execute for city
	 */
	private function fireCity()
	{
		$this->info('** In progress: cities **');

		\DB::table('cities')->truncate();

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

		while (null != ($line = fgetcsv($resource, null, ',', '"'))){
			if (array(null) === $line) continue;

			// 0:code postal, 1:insee, 2:article, 3:ville, 4:ARTICLE, 5:VILLE, 6:libelle,
			// 7:region, 8:nom region, 9:dep, 10:nom dep, 11:latitude, 12:longitude,
			// 13:soundex, 14:metaphone
			$csv[] = [
				'postcode'			=> $line[0],
				'insee'				=> $line[1],
				'article'			=> $line[2],
				'name'				=> $line[3],
				'article_up'		=> $line[4],
				'name_up'			=> $line[5],
				'slug'				=> Str::slug($line[3]),
				'clean'				=> $line[6],
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

		$this->info('Number of cities to import: ' . count($csv));

		do {
			$max = count($csv)> $this->max_per_request ? $this->max_per_request: count($csv);
			$slice = array_splice($csv, 0, $max);

			\DB::table('cities')->insert($slice);

		} while (count($csv));
	}

	/**
	 * Execute for departement
	 */
	private function fireDepartement()
	{
		$this->info('** In progress: departments **');

		\DB::table('departments')->truncate();

		$filename = realpath(dirname(__FILE__) . '/../../../data/departements.csv');
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

		while (null != ($line = fgetcsv($resource, null, ',', '"'))){
			if (array(null) === $line) continue;

			// 0:code region, 1:code departement, 2:cheflieu, 3:tncc, 4:DEPARTEMENT, 5:departement
			$csv[] = [
				'code'				=> $line[1],
				'name'				=> $line[5],
				'name_up'			=> $line[4],
				'slug'				=> Str::slug($line[5]),
				'chief_place'		=> $line[2],
				'region_code'		=> $line[0],
				'created_at'		=> $now,
				'updated_at'		=> $now,
			];
		}

		$this->info('Number of departements to import: ' . count($csv));

		do {
			$max = count($csv)> $this->max_per_request ? $this->max_per_request: count($csv);
			$slice = array_splice($csv, 0, $max);

			\DB::table('departments')->insert($slice);

		} while (count($csv));
	}

	/**
	 * Execute for region
	 */
	private function fireRegion()
	{
		$this->info('** In progress: region **');

		\DB::table('regions')->truncate();

		$filename = realpath(dirname(__FILE__) . '/../../../data/regions.csv');
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

		while (null != ($line = fgetcsv($resource, null, ',', '"'))){
			if (array(null) === $line) continue;

			// 0:code, 1:cheflieu, 2:tncc, 3:REGION, 4:region
			$csv[] = [
				'code'				=> $line[0],
				'name'				=> $line[4],
				'name_up'			=> $line[3],
				'slug'				=> Str::slug($line[4]),
				'chief_place'		=> $line[1],
				'created_at'		=> $now,
				'updated_at'		=> $now,
			];
		}

		$this->info('Number of regions to import: ' . count($csv));


		do {
			$max = count($csv)> $this->max_per_request ? $this->max_per_request: count($csv);
			$slice = array_splice($csv, 0, $max);

			\DB::table('regions')->insert($slice);

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
			array('max-per-request', null, InputOption::VALUE_OPTIONAL, 'Number of line maximum per request', 2000),
		);
	}

}
