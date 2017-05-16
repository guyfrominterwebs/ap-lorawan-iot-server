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

[system]
debug					=true

[server]
path_root				=.
path_frameworks			=../frameworks
path_api				=../server/api
path_content			=../server/content