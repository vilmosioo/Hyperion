<?php
/*
* Gist Manager
* 
* Calls the GIthub API to retreive latest GIST and include them in the WP blog
*/
class Gist_Manager{
	private $user; 
	function __construct($user = ""){
		if($user == null || $user == "") return;
		$this->user = $user;

 		// TODO Delete this
 		wp_unschedule_event(wp_next_scheduled( 'gist-manager' ), 'gist-manager' ); 
		add_action( 'gist-manager', array(&$this, 'refresh') );  

		if( !wp_next_scheduled( 'gist-manager' ) ) {  
	       wp_schedule_event( current_time('timestamp', 1), 'daily', 'gist-manager' ); 
	    } 
	}

	function refresh(){
		echo 'Refresh fired';
		die();
		$gists = Utils::get_gists($this->user); 
		foreach($gists as $gist){
			$post = get_page_by_title( $gist['description'], OBJECT, 'post' );
			if($post){
				echo 'Found a post';
				die();
			} 
		}
	}
}

/*
[0] => Array
        (
            [url] => https://api.github.com/gists/4616722
            [description] => Adding Twitter cards to a WordPress website. Add this to your header.php
            [forks_url] => https://api.github.com/gists/4616722/forks
            [user] => Array
                (
                    [type] => User
                    [organizations_url] => https://api.github.com/users/ioowilly/orgs
                    [url] => https://api.github.com/users/ioowilly
                    [gravatar_id] => 46dbf4d3e8ce610c1db6cdfd06bbbf99
                    [gists_url] => https://api.github.com/users/ioowilly/gists{/gist_id}
                    [avatar_url] => https://secure.gravatar.com/avatar/46dbf4d3e8ce610c1db6cdfd06bbbf99?d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png
                    [repos_url] => https://api.github.com/users/ioowilly/repos
                    [received_events_url] => https://api.github.com/users/ioowilly/received_events
                    [events_url] => https://api.github.com/users/ioowilly/events{/privacy}
                    [followers_url] => https://api.github.com/users/ioowilly/followers
                    [login] => ioowilly
                    [subscriptions_url] => https://api.github.com/users/ioowilly/subscriptions
                    [following_url] => https://api.github.com/users/ioowilly/following
                    [starred_url] => https://api.github.com/users/ioowilly/starred{/owner}{/repo}
                    [id] => 1485154
                )

            [git_pull_url] => https://gist.github.com/4616722.git
            [public] => 1
            [comments_url] => https://api.github.com/gists/4616722/comments
            [updated_at] => 2013-01-24T01:25:44Z
            [git_push_url] => https://gist.github.com/4616722.git
            [comments] => 0
            [id] => 4616722
            [commits_url] => https://api.github.com/gists/4616722/commits
            [created_at] => 2013-01-24T01:25:01Z
            [files] => Array
                (
                    [twitter.php] => Array
                        (
                            [type] => application/httpd-php
                            [filename] => twitter.php
                            [language] => PHP
                            [size] => 762
                            [raw_url] => https://gist.github.com/raw/4616722/f0055f230b9aadd054c0799d60ec31a4c50c1753/twitter.php
                        )

                )

            [html_url] => https://gist.github.com/4616722
        )
*/
?>