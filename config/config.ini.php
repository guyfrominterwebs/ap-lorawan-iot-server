; <?php @ob_end_clean (); die (); ?>

;
;	Legend; indicator part will be removed from the config name. (server, path_root => server, root)
;	Valid indicators are path_ and ext_. Underscrore is required. See config.php for implementation details.
;	In order to these conveersions take effect, the configurations must be loaded using the Config class.
;	Due to architectural decision, multiple configurations can be loaded at once but the first to define 
;	a setting is the one to dictate its actual value.
;
;	- path				Can be found with path -method using correct section and variable name.
;						All paths must be relative to main.php which is located in the local server root.
;	- extension			Can be found with ext -method using correct section and variable name.
;
;	This is a global configuration file which defines setting values common to each of the running servers.
;	The servers may override these values using their own configuration files.

[system]
debug						=false

[server]
path_root					=.
hosted_servers				=../servers
port_public_ws				=9000
port_internal_messaging		=9001
autoload_exclude[]			=git
autoload_exclude[]			=vagrant
autoload_exclude[]			=servers
autoload_exclude[]			=config
autoload_exclude[]			=docs
autoload_exclude[]			=frameworks