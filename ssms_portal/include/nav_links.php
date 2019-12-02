<?php
	if (empty($stu_name)) {
		$stu_name = NULL;
	}

	if ($user) {
		$stu_name_sub = substr_replace($stu_name, '...', 10);
		$stu_name_nav = '<span title="' . $stu_name . '" style="cursor: default"><i class="far fa-user-circle"></i> ' . $stu_name_sub . '</span>';
		$main_nav = '
			<li class="nav-item">
				<a class="nav-link" href="./">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="./results">View Results</a>
			</li>
		';

		$nav_drop = '
			<a class="dropdown-item" href="./profile">My Profile</a>
			<a class="dropdown-item" href="./logout">Logout</a>
		';

	} else {
		$stu_name_nav = NULL;

		if (!stristr($currentURL, '/signup')) {
			$nav_drop = '
				<a class="dropdown-item" href="./signup">Signup</a>
			';

		} else {
			$nav_drop = '
				<a class="dropdown-item" href="./">Login</a>
			';
		}

		$main_nav = '
			<li class="nav-item">
				<i class="fa-2x fad fa-user-lock"></i>
			</li>
		';
	}