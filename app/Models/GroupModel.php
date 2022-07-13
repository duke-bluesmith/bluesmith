<?php

namespace App\Models;

use Myth\Auth\Models\GroupModel as MythModel;

/**
 * Group Model
 *
 * Ensures that the alternate models are used
 * anytime model() requests a class
 *
 * @see https://github.com/lonnieezell/myth-auth/blob/develop/docs/extending.md#models
 */
class GroupModel extends MythModel
{
}
