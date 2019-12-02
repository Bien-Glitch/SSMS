<?php
if (empty($a_name) || empty($a_type)) {
	$a_name = NULL;
	$a_type = NULL;
}

if ($user) {
	if ($a_type == 'admin' || $a_type == 'principal') {
		$main_nav_sub = '
			<a class="dropdown-item" href="./manage_classes">Manage Classes</a>
			<a class="dropdown-item" href="./manage_subjects">Manage Subjects</a>
			<a class="dropdown-item" href="./manage_fees">Manage School Fees</a>
			<a class="dropdown-item" href="./manage_sessions_terms">Manage Sessions & Terms</a>
			<a class="dropdown-item" href="./manage_results">Student Results</a>
		';

	} elseif ($a_type == 'exam officer') {
		$main_nav_sub = '
			<a class="dropdown-item" href="./manage_results">Student Results</a>
		';

	} else {
		$main_nav_sub = NULL;
	}

	$a_name_sub = substr_replace($a_name, '...', 10);
	$a_name_nav = '<span title="' . $a_name . '" style="cursor: default"><i class="fa fa-user-crown"></i> ' . $a_name_sub . '</span>';
	$main_nav = '
		<li class="nav-item">
			<a class="nav-link" href="./">Home</a>
		</li>
		<li class="nav-item dropdown">
			<a class="j-link nav-link" id="dropdownId" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span>Manage <i class="fa fa-caret-down"></i></span>
			</a>
			<div class="dropdown-menu" aria-labelledby="dropdownId">
				<a class="dropdown-item" href="./manage_students?q=manage_students">Manage Students</a>
				<a class="dropdown-item" href="./manage_students?q=view_students">View Students Details</a>
				' . $main_nav_sub . '
			</div>
		</li>
	';

	$nav_drop = '
		<a class="dropdown-item" href="./profile">My Profile</a>
		<a class="dropdown-item" href="./logout">Logout</a>
	';

} else {
	$a_name_nav = NULL;

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
		<li class="nav-item text-white">
			<i class="fa-3x fad fa-user-crown"></i>
		</li>
	';

}