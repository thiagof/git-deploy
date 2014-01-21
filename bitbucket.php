<?php
// Make sure we have a payload, stop if we do not.
if( ! isset( $_POST['payload'] ) )
	die( '<h1>No payload present</h1><p>A BitBucket POST payload is required to deploy from this script.</p>' );

/**
 * Tell the script this is an active end point.
 */
define( 'ACTIVE_DEPLOY_ENDPOINT', true );

require_once 'deploy-config.php';

//Log post information (only debug mode)
Deploy::log( '[Debug: ' . json_encode($_REQUEST), 'DEBUG' );

/**
 * Deploys BitBucket git repos
 */
class BitBucket_Deploy extends Deploy {
	/**
	 * Decodes and validates the data from bitbucket and calls the 
	 * doploy contructor to deoploy the new code.
	 *
	 * @param 	string 	$payload 	The JSON encoded payload data.
	 */
	function __construct( $payload ) {
		//pushed data information
		$payload = json_decode( stripslashes( $_POST['payload'] ), true );
		//pushed repository name
		$push_repo = $payload['repository']['slug'];

		//Define branches commited
		$push_branches = array();
		foreach ($payload['commits'] as $commit)
		{
			if ($commit['branch'])
				$push_branches[] = $commit['branch'];
		}

		$this->log( "Bitbucket pushed *$push_repo* on branches ". json_encode($push_branches) );

		//Find the repositories which matches the pushed repo commit
		//  checks if push is on a configured REPO_NAME and BRANCH
		$repos = parent::$repos;
		$repo_this = array();
		foreach ($repos as $name => $repo)
		{
			//allow config to have repo name in the index of array or in a value
			//this allow user to configure on the deploy system more environments to the same repo (eg dev, stag, production)

			//Repo configured as key name
			if ($name == $push_repo) {
				$repo_this[] = $config;
			}
			//Or configured with 'name' config
			elseif (
				isset( $config['name'] )
				&& $config['name'] == $push_repo
				&& in_array($config['branch'], $push_branches)
			) {
				$repo_this[] = $config;
			}
		}

		//Loop found repos and pull them
		if ( isset($repo_this) )
		{
			foreach ($repo_this as $repo) {
				$this->log( "Checking *$push_repo* branch *$repo[branch]*" );

				$repo['commit'] = $payload['commits'][0]['node'];

				parent::__construct( $push_repo, $repo );
			}
		}
		else
		{
			$this->log( "Repository or branch did not match: ". json_encode($repo_this) );
		}
	}
}
// Start the deploy attempt.
new BitBucket_Deploy( $_POST['payload'] );