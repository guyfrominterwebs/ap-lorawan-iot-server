; <?php @ob_end_clean (); die (); ?>

;
; Legend; indicator part will be removed.
;	- path				Can be found with path -method using correct section and variable name.
;	- extension			Can be found with ext -method using correct section and variable name.
;

[system]
debug					=false

[server]
path_root				=.
hosted_servers			=../servers
ws_port					=9000
intern_port				=9001
autoload_exclude[]		=git
autoload_exclude[]		=vagrant
autoload_exclude[]		=servers
autoload_exclude[]		=config
autoload_exclude[]		=docs
autoload_exclude[]		=frameworks