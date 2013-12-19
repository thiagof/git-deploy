<?php
/**
 * The repos that we want to deploy.
 *
 * Each repos will be an entry in the array in the following way:
 * 'repo name' => array( // Required. This is the repo name
 * 		'name' 	 => 'repo_slug' // Optional. The repository slug. Allow use of repo branches on the same deploy env
 * 		'path' 	 => '/path/to/local/repo/' // Required. The local path to your code.
 * 		'branch' => 'the_desired_deploy_branch', // Required. Deployment branch.
 *		'remote' => 'git_remote_repo', // Optional. Defaults to 'origin'
 * 		'post_deploy' => 'callback' // Optional callback function for whatever.
 * 		'private_key' => 'string' // Required. The validating key for the request. Should be passed with hook request as https://youserver.com/git-deploy/github.php?pkey=someweirdkey
 * )
 *
 * You can put as many of these together as you want, each one is simply 
 * another entry in the $repos array. To set up a deploy create a deploy key
 * for your repo on github or bitbucket. You can generate multiple deploy keys
 * for multiple repos.
 * @see https://confluence.atlassian.com/pages/viewpage.action?pageId=271943168
 *
 * Note that deploy keys are only necessary if the repo is private. If it is a
 * public repo, then you do not need a key to get read only access to the repo
 * which is really what we are after for deployment.
 *
 * Once you have done an initial git pull in the desired code location, you can
 * run 'pwd' to get the full directory of your git repo. Once done, enter that
 * full path in the 'path' option for that repo. The optional callback will allow
 * you to ping something else as well such as hitting a DB update script or any
 * other configuration you may need to do for the newly deployed code.
 */
$repos = array(
	/*
	'myrepo-dev' => array(
		'name' => 'myrepo',
		'branch' => 'develop',
		'remote' => 'origin',
		'path' => '/path/to/local/code/',
		'private_key' => 'someweirdkey',
	),
	'myrepo-pro' => array(
		'name' => 'myrepo',
		'branch' => 'master',
		'remote' => 'origin',
		'path' => '/path/to/production/code/',
		'private_key' => 'someweirdkey2',
	)
	*/
);

$debug = true;
$git_bin = '/usr/bin/git';

/**
 * Sets the deploy log direcotry
 */
define( 'DEPLOY_LOG_DIR', dirname( __FILE__ ) );

/* Do not edit below this line */
require_once 'inc/class.deploy.php';
