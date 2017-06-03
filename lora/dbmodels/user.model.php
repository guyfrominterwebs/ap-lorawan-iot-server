<?php

namespace Lora\Database;

class User extends BaseModel
{

	public function verify () : bool {
		return true;
	}

}
