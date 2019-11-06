<?php namespace App\Models\Legacy;

use CodeIgniter\Model;

class MaterialModel extends Model
{
	protected $DBGroup    = 'legacy';
	protected $table      = 'materials';
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
		$material = [
			'id'          => $legacy->id,
			'name'        => $legacy->name,
			'summary'     => $legacy->name,
			'description' => $legacy->description,
			'sortorder'   => $legacy->sortorder,
			'method_id'   => $legacy->method_id,
			'created_at'  => $legacy->created_at,
			'updated_at'  => $legacy->updated_at,
			'deleted_at'  => $legacy->status == 'Archived' ? $legacy->updated_at : null,
		];
		
		$materials = new \App\Models\MaterialModel();
		if ($materials->find($material['id']))
		{
			$result = $materials->protect(false)->save($material);
		}
		else
		{
			$result = $materials->protect(false)->insert($material);
		}
			
		return $result;
	}
}

/*
describe materials;
+-------------+--------------+------+-----+-------------------+-----------------------------+
| Field       | Type         | Null | Key | Default           | Extra                       |
+-------------+--------------+------+-----+-------------------+-----------------------------+
| id          | int(11)      | NO   | PRI | NULL              | auto_increment              |
| method_id   | int(11)      | NO   | MUL | NULL              |                             |
| name        | varchar(127) | NO   | MUL | NULL              |                             |
| description | text         | NO   |     | NULL              |                             |
| status      | varchar(15)  | NO   | MUL | NULL              |                             |
| sortorder   | int(11)      | NO   |     | NULL              |                             |
| created_by  | int(11)      | NO   |     | NULL              |                             |
| created_at  | datetime     | NO   | MUL | NULL              |                             |
| updated_at  | timestamp    | NO   | MUL | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP |
+-------------+--------------+------+-----+-------------------+-----------------------------+
9 rows in set (0.01 sec)

select * from materials order by rand() limit 3;
+----+-----------+-----------------+-------------------------------------------------------------+----------+-----------+------------+---------------------+---------------------+
| id | method_id | name            | description                                                 | status   | sortorder | created_by | created_at          | updated_at          |
+----+-----------+-----------------+-------------------------------------------------------------+----------+-----------+------------+---------------------+---------------------+
| 28 |         9 | Dealer's Choice |                                                             | Active   |         0 |     157080 | 2018-03-13 16:36:27 | 2018-03-13 16:36:27 |
| 10 |         5 | Navy            | A navy polycarbonate-like material.                         | Archived |         0 |     155136 | 2017-02-24 13:18:01 | 2017-03-23 17:17:33 |
|  2 |         1 | PETG            | Superior durability to PLA, slightly tricker to print with  | Active   |         0 |          4 | 2017-01-30 12:43:25 | 2017-02-24 13:07:45 |
+----+-----------+-----------------+-------------------------------------------------------------+----------+-----------+------------+---------------------+---------------------+
3 rows in set (0.01 sec)
*/
