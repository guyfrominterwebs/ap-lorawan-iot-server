; <?php @ob_end_clean (); die (); ?>

;
; Legend; indicator part will be removed.
;	- path				Can be found with path -method using correct section and variable name.
;	- extension			Can be found with ext -method using correct section and variable name.
;

[system]
debug					=true

[server]
path_root				=.
path_frameworks			=../frameworks
path_api				=../server/api
path_content			=../server/content
autoload_exclude[]		=api
autoload_exclude[]		=content
