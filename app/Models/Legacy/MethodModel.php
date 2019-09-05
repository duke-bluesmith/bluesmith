<?php namespace App\Models\Legacy;

use CodeIgniter\Model;

class MethodModel extends Model
{
	protected $DBGroup    = 'legacy';
	protected $table      = 'methods';
	protected $primaryKey = 'id';

	protected $returnType = 'object';
	protected $useSoftDeletes = false;

	protected $allowedFields = [];

	protected $useTimestamps = true;

	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;

	// Take a legacy object and add/update the live version
	public function legacyToLive($legacy)
	{
		$method = [
			'id'          => $legacy->id,
			'name'        => $legacy->name,
			'summary'     => $legacy->fullname,
			'description' => $legacy->description,
			'sortorder'   => $legacy->sortorder,
			'created_at'  => $legacy->created_at,
			'updated_at'  => $legacy->updated_at,
			'deleted_at'  => $legacy->status == 'Archived' ? $legacy->updated_at : null,
		];
		
		$methods = new \App\Models\MethodModel();
		if ($methods->find($method['id']))
		{
			$result = $methods->builder()->where('id', $method['id'])->update($method);
		}
		else
		{
			$result = $methods->builder()->insert($method);
		}
		
		return $result;
	}
}

/*
describe methods;
+-------------+--------------+------+-----+-------------------+-----------------------------+
| Field       | Type         | Null | Key | Default           | Extra                       |
+-------------+--------------+------+-----+-------------------+-----------------------------+
| id          | int(11)      | NO   | PRI | NULL              | auto_increment              |
| name        | varchar(31)  | NO   | MUL | NULL              |                             |
| fullname    | varchar(127) | NO   |     | NULL              |                             |
| description | text         | NO   |     | NULL              |                             |
| status      | varchar(15)  | NO   | MUL | NULL              |                             |
| sortorder   | int(11)      | NO   |     | NULL              |                             |
| created_by  | int(11)      | NO   |     | NULL              |                             |
| created_at  | datetime     | NO   | MUL | NULL              |                             |
| updated_at  | timestamp    | NO   | MUL | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+-------------+--------------+------+-----+-------------------+-----------------------------+
9 rows in set (0.00 sec)

select * from methods order by rand() limit 3;
+----+-----------+------------------------+---------------------------------------+----------+-----------+------------+---------------------+---------------------+
| id | name      | fullname               | description                           | status   | sortorder | created_by | created_at          | updated_at          |
+----+-----------+------------------------+---------------------------------------+----------+-----------+------------+---------------------+---------------------+
|  2 | SLA       | Stereolithography      | <p>We print for you using our high... | Active   |         2 |          4 | 2017-01-28 13:00:46 | 2018-04-23 15:02:00 |
| 10 | Bluechips | Bluechips              | Purchase Bluechip 3D printing credit  | Active   |        10 |     157080 | 2018-04-23 14:56:57 | 2018-04-23 15:01:55 |
|  4 | FDM       | Fused depositing model | <p>We print for you using our high... | Archived |         0 |          4 | 2017-02-02 10:39:50 | 2017-02-24 12:44:14 |
+----+-----------+------------------------+---------------------------------------+----------+-----------+------------+---------------------+---------------------+
*/
