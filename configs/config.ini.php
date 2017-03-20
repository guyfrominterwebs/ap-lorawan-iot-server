; <?php @ob_end_clean (); die (); ?>

;
; Legend; indicator part will be removed.
;	- path				Can be found with path -method using correct section and variable name.
;	- extension			Can be found with ext -method using correct section and variable name.
;

[system]
debug					=true
autoload_exclude[]		=api
autoload_exclude[]		=content

[server]
path_root				=../server
path_frameworks			=../frameworks
path_api				=../server/api
path_content			=../server/content
path_pages				=../pages
path_page_cache			=../pages/page_cache/
ext_page				=page

; 
[twig]
path_cache				=../pages/cache/
path_templates			=../pages/templates/
path_content			=../pages/content/
path_macros				=../pages/macros/
ext_twig				=twig

; Client side configs
[client]
path_assets				=assets/
path_styles				=assets/styles/
path_ext				=assets/ext/
path_scripts			=assets/scripts/
