<?php

namespace App\Database\Seeds;

use App\Models\OptionModel;
use CodeIgniter\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run()
    {
        // Initialize the model
        $options = model(OptionModel::class);

        $rows = [
            [
                'name'        => 'premium',
                'summary'     => 'Premium service',
                'description' => 'Premium service provides extra support and priority printing. Additional charges apply.',
            ],
            [
                'name'        => 'inspection',
                'summary'     => 'Inspection scan',
                'description' => 'An inspection scan adds an additional quality check to the post-processing. Additional charges apply.',
            ],
            [
                'name'        => 'confidential',
                'summary'     => 'Confidential job',
                'description' => 'Printing occurs in an open lab and cannot guarantee privacy. By request we can make extra efforts not to position your job in a way it can be seen by others.',
            ],
            [
                'name'        => 'priority',
                'summary'     => 'High priority',
                'description' => 'High priorty jobs are reserved for urgent clinical needs and take precendence over other jobs.',
            ],
        ];

        foreach ($rows as $row) {
            $option = $options->where('name', $row['name'])->withDeleted()->first();

            if (empty($option)) {
                $options->insert($row);
            }
        }
    }
}
